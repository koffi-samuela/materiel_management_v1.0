<?php

namespace App\DataFixtures;
use App\Entity\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
class AppFixturesMaterial extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $locations = ["emprunté","Salle B1","Salle B2","Salle B3","administration"];
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<20 ; $i++){
            $material = new Material();
            $material->setName( $faker->name());
            $material->setSerialNumber( $faker->randomDigitNotNull().$faker->randomDigitNotNull() .'-'.$faker->randomLetter().$faker->randomLetter().$faker->randomLetter().$faker->randomLetter().'-'.$faker->randomDigitNotNull().$faker->randomDigitNotNull() );
            $material->setTagNumber( rand(1,9999).rand(1,9999).'LM');
            $material->setComment( $faker->paragraph(3));
            $material->setLocation( $locations[array_rand($locations)]);
            $material->setIsAvailable($faker ->boolean());
            $material->setMaterialKind( $this->getReference("material_kind_".$faker->numberBetween(0,9)) ) ;
            $this->addReference('material_'.$i,$material);
            $manager->persist($material);
    }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            AppFixturesMaterialKind::class,

        ];
    }
}
