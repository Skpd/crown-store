<?php

namespace Catalog\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
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
        $page = $this->params('page', 0);

        $products = $this->getEntityManager()->createQuery(
            <<<'DQL'
            SELECT product.id, category.slug slug, product.name name, image.id FROM Catalog\Entity\Product product
                JOIN product.categories AS category
                JOIN product.images AS image
            WHERE category.slug = :slug
DQL
        )->setParameter('slug', $slug);

        $paginator = new Paginator($products);
        $paginator->setUseOutputWalkers(false);

        $products = new \Zend\Paginator\Paginator(new DoctrinePaginator($paginator));
        $products->setItemCountPerPage(9);
        $products->setCurrentPageNumber($page);

        $total = $this->getEntityManager()->createQuery(
            <<<'DQL'
            SELECT COUNT(product) FROM Catalog\Entity\Product product
                JOIN product.categories AS category
                JOIN product.images AS image
            WHERE category.slug = :slug
DQL
        )->setParameter('slug', $slug)->getArrayResult();

        $total = (int) $total[0][1];

        $category = $this->getEntityManager()->getRepository('Catalog\Entity\Category')->findBy(['slug' => $slug]);
        $childCategories = [];

        foreach ($this->getEntityManager()->getRepository('Catalog\Entity\Category')->findBy(['parent' => $category]) as $childCategory) {
            $childProducts = $this->getEntityManager()->createQuery(
                <<<'DQL'
                SELECT product.name, image.id
                    FROM Catalog\Entity\Product product
                    JOIN product.categories AS category
                    JOIN product.images AS image
                WHERE category.slug = :slug
DQL
            )->setParameter('slug', $childCategory->getSlug())->setMaxResults(3)->getArrayResult();

            if (count($childProducts) > 0) {
                $childCategories[] = [
                    'category' => [
                        'slug' => $childCategory->getSlug(),
                        'name' => $childCategory->getName(),
                    ],
                    'products' => $childProducts
                ];
            }
        }

        return [
            'products' => $products,
            'childCategories' => $childCategories,
            'total' => $total,
            'category' => $category,
            'displaySeo' => $page <= 1,
            'showDetails' => $this->params('showDetails', true)
        ];
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