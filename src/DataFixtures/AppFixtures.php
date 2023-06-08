<?php

namespace App\DataFixtures;

use App\Entity\StudyCenter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        // $product = new Product();
        // $manager->persist($product);

        // 10 Centros de estudios
        $study_centers = [
            'Instituto de Educación Secundaria El Cid',
            'Instituto de Educación Secundaria Lluís Vives',
            'Instituto de Educación Secundaria Ramón Llull',
            'Instituto de Educación Secundaria Campanar',
            'Instituto de Educación Secundaria Ausiàs March'
        ];

        for ($i = 0; $i<5;$i++) {
            $study_center = new StudyCenter();
            $study_center->setName($study_centers[$i]);
            $phone=$faker->numerify('962######');
            $study_center->setPhone($phone);
            $study_center->setEmail($faker->email());
            $study_center->setAddress($faker->address());
            $manager->persist($study_center);
            $manager->flush();
        }


        $manager->flush();
    }
}
