<?php

namespace App\DataFixtures;

use App\Entity\Home;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class HomeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $home = new Home();
         $home->setTitre('Bienvenue sur le site de la librairie');
         $home->setTexte('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lacinia dui sem, sit amet congue lectus lacinia eu. Aliquam ut ligula non neque imperdiet semper sit amet vitae odio. Pellentesque ac ullamcorper sem. Integer pellentesque gravida vehicula. In posuere felis mi, ut dapibus ante dapibus at. Phasellus tincidunt nisl elit, vel aliquet diam mollis non. Maecenas tincidunt metus quis neque commodo ullamcorper. Phasellus porttitor, felis sit amet dignissim vulputate, mauris risus mollis leo, vel convallis erat eros in ipsum.</p>'
    );
        $home->setSignature("l'equipe de la Librairie");
        $home->setIsActive(true);
         $manager->persist($home);

        $manager->flush();
    }
}
