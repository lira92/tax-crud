<?php

namespace Tax\Model;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\I18n\Filter\NumberParse;
use Zend\I18n\Validator\IsFloat;
use Zend\Validator\GreaterThan;


/**
 * Tax
 *
 * @ORM\Table(name="tax", indexes={@ORM\Index(name="tax_table_id", columns={"tax_table_id"})})
 * @ORM\Entity
 */
class Tax implements InputFilterAwareInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false, unique=false)
     */
    private $value;

    /**
     * @var float
     *
     * @ORM\Column(name="from_value", type="float", precision=10, scale=0, nullable=false, unique=false)
     */
    private $fromValue;

    /**
     * @var float
     *
     * @ORM\Column(name="until_value", type="float", precision=10, scale=0, nullable=false, unique=false)
     */
    private $untilValue;

    /**
     * @var \Tax\Model\TaxTable
     *
     * @ORM\ManyToOne(targetEntity="Tax\Model\TaxTable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tax_table_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $taxTable;

    private $inputFilter;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Tax
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set fromValue
     *
     * @param float $fromValue
     *
     * @return Tax
     */
    public function setFromValue($fromValue)
    {
        $this->fromValue = $fromValue;

        return $this;
    }

    /**
     * Get fromValue
     *
     * @return float
     */
    public function getFromValue()
    {
        return $this->fromValue;
    }

    /**
     * Set untilValue
     *
     * @param float $untilValue
     *
     * @return Tax
     */
    public function setUntilValue($untilValue)
    {
        $this->untilValue = $untilValue;

        return $this;
    }

    /**
     * Get untilValue
     *
     * @return float
     */
    public function getUntilValue()
    {
        return $this->untilValue;
    }

    /**
     * Set taxTable
     *
     * @param \Tax\Model\TaxTable $taxTable
     *
     * @return Tax
     */
    public function setTaxTable(\Tax\Model\TaxTable $taxTable = null)
    {
        $this->taxTable = $taxTable;

        return $this;
    }

    /**
     * Get taxTable
     *
     * @return \Tax\Model\TaxTable
     */
    public function getTaxTable()
    {
        return $this->taxTable;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'value',
            'required' => true,
            'filters' => [
                ['name' => NumberParse::class],
            ],
            'validators' => [
                [
                    'name' => IsFloat::class
                ],
                [
                    'name' => GreaterThan::class,
                    'options' => [
                        'min' => 0
                    ]
                ],
            ]
        ]);

        $inputFilter->add([
            'name' => 'fromValue',
            'required' => true,
            'filters' => [
                ['name' => NumberParse::class],
            ],
            'validators' => [
                [
                    'name' => IsFloat::class
                ],
                [
                    'name' => GreaterThan::class,
                    'options' => [
                        'min' => 0
                    ]
                ],
            ]
        ]);

        $inputFilter->add([
            'name' => 'untilValue',
            'required' => true,
            'filters' => [
                ['name' => NumberParse::class],
            ],
            'validators' => [
                [
                    'name' => IsFloat::class
                ],
                [
                    'name' => GreaterThan::class,
                    'options' => [
                        'min' => 0
                    ]
                ],
            ]
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}

