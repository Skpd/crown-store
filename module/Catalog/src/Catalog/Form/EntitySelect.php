<?php

namespace Catalog\Form;

use DoctrineModule\Form\Element\ObjectSelect as DoctrineObjectSelect;

class EntitySelect extends DoctrineObjectSelect
{

    /**
     * {@inheritDoc}
     *
     * @var $value \Doctrine\ORM\PersistentCollection
     */
    public function setValue($value)
    {
        if ($value == null || $value == '' || !is_object($value)) {
            $this->value = $value;
            return $this;
        }

        if ($value instanceof \Doctrine\ORM\PersistentCollection || $value instanceof \Doctrine\Common\Collections\ArrayCollection) {
            $values = array();

            foreach ($value->toArray() as $v) {
                if (is_object($v)) {
                    $values[] = $v->getId();
                }
            }

            $this->value = $values;
            return $this;
        }

        $this->value = $value->getId();
        return $this;
    }
}