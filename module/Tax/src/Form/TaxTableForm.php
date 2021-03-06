<?php

namespace Tax\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tax\Form\TaxFieldset;

class TaxTableForm extends Form
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->objectManager));

        parent::__construct('tax_table');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);
        $this->add([
            'name' => 'effectiveDate',
            'type' => 'text',
            'options' => [
                'label' => 'Effective date',
            ],
            'attributes' => [
                'class' => 'input-group date form-control',
                'id' => 'effetiveDate_datepicker'
            ]
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'operator',
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class'   => 'Tax\Model\Operator',
                'property'       => 'name',
                'label'          => 'Operator',
            ],
        ]);

        $this->add([
            'type' => Element\Collection::class,
            'name' => 'taxes',
            'options' => [
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => TaxFieldset::class,
                ],
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}