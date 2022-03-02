<?php

declare(strict_types=1);

namespace App\Dto\Request\Book;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class BookSearchDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     *
     * @OA\Property(description="Название автора", example="Руслан и Людмила")
     */
    private string $title;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
