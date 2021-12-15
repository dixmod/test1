<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Traits\JsonSerializeTrait;
use JsonSerializable;

class BookDto implements JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @SerializedName("Id")
     */
    private int $id;

    /**
     * @SerializedName("Title")
     */
    private string $title;

    /**
     * @SerializedName("Author")
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
}
