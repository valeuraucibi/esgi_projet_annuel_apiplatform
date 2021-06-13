<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Comment;
use App\Entity\Message;
use App\Entity\Product;
use App\Entity\Bookmark;
use App\Entity\Category;
use App\Entity\PaymentResult;
use App\Entity\ShippingAddress;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder ;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
 
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

        //$contentChanged   = $faker->dateTime('now');
        //->setContentChanged($contentChanged)

        $adminUser = new User();
        $adminUser->setFirstName('Lassana')
                  ->setLastName('Diakité')
                  ->setEmail('ld@gmail.com')
                  ->setPassword( '$argon2i$v=19$m=65536,t=4,p=1$Nzd4S2JTcHBDVVRCdmhaMQ$lnG+Lb9ZEAMoakhubfHGTRNWHun/QHgfZ0L9cbed7sI')
                //  ->setPicture('https://netrinoimages.s3.eu-west-2.amazonaws.com/2012/05/26/136161/57586/ac_cobra_shelby_cobra_3d_model_c4d_max_obj_fbx_ma_lwo_3ds_3dm_stl_506117_o.jpg')
                  ->setRoles(['ROLE_ADMIN'])

                  ->setAccountStatus("Active")
                  ;

        $manager->persist($adminUser);
        
        
        //Nous gérons les utilisateurs customers (clients )
    
        $customers=[];
        $genres = ['male', 'female'];

        for($i = 1; $i <=10; $i++){
            $customer = new User();
            
            
         /*   $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;
            */
            $password = $this->encoder->encodePassword($customer, 'password');
            
            $customer->setFirstName($faker->firstname)
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setRoles(['ROLE_CUSTOMER'])
                 ->setPassword($password)
                 ->setAccountStatus("Active")
                 ;
                // ->setPicture($picture);

            $manager->persist($customer);
            $customers[]= $customer;

            
        }

        // Gestion des messages
        for($l = 1; $l <=20; $l++){
            $customerMessage   = $customers[mt_rand(0, count($customers) - 1)];
            $message = new Message();
            $message->setContent($faker->paragraph())
                ->setSubject($faker->domainWord)
                ->setAuthor($customerMessage)
                ->setStatus($faker->randomElement(['SENT', 'READ', 'ANSWER']))  
                ;

            $manager->persist($message);
        }


        // les vendeurs (seller)
            $usersSeller =[];
        for($j = 1; $j <=10; $j++){
            $userSeller = new User();

            
            $genre = $faker->randomElement($genres);

          /*  $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;
            */
            $password = $this->encoder->encodePassword($userSeller, 'password');
            //$status = ["Active", "Attente", "Désactivé"];
            $birthdate = $faker->dateTimeBetween('-50 months');
            
          
            $userSeller->setFirstName($faker->firstname)
            ->setLastName($faker->lastname)
            ->setEmail($faker->email)
            ->setRoles(['ROLE_SELLER'])
            ->setPassword($password)
            ->setAccountStatus($faker->randomElement(["Active", "Attente", "Désactivé"]))
            ->setAddress($faker->address)
            ->setBirthdate($birthdate)
            ->setPhone($faker->phoneNumber)
            ->setSiren($faker->siren)
            ->setCompanyName($faker->company)
            ;  
            $manager->persist($userSeller);
            $usersSeller[]= $userSeller;
        }

        //Nous gérons les catégories
        $categories = [];
        for($i=1; $i<=10; $i++){
            $category = new Category();
            $category->setName($faker->jobTitle($nbWords = 15, $variableNbWords = false))
            ->setDescription($faker->paragraph(4));
            $manager->persist($category);
            $categories[]= $category;
        }

        // Nous gérons shipping address
        $shippingAddresses = [];
        for($i=1; $i<=10; $i++){
            $shippingAddress = new ShippingAddress();
            $shippingAddress->setFullName($faker->firstname)
            ->setAddress($faker->address)
            ->setPostalCode(mt_rand(9000, 10000))
            ->setCity($faker->city)
            ->setCountry($faker->country)
            ;  
            $manager->persist($shippingAddress);
            $shippingAddresses[]= $shippingAddress;
        }

        // Nous gérons payment result
        $paymentResults = [];
        for($i=1; $i<=10; $i++){
            $paymentResult = new PaymentResult();
            $paymentResult->setStatus($faker->randomElement(['Paid', 'Not paid']))
                          ->setEmailAddress($faker->email);
            $manager->persist($paymentResult);
            $paymentResults[]= $paymentResult;
        }
        
        // Gestion des Order
              $products = [];
        
            $orders = [];
        for ($k = 1; $k <= mt_rand(6, 10); $k++) {
            $order = new Order();
            

          //  $product = $products[mt_rand(0, count($products) -1)];
            $customerOrder  = $customers[$faker->unique()->numberBetween(0, count($customers) - 1)];
            $orderPaymentResult    = $paymentResults[mt_rand(0, count($paymentResults) -1)];
            $ordershippingAddress    = $shippingAddresses[mt_rand(0, count($shippingAddresses) -1)];

            $order->setCustomer($customerOrder)
                  ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))   
                  ->setAmount(mt_rand(50, 1000))
                  ->setItemsPrice(mt_rand(50, 100))
                  ->setShippingPrice(mt_rand(50, 110))
                  ->setTaxPrice(mt_rand(60, 120))
                  ->setTotalPrice(mt_rand(50, 1000))
                  ->setPaymentResult($orderPaymentResult)
                  ->addShippingAddress($ordershippingAddress)
                  ->setPaymentMethod($faker->randomElement(['PAYPAL', 'STRIPE']))  
                  //
                  ;

                //Nous gérons les Produits
        
            for($i=1; $i <= 30; $i++){
                $product = new Product(); 
                
        
                $name       = $faker->jobTitle;
                $image   = $faker->imageUrl();
            //    $introduction = $faker->sentence($nbWords = 15, $variableNbWords = false);
                $description      = '<p>'. join('</p><p>', $faker->paragraphs(4)) . '</p>';
            
                
                
                $userSeller    = $usersSeller[mt_rand(0, count($usersSeller) -1)];
                $category = $categories[mt_rand(0, count($categories) -1)];
               // $order = $orders[mt_rand(0, count($orders) -1)];
        
                $product->setName($name)
                ->setImage($faker->picsumUrl(829, 679))
                //->setReference($faker->isbn13()) 
                ->setBrand($faker->jobTitle($nbWords = 15, $variableNbWords = true))
                ->setDescription($faker->paragraph(4))
                ->setPrice(mt_rand(40, 200))
                ->setUserId($userSeller)
                ->setCategory($category)
                //->addOrder($order)
                ->setRating(mt_rand(1, 5))
                ->setNumReviews(mt_rand(8, 21))
                ->setCountInStock(mt_rand(0, 25))
                ;
            
                    // Gestion des commentaires
                    if (mt_rand(0, 1)) {
                        $userComment   = $customers[mt_rand(0, count($customers) - 1)];
                        $comment = new Comment();
                        $comment->setContent($faker->paragraph())
                            ->setRating(mt_rand(1, 5))
                            ->setAuthor($userComment)
                            ->setProduct($product)
                            ;
        
                        $manager->persist($comment);
                    }

                    
                
                $manager->persist($product);
                $products[] = $product;
                
                }
        //
            $manager->persist($order);
            $orders[] = $order;
        }
         // Gestion des Bookmark
         for($l = 1; $l <=20; $l++){
            $customerBookmark   = $customers[mt_rand(0, count($customers) - 1)];
            $productBookmark   = $products[mt_rand(0, count($products) - 1)];
            $bookmark = new Bookmark();
            $bookmark->setProduct($productBookmark)
                ->setUserId($customerBookmark);

            $manager->persist($bookmark);
        }

        $manager->flush();
    }
}
