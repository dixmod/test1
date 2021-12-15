<?php

declare(strict_types=1);

namespace App\Service\Author;

use App\Dto\Request\Author\AuthorCreateDto;
use App\Dto\Response\AuthorDto;
use App\Entity\Author;
use App\Factory\Response\AuthorFactory;
use Doctrine\ORM\EntityManagerInterface;

class Creator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(AuthorCreateDto $createDto): Author
    {
        $author = (new Author())
            ->setName($createDto->getName());

        $this->em->persist($author);
        $this->em->flush();

        return $author;
    }
}
