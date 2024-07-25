<?php

namespace App\Movie\Provider;

use App\Entity\Movie;
use App\Movie\Enum\SearchType;

class MovieProvider
{
    public function getOne(string $value, SearchType $type = SearchType::Title): Movie
    {
        // Search movie in DB
        // if found return Movie
        // or
        // fetch data from OMDb
        // create Movie
        // add Genres
        // persist Movie
        // return Movie
    }
}
