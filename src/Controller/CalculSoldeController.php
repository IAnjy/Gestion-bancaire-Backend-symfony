<?php

namespace App\Controller;

use App\Entity\Versement;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalculSoldeController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
   
    /**
     *
     *
     * @var ClientRepository
     */
    private $client;


    public function __construct(EntityManagerInterface $manager, ClientRepository $client)
    {
        $this->manager = $manager;
        $this->client = $client;
    }



    public function __invoke(Versement $data)
    {
        $versement = $data->getMontantVersement();
        $idClient = $data->getClient()->getId();
        $solde =  $data->getClient()->getSolde();
        $nouveauSolde = $solde + $versement;

        $client = $this->client->find($idClient);
        $client->setSolde($nouveauSolde);

        ////////: $data->getClient()-setSolde($solde + $versement);
        // $nouveauSolde = $solde + $versement;
        // $client->setSolde($nouveauSolde);

        $this->manager->persist($client);
        $this->manager->flush();

        return $data;
        // dd($data);
    }
}