<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $book = new Book();
        $book->setTitle("L'échappée Bill");
        $book->setSlug('l-echappee-bill');
        $book->setImageName('boule-bill-tome-43-lechappee-bill.jpg');
        $book->setAuthor($this->getReference(AuthorFixtures::JEAN_ROBA));
        $book->setBookCategory($this->getReference(BookCategoryFixtures::BANDE_DESSINEE));
        $book->setIsActive(true);
        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Royal taquin");
        $book->setSlug('royal-taquin');
        $book->setImageName('boule-bill-tome-42-royal-taquin.jpg');
        $book->setAuthor($this->getReference(AuthorFixtures::JEAN_ROBA));
        $book->setBookCategory($this->getReference(BookCategoryFixtures::BANDE_DESSINEE));
        $book->setIsActive(true);
        $manager->persist($book);

        $book = new Book();
        $book->setTitle("Bill se tient à Caro");
        $book->setSlug('bill-se-tient-a-caro');
        $book->setImageName('boule-bill-tome-41-bill-se-tient-caro.jpg');
        $book->setAuthor($this->getReference(AuthorFixtures::JEAN_ROBA));
        $book->setBookCategory($this->getReference(BookCategoryFixtures::BANDE_DESSINEE));
        $book->setIsActive(true);
        $manager->persist($book);

        $manager->flush();
    }
}
