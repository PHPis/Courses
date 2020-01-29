<?php
namespace App\Services;

use App\Entity\Ingestion;
use App\Entity\Meal;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Form\Form;

class MealService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function findById(int $id): ?Meal
    {
        return $this->entityManager->getRepository(Meal::class)->find($id);
    }

    public function createMeal(Form $form, User $user):void
    {
        $meal = new Meal();
        $meal->setName($form['name']->getData());
        $meal->setDescription($form['description']->getData());
        $meal->setIsStandard(true);
        foreach ($form['ingestion']->getData() as $ingestion) {
            $meal->addIngestion($ingestion);
        }
        $meal->setUser($user);

        $this->entityManager->persist($meal);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }
    }

    public function editMeal(Form $form, Meal $meal): void
    {
        $meal->setName($form['name']->getData());
        $meal->setDescription($form['description']->getData());
        foreach ($form['ingestion']->getData() as $ingestion) {
            $meal->addIngestion($ingestion);
        }

        $this->entityManager->persist($meal);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }
    }

    public function deleteMeal(int $id): bool
    {
        $meal = $this->findById($id);

        $this->entityManager->remove($meal);
        try {
            $this->entityManager->flush();
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function getAllMeal(): ?PaginationInterface
    {
        $meals = $this->entityManager
            ->getRepository(Meal::class)
            ->getAllMealPaginator();

        return $meals;
    }

    public function searchMeal(string $name, ?array $ingestionIds): ?PaginationInterface
    {
        $meals = $this->entityManager
            ->getRepository(Meal::class)
            ->searchQueryPaginator($name, $ingestionIds);

        return $meals;
    }
}