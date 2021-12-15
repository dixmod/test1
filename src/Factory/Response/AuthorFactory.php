<?php

declare(strict_types=1);

namespace App\Factory\Response;

use App\Dto\Response\AuthorDto;
use App\Entity\Author;

class AuthorFactory
{
    public static function create(Author $author): AuthorDto
    {
        return new AuthorDto($author->getId(), $author->getName());
    }
}
