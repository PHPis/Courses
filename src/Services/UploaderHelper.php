<?php

namespace App\Services;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    const USER_PHOTO_PATH = 'user-photo/';

    private $uploadsPath;


    public function uploadFile(?UploadedFile $file, string $path): ?string
    {
        if (!$file){
            return null;
        }
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $filesystem = new Filesystem();
        $fileDir = $this->uploadsPath . $path;

        if (!$filesystem->exists($fileDir)) {
            $filesystem->mkdir($fileDir);
        }

        try {
            $file->move(
                $fileDir,
                $newFilename
            );
            return $newFilename;
        } catch (FileException $e) {
            throw new FileException("File was not uploaded." . $e);
        }
    }

    public function deleteFile(string $fileName, string $path): void
    {
        $filesystem = new Filesystem();
        $fileTest = $this->uploadsPath . $path . $fileName;
        if ($filesystem->exists($fileTest)) {
            try {
                $filesystem->remove($fileTest);
            } catch (IOExceptionInterface $exception) {
                throw new FileException("File was not uploaded." . $exception);
            }
        }
    }
}
