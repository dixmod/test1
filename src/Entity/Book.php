<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\Table(name="book", indexes={
 *     @ORM\Index(name="search_idx", columns={"title"})
 * })
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=255, unique=true)
     */
    private string $title;

    /**
     * @var ArrayCollection<int, Author>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Author", mappedBy="id")
     */
    private $author;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function setAuthor(Collection $author): self
    {
        $this->author = $author;

        return $this;
    }
}
