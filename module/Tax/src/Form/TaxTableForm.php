<?php

namespace Tax\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tax\Form\TaxFieldset;

class TaxTableForm extends Form implements ObjectManagerAwareInterface
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
            'name' => 'effective_date',
            'type' => 'DateSelect',
            'options' => [
                'label' => 'Effective date',
            ],
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'operator_id',
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
                'label' => 'Please add a taxes to this tax table',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => TaxFieldset::class,
                ],
                //'use_as_base_fieldset' => true,
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

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}