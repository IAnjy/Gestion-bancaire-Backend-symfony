<?php

namespace App\Events;

use App\Entity\Versement;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DateVersementSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['setDateVersement', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setDateVersement( ViewEvent $event){
        $versement = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($versement instanceof Versement && $method === "POST") {
            // dd($versement);
           if (empty($versement->getDateVersement())) {
               $date = new \DateTime();
               $date->modify("+3 hours"); // GMT +3 tsika fa tsy aiko hoe ahona msetting anle izy
               $versement->setDateVersement($date);
           }
        }
    }
}