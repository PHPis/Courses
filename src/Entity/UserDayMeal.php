<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDayMealRepository")
 */
class UserDayMeal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="userDayMeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserDay", inversedBy="userDayMeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userDay;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $count;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingestion", inversedBy="userDays")
     */
    private $ingestions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getUserDay(): ?UserDay
    {
        return $this->userDay;
    }

    public function setUserDay(?UserDay $userDay): self
    {
        $this->userDay = $userDay;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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
