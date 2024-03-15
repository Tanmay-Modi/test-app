<?php 
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private $userRepository;
    private $passwordHasher;
    private $em;
    public function __construct(UserRepository $userRepository,UserPasswordHasherInterface  $passwordHasher, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;  
        $this->em             = $em;
    }

    public function createUser(User $user): User
    {
        
       $hashedPassword =  $this->createHashPassword($user->getPassword(),$user);
           
        $user->setPassword($hashedPassword);
        $this->userRepository->add($user); // Assuming UserRepository has an add() method
        return $user;
    }

    public function createHashPassword(string $password,User $user){
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );   
        return $hashedPassword;
    }

    public function deleteUser($user){
        $this->em->remove($user);
        $this->em->flush();
    }
}