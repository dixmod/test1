<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Traits\JsonSerializeTrait;
use JsonSerializable;

class AuthorDto implements JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @SerializedName("Id")
     */
    private int $id;

    /**
     * @SerializedName("Name")
     */
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
