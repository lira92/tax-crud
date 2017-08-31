<?php

namespace Tax\Form;

use Tax\Model\Tax;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;

class TaxFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('taxes');

        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Tax());

        $this->setLabel('Tax');

        $this->add([
            'name' => 'value',
            'type' => 'number',
            'options' => [
                'label' => 'Value',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'fromValue',
            'type' => 'number',
            'options' => [
                'label' => 'From Value',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'untilValue',
            'type' => 'number',
            'options' => [
                'label' => 'Until Value',
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            'value' => [
                'required' => true,
            ],
            'fromValue' => [
                'required' => true,
            ],
            'untilValue' => [
                'required' => true,
            ],
        ];
    }
}