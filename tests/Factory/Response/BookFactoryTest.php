<?php

declare(strict_types=1);

namespace App\Tests\Factory\Response;

use App\Dto\Response\Author\AuthorDto;
use App\Dto\Response\Book\BookDto;
use App\Entity\Author;
use App\Entity\Book;
use App\Factory\Response\BookFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class BookFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromClients(Book $author, BookDto $expected): void
    {
        $result = BookFactory::create($author);

        self::assertEquals($expected, $result);
    }

    /**
     * @return Generator<array<string, mixed>>
     */
    public function dataProvider(): Generator
    {
        yield [
            'author' => (new Book())
                ->setId(1)
                ->setTitle('BookTest1'),
            'expected' => (new BookDto(1, 'BookTest1', []))
        ];

        $authors = new ArrayCollection();

        $author = (new Author())
            ->setId(1)
            ->setName('AuthorTest1');

        $authors->add($author);

        yield [
            'author' => (new Book())
                ->setId(100)
                ->setTitle('BookTest100')
                ->setAuthor($authors),
            'expected' => (new BookDto(100, 'BookTest100', [new AuthorDto(1, 'AuthorTest1')]))
        ];
    }
}
