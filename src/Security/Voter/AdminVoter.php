<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class AdminVoter implements VoterInterface
{
    public function __construct(protected readonly RoleHierarchyInterface $hierarchy)
    {
    }

    /**
     * @inheritDoc
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        if (\in_array(
            'ROLE_ADMIN',
            $this->hierarchy->getReachableRoleNames($token->getRoleNames())
        )) {
            return self::ACCESS_GRANTED;
        }

        return self::ACCESS_ABSTAIN;
    }
}
