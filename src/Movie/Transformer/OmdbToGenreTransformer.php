<?php

namespace App\Movie\Transformer;

use App\Entity\Genre;

class OmdbToGenreTransformer
{
    public function transform(string $value): Genre
    {
        if (str_contains($value, ', ')) {
            throw new \InvalidArgumentException();
        }

        return (new Genre())->setName($value);
    }
}
