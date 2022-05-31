<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        // $product = new Product();
        // $manager->persist($product);
        
        for ($i=1; $i < 101; $i++) { 
            $property = new Property;
            $property->setTitle("Mon Titre ".$i)
                    ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ".$i)
                    ->setSurface(rand(10, 350))
                    ->setRooms(rand(2, 10))
                    ->setBedrooms(rand(1, 9))
                    ->setFloor(rand(0, 15))
                    ->setPrice(rand(1000, 100000))
                    ->setHeat(rand(1, count(Property::HEAT)))
                    ->setPostalCode(random_int(10000, 99999))
                    ->setCity('Montpellier '.$i)
                    ->setAddress('Adressse '.$i)
                    ->setSold(false);

            $manager->persist($property);
        }

        $manager->flush();
    }
}
