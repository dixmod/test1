<?php

declare(strict_types=1);

namespace App\Service\Book;

use App\Dto\Request\Author\AuthorCreateDto;
use App\Dto\Request\Book\BookCreateDto;
use App\Dto\Response\Book\BookDto;
use App\Entity\Author;
use App\Entity\Book;
use App\Factory\Response\BookFactory;
use App\Service\Author\Creator as AuthorCreator;
use App\Service\Author\Finder as AuthorFinder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class Creator
{
    private EntityManagerInterface $em;
    private AuthorFinder $authorFinder;
    private AuthorCreator $authorCreator;

    public function __construct(
        EntityManagerInterface $em,
        AuthorFinder $authorFinder,
        AuthorCreator $authorCreator
    ) {
        $this->em = $em;
        $this->authorFinder = $authorFinder;
        $this->authorCreator = $authorCreator;
    }

    public function create(BookCreateDto $requestDto): BookDto
    {
        $authors = $this->listAuthors($requestDto->getAuthors());

        $book = (new Book())
            ->setTitle($requestDto->getTitle())
            ->setAuthor($authors);

        $this->em->persist($book);
        $this->em->flush();

        return BookFactory::create($book);
    }

    /**
     * @param string[] $authors
     *
     * @return ArrayCollection<int, Author>
     */
    private function listAuthors(array $authors): ArrayCollection
    {
        $listAuthors = new ArrayCollection();

        foreach ($authors as $authorName) {
            $author = $this->authorFinder->findByName($authorName);

            if (null === $author) {
                $authorCreateDto = (new AuthorCreateDto())->setName($authorName);

                $author = $this->authorCreator->create($authorCreateDto);
            }

            $listAuthors[] = $author;
        }

        return $listAuthors;
    }
}
