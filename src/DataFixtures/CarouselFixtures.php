<?php

namespace App\DataFixtures;

use App\Entity\Carousel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarouselFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $carousel = new Carousel();
         $carousel->setTag('home');
         $carousel->setImageName('bac-francais-livres-revisions.jpg');
         $manager->persist($carousel);

         $carousel = new Carousel();
         $carousel->setTag('home');
         $carousel->setImageName('GettyImages-1317481170.jpg');
         $manager->persist($carousel);

         $carousel = new Carousel();
         $carousel->setTag('home');
         $carousel->setImageName('livre-ouvert-pour-decoration.jpg');
         $manager->persist($carousel);

        $manager->flush();
    }
}
