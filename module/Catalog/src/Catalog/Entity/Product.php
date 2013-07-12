<?php

namespace Catalog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks
 * @Form\Name("product")
 */
class Product
{
    #region Fields

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Form\Attributes({"type":"hidden"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, unique=false, length=127)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true, unique=false)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Form\Exclude()
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @Form\Exclude()
     * @var \DateTime
     */
    private $updated;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
     * @ORM\JoinTable(name="products_categories")
     * @var Category
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Image")
     * @var Image
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="Option", mappedBy="product", cascade={"all"})
     */
    private $options;

    #endregion

    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime();
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images     = new ArrayCollection();
        $this->options    = new ArrayCollection();
    }

    public function addOptions($options)
    {
        foreach ($options as $option) {
            $this->options->add($option);
            $option->setProduct($this);
        }
    }

    public function removeOptions($options)
    {
        foreach ($options as $option) {
            $this->options->removeElement($option);
            $option->setProduct(null);
        }
    }

    public function addCategories($categories)
    {
        foreach ($categories as $category) {
            $this->categories->add($category);
            $category->addProduct($this);

            if ($category->getParent()) {
                $this->addCategories([$category->getParent()]);
            }
        }
    }

    public function removeCategories($categories)
    {
        foreach ($categories as $category) {
            $this->categories->removeElement($category);
            $category->removeProduct($this);
        }
    }

    public function addImages($images)
    {
        foreach ($images as $image) {
            $this->images->add($image);
        }
    }

    public function removeImages($images)
    {
        foreach ($images as $image) {
            $this->images->removeElement($image);
        }
    }
    
    #region Getters / Setters

    /**
     * @param \Catalog\Entity\Image $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return \Catalog\Entity\Image
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \Catalog\Entity\Category $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \Catalog\Entity\Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

        /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param Option[] $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    #endregion
}