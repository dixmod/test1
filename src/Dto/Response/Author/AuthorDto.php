<?php

declare(strict_types=1);

namespace App\Dto\Response\Author;

use App\Traits\JsonSerializeTrait;
use JsonSerializable;
use OpenApi\Annotations as OA;

class AuthorDto implements JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @OA\Property(description="Идендификатор автора", example="1")
     */
    private int $id;

    /**
     * @OA\Property(description="Имя автора", example="Пушкин Александ Сергеевич")
     */
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
