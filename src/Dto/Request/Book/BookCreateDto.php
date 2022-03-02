<?php

declare(strict_types=1);

namespace App\Dto\Request\Book;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class BookCreateDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     *
     * @OA\Property(description="Название автора", example="Руслан и Людмила")
     */
    private string $title;

    /**
     * @var string[]
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="array")
     * @Assert\Count(min=1)
     *
     * @OA\Property(description="Авторы", example={"Пушкин Александ Сергеевич"})
     */
    private array $authors;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }
}
