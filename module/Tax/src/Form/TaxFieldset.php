<?php

namespace Tax\Form;

use Tax\Model\Tax;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;

class TaxFieldset extends Fieldset
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
                'class' => 'form-control',
                'step' => '0.01'
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
                'class' => 'form-control',
                'step' => '0.01'
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
                'class' => 'form-control',
                'step' => '0.01'
            ],
        ]);
    }
}