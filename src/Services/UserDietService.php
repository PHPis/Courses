<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\UserDiet;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserDietService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function createUserDiet(User $user, IngestionService $ingestionService): ?UserDiet
    {
        $date = new \DateTime();
        $userDiet = new UserDiet();
        $userDiet->setUser($user);
        $userDiet->setDateCreate($date);

        $this->entityManager->persist($userDiet);
        try {
            $this->entityManager->flush();
            $this->addAllIngestion($userDiet, $ingestionService);
            return $userDiet;
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }

    }

    public function addAllIngestion(UserDiet $userDiet, IngestionService $ingestionService)
    {
        $ingestions = $ingestionService->getAllIngestionsArray();
        foreach ($ingestions as $ingestion) {
            $ingestion = $ingestionService->findById($ingestion['id']);
            $userDiet->addIngestion($ingestion);
        }

        $this->entityManager->persist($userDiet);
        try {
            $this->entityManager->flush();
            return $userDiet;
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }
    }

    public function addAllRequestIngestion(UserDiet $userDiet, array $ingestions, IngestionService $ingestionService)
    {
        foreach ($userDiet->getIngestions() as $ingestion){
            $userDiet->removeIngestion($ingestion);
        }

        foreach ($ingestions as $ingestion) {
            $ingestion = $ingestionService->findById($ingestion);
            $userDiet->addIngestion($ingestion);
        }

        $this->entityManager->persist($userDiet);
        try {
            $this->entityManager->flush();
            return $userDiet;
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }
    }

    public function getStartDay(Request $request, \DateTime $today): \DateTime
    {
        $requestPrevDay = $request->query->get('prev');
        $requestNextDay = $request->query->get('next');
        if($requestPrevDay) {
            $startDay = \DateTime::createFromFormat('d-m-y',$requestPrevDay)->setTime(0, 0, 0, 0);
        } elseif ($requestNextDay) {
            $startDay = \DateTime::createFromFormat('d-m-y',$requestNextDay)->setTime(0, 0, 0, 0);
        } elseif ($today->format('N') != 1) {
            $startDay = (new \DateTime('last monday'));
        } else {
            $startDay = new \DateTime('now');
        }
        return $startDay;
    }

    public function getLastDay(\DateTime $startDay): \DateTime
    {
        return (new \DateTime($startDay->format('d-m-Y')))->modify('+1 week');
    }

    public function prevDay(\DateTime $startDay): \DateTime
    {
        return (new \DateTime($startDay->format('d-m-Y')))->modify('-1 week');
    }

    public function nextDay(\DateTime $startDay): \DateTime
    {
        return (new \DateTime($startDay->format('d-m-Y')))->modify('+1 week');
    }

    public function getIngestionsOfDate(\DateTime $date, \DateTime $today, UserDiet $userDiet): ?array
    {
        if ($date >= $today || $date->format('d:m:Y') == $today->format('d:m:Y')) {
            return $userDiet->getIngestions()->toArray();
        } elseif ($userDiet->getUserDays()->count() != 0) {
            foreach ($userDiet->getUserDays() as $day){
                if ($day->getDate() == $date){
                    return $userDiet->getUserDays()->getIngestions()->toArray();
                }
            }
            return null;
        } else {
            return null;
        }
    }
}