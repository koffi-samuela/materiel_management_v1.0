<?php

namespace App\DataFixtures;
use App\Entity\TrainingProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
class AppFixturesTraining extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $functions = ["Apprenant","Staff"];
        $levels = ["CDUI PRF P2","DWWM EP P5","Bachelor 1 sept 2022","Bachelor 2 opt Digital marketeur sept 2022"];
        $faker = Faker::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $training = new TrainingProgram();
            $randomFunction = $functions[array_rand($functions)];
            $training->setName($randomFunction);        
            if ($randomFunction == "Apprenant") {
                $training->setLevel($levels[array_rand($levels)]);
            }
            $this->addReference("training_program_".$i, $training);
            $manager->persist($training);
    }
        $manager->flush();
    }
}
