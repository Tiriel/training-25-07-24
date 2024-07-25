<?php

namespace App\Movie\Transformer;

use App\Entity\Movie;

class OmdbToMovieTransformer
{
    public const KEYS = [
        'Released',
        'Year',
        'Title',
        'Poster',
        'Plot',
        'Country',
        'Rated',
        'imdbID',
    ];

    public function transform(array $value): Movie
    {
        if (0 < \count(\array_diff(self::KEYS, \array_keys($value)))) {
            throw new \InvalidArgumentException();
        }

        $date = $value['Released'] === 'N/A' ? '01-01-'.$value['Year'] : $value['Released'];

        return (new Movie())
            ->setTitle($value['Title'])
            ->setPlot($value['Plot'])
            ->setCountry($value['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPoster($value['Poster'])
            ->setPrice(5.0)
            ->setRated($value['Rated'])
            ->setImdbId($value['imdbID'])
        ;
    }
}
