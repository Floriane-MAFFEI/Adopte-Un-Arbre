<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{

    public const BROWSE = 'USER_BROWSE';
    public const READ_EDIT = 'USER_READ_EDIT';
    public const DELETE = 'USER_DELETE';

    // Inject bundle security to check users permissions
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::READ_EDIT])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }
    
        if($this->security->isGranted("ROLE_ADMIN")) {
            return true;
        }

        if($subject === $user){
            if($attribute == self::READ_EDIT){ return true; }
            if($attribute == self::DELETE || $attribute == self::BROWSE){ return false; }
        }

        return false;
    }
}
