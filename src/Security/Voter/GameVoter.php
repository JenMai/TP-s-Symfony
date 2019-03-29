<?php
namespace App\Security\Voter;

use App\Entity\Game;
use App\Entity\UserCharacters;
use App\Event\AppEvent;
use App\Security\AppAccess;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class GameVoter extends Voter
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        return in_array($attribute, [AppAccess::GAMESHOW, AppAccess::GAMEEDIT])
            && $subject instanceof Game;
    }
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if ($this->security->isGranted('ROLE__ADMIN'))
            return true;

        // if the user is anonymous, do not grant access    
        if (!$user instanceof UserInterface)
            return false;

        if ($subject->getUserCharacters()->getUser() === $user)
            return true;

        return false;
    }
}