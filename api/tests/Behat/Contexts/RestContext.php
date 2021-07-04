<?php

declare(strict_types=1);

namespace App\Tests\Behat\Contexts;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
//use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Hautelook\AliceBundle\PhpUnit\BaseDatabaseTrait;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Tests\Manager\FixturesManager;
use App\Tests\Manager\MyReferences;

final class RestContext extends ApiTestCase implements Context
{
    use HeaderContextTrait;
    use FixturesContextTrait;

    //use RefreshDatabaseTrait;
    use BaseDatabaseTrait;
    use HookContextTrait;

    /** @var Response|null */
    private $lastResponse;

    /** @var PyStringNode */
    private $lastPayload;

    /** @var PersisterLoader */
    private $fixturesLoader;

    /** @var string */
    private $token;

    private static $getKernel;

    /**
     * @var FixturesManager
     */
    private FixturesManager $fixturesManager;

    public function __construct(KernelInterface $kernel, FixturesManager $fixturesManager)
    {
        parent::__construct();
        self::$getKernel = $kernel;
        $this->fixturesLoader = $kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->fixturesManager = $fixturesManager;
    }

    /**
     * @When I request to :method :path
     */
    public function iSendARequestTo(string $method, string $path): void
    {
        $options = ['headers' => $this->headers];
        if ($this->token) {
            $options['headers']['Authorization'] = $this->token;
        }

        if ($this->lastPayload) {
            $options['body'] = $this->lastPayload->getRaw();
        }

        if(isset($options['body'])) {
            if(str_contains($options['body'],"{product")) {
                $product = $this->get_string_between($options['body'],'"{','}"');
                $referencedValue = MyReferences::getReference($product);
                $options['body'] = str_replace('{'.$product.'}',"/products/".$referencedValue,$options['body']);
            }
            if(str_contains($options['body'],"{category")) {
                $category = $this->get_string_between($options['body'],'"{','}"');
                $referencedValue = MyReferences::getReference($category);
                $options['body'] = str_replace('{'.$category.'}',"/categories/".$referencedValue,$options['body']);
            }
            if(str_contains($options['body'],"{bookmark")) {
                $bookmark = $this->get_string_between($options['body'],'"{','}"');
                $referencedValue = MyReferences::getReference($bookmark);
                $options['body'] = str_replace('{'.$bookmark.'}',"/bookmarks/".$referencedValue,$options['body']);
            }
            if(str_contains($options['body'],"{userSeller")) {
                $userSeller = $this->get_string_between($options['body'],'"{','}"');
                $referencedValue = MyReferences::getReference($userSeller);
                $options['body'] = str_replace('{'.$userSeller.'}',"/users/".$referencedValue,$options['body']);
            }
            var_dump($options['body']);
        }



        $entity=$this->get_string_between($path,'{','}');
        if($entity !== "") {
            // replace by value
            $referencedValue= MyReferences::getReference($entity);

            $newPath = str_replace('{'.$entity.'}',$referencedValue,$path);
           // var_dump($referencedValue);
           // var_dump($newPath);
        }
        $this->lastResponse = $this->createClient()->request($method, $newPath ?? $path, $options);
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * @Given I log in
     */
    public function iLogIn(): void
    {
        $this->iSendARequestTo('POST', '/authentication_token');

        $this->token = 'Bearer ' . json_decode($this->lastResponse->getContent())->token;
    }

    /**
     * PAS UTILE SI PAYLOAD
     * @When I request to :method :path with data
     */
    public function iSendARequestWithData(string $method, string $path, PyStringNode $parameters): void
    {
        $this->lastResponse = $this->createClient()->request($method, $path, [
            'headers' => [
                'content-type' => 'application/ld+json'
            ],
            'body' => $parameters->getRaw()
        ]);
    }

    /**
     * @When I set payload
     */
    public function iSetPayload( PyStringNode $payload): void
    {
        $this->lastPayload = $payload;
    }

    /**
     * @param PyStringNode $payload
     * @When I have The Payload
     */
    public function iHavePayload(PyStringNode $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @param $statusCode
     * @Then The response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        var_dump($this->lastResponse->getStatusCode());
        if ($this->lastResponse->getStatusCode() != $statusCode) {
            throw new \RuntimeException('Status code error');
        }
    }
}
