<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDayRepository")
 */
class UserDay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserDiet", inversedBy="userDays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $diet;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingestion", inversedBy="userDays")
     */
    private $ingestions;

    public function __construct()
    {
        $this->ingestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiet(): ?UserDiet
    {
        return $this->diet;
    }

    public function setDiet(?UserDiet $diet): self
    {
        $this->diet = $diet;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
