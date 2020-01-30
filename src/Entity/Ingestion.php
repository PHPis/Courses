<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngestionRepository")
 */
class Ingestion
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Meal", mappedBy="ingestion")
     */
    private $meals;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserDiet", mappedBy="ingestions")
     */
    private $userDiets;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserDay", mappedBy="ingestions")
     */
    private $userDays;

    public function __construct()
    {
        $this->meals = new ArrayCollection();
        $this->userDiets = new ArrayCollection();
        $this->userDays = new ArrayCollection();
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

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

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

    /**
     * @return Collection|Meal[]
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meal $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals[] = $meal;
            $meal->addIngestion($this);
        }

        return $this;
    }

    public function removeMeal(Meal $meal): self
    {
        if ($this->meals->contains($meal)) {
            $this->meals->removeElement($meal);
            $meal->removeIngestion($this);
        }

        return $this;
    }

    /**
     * @return Collection|UserDietIngestion[]
     */
    public function getUserDietIngestions(): Collection
    {
        return $this->userDietIngestions;
    }

    public function addUserDietIngestion(UserDietIngestion $userDietIngestion): self
    {
        if (!$this->userDietIngestions->contains($userDietIngestion)) {
            $this->userDietIngestions[] = $userDietIngestion;
            $userDietIngestion->addIngestion($this);
        }

        return $this;
    }

    public function removeUserDietIngestion(UserDietIngestion $userDietIngestion): self
    {
        if ($this->userDietIngestions->contains($userDietIngestion)) {
            $this->userDietIngestions->removeElement($userDietIngestion);
            $userDietIngestion->removeIngestion($this);
        }

        return $this;
    }

    /**
     * @return Collection|UserDiet[]
     */
    public function getUserDiets(): Collection
    {
        return $this->userDiets;
    }

    public function addUserDiet(UserDiet $userDiet): self
    {
        if (!$this->userDiets->contains($userDiet)) {
            $this->userDiets[] = $userDiet;
            $userDiet->addIngestion($this);
        }

        return $this;
    }

    public function removeUserDiet(UserDiet $userDiet): self
    {
        if ($this->userDiets->contains($userDiet)) {
            $this->userDiets->removeElement($userDiet);
            $userDiet->removeIngestion($this);
        }

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
            $userDay->addIngestion($this);
        }

        return $this;
    }

    public function removeUserDay(UserDay $userDay): self
    {
        if ($this->userDays->contains($userDay)) {
            $this->userDays->removeElement($userDay);
            $userDay->removeIngestion($this);
        }

        return $this;
    }
}
