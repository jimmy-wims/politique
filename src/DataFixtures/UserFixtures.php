<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	private $passwordEncoder;
	public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
		$this->passwordEncoder = $passwordEncoder;
 	}
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
		$user1->setUsername('secretaire');
		$user1->setRoles(['ROLE_SECRETAIRE']);
		$encrypted = $this->passwordEncoder->encodePassword($user1,'secret');
		$user1->setPassword($encrypted);
		$manager->persist($user1);
		$user2 = new User();
		$user2->setUsername('administrateur');
		$user2->setRoles(['ROLE_ADMIN']);
		$encrypted = $this->passwordEncoder->encodePassword($user2,'grossecret');
		$user2->setPassword($encrypted);
		$manager->persist($user2);
		$user3 = new User();
		$user3->setUsername('bebert');
		$user3->setRoles(['ROLE_USER']);
		$encrypted = $this->passwordEncoder->encodePassword($user3,'grosgrossecret');
		$user3->setPassword($encrypted);
		$manager->persist($user3);
		$manager->flush();
    }
}
