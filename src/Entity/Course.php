<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Tutor::class, mappedBy: 'courses')]
    private Collection $tutors;

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'courses')]
    private Collection $students;

    #[ORM\ManyToMany(targetEntity: StudyCenter::class, mappedBy: 'courses')]
    private Collection $study_centers;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: StudentOffer::class)]
    private Collection $student_offers;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: TrainingOffer::class)]
    private Collection $training_offers;


    public function __construct()
    {
        $this->tutors = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->study_centers = new ArrayCollection();
        $this->student_offers = new ArrayCollection();
        $this->training_offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Tutor>
     */
    public function getTutors(): Collection
    {
        return $this->tutors;
    }

    public function addTutor(Tutor $tutor): self
    {
        if (!$this->tutors->contains($tutor)) {
            $this->tutors->add($tutor);
            $tutor->addCourse($this);
        }

        return $this;
    }

    public function removeTutor(Tutor $tutor): self
    {
        if ($this->tutors->removeElement($tutor)) {
            $tutor->removeCourse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->addCourse($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            $student->removeCourse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, StudyCenter>
     */
    public function getStudyCenters(): Collection
    {
        return $this->study_centers;
    }

    public function addStudyCenter(StudyCenter $study_center): self
    {
        if (!$this->study_centers->contains($study_center)) {
            $this->study_centers->add($study_center);
            $study_center->addCourse($this);
        }

        return $this;
    }

    public function removeStudyCenter(StudyCenter $study_center): self
    {
        if ($this->study_centers->removeElement($study_center)) {
            $study_center->removeCourse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, StudentOffer>
     */
    public function getStudentOffers(): Collection
    {
        return $this->student_offers;
    }

    public function addStudentOffer(StudentOffer $studentOffer): self
    {
        if (!$this->student_offers->contains($studentOffer)) {
            $this->student_offers->add($studentOffer);
            $studentOffer->setCourse($this);
        }

        return $this;
    }

    public function removeStudentOffer(StudentOffer $studentOffer): self
    {
        if ($this->student_offers->removeElement($studentOffer)) {
            // set the owning side to null (unless already changed)
            if ($studentOffer->getCourse() === $this) {
                $studentOffer->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrainingOffer>
     */
    public function getTrainingOffers(): Collection
    {
        return $this->training_offers;
    }

    public function addTrainingOffer(TrainingOffer $trainingOffer): self
    {
        if (!$this->training_offers->contains($trainingOffer)) {
            $this->training_offers->add($trainingOffer);
            $trainingOffer->setCourse($this);
        }

        return $this;
    }

    public function removeTrainingOffer(TrainingOffer $trainingOffer): self
    {
        if ($this->training_offers->removeElement($trainingOffer)) {
            // set the owning side to null (unless already changed)
            if ($trainingOffer->getCourse() === $this) {
                $trainingOffer->setCourse(null);
            }
        }

        return $this;
    }

}
