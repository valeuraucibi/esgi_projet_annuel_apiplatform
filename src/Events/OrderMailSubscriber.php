<?php
// api/src/EventSubscriber/OrderMailSubscriber.php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\ShippingAddress;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Component\Security\Core\Security;

final class OrderMailSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE],
        ];
    }

    public function sendMail(ViewEvent $event): void
    {
        $order = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        //$lastName=htmlspecialchars(strip_tags($order->getFirstName()));
        //$firstName=htmlspecialchars(strip_tags($order->getLastName()));
       // $orderItems=htmlspecialchars(strip_tags($order->getOrderItems()));
        //$mail=htmlspecialchars(strip_tags($order->getMail())); 

        if ($order instanceof Order && (($method === "POST") || ($method === "PUT")) /*!$order instanceof Order || Request::METHOD_POST !== $method*/) {
           // return; 
                
        
            if($order->getIsPaid() === true){
                $orders="";
                foreach($order->getOrderItems() as $item) { $orders.=("<tr> <td>".
                $item->getName()."</td> <td align='center'>".
                $item->getQty()."</td><td align='right'>".$item->getPrice().
                "</td></tr>");}
                $shippingAddresses="";
                foreach($order->getShippingAddress() as $item) { $shippingAddresses.=(
                $item->getFullName().",<br/>".
                $item->getAddress().",<br/>".
                $item->getCity().",<br/>".
                $item->getCountry().",<br/>");}

                $message = (new TemplatedEmail())
                    ->from('papadiaki90@gmail.com')
                    ->to($order->getCustomer()->getEmail())
                    ->subject('Facture')
                    ->priority(Email::PRIORITY_HIGH)
                    //->setBody(sprintf('The book #%d has been added.', $book->getId()));
                    ->html(  "<h1>Merci d'avoir acheté chez nous.</h1> <p> Salut ".
                    $order->getCustomer()->getfirstName()." " .$order->getCustomer()->getlastName() .
                    ",</p> <p>Nous avons terminé le traitement de votre commande</p> <h2>[Commande ".$order->getId()." ] ".
                    $order->getCreatedAt()->format('Y-m-d').
                    "</h2> <table> <thead> <tr> <td><strong>Product</strong></td> <td><strong>Quantité</strong></td> <td> <strong align='right'>Prix</strong> </td> </thead> <tbody>". 
                    $orders."</tbody> <tfoot> <tr> <td colspan='2'>Sous total :</td> <td align='right'>".$order->getItemsPrice().
                    "<tr> <td colspan='2'>TVA:</td><td align='right'>".$order->getTaxPrice().
                    "</td> </tr> <tr> <td colspan='2'>Prix de l'expédition:</td> <td align='right'>".
                    $order->getShippingPrice().
                    "</td> </tr> <tr> <td colspan='2'><strong>Total:</strong></td> <td align='right'><strong>".
                    $order->getTotalPrice().
                    "</strong></td></tr> <tr><td colspan='2'>Mode de paiement:</td><td align='right'>"
                    .$order->getPaymentMethod().
                    "</td></tr></table>".
                    " <h2>Adresse de livraison</h2>".
                    $shippingAddresses.
                    "<br/> </p> <hr/> <p>Merci d'avoir acheté chez nous.</p>")
    
                    //->setBody(sprintf('The order #%d has been added.', $order->getId()))
                    //->htmlTemplate("emails/orderMail.html.twig")
                /*->context(
                        [ $order,
                            ])*/
                    
                    ;
                //  dd($order);
                $this->mailer->send($message);   
            }
    }
    }
    
}