<?php

namespace App\Tests\Manager;

use Fidry\AliceDataFixtures\ProcessorInterface;

class FixturesManager implements ProcessorInterface
{

    /**
    * @inheritDoc
     */
    public function preProcess(string $id, $object): void
    {
        // do nothing
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function postProcess(string $id, $object): void
    {
        // TODO: Implement postProcess() method.
        if(method_exists($object,'getId')) {
            var_dump($id);
            var_dump($object->getId());
            MyReferences::addReference($id,$object->getId());
        }

    }
}
