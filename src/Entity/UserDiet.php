<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDietRepository")
 */
class UserDiet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userDiet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserDay", mappedBy="diet")
     */
    private $userDays;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingestion", inversedBy="userDiets")
     */
    private $ingestions;

    public function __construct()
    {
        $this->userDays = new ArrayCollection();
        $this->userDietIngestions = new ArrayCollection();
        $this->ingestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|UserDay[]
     */
    public function getUserDays(): Collection
    {
        return $this->userDays;
    }

    public function addUserDay(UserDay $userDay): self
    {
        if (!$this->userDays->contains($userDay)) {
            $this->userDays[] = $userDay;
            $userDay->setDiet($this);
        }

        return $this;
    }

    public function removeUserDay(UserDay $userDay): self
    {
        if ($this->userDays->contains($userDay)) {
            $this->userDays->removeElement($userDay);
            // set the owning side to null (unless already changed)
            if ($userDay->getDiet() === $this) {
                $userDay->setDiet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ingestion[]
     */
    public function getIngestions(): Collection
    {
        return $this->ingestions;
    }

    public function addIngestion(Ingestion $ingestion): self
    {
        if (!$this->ingestions->contains($ingestion)) {
            $this->ingestions[] = $ingestion;
        }

        return $this;
    }

    public function removeIngestion(Ingestion $ingestion): self
    {
        if ($this->ingestions->contains($ingestion)) {
            $this->ingestions->removeElement($ingestion);
        }

        return $this;
    }
}
