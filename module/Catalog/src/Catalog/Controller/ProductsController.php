<?php

namespace Catalog\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class ProductsController extends AbstractActionController
{
    private $entityManager;

    public function getImageAction()
    {
        $response = new Response();

        $id = $this->params('id', null);

        /** @var null|\Catalog\Entity\Image $image */
        $image = $this->getEntityManager()->getRepository('Catalog\Entity\Image')->find($id);

        if (empty($image)) {
            $response->setStatusCode(403);
            return $response;
        }

        $response->setStatusCode(200);
        $response->getHeaders()->addHeaderLine('Content-Type', $image->getMimeType());

        $type = $this->params('type');

        if ($type == 'medium') {
            $response->setContent(stream_get_contents($image->getThumbnail()));
        } else {
            $response->setContent(stream_get_contents($image->getImage()));
        }

        return $response;
    }

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
        $slug = $this->params('slug', null);

        /** @var null|\Catalog\Entity\Category $category */
        $category = $this->getEntityManager()->getRepository('Catalog\Entity\Category')->findOneBy(['slug' => $slug]);

        if (empty($category)) {
            $this->redirect()->toRoute('home');
        }

        $name = $this->params('name', null);

        /** @var null|\Catalog\Entity\Product $product */
        $product = $this->getEntityManager()->getRepository('Catalog\Entity\Product')->findOneBy(['name' => $name]);

        if (empty($product)) {
            $this->redirect()->toRoute('home');
        }

        return ['product' => $product, 'category' => $category];
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