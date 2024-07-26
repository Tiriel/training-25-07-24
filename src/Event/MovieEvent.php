<?php

namespace App\Event;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

abstract class MovieEvent extends Event
{
    public function __construct(
        protected ?Movie $movie = null,
    ) {
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): MovieEvent
    {
        $this->movie = $movie;

        return $this;
    }
}
