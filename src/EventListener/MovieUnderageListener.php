<?php

namespace App\EventListener;

use App\Event\MovieUnderageEvent;
use App\Notifier\AppNotifier;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class MovieUnderageListener
{
    public function __construct(protected readonly AppNotifier $notifier)
    {
    }

    #[AsEventListener(event: MovieUnderageEvent::class)]
    public function onMovieUnderageEvent(MovieUnderageEvent $event): void
    {
        $movie = $event->getMovie();
        $user = $event->getUser();
        $message = sprintf(
            'User "%s" (age %d) tried to view movie "%s" (rated %s)',
            $user->getUserIdentifier(),
            $user->getBirthday()?->diff(new \DateTimeImmutable())->y,
            $movie->getTitle(),
            $movie->getRated(),
        );

        $this->notifier->sendNotification($message);
    }
}
