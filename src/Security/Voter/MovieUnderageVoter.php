<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use App\Event\MovieUnderageEvent;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MovieUnderageVoter implements VoterInterface
{
    public const UNDERAGE = 'movie.underage';

    public function __construct(protected readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return self::ACCESS_ABSTAIN;
        }

        foreach ($attributes as $attribute) {
            if (self::UNDERAGE !== $attribute || !$subject instanceof Movie) {
                return self::ACCESS_ABSTAIN;
            }
        }

        $age = $user->getBirthday()?->diff(new \DateTimeImmutable())->y;

        $vote = match ($subject->getRated()) {
            'G' => self::ACCESS_GRANTED,
            'PG', 'PG-13' => $age && $age >= 13 ? self::ACCESS_GRANTED : self::ACCESS_DENIED,
            'R', 'NC-17' => $age && $age >= 17 ? self::ACCESS_GRANTED : self::ACCESS_DENIED,
            default => self::ACCESS_DENIED
        };

        if (self::ACCESS_DENIED === $vote) {
            $this->dispatcher->dispatch(new MovieUnderageEvent($subject, $user));
        }

        return $vote;
    }
}
