<?php
namespace App\Services;

use App\Entity\UserDay;
use App\Entity\UserDiet;
use Doctrine\ORM\EntityManagerInterface;

class UserDayService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function findById(int $id): ?UserDay
    {
        return $this->entityManager->find(UserDay::class, $id);
    }

    public function create(UserDiet $userDiet, \DateTime $dateTime): ?UserDay
    {
        $userDay = new UserDay();
        $userDay->setDiet($userDiet);
        $userDay->setDate($dateTime);
        foreach ($userDiet->getIngestions() as $ingestion){
            $userDay->addIngestion($ingestion);
        }
        $this->entityManager->persist($userDay);
        try {
            $this->entityManager->flush();
            return $userDay;
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating user day.");
        }
    }

    public function  searchDayByDate(\DateTime $date, UserDiet $userDiet): ?array
    {
        return $this->entityManager
            ->getRepository(UserDay::class)
            ->searchUserDayByDate($userDiet, $date);
    }
}