<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Versement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory:: create();

        for($c = 1; $c <= 20; $c++){
            $client = new Client;
            $client->setPrenoms($faker->firstName())
                   ->setNom($faker->lastName())
                   ->setSolde($faker->randomFloat(0, 6000,8000000));
            if ($c < 10) $client->setNumCompte("C0000".$c); else $client->setNumCompte("C000".$c);   
            
            $manager->persist($client);

            for ($i=0; $i < mt_rand(3,8); $i++) { 
                $versement = new Versement;
                $versement->setMontantVersement($faker->randomFloat(0, 10000,1200000))
                        ->setDateVersement($faker->dateTimeBetween('-6 months'))
                        ->setClient($client);

                $manager->persist($versement);
            }
            
        }

        $manager->flush();
    }
}
