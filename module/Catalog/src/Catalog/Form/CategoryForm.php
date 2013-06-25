<?php

namespace Catalog\Form;

use Zend\Form\Form;
use DoctrineModule\Validator\ObjectExists;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class CategoryForm extends Form implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true,
                'allow_empty' => false,
                'filters' => [
                    ['name' => 'HtmlEntities'],
                    ['name' => 'StringTrim'],
                ]
            ],
            'parent' => [
                'required' => false,
                'allow_empty' => true,
                'validators' => [
                    [
                        'name' => 'DoctrineModule\Validator\ObjectExists',
                        'options' => [
                            'object_repository' => $this->getServiceLocator()->getServiceLocator()->get('orm_manager')
                                ->getRepository('Catalog\Entity\Category'),
                            'fields' => 'id',
                            'messages' => [
                                ObjectExists::ERROR_NO_OBJECT_FOUND => 'Category not found'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public function init()
    {
        $this->setName('category');

        $this->add(['name' => 'name', 'type' => 'text', 'options' => ['label' => 'Name']]);

        $this->add(
            [
            'type'    => 'Catalog\Form\EntitySelect',
            'name'    => 'parent',
            'options' => [
                'label'          => 'Parent',
                'object_manager' => $this->getServiceLocator()->getServiceLocator()->get('orm_manager'),
                'target_class'   => 'Catalog\Entity\Category',
                'property'       => 'name',
                'empty_option'   => '',
            ]
            ]
        );
    }

}