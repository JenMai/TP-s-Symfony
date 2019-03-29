<?php
namespace App\Service\ActionUser;
use App\Entity\UserCharacters;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use PhpParser\Node\Stmt\UseUse;

class Shoot{
    private $em;
    private $session;
    private $token;
    private $percentKill = 20;
    private $percentDamage = 50;
    private $damage = 100;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->session = $session;
        $this->token = $token;
    }

    public function shoot(Game $game, $randomize)
    {
        if($this->randomPercentage($this->percentKill, $randomize) === true){
            $game->setDamage(0);
            return;
        }

        if($this->randomPercentage($this->percentDamage, $randomize) === true){
            $game->setDamage($game->getDamage() + $this->damage);
            return;
        }
    }

    private function randomPercentage($percent, $randomize){
        if($randomize === true){
            $result = $this->random(1,100);
            if($result > $percent){
                return false;
            }
            else
                return true;

        }
        return false;
    }

    private function random($min, $max){
        return mt_rand($min, $max);
    }
}