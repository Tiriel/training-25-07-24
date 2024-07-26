<?php

namespace App\Event;

use App\Entity\Movie;
use App\Entity\User;
use App\Event\MovieEvent;

class MovieUnderageEvent extends MovieEvent
{
    public function __construct(
        ?Movie $movie = null,
        protected ?User $user = null,
    ) {
        parent::__construct($movie);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): MovieUnderageEvent
    {
        $this->user = $user;

        return $this;
    }
}
