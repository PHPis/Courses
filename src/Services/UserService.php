<?php
namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserService
{
    private $uploaderHelper, $entityManager;

    public function __construct(EntityManagerInterface $em, UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->entityManager = $em;
    }

    public function uploadPhoto(User $user, UploadedFile $file)
    {
        $fileName = $this->uploaderHelper->uploadFile($file, UploaderHelper::USER_PHOTO_PATH);

        $user->setPhoto($fileName);
        $this->entityManager->persist($user);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("Photo wasn't uploaded.");
        }
    }
}