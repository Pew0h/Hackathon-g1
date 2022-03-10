<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    
	public function __construct(UserPasswordHasherInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $password = $this->passwordEncoder->hashPassword( $admin, 'password' );
        $admin
            ->setRoles( [ 'ROLE_ADMIN' ] )
            ->setFirstname('Elon')
            ->setLastname('Musk')
            ->setAge(50)
            ->setLatitude(48.859)
            ->setLongitude(2.347)
            ->setPassword($password)
            ->setHeight(180)
            ->setWeight(72)
            ->setEmail('test@gmail.com');

        $manager->persist($admin);

        $manager->flush();
    }
}
