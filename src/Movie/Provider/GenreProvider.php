<?php

namespace App\Movie\Provider;

use App\Entity\Genre;
use App\Movie\Transformer\OmdbToGenreTransformer;
use App\Repository\GenreRepository;

class GenreProvider
{
    public function __construct(
        protected readonly GenreRepository $repository,
        protected readonly OmdbToGenreTransformer $transformer,
    )
    {
    }

    public function getOne(string $name): Genre
    {
        return $this->repository->findOneBy(['name' => $name])
            ?? $this->transformer->transform($name);
    }

    public function getFromString(string $data): iterable
    {
        foreach (explode(', ', $data) as $name) {
            yield $this->getOne($name);
        }
    }
}
