<?php

declare(strict_types=1);

namespace App\Service\Book;

use App\Dto\Request\Book\BookSearchDto;
use App\Entity\Book;
use App\Factory\Response\BookFactory;
use App\Repository\BookRepository;

class Finder
{
    private BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BookSearchDto $requestDto
     *
     * @return Book[]
     */
    public function find(BookSearchDto $requestDto): array
    {
        $books = $this->repository->findBy([
            'title' => $requestDto->getTitle()
        ]);

        return array_map(
            static fn (Book $book) => BookFactory::create($book),
            $books
        );
    }
}
