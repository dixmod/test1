<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public const COUNT_FIXTURES = 1000;

    /**
     * @var Author[]
     */
    private array $authors;

    private Generator $faker;

    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create('ru_RU');

        $this->createAuthors();
        $this->createBooks();
    }

    private function createAuthors(): void
    {
        for ($i = 0; $i < self::COUNT_FIXTURES; $i++) {
            $author = new Author();
            $author->setName($this->faker->name);
            $this->manager->persist($author);

            $this->manager->persist($author);

            $this->authors[] = $author;
        }

        $this->manager->flush();
    }

    /**
     * @throws Exception
     */
    private function createBooks(): void
    {
        for ($i = 0; $i < self::COUNT_FIXTURES; $i++) {
            $authors = $this->listAuthors();

            $book = new Book();
            $book->setTitle($this->faker->title)
                ->setAuthor($authors);

            $this->manager->persist($book);
        }

        $this->manager->flush();
    }

    /**
     * @return Author[]
     * @throws Exception
     *
     */
    private function listAuthors(): array
    {
        $authors = [];

        for ($index = 1; random_int(1, 5); $index++) {
            $authors[] = $this->faker->randomElement($this->authors);
        }

        return $authors;
    }
}
