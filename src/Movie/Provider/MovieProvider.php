<?php

namespace App\Movie\Provider;

use App\Entity\Movie;
use App\Movie\Consumer\OmdbApiConsumer;
use App\Movie\Enum\SearchType;
use App\Movie\Transformer\OmdbToMovieTransformer;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;

class MovieProvider
{
    public function __construct(
        protected readonly MovieRepository $repository,
        protected readonly EntityManagerInterface $manager,
        protected readonly OmdbApiConsumer $consumer,
        protected readonly OmdbToMovieTransformer $transformer,
        protected readonly GenreProvider $genreProvider,
    )
    {
    }

    public function getOne(string $value, SearchType $type = SearchType::Title): Movie
    {
        $movie = $this->repository->findLikeOmdb($type, $value);

        if ($movie instanceof Movie) {
            return $movie;
        }

        $data = $this->consumer->fetch($value, $type);
        $movie = $this->transformer->transform($data);

        foreach ($this->genreProvider->getFromString($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }

        $this->manager->persist($movie);
        $this->manager->flush();

        return $movie;
    }
}
