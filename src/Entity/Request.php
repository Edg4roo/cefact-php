<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RequestRepository::class)]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'request')]
    private ?TrainingOffer $training_offer = null;

    #[ORM\ManyToOne(inversedBy: 'request')]
    private ?StudentOffer $student_offer = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    private ?Company $company = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Choice(choices: ['accepted','denied','undefined'])]
    private ?string $status = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getRequest() === $this) {
                $company->setRequest(null);
            }
        }

        return $this;
    }

    public function getTrainingOffer(): ?TrainingOffer
    {
        return $this->training_offer;
    }

    public function setTrainingOffer(?TrainingOffer $training_offer): self
    {
        $this->training_offer = $training_offer;

        return $this;
    }

    public function getStudentOffer(): ?StudentOffer
    {
        return $this->student_offer;
    }

    public function setStudentOffer(?StudentOffer $student_offer): self
    {
        $this->student_offer = $student_offer;

        return $this;
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
