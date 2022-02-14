<?php

namespace App\Events;

use App\Entity\Versement;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Retrait;
use App\Entity\Transfert;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DateVersementSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['setDateVersement', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setDateVersement( ViewEvent $event){
        $data = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($data instanceof Versement && $method === "POST") {
            // dd($versement);
           if (empty($data->getDateVersement())) {
               $date = new \DateTime();
               $date->modify("+3 hours"); // GMT +3 tsika fa tsy aiko hoe ahona msetting anle izy
               $data->setDateVersement($date);
           }
        }

        if ($data instanceof Retrait && $method === "POST") {
            // dd($versement);
           if (empty($data->getDateRetrait())) {
               $date = new \DateTime();
               $date->modify("+3 hours"); // GMT +3 tsika fa tsy aiko hoe ahona msetting anle izy
               $data->setDateRetrait($date);
           }
        }

        if ($data instanceof Transfert && $method === "POST") {
            // dd($versement);
           if (empty($data->getDateTransfert())) {
               $date = new \DateTime();
               $date->modify("+3 hours"); // GMT +3 tsika fa tsy aiko hoe ahona msetting anle izy
               $data->setDateTransfert($date);
           }
        }
    }
}