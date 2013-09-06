<?php

namespace Catalog\View\Helper;

use Catalog\Entity\Category;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Router\RouteMatch;
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
    private $template = 'catalog/categories';

    public function __invoke()
    {
        if (null === $this->container) {
            /** @var EntityManager $em */
            $em              = $this->getServiceLocator()->getServiceLocator()->get('orm_manager');
            $this->container = new Navigation();
            Mvc::setDefaultRouter($this->getServiceLocator()->getServiceLocator()->get('router'));

            $match = Mvc::getDefaultRouter()->match($this->getServiceLocator()->getServiceLocator()->get('request'));

            if ($match instanceof RouteMatch) {
                $this->container->setPages($this->buildPages($em->getRepository('Catalog\Entity\Category')->findBy(['visible' => true])));
            }
        }

        return $this;
    }

    private function buildPages($categories, $parent = null)
    {
        $pages = [];

        foreach ($categories as $category) {
            /** @var $category \Catalog\Entity\Category */

            if ($category->getParent() == $parent) {
                $page = $this->getPage($category);

                $page->addPages($this->buildPages($categories, $category));

                $pages[] = $page;
            }
        }

        return $pages;
    }

    private function getPage(Category $category)
    {
        $page = new Mvc();

        $page->setLabel($category->getName())
            ->setRoute('products/list-by-category')
            ->setParams(['slug' => $category->getSlug()])
            ->setRouteMatch(Mvc::getDefaultRouter()->match($this->getServiceLocator()->getServiceLocator()->get('request')))
            ->setOrder($category->getDisplayOrder());

        return $page;
    }

    public function __toString()
    {
        return $this->getView()->render($this->template, ['container' => $this->container]);
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function getContainer()
    {
        return $this->container;
    }
}