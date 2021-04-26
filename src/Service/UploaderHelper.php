<?php


namespace App\Service;


use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    public const PRODUCT_IMAGE = 'product_image';
    /**
     * @var string
     */
    private $uploadPath;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function uploadImage(UploadedFile $uploadedFile): string {

        $destination = $this->getUploadsPath();
        $originalFileName = $this->getOriginalFileName($uploadedFile);

        $newFileName = $this->getNewFileName($uploadedFile);

        $uploadedFile->move(
            $destination,
            $newFileName
        );
        return $newFileName;
    }

    /**
     * @return string
     */
    public function getUploadsPath(): string {
        return $this->uploadPath.self::PRODUCT_IMAGE.'/';
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function getOriginalFileName(UploadedFile $uploadedFile): string {
        return pathinfo($uploadedFile->getClientOriginalName(),PATHINFO_FILENAME);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function getNewFileName(UploadedFile $uploadedFile): string {
        return Urlizer::urlize($this->getOriginalFileName($uploadedFile)).'-'.uniqid().'.'.$uploadedFile->guessExtension();
    }

}