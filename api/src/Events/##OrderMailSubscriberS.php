<?php
// api/src/EventSubscriber/OrderMailSubscriberS.php

/*namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Order;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class OrderMailSubscriberS implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
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

        if (!$order instanceof Order || Request::METHOD_POST !== $method) {
            return;
        }
        if($order->getIsPaid() === true){
            $message = (new \Swift_Message('A new order has been added'))
                ->setFrom('papadiaki90@gmail.com')
                ->setTo('lassanadiakite90@gmail.com')
                ->setBody(sprintf('The order #%d has been added.', $order->getId()));

            $this->mailer->send($message);
        }
    }
}*/