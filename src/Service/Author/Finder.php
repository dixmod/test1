<?php

declare(strict_types=1);

namespace App\Service\Author;

use App\Dto\Request\Book\BookSearchDto;
use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;

class Finder
{
    private AuthorRepository $repository;

    /**
     * @param AuthorRepository $repository
     */
    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findByName(string $name): ?Author
    {
        return $this->repository->findOneBy([
            'name' => $name
        ]);
    }
}
