<?php

namespace Catalog\Controller;

use Catalog\Entity\Image;
use Catalog\Entity\Product;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class ManageProductsController
 *
 * @package Catalog\Controller
 * @method \Zend\Http\Request getRequest()
 */
class ManageProductsController extends AbstractActionController
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;
    /** @var \Zend\Form\Form */
    private $form;

    public function listAction()
    {
        return [
            'products' => $this->getEntityManager()->getRepository('Catalog\Entity\Product')->findAll()
        ];
    }

    public function createAction()
    {
        $form = $this->getForm();

        if ($this->getRequest()->isPost()) {
            $form->setData(
                array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    $this->getRequest()->getFiles()->toArray()
                )
            );

            if ($form->isValid()) {
                $entity = $form->getData();

                $images = $form->get('image')->getValue();

                if (!empty($images)) {
                    foreach ($images as $i) {
                        $image = new Image();
                        $image->setImage(file_get_contents($i['tmp_name']));
                        $image->setMimeType($i['type']);
                        $image->setName($i['name']);

                        $this->getEntityManager()->persist($image);
                        $entity->addImages([$image]);
                    }
                }

                $this->getEntityManager()->persist($entity);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage('Product added.');
                $this->redirect()->toRoute('manage/products/list');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function updateAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id', null);
        $entity = $this->getEntityManager()->find('Catalog\Entity\Product', $id);

        if (empty($entity)) {
            $this->flashMessenger()->addErrorMessage('Product not found');
            $this->redirect()->toRoute('manage/products/list');
        }

        $form = $this->getForm();
        $form->bind($entity);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $category = $form->getData();

                $this->getEntityManager()->persist($category);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage('Product added.');
                $this->redirect()->toRoute('manage/products/list');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function deleteAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id', null);
        $entity = $this->getEntityManager()->find('Catalog\Entity\Product', $id);

        if (empty($entity)) {
            $this->flashMessenger()->addErrorMessage('Product not found');
            $this->redirect()->toRoute('manage/products/list');
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();

        $this->flashMessenger()->addSuccessMessage('Product deleted.');
        $this->redirect()->toRoute('manage/products/list');
    }

    /**
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        if (null === $this->form) {
            $this->form = $this->serviceLocator->get('FormElementManager')->get('ProductForm');
            $this->form->setHydrator(new DoctrineObject($this->getEntityManager(), 'Catalog\Entity\Product'));
            $this->form->bind(new Product());
        }

        return $this->form;
    }

    /** @return array|\Doctrine\ORM\EntityManager|object */
    public function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->serviceLocator->get('doctrine.entity_manager.orm_default');
        }
        return $this->entityManager;
    }
}