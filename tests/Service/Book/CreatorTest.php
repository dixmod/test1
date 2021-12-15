<?php

declare(strict_types=1);

namespace App\Tests\Service\Book;

use App\Dto\Request\Book\BookCreateDto;
use App\Dto\Response\AuthorDto;
use App\Dto\Response\BookDto;
use App\Entity\Author;
use App\Entity\Book;
use App\Service\Author\Creator as AuthorCreator;
use App\Service\Author\Finder as AuthorFinder;
use App\Service\Book\Creator;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class CreatorTest extends TestCase
{
    private Creator $service;

    protected function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->em->method('persist')->will($this->returnCallback(function ($book) {
            if ($book instanceof Book) {
                $book->setId(1);
            }
        }));

        $this->authorFinder = $this->createMock(AuthorFinder::class);
        $this->authorFinder->method('findByName')
        ->willReturn((new Author())->setId(1)->setName('testAuthor1'));

        $this->authorCreator = $this->createMock(AuthorCreator::class);

        $this->service = new Creator(
            $this->em,
            $this->authorFinder,
            $this->authorCreator
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCreate(
        BookCreateDto $request,
        BookDto $expected
    ): void {
        $this->em
            ->expects(self::once())
            ->method('persist')
        ;

        $this->em
            ->expects(self::once())
            ->method('flush')
        ;

        $result = $this->service->create($request);

        self::assertInstanceOf(BookDto::class, $result);

        self::assertEquals($expected, $result);
    }

    /**
     * @return Generator<array<string, mixed>>
     */
    public function dataProvider(): Generator
    {
        yield [
            'request' => (new BookCreateDto())
                ->setTitle('bookTest1')
                    ->setAuthors(['testAuthor1']),

            'expected' => new BookDto(1, 'bookTest1', [
                new AuthorDto(1, 'testAuthor1'),
            ]),
        ];

        yield [
            'request' => (new BookCreateDto())
                ->setTitle('bookTest1')
                ->setAuthors(['testAuthor1','testAuthor1']),

            'expected' => new BookDto(1, 'bookTest1', [
                new AuthorDto(1, 'testAuthor1'),
                new AuthorDto(1, 'testAuthor1'),
            ]),
        ];
    }

    private function getAuthor()
    {
        yield (new Author())
            ->setId(1)
            ->setName('testAuthor1');

        yield (new Author())
            ->setId(2)
            ->setName('testAuthor2');
    }
}
