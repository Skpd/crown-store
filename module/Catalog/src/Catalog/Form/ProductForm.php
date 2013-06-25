<?php

namespace Catalog\Form;

use Zend\Form\Form;
use DoctrineModule\Validator\ObjectExists;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ProductForm extends Form implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function getInputFilterSpecification()
    {
        return [
            'name'        => [
                'required'    => true,
                'allow_empty' => false,
                'filters'     => [
                    ['name' => 'HtmlEntities'],
                    ['name' => 'StringTrim'],
                ]
            ],
            'description' => [
                'required'    => false,
                'allow_empty' => true,
                'filters'     => [
                    ['name' => 'StringTrim'],
                ]
            ],
            'categories'  => [
                'required'    => false,
                'allow_empty' => true,
            ],
            'image' => [
                'required' => false,
                'allow_empty' => true
            ]
        ];
    }

    public function init()
    {
        $this->setName('category');

        $this->add(['name' => 'name', 'type' => 'text', 'options' => ['label' => 'Name']]);
        $this->add(['name' => 'description', 'type' => 'textarea', 'options' => ['label' => 'Description']]);
        $this->add(
            [
            'name'    => 'image',
            'type'    => 'file',
            'attributes' => [
                'multiple' => 'multiple'
            ],
            ]
        );

        $this->add(
            [
            'type'       => 'Catalog\Form\EntitySelect',
            'name'       => 'categories',
            'attributes' => [
                'multiple' => 'multiple'
            ],
            'options'    => [
                'label'          => 'Categories',
                'object_manager' => $this->getServiceLocator()->getServiceLocator()->get('doctrine.entity_manager.orm_default'),
                'target_class'   => 'Catalog\Entity\Category',
                'property'       => 'name',
                'empty_option'   => '',
            ]
            ]
        );
    }

}