<?php

declare(strict_types=1);

namespace App\Dto\Request\Author;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorCreateDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
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
