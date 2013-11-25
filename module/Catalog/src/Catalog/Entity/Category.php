<?php

namespace Catalog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 * @ORM\HasLifecycleCallbacks
 * @Form\Name("category")
 */
class Category
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
     * @ORM\ManyToOne(targetEntity="Category")
     * @var Category
     */
    private $parent;

    /**
     * @ORM\Column(type="string", unique=true, length=64)
     * @var string
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     * @var ArrayCollection
     */
    private $products;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $displayOrder = 0;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $visible = true;

    /**
     * @ORM\Column(type="string", nullable=false, unique=false, length=255)
     * @var string
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", nullable=false, unique=false, length=127)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=false, unique=false)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=false, unique=false)
     * @var string
     */
    private $text;
    #endregion

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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

    public function __toString()
    {
        return $this->name;
    }

    public function addProduct(Product $product)
    {
        $this->products->add($product);
    }

    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    #region Getters / Setters

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
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param \Catalog\Entity\Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return \Catalog\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
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
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param string $displayOrder
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;
    }

    /**
     * @return string
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    #endregion
}