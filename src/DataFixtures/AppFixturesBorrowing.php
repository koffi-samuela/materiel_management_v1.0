<?php

namespace App\DataFixtures;
use App\Entity\Borrowing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class AppFixturesBorrowing extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // borrow_date	expected_return_date	actual_return_date	comment	material_id	training_program_id	student_id	employee_id	employee_borrow_id
        $faker = Faker::create('fr_FR');
        for ($i=0 ;$i<20 ; $i++){
            $borrowing = new Borrowing();
            $startDateTime = $faker->dateTimeBetween('-1 year', 'now'); 
            $endDateTime = $startDateTime->modify('+2 weeks');
            $expectedReturnDate = $faker->dateTimeBetween($startDateTime, $endDateTime);
            $actualReturnDate = $faker->dateTimeBetween($expectedReturnDate, $endDateTime);
            //insertion
            $borrowing->setBorrowDate($startDateTime);  
            $borrowing->setExpectedReturnDate($expectedReturnDate);
            $borrowing->setActualReturnDate($actualReturnDate);
            $comment = $faker->realText; // Supposons que $faker->realText contient le commentaire généré aléatoirement

            // Limiter la taille du commentaire à 255 caractères maximum
            if (strlen($comment) > 255) {
                $comment = substr($comment, 0, 255); // Tronquer le commentaire à 255 caractères
            }

            $borrowing->setComment($comment);

            $borrowing->setMaterial( $this->getReference('material_'.$i) ) ;  
            // $borrowing->setMaterial( $this->getReference('material_'.$faker->numberBetween(0,19)) ) ;  
            $borrowing->setTrainingProgram($this->getReference("training_program_".$i)) ; 
            
            if($i%2 == 0){
                $borrowing -> setStudent($this->getReference("student_".$i));
            }else{
                // $this->addReference('employee_'.$i, $employee);
                $borrowing->setEmployee($this->getReference('employee_'.rand(0,4)));
            }
            $borrowing->setEmployeeBorrow($this->getReference('employee_'.rand(0,4)));


            $manager->persist($borrowing);
    }
        // $product = new Product();()
        // $manager->persist($product);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            AppFixturesStudent::class,
            AppFixturesEmployee::class,
            AppFixturesTraining::class,

            AppFixturesMaterial::class

            // Ajoutez d'autres dépendances au besoin
        ];
    }
}
