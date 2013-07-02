<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ProductsController extends AbstractActionController
{
    private $entityManager;

    public function listByCategoryAction()
    {
        $slug = $this->params('slug', null);

        /** @var null|\Catalog\Entity\Category $category */
        $category = $this->getEntityManager()->getRepository('Catalog\Entity\Category')->findOneBy(['slug' => $slug]);

        if (empty($category)) {
            $this->redirect()->toRoute('home');
        }

        return ['products' => $category->getProducts(), 'category' => $category];
    }

    public function viewAction()
    {

    }

    /** @return array|\Doctrine\ORM\EntityManager|object */
    public function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->serviceLocator->get('orm_manager');
        }
        return $this->entityManager;
    }
}