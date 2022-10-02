<?php

namespace App\Security;

use App\Entity\Credential;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CredentialVoter extends Voter
{
    const READ = 'read';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::READ, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Credential) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Credential object, thanks to `supports()`
        /** @var Credential $credential */
        $credential = $subject;

        return match($attribute) {
            self::READ => $this->canRead($credential, $user),
            self::EDIT => $this->canEdit($credential, $user),
            self::DELETE => $this->canDelete($credential, $user),
            default => throw new \LogicException('This code should not be reached!')
         };
    }

    private function canRead(Credential $credential, User $user): bool
    {
        return $credential->getUser()->getId() === $user->getId();
    }

    private function canEdit(Credential $credential, User $user): bool
    {
        return $credential->getUser()->getId() === $user->getId();
    }

    private function canDelete(Credential $credential, User $user): bool
    {
        return $credential->getUser()->getId() === $user->getId();
    }
}