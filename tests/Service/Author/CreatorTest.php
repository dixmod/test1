<?php

declare(strict_types=1);

namespace App\Tests\Service\Author;

use App\Dto\Request\Author\AuthorCreateDto;
use App\Entity\Author;
use App\Service\Author\Creator;
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
        $this->em->method('persist')->will($this->returnCallback(function ($Author) {
            if ($Author instanceof Author) {
                $Author->setId(1);
            }
        }));

        $this->service = new Creator(
            $this->em
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCreate(
        AuthorCreateDto $request,
        Author $expected
    ): void {
        $this->em
            ->expects(self::once())
            ->method('persist');

        $this->em
            ->expects(self::once())
            ->method('flush');

        $result = $this->service->create($request);

        self::assertInstanceOf(Author::class, $result);

        self::assertEquals($expected, $result);
    }

    /**
     * @return Generator<array<string, mixed>>
     */
    public function dataProvider(): Generator
    {
        yield [
            'request' => (new AuthorCreateDto())
                ->setName('AuthorTest1'),
            'expected' => (new Author())
                ->setId(1)
                ->setName('AuthorTest1'),
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
