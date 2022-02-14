<?php

namespace App\Events;

use App\Entity\Versement;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Retrait;
use App\Entity\Transfert;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RetraitPostSubscriber implements EventSubscriberInterface{


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
            KernelEvents::VIEW => ["calculSoldeRetrait", EventPriorities::PRE_WRITE]
         ];
     }


     public function calculSoldeRetrait(ViewEvent $event){
        $data = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($data instanceof Retrait && $method === "POST") {
            $montantRetrait =  $data->getMontantRetrait();
            $idClient = $data->getClient()->getId();
            $solde = $data->getClient()->getSolde();
            if ($solde < $montantRetrait) {
               dd('erreur');
            } else {
            $nouveauSolde = $solde - $montantRetrait;
            
            $client = $this->client->find($idClient);
            $client->setSolde($nouveauSolde);

            $this->manager->persist($client);
            $this->manager->flush();
            }
        }

        if ($data instanceof Transfert && $method === "POST") {
           $montantTransfert = $data->getMontantTransfert();
           $IDenvoyeur = $data->getEnvoyeur()->getId();
           $IDdestinataire = $data->getDestinataire()->getId();
           $soldeEnvoyeur = $data->getEnvoyeur()->getSolde();
           $soldeDestinataire = $data->getDestinataire()->getSolde();
            if ($soldeEnvoyeur < $montantTransfert) {
               dd('Kely ny solde ry zoky e ');
            } else {
               $nouveauSoldeEnvoyeur = $soldeEnvoyeur - $montantTransfert;
               $nouveauSoldeDestinataire = $soldeDestinataire + $montantTransfert;

               $client1 = $this->client->find($IDenvoyeur);
               $client1->setSolde($nouveauSoldeEnvoyeur);

               $client = $this->client->find($IDdestinataire);
               $client->setSolde($nouveauSoldeDestinataire);

               $this->manager->persist($client1);
               $this->manager->persist($client);
               $this->manager->flush();
            }
            

        }
     }
}