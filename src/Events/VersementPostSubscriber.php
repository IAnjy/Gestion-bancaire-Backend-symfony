<?php

namespace App\Events;

use App\Entity\Versement;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VersementPostSubscriber implements EventSubscriberInterface{


    /**
     * @var ClientRepository
     */
    private $client;

    public function __construct(ClientRepository $client, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->client = $client;
    }

     public static function getSubscribedEvents()
     {
         return[
            KernelEvents::VIEW => ["calculSoldeVersement", EventPriorities::POST_WRITE]
         ];
     }


     public function calculSoldeVersement(ViewEvent $event){
        $versement = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($versement instanceof Versement && $method === "POST") {
           $montantVersement =  $versement->getMontantVersement();
           $idClient = $versement->getClient()->getId();
           $solde = $versement->getClient()->getSolde();
           $nouveauSolde = $solde + $montantVersement;

           $client = $this->client->find($idClient);
           $client->setSolde($nouveauSolde);

           $this->manager->persist($client);
           $this->manager->flush();

        }
     }
}