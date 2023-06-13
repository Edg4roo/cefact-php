<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyRepresentative;
use App\Entity\Course;
use App\Entity\Request;
use App\Entity\Student;
use App\Entity\StudentOffer;
use App\Entity\StudyCenter;
use App\Entity\TrainingOffer;
use App\Entity\Tutor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('es_ES');
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));
        // $product = new Product();
        // $manager->persist($product);

        // 5 Centros de estudios
        $study_centers = [
            'Instituto de Educación Secundaria Enric Valor',
            'Instituto de Educación Secundaria Lluís Vives',
            'Instituto de Educación Secundaria Ramón Llull',
            'Instituto de Educación Secundaria Campanar',
            'Instituto de Educación Secundaria Ausiàs March'
        ];
        $study_centers_to_use = [];
        for ($i = 0; $i<5;$i++) {
            $study_center = new StudyCenter();
            $study_center->setName($study_centers[$i]);
            $phone=$faker->numerify('962######');
            $study_center->setPhone($phone);
            $study_center->setEmail($faker->email());
            $study_center->setAddress($faker->address());
            $manager->persist($study_center);
            $study_centers_to_use[] = $study_center;
            $manager->flush();
        }

        // 5 cursos
        $courses = [
            "Administración de Sistemas Informáticos en Red",
            "Desarrollo de Aplicaciones Web",
            "Marketing y Publicidad",
            "Diseño y Desarrollo de Videojuegos",
            "Comercio Internacional"
        ];
        $courses_to_use = [];

        for ($i = 0; $i<5;$i++) {
            $course = new Course();
            $course->setName($courses[$i]);
            $courses_to_use[] = $course;
            $manager->persist($course);
        }


        // 1 tutor por defecto para las pruebas
        $tutor = new Tutor();
        $tutors_to_use = [];
        $tutor->setName('David');
        $tutor->setEmail('david@gmail.com');
        $tutor->setPhone('611223344');
        $tutor->setStudyCenter($study_centers_to_use[0]);
        $tutor->addCourse($courses_to_use[1]);
        $plainPassword = 'david';
        $hashedPassword = $this->passwordHasher->hashPassword($tutor, $plainPassword);
        $tutor->setPassword($hashedPassword);
        $tutor->setProfile($faker->image(dir:'public/uploads/images/profiles/tutors',fullPath: false, width: '128', height:'128',));
        $manager->persist($tutor);
        $tutor_david = $tutor;

        // 10 tutores
        for ($i = 0; $i<9;$i++) {
            $tutor = new Tutor();
            $tutor->setName($faker->firstName());
            $tutor->setEmail($faker->email());
            $phone=$faker->numerify('621######');
            $tutor->setPhone($phone);
            $tutor->setStudyCenter($study_centers_to_use[rand(0,4)]);
            $plainPassword = 'tutor';
            $hashedPassword = $this->passwordHasher->hashPassword($tutor, $plainPassword);
            $tutor->setPassword($hashedPassword);
            $tutor->setProfile($faker->image(dir:'public/uploads/images/profiles/tutors',fullPath: false, width: '128', height:'128',));
            $tutors_to_use[] = $tutor;
            $manager->persist($tutor);
        }

        // 10 alumnos en general
        for ($i = 0; $i<10;$i++) {
            $student = new Student();
            $student->setName($faker->firstName());
            $student->setEmail($faker->email());
            $student->setNia($faker->numerify('########'));
            $phone=$faker->numerify('621######');
            $student->setPhone($phone);
            $student->addTutor($tutors_to_use[rand(0,8)]);
            $manager->persist($student);
        }

        // 5 alumnos para el tutor David
        for ($i = 0; $i<5;$i++) {
            $student = new Student();
            $student->setName($faker->firstName());
            $student->setEmail($faker->email());
            $student->setNia($faker->numerify('########'));
            $phone=$faker->numerify('621######');
            $student->setPhone($phone);
            $student->addTutor($tutor_david);
            $student->setThumbnail($faker->image(dir:'public/uploads/images/thumbnails/students',fullPath: false, width: '128', height:'128',));
            $manager->persist($student);
        }

        // 15 empresas
        $cities = [
            "Alicante",
            "Elche",
            "Torrevieja",
            "Orihuela",
            "Benidorm",
            "Alcoy",
            "Elda",
            "San Vicente del Raspeig",
            "Denia",
            "Villena",
            "Pego",
            "Jávea",
            "Calpe",
            "Santa Pola",
            "Crevillente"
        ];
        $postalCodes = [
            "03001",
            "03201",
            "03180",
            "03300",
            "03501",
            "03801",
            "03600",
            "03690",
            "03700",
            "03400",
            "03780",
            "03730",
            "03710",
            "03130",
            "03330"
        ];
        $companies_to_use = [];
        for ($i = 0; $i<15;$i++) {
            $company = new Company();
            $company->setName($faker->company());
            $company->setEmail($faker->companyEmail());
            $company->setAddress($faker->address());
            $phone=$faker->numerify('965######');
            $company->setPhone($phone);
            $company->setAutonomie('Comunidad Valenciana');
            $company->setProvince('Alicante');
            $company->setCity($cities[$i]);
            $company->setCP($postalCodes[$i]);
            $company->setThumbnail($faker->image(dir:'public/uploads/images/thumbnails/companies',fullPath: false, width: '128', height:'128',));
            $companies_to_use[] = $company;
            $manager->persist($company);
        }

        // 15 responsables de empresa
        for ($i = 0; $i<15;$i++) {
            $companyRepresentative = new CompanyRepresentative();
            $companyRepresentative->setName($faker->name());
            $companyRepresentative->setEmail($faker->email());
            $phone=$faker->numerify('682######');
            $companyRepresentative->setPhone($phone);
            $plainPassword = 'representante';
            $hashedPassword = $this->passwordHasher->hashPassword($companyRepresentative, $plainPassword);
            $companyRepresentative->setPassword($hashedPassword);
            $companyRepresentative->setCompany($companies_to_use[$i]);
            $manager->persist($companyRepresentative);
        }

        // 10 ofertas de formación
        $training_offers_to_use = [];
        for ($i = 0; $i<10;$i++) {
            $training_offer = new TrainingOffer();
            $training_offer->setCompany($companies_to_use[array_rand($companies_to_use)]);
            $training_offer->setCourse($courses_to_use[array_rand($courses_to_use)]);
            $training_offer->setCreatedAt(new \DateTimeImmutable('now'));
            $training_offers_to_use[] = $training_offer;
            $manager->persist($training_offer);
        }

        // 3 ofertas de alumnos del tutor David
        $student_offers_to_use = [];
        $alumnos = $tutor_david->getStudents();
        $student_offer_course = $tutor_david->getCourses();
        for ($i = 0; $i<3;$i++) {
            $student_offer = new StudentOffer();
            $student_offer->setStudent($alumnos[$i]);
            $student_offer->setCourse($student_offer_course[0]);
            $student_offer->setCreatedAt(new \DateTimeImmutable('now'));
            $student_offers_to_use[] = $student_offer;
            $manager->persist($student_offer);
        }

        // 2 peticiones de formación de alumnos del tutor David
        $alumnos = $tutor_david->getStudents();
        for ($i=0; $i<2; $i++) {
            $request = new Request();
            $request->setStudent($alumnos[$i]);
            $request->setTrainingOffer($training_offers_to_use[$i]);
            $request->setCreatedAt(new \DateTimeImmutable('now'));
            $request->setStatus('undefined');
            $manager->persist($request);
        }

        // 3 peticiones a alumnos del tutor David
        for ($i=2; $i<5; $i++) {
            $request = new Request();
            $request->setCompany($companies_to_use[$i]);
            $request->setStudentOffer($student_offers_to_use[$i-2]);
            $request->setCreatedAt(new \DateTimeImmutable('now'));
            $request->setStatus('undefined');
            $manager->persist($request);
        }

        $manager->flush();


    }


}
