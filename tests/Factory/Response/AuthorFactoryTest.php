<?php

declare(strict_types=1);

namespace App\Tests\Factory\Response;

use App\Dto\Response\AuthorDto;
use App\Entity\Author;
use App\Factory\Response\AuthorFactory;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AuthorFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromClients(Author $author, AuthorDto $expected): void
    {
        $result = AuthorFactory::create($author);

        self::assertEquals($expected, $result);
    }

    /**
     * @return Generator<array<string, mixed>>
     */
    public function dataProvider(): Generator
    {
        yield [
            'author' => (new Author())
                ->setId(1)
                ->setName('AuthorTest1'),
            'expected' => (new AuthorDto(1, 'AuthorTest1'))
        ];

        yield [
            'author' => (new Author())
                ->setId(100)
                ->setName('AuthorTest100'),
            'expected' => (new AuthorDto(100, 'AuthorTest100'))
        ];
    }
}
