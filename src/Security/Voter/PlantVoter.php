<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Plant;

class PlantVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['PLANT_EDIT', 'PLANT_DELETE', 'PLANT_ACTION', 'PLANT_RECORD'])
            && $subject instanceof \App\Entity\Plant;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $plant = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'PLANT_EDIT':
            case 'PLANT_DELETE':
            case 'PLANT_RECORD':
            case 'PLANT_ACTION':
                return $user === $plant->getOwnerId();
                // logic to determine if the user can edit/delete/ or add records/actions on a plant
                // return true or false
                break;
        }

        return false;
    }
}
