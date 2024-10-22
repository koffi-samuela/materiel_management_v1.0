<?php

namespace App\DataFixtures;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesEmployee extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ){

    }
// id	username	roles	password	lastname	firstname	is_active	

    public function load(ObjectManager $manager): void
    {
        $roles =  ['ROLE_ADMIN','ROLE_EMPLOYEE'];
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<5; $i++){
            $employee = new Employee();
            $employee->setUsername( $faker->userName());
            $employee->setFirstname( $faker->firstName());
            $employee->setLastname($faker->lastName);
            if ($i == 0) {
                $employee->setRoles([$roles[0]]);
            } else {
                $employee->setRoles([$roles[1]]);

            }
            
            $employee->setIsActive($faker->boolean());
            $hashedPassword = $this->passwordHasher->hashPassword($employee, 'password' );
            $employee->setPassword($hashedPassword);
            $this->addReference('employee_'.$i, $employee);
            $manager->persist($employee);
    }

        $manager->flush();
    }
}
