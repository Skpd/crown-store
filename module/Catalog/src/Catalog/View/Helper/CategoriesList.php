<?php

namespace Catalog\View\Helper;

use Catalog\Entity\Category;
use Doctrine\ORM\EntityManager;
use Zend\Navigation\Navigation;
use Zend\Navigation\Page\Mvc;
use Zend\Navigation\Page\Uri;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Helper\AbstractHelper;

class CategoriesList extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    private $container;

    public function __invoke()
    {
        if (null === $this->container) {
            /** @var EntityManager $em */
            $em              = $this->getServiceLocator()->getServiceLocator()->get('orm_manager');
            $this->container = new Navigation();

            $this->container->setPages($this->buildPages($em->getRepository('Catalog\Entity\Category')->findAll()));
        }

        return $this;
    }

    public function getContainer()
    {
        return $this->container;
    }

    private function buildPages($categories, $parent = null)
    {
        $pages = [];

        foreach ($categories as $category) {
            if ($category->getParent() == $parent) {
                $page = $this->getPage($category);

                $child = $this->buildPages($categories, $category);

                if (!empty($child)) {
                    $page->addPages($child);
                }

                $pages[] = $page;
            }
        }

        return $pages;
    }

    private function getPage(Category $category)
    {
        $page = new Uri();
        $page->setLabel($category->getName());
        $page->setUri('#');
        return $page;
    }

    public function __toString()
    {
        return (string) $this->getView()->navigation()->menu($this->container)->renderMenu();
    }
}