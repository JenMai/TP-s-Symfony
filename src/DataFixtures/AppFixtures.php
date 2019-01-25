<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Team;
use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture {
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        $user = new User();
        $user->setFirstName('admin');
        $user->setLastName('admin');
        $user->setEmail('admin@gmail.com');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $user->setEnabled(true);
        $password = $this->encoder->encodePassword($user, 'pass1234');
        $user->setPassword($password);
        $manager->persist($user);


        //create 3 users
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setFirstName('userfn' . $i);
            $user->setLastName('userln' . $i);
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setEnabled(true);
            $password = $this->encoder->encodePassword($user, 'pass1234');
            $user->setPassword($password);
            $manager->persist($user);
        }
        //create 6 teams
        $team1 = new Team();
        $team1->setName('team1');
        $team1->setFlag('flag1');
        $manager->persist($team1);

        $team2 = new Team();
        $team2->setName('team2');
        $team2->setFlag('flag2');
        $manager->persist($team2);

        $team3 = new Team();
        $team3->setName('team3');
        $team3->setFlag('flag3');
        $manager->persist($team3);

        $team4 = new Team();
        $team4->setName('team4');
        $team4->setFlag('flag4');
        $manager->persist($team4);

        $team5 = new Team();
        $team5->setName('team5');
        $team5->setFlag('flag5');
        $manager->persist($team5);

        $team6 = new Team();
        $team6->setName('team6');
        $team6->setFlag('flag6');
        $manager->persist($team6);

        //create 5 Games;

        $game = new Game();
        $game->setTeamA($team1);
        $game->setTeamB($team2);
        $game->setScoreTeamA(3);
        $game->setScoreTeamB(5);
        $game->setDate(new \DateTime('now'));
        $game->setRating(5.0);
        $manager->persist($game);

        $game = new Game();
        $game->setTeamA($team1);
        $game->setTeamB($team3);
        $game->setScoreTeamA(5);
        $game->setScoreTeamB(3);
        $game->setDate(new \DateTime('now'));
        $game->setRating(6.0);
        $manager->persist($game);

        $game = new Game();
        $game->setTeamA($team3);
        $game->setTeamB($team2);
        $game->setScoreTeamA(5);
        $game->setScoreTeamB(5);
        $game->setDate(new \DateTime('now'));
        $game->setRating(6.0);
        $manager->persist($game);

        $game = new Game();
        $game->setTeamA($team4);
        $game->setTeamB($team5);
        $game->setScoreTeamA(2);
        $game->setScoreTeamB(6);
        $game->setDate(new \DateTime('now'));
        $game->setRating(7.0);
        $manager->persist($game);

        $game = new Game();
        $game->setTeamA($team1);
        $game->setTeamB($team6);
        $game->setScoreTeamA(8);
        $game->setScoreTeamB(2);
        $game->setDate(new \DateTime('now'));
        $game->setRating(5.0);
        $manager->persist($game);

        $manager->flush();
    }
}
