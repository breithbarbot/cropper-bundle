# Exemple File.php entity
```php
<?php
namespace YourBundle\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @link http://atlantic18.github.io/DoctrineExtensions/doc/uploadable.html Documentation Uploadable behavior extension for Doctrine 2
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="YourBundle\Repository\FileRepository")
 * @Gedmo\Uploadable(callback="callbackMethod", filenameGenerator="ALPHANUMERIC", appendNumber=true)
 * @ORM\HasLifecycleCallbacks()
 */
class File
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="full_path", type="string", length=255)
     * @Gedmo\UploadableFilePath
     */
    private $fullPath;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string", length=100)
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="decimal", precision=10, scale=0)
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     *
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    private $file;

    public function callbackMethod(array $info)
    {
        // Rewrite variables
        $info['fileWithoutExt'] = str_replace($info['fileExtension'], '', realpath($info['fileWithoutExt'].$info['fileExtension']));
        $info['filePath'] = realpath($info['filePath']);

        $realpath = str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', $info['filePath']);
        $this->setPath(str_replace('\\', '/', $realpath));
        $this->setFullPath($info['filePath']);
    }

    /**
     * @ORM\PreUpdate()
     *
     * @param PreUpdateEventArgs $args
     */
    public function setPreupdate(PreUpdateEventArgs $args)
    {
        if ($args->hasChangedField('fullPath')) {
            if ($args->getOldValue('fullPath') !== $args->getNewValue('fullPath')) {
                $this->removeFiles($args->getOldValue('fullPath'), true);
            }
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function setPreRemove()
    {
        $this->removeFiles($this->getFullPath());
    }

    /**
     * Remove files if they are unnecessary
     *
     * @param      $fullPath
     * @param bool $removeBaseFile
     */
    public function removeFiles($fullPath, $removeBaseFile = false)
    {
        if (is_file($fullPath)) {
            // Variables
            $pathinfo = pathinfo($fullPath);
            $filename = $pathinfo['filename'];
            $extension = $pathinfo['extension'];

            // Delete base file if exist
            if ($removeBaseFile && file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Delete original file if exist
            $originalFilename = str_replace($filename.'.'.$extension, $filename.'.original.'.$extension, $fullPath);
            if (file_exists($originalFilename)) {
                unlink($originalFilename);
            }
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return File
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File|null
     */
    public function getFile()
    {
        return $this->file;
    }
    
    // Getter, setter and more custom...
    // For getName() function : `return pathinfo($this->name, PATHINFO_FILENAME);`
    // [...]
}
```

<br>

#### Back to index
[Back to documentation index](../../index.md)