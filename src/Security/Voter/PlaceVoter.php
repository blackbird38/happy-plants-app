<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Place;

class PlaceVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['PLACE_EDIT', 'PLACE_DELETE', 'PLACE_VIEW', 'PLACE_ACTION'])
            && $subject instanceof \App\Entity\Place;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        $place = $subject;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'PLACE_EDIT':
            case 'PLACE_DELETE':
            case 'PLACE_VIEW':
            case 'PLACE_ACTION':
                return $user === $place->getOwner();
                // logic to determine if the user can edit/delete/ a place or add a plant in a place
                // return true or false
                break;
        }

        return false;
    }
}
