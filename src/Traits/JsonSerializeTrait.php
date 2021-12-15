<?php

declare(strict_types=1);

namespace App\Traits;

use JsonSerializable;

trait JsonSerializeTrait
{
    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return self::jsonSerializeRecursive(get_object_vars($this));
    }

    /**
     * @param array<mixed> $data
     *
     * @return array<mixed>
     */
    public static function jsonSerializeRecursive(array $data): array
    {
        return array_map(static function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            }

            if (is_array($value)) {
                return self::jsonSerializeRecursive($value);
            }

            return $value;
        }, $data);
    }
}
