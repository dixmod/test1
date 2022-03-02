<?php

declare(strict_types=1);

namespace App\Factory\Response;

use App\Dto\Response\Book\BookDto;
use App\Entity\Book;
use Doctrine\Common\Collections\Collection;

class BookFactory
{
    public static function create(Book $book): BookDto
    {
        return new BookDto(
            $book->getId(),
            $book->getTitle(),
            self::createAuthors($book->getAuthor()),
        );
    }

    private static function createAuthors(Collection $authors): array
    {
        $listAuthorDto = [];

        foreach ($authors as $author) {
            $listAuthorDto[] = AuthorFactory::create($author);
        }

        return $listAuthorDto;
    }
}
