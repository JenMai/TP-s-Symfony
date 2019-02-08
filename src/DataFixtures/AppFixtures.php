<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture {
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user@user.fr');
        $user1->setFirstName('user');
        $user1->setLastName('userlast');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user@user.fr'));
        $manager->persist($user1);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user1@user.fr');
        $user1->setFirstName('user1');
        $user1->setLastName('userlast1');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user1@user.fr'));
        $manager->persist($user1);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user2@user.fr');
        $user1->setFirstName('user2');
        $user1->setLastName('userlast2');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user2@user.fr'));
        $manager->persist($user1);

        $team1 = new Team();
        $team1->setName('toto');
        $team1->setFlag('flag a toto');
        $manager->persist($team1);

        $team2 = new Team();
        $team2->setName('roro');
        $team2->setFlag('flag a roro');
        $manager->persist($team2);

        $team3 = new Team();
        $team3->setName('titi');
        $team3->setFlag('flag a titi');
        $manager->persist($team3);

        $team4 = new Team();
        $team4->setName('riri');
        $team4->setFlag('flag a riri');
        $manager->persist($team4);

        $game1 = new Game();
        $game1->setTeamA($team1);
        $game1->setTeamB($team2);
        $game1->setDate(new \DateTime('now'));
        $game1->getRating(2);
        $manager->persist($game1);

        $manager->flush();
    }
}
