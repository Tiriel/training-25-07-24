<?php

namespace App\Movie\Provider;

use App\Entity\Genre;

class GenreProvider
{
    public function getOne(string $name): Genre
    {
        // return Genre from DB
        // or create it
    }

    public function getFromString(string $data): iterable
    {
        foreach (explode(', ', $data) as $name) {
            yield $this->getOne($name);
        }
    }
}
