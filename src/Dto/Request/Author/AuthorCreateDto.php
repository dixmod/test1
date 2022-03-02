<?php

declare(strict_types=1);

namespace App\Dto\Request\Author;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorCreateDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     *
     * @OA\Property(description="Имя автора", example="Пушкин Александ Сергеевич")
     */
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
