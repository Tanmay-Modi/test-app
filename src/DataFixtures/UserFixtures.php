<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
  
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface  $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;  
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('ty@gmail.com');
        $user->setPassword('123456');
        $user->setGender('Male');
        $user->setName('Tanmay');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            '123456'
        );       
        $user->setPassword($hashedPassword);
        $user->setPhone('8733907483');
        $manager->persist($user);
        $manager->flush();
    }
}
