<?php

namespace Tax\Model;

use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Filter\DateSelect;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Validator\Date;
use Tax\Model\Tax;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TaxTable
 *
 * @ORM\Table(name="tax_table", indexes={@ORM\Index(name="operator_id", columns={"operator_id"})})
 * @ORM\Entity
 */
class TaxTable implements InputFilterAwareInterface
{
    public function __construct()
    {
        $this->taxes = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effective_date", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $effectiveDate;

    /**
     * @var \Tax\Model\Operator
     *
     * @ORM\ManyToOne(targetEntity="Tax\Model\Operator")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operator_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $operator;

    /**
     * @var \Tax\Model\Tax
     *
     * @ORM\OneToMany(targetEntity="Tax\Model\Tax", mappedBy="taxTable", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operator_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $taxes;

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
     * Set description
     *
     * @param string $description
     *
     * @return TaxTable
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set effectiveDate
     *
     * @param \DateTime $effectiveDate
     *
     * @return TaxTable
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    /**
     * Get effectiveDate
     *
     * @return \DateTime
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * Set operator
     *
     * @param \Tax\Model\Operator $operator
     *
     * @return TaxTable
     */
    public function setOperator(\Tax\Model\Operator $operator = null)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return \Tax\Model\Operator
     */
    public function getOperator()
    {
        return $this->operator;
    }

    public function addTax(Tax $tax)
    {
        $this->taxes[] = $tax;
        $tax->setTaxTable($this);
    }

    public function addTaxes(\Doctrine\Common\Collections\ArrayCollection $taxes)
    {
        foreach($taxes as $tax) {
            $this->add($tax);
        }
    }

    public function removeTaxes(\Doctrine\Common\Collections\ArrayCollection $taxes)
    {
        foreach($taxes as $tax) {
            $this->taxes->removeElement($tax);
        }
    }

    public function getTaxes()
    {
        return $this->taxes;
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
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ]
        ]);

        $inputFilter->add([
            'name' => 'effective_date',
            'required' => true,
            'filters' => [
                ['name' => DateSelect::class],
            ],
            'validators' => [
                [
                    'name' => Date::class
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}

