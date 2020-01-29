<?php
namespace App\Services;

use App\Entity\Ingestion;
use App\Repository\IngestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Form\Form;

class IngestionService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function findById(int $id): ?Ingestion
    {
        return $this->entityManager->getRepository(Ingestion::class)->find($id);
    }

    public function addIngestion(Form $form): void
    {
        $ingestion = new Ingestion();
        $ingestion->setName($form['name']->getData());
        $ingestion->setPriority($form['priority']->getData());
        $this->entityManager->persist($ingestion);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }
    }

    public function editIngestion(Form $form, Ingestion $ingestion): void
    {
        $ingestion->setName($form['name']->getData());
        $ingestion->setPriority($form['priority']->getData());
        $this->entityManager->persist($ingestion);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("Exception of creating Ingestion.");
        }
    }

    public function deleteIngestion(int $id): bool
    {
        $ingestion = $this->findById($id);
        $this->entityManager->remove($ingestion);
        try {
            $this->entityManager->flush();
            return true;
        } catch(\Exception $e) {
            return false;
        }

    }

    public function getAllIngestions(): ?PaginationInterface
    {
        $ingestions = $this->entityManager
            ->getRepository(Ingestion::class)
            ->getAllIngestionPaginator();

        return $ingestions;
    }
}