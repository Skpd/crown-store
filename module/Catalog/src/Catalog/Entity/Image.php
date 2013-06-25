<?php

namespace Catalog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks
 * @Form\Name("image")
 */
class Image
{
    #region Fields
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Form\Attributes({"type":"hidden"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="blob")
     * @var string
     */
    private $image;

    /**
     * @ORM\Column(type="blob")
     * @var string
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $originalWidth;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $originalHeight;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $thumbnailWidth;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $thumbnailHeight;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $mimeType;
    #endregion

    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        $image = imagecreatefromstring($this->image);

        if ($image) {
            $this->originalWidth  = imagesx($image);
            $this->originalHeight = imagesy($image);

            $thumbnail = imagecreatetruecolor(64, 64);

            $this->thumbnailWidth  = 64;
            $this->thumbnailHeight = 64;

            imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, 64, 64, $this->originalWidth, $this->originalHeight);

            ob_start();
            imagepng($thumbnail);
            $this->thumbnail = ob_get_clean();
        }
    }

    #region Getters / Setters
    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param integer $originalHeight
     */
    public function setOriginalHeight($originalHeight)
    {
        $this->originalHeight = $originalHeight;
    }

    /**
     * @return integer
     */
    public function getOriginalHeight()
    {
        return $this->originalHeight;
    }

    /**
     * @param integer $originalWidth
     */
    public function setOriginalWidth($originalWidth)
    {
        $this->originalWidth = $originalWidth;
    }

    /**
     * @return integer
     */
    public function getOriginalWidth()
    {
        return $this->originalWidth;
    }

    /**
     * @param integer $thumbnailHeight
     */
    public function setThumbnailHeight($thumbnailHeight)
    {
        $this->thumbnailHeight = $thumbnailHeight;
    }

    /**
     * @return integer
     */
    public function getThumbnailHeight()
    {
        return $this->thumbnailHeight;
    }

    /**
     * @param integer $thumbnailWidth
     */
    public function setThumbnailWidth($thumbnailWidth)
    {
        $this->thumbnailWidth = $thumbnailWidth;
    }

    /**
     * @return integer
     */
    public function getThumbnailWidth()
    {
        return $this->thumbnailWidth;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    #endregion
}