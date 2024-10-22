<?php

namespace App\DataFixtures;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
class AppFixturesStudent extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<20 ; $i++){
            $student = new Student();
            $student->setFirstname( $faker->firstName);
            $student->setLastname($faker->lastName);
            $student->setBirthdate($faker->dateTimeBetween($startDate = '-25 years', $endDate = '-10 years', $timezone = null));
            $isActive = $faker->optional($weight = 0.75, $default = true)->boolean(); // 75% de chance de true
            $student->setIsActive($isActive);
            $this->addReference('student_'.$i , $student );
            $manager->persist($student);
    }
        $manager->flush();
    }
}
