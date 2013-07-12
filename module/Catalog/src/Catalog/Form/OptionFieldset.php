<?php

namespace Catalog\Form;

use Catalog\Entity\Option;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Fieldset;

class OptionFieldset extends Fieldset
{
    public function init()
    {
        $this->setHydrator(new DoctrineObject($this->getFormFactory()->getFormElementManager()->getServiceLocator()->get('orm_manager'), 'Catalog\Entity\Option'));
        $this->setObject(new Option);

        $this->add(['name' => 'name', 'type' => 'text', 'options' => ['label' => 'Name'], 'attributes' => ['class' => 'option-name']]);
        $this->add(['name' => 'value', 'type' => 'text', 'options' => ['label' => 'Value'], 'attributes' => ['class' => 'option-value']]);
    }
}