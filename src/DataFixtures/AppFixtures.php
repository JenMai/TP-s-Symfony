<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\UserProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture {
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        $product1 = new Product();
        $product1->setName("Produit1");
        $product1->setPrice(11.50);
        $product1->setQuantity(10);
        $product1->setCreatedAt(new \DateTime('now'));
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName("Produit2");
        $product2->setPrice(11.50);
        $product2->setQuantity(10);
        $product2->setCreatedAt(new \DateTime('now'));
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName("Produit3");
        $product3->setPrice(11.50);
        $product3->setQuantity(10);
        $product3->setCreatedAt(new \DateTime('now'));
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setName("Produit4");
        $product4->setPrice(11.50);
        $product4->setQuantity(10);
        $product4->setCreatedAt(new \DateTime('now'));
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setName("Produit5");
        $product5->setPrice(11.50);
        $product5->setQuantity(10);
        $product5->setCreatedAt(new \DateTime('now'));
        $manager->persist($product5);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user@user.fr');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setFirstName('user');
        $user1->setLastName('userlast');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user@user.fr'));
        $manager->persist($user1);

        $userProduct = new UserProduct();
        $userProduct->setCreatedAt(new \DateTime('now'));
        $userProduct->setProduct($product1);
        $userProduct->setQuantity(1);
        $userProduct->setUser($user1);
        $manager->persist($userProduct);

        $userProduct = new UserProduct();
        $userProduct->setCreatedAt(new \DateTime('now'));
        $userProduct->setProduct($product2);
        $userProduct->setQuantity(2);
        $userProduct->setUser($user1);
        $manager->persist($userProduct);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user1@user.fr');
        $user1->setFirstName('user1');
        $user1->setLastName('userlast1');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user1@user.fr'));
        $manager->persist($user1);

        $userProduct = new UserProduct();
        $userProduct->setCreatedAt(new \DateTime('now'));
        $userProduct->setProduct($product3);
        $userProduct->setQuantity(2);
        $userProduct->setUser($user1);
        $manager->persist($userProduct);

        $userProduct = new UserProduct();
        $userProduct->setCreatedAt(new \DateTime('now'));
        $userProduct->setProduct($product4);
        $userProduct->setQuantity(4);
        $userProduct->setUser($user1);
        $manager->persist($userProduct);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user2@user.fr');
        $user1->setFirstName('user2');
        $user1->setLastName('userlast2');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user2@user.fr'));
        $manager->persist($user1);

        $userProduct = new UserProduct();
        $userProduct->setCreatedAt(new \DateTime('now'));
        $userProduct->setProduct($product5);
        $userProduct->setQuantity(2);
        $userProduct->setUser($user1);
        $manager->persist($userProduct);

        $userProduct = new UserProduct();
        $userProduct->setCreatedAt(new \DateTime('now'));
        $userProduct->setProduct($product4);
        $userProduct->setQuantity(1);
        $userProduct->setUser($user1);
        $manager->persist($userProduct);

        $manager->flush();
    }
}
