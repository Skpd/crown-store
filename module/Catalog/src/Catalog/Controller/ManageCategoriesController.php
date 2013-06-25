<?php

namespace Catalog\Controller;

use Catalog\Entity\Category;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\AbstractActionController;

class ManageCategoriesController extends AbstractActionController
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;
    /** @var \Zend\Form\Form */
    private $form;

    public function listAction()
    {
        return [
            'categories' => $this->getEntityManager()->getRepository('Catalog\Entity\Category')->findAll()
        ];
    }

    public function createAction()
    {
        $form = $this->getForm();

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $category = $form->getData();

                $this->getEntityManager()->persist($category);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage('Category added.');
                $this->redirect()->toRoute('manage/categories/list');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function updateAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id', null);
        $entity = $this->getEntityManager()->find('Catalog\Entity\Category', $id);

        if (empty($entity)) {
            $this->flashMessenger()->addErrorMessage('Category not found');
            $this->redirect()->toRoute('manage/categories/list');
        }

        $form = $this->getForm();
        $form->bind($entity);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $category = $form->getData();

                $this->getEntityManager()->persist($category);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage('Category added.');
                $this->redirect()->toRoute('manage/categories/list');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function deleteAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id', null);
        $entity = $this->getEntityManager()->find('Catalog\Entity\Category', $id);

        if (empty($entity)) {
            $this->flashMessenger()->addErrorMessage('Category not found');
            $this->redirect()->toRoute('manage/categories/list');
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();

        $this->flashMessenger()->addSuccessMessage('Category deleted.');
        $this->redirect()->toRoute('manage/categories/list');
    }

    /**
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        if (null === $this->form) {
            $this->form = $this->serviceLocator->get('FormElementManager')->get('CategoryForm');
            $this->form->setHydrator(new DoctrineObject($this->getEntityManager(), 'Catalog\Entity\Category'));
            $this->form->bind(new Category());
        }

        return $this->form;
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