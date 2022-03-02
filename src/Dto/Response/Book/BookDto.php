<?php

declare(strict_types=1);

namespace App\Dto\Response\Book;

use OpenApi\Annotations as OA;
use App\Traits\JsonSerializeTrait;
use JsonSerializable;

class BookDto implements JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @OA\Property(description="Идендификатор книги", example="1")
     */
    private int $id;

    /**
     * @OA\Property(description="Название автора", example="Руслан и Людмила")
     */
    private string $title;

    /**
     * @var string[]
     *
     * @OA\Property(description="Aвторы", example={"Пушкин Александ Сергеевич"})
     */
    private array $author;

    /**
     * @param int $id
     * @param string $title
     * @param array $author
     */
    public function __construct(int $id, string $title, array $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function getAuthor(): array
    {
        return $this->author;
    }
}
