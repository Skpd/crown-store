<?php

namespace Catalog\Form;

use Catalog\Entity\Image;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ImageFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function getInputFilterSpecification()
    {
        return [
            'image' => [
                'required' => false,
                'allow_empty' => true
            ]
        ];
    }


    public function init()
    {
        $this->add(['name' => 'image', 'type' => 'file', 'options' => ['label' => 'Image']]);
        $this->setHydrator(new DoctrineObject($this->serviceLocator->getServiceLocator()->get('orm_manager'), 'Catalog\Entity\Image'));
        $this->setObject(new Image());
    }

}