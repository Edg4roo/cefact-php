<?php

namespace App\Entity;

use App\Repository\StudyCenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudyCenterRepository::class)]
class StudyCenter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'studyCenter', targetEntity: Tutor::class)]
    private Collection $tutors;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'studyCenters')]
    private Collection $courses;

    public function __construct()
    {
        $this->tutors = new ArrayCollection();
        $this->courses = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
            $tutor->setStudyCenter($this);
        }

        return $this;
    }

    public function removeTutor(Tutor $tutor): self
    {
        if ($this->tutors->removeElement($tutor)) {
            // set the owning side to null (unless already changed)
            if ($tutor->getStudyCenter() === $this) {
                $tutor->setStudyCenter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        $this->courses->removeElement($course);

        return $this;
    }
}
