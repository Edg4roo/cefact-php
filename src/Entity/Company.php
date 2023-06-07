<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyRepresentative::class)]
    private Collection $company_representatives;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Training::class)]
    private Collection $trainings;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: TrainingOffer::class)]
    private Collection $training_offers;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Request::class)]
    private Collection $requests;


    public function __construct()
    {
        $this->company_representatives = new ArrayCollection();
        $this->trainings = new ArrayCollection();
        $this->training_offers = new ArrayCollection();
        $this->requests = new ArrayCollection();
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
     * @return Collection<int, CompanyRepresentative>
     */
    public function getCompanyRepresentatives(): Collection
    {
        return $this->company_representatives;
    }

    public function addCompanyRepresentative(CompanyRepresentative $company_representative): self
    {
        if (!$this->company_representatives->contains($company_representative)) {
            $this->company_representatives->add($company_representative);
            $company_representative->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyRepresentative(CompanyRepresentative $company_representative): self
    {
        if ($this->company_representatives->removeElement($company_representative)) {
            // set the owning side to null (unless already changed)
            if ($company_representative->getCompany() === $this) {
                $company_representative->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setCompany($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getCompany() === $this) {
                $training->setCompany(null);
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
            $trainingOffer->setCompany($this);
        }

        return $this;
    }

    public function removeTrainingOffer(TrainingOffer $trainingOffer): self
    {
        if ($this->training_offers->removeElement($trainingOffer)) {
            // set the owning side to null (unless already changed)
            if ($trainingOffer->getCompany() === $this) {
                $trainingOffer->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Request>
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests->add($request);
            $request->setCompany($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getCompany() === $this) {
                $request->setCompany(null);
            }
        }

        return $this;
    }
}
