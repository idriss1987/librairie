<?php

namespace App\DataFixtures;

use App\Entity\Author;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuthorFixtures extends Fixture
{
    // ====================================================== //
    // ===================== PROPRIETES ===================== //
    // ====================================================== //
    public const JEAN_ROBA = "jean roba";
    public const VICTOR_HUGO = "victor hugo";
    public const ALDER_OLSEN = "alder-olsen";
    // ====================================================== //
    // ====================== METHODES ====================== //
    // ====================================================== //
    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $author->setName('Roba');
        $author->setFirstName('Jean');
        $author->setSlug('jean-roba');
        $author->setBirthdate(new DateTime("1802/02/26"));
        $author->setImageName("jean-roba.jpg");
        $manager->persist($author);
        $this->setReference(self::JEAN_ROBA, $author);

        $author = new Author();
        $author->setName('Hugo');
        $author->setFirstName('Victor');
        $author->setSlug('victor-hugo');
        $author->setImageName("jean-roba.jpg");
        $author->setBirthdate(new DateTime("1802/02/26"));
        $author->setDateOfDeath(new DateTime("1885/05/22"));
        $manager->persist($author);
        $this->setReference(self::VICTOR_HUGO, $author);

        $author = new Author();
        $author->setName('Alder-Olsen');
        $author->setFirstName('Jussi');
        $author->setSlug('jussi-alder-olsen');
        $author->setImageName("jussi_adler-olsen.jpg");
        $author->setBirthdate(new DateTime("1950/08/02"));
        $manager->persist($author);
        $this->setReference(self::ALDER_OLSEN, $author);


        $manager->flush();
    }
}
