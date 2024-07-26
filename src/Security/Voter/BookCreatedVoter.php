<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class BookCreatedVoter implements VoterInterface
{
    public const CREATED = 'book.created';

    /**
     * @inheritDoc
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $user = $token->getUser();

        foreach ($attributes as $attribute) {
            if (
                self::CREATED !== $attribute
                || !$subject instanceof Book
                || !$user instanceof User
            ) {
                return self::ACCESS_ABSTAIN;
            }

            if ($subject->getCreatedBy() === $user) {
                return self::ACCESS_GRANTED;
            }
        }

        return self::ACCESS_DENIED;
    }
}
