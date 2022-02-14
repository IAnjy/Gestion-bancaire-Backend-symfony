<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Retrait;
use App\Entity\Versement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory:: create("fr_FR");

        for($c = 1; $c <= 20; $c++){
            $client = new Client;
            $client->setPrenoms($faker->firstName())
                   ->setNom($faker->lastName())
                   ->setSolde($faker->randomFloat(0, 6000,8000000));
            if ($c < 10) $client->setNumCompte("C0000".$c); else $client->setNumCompte("C000".$c);   
            
            $manager->persist($client);

            for ($i=0; $i < mt_rand(2,4); $i++) { 
                $versement = new Versement;
                $versement->setMontantVersement($faker->randomFloat(0, 10000,1200000))
                        ->setDateVersement($faker->dateTimeBetween('-6 months'))
                        ->setClient($client);

                $manager->persist($versement);
            }

            for ($i=0; $i < mt_rand(2,4); $i++) { 
                $retrait = new Retrait;
                $retrait->setNumCheque("CQ".$faker->randomFloat(0, 100,1000))
                        ->setMontantRetrait($faker->randomFloat(0, 10000,1200000))
                        ->setDateRetrait($faker->dateTimeBetween('-6 months'))
                        ->setClient($client);

                $manager->persist($retrait);
            }
            
        }

        $manager->flush();
    }
}
