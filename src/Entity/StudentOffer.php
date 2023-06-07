<?php

namespace App\Entity;

use App\Repository\StudentOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentOfferRepository::class)]
class StudentOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'student_offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\OneToMany(mappedBy: 'student_offer', targetEntity: Request::class)]
    private Collection $request;

    public function __construct()
    {
        $this->request = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, Request>
     */
    public function getRequest(): Collection
    {
        return $this->request;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->request->contains($request)) {
            $this->request->add($request);
            $request->setStudentOffer($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->request->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getStudentOffer() === $this) {
                $request->setStudentOffer(null);
            }
        }

        return $this;
    }
}
