<?php

namespace App\DataFixtures;
use App\Entity\MaterialKind;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
class AppFixturesMaterialKind extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<10 ; $i++){
            $materialKind = new MaterialKind();
            $materialKind->setName($faker->name());
            $this->addReference("material_kind_".$i,$materialKind);
            $manager->persist($materialKind);
    }
        $manager->flush();
    }
}
