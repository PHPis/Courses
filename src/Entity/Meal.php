<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isStandard;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="meals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingestion", inversedBy="meals")
     */
    private $ingestion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserDayMeal", mappedBy="meal")
     */
    private $userDayMeals;

    public function __construct()
    {
        $this->ingestion = new ArrayCollection();
        $this->userDayMeals = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsStandard(): ?bool
    {
        return $this->isStandard;
    }

    public function setIsStandard(bool $isStandard): self
    {
        $this->isStandard = $isStandard;

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
     * @return Collection|Ingestion[]
     */
    public function getIngestion(): Collection
    {
        return $this->ingestion;
    }

    public function addIngestion(Ingestion $ingestion): self
    {
        if (!$this->ingestion->contains($ingestion)) {
            $this->ingestion[] = $ingestion;
        }

        return $this;
    }

    public function removeIngestion(Ingestion $ingestion): self
    {
        if ($this->ingestion->contains($ingestion)) {
            $this->ingestion->removeElement($ingestion);
        }

        return $this;
    }

    /**
     * @return Collection|UserDayMeal[]
     */
    public function getUserDayMeals(): Collection
    {
        return $this->userDayMeals;
    }

    public function addUserDayMeal(UserDayMeal $userDayMeal): self
    {
        if (!$this->userDayMeals->contains($userDayMeal)) {
            $this->userDayMeals[] = $userDayMeal;
            $userDayMeal->setMeal($this);
        }

        return $this;
    }

    public function removeUserDayMeal(UserDayMeal $userDayMeal): self
    {
        if ($this->userDayMeals->contains($userDayMeal)) {
            $this->userDayMeals->removeElement($userDayMeal);
            // set the owning side to null (unless already changed)
            if ($userDayMeal->getMeal() === $this) {
                $userDayMeal->setMeal(null);
            }
        }

        return $this;
    }
}
