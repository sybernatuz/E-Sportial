<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 16/04/19
 * Time: 19:31
 */

namespace App\Services;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    private $targetDirectory;
    private $fileSystem;
    private $publicDir;

    /**
     * FileUploaderService constructor.
     * @param string $targetDirectory
     * @param Filesystem $fileSystem
     */
    public function __construct(string $targetDirectory, string $publicDir, Filesystem $fileSystem)
    {
        $this->targetDirectory = $targetDirectory;
        $this->fileSystem = $fileSystem;
        $this->publicDir = $publicDir;
    }

    /**
     * @param $subject
     * @param string $directory
     * @param bool $removeOlds
     * @param null|UploadedFile|UploadedFile[] $oldSubject
     * @return bool|array|string
     */
    public function upload($subject, string $directory, bool $removeOlds = false, $oldSubject = null)
    {
        $directory = $this->getTargetDirectory() . "/" . $directory . "/";
        try {
            if($removeOlds && !empty($oldSubject)) {
                $this->removeFiles($directory, $oldSubject);
            }
            $subjectName = $this->moveFiles($directory, $subject);
        } catch (FileException $e) {
            return false;
        }

        return $subjectName;
    }

    /**
     * @param string $directory
     * @param array|string $subject
     */
    private function removeFiles(string $directory, $subject) {
        if(is_array($subject)) {
            foreach ($subject as $sub) {
                $this->fileSystem->remove($directory . $sub);
            }
        } else {
            $this->fileSystem->remove($directory . $subject);
        }
    }

    /**
     * @param string $directory
     * @param UploadedFile[]|UploadedFile $subject
     * @return array|string
     */
    private function moveFiles(string $directory, $subject)  {
        if(is_array($subject)) {
            foreach ($subject as $sub) {
                $fileName = md5(uniqid()).'.'.$sub->guessExtension();
                $sub->move($this->getPublicDir() . $directory, $fileName);
                $newSubject[] = $fileName;
            }
        } else {
            $fileName = md5(uniqid()).'.'.$subject->guessExtension();
            $subject->move($this->getPublicDir() . $directory, $fileName);
            $newSubject = $fileName;
        }

        return $newSubject;
    }

    /**
     * @return string
     */
    public function getTargetDirectory() : string
    {
        return $this->targetDirectory;
    }

    /**
     * @return string
     */
    public function getPublicDir(): string
    {
        return $this->publicDir;
    }

    /**
     * @param string $publicDir
     */
    public function setPublicDir(string $publicDir): void
    {
        $this->publicDir = $publicDir;
    }


}