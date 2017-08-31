<?php

namespace Tax\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tax
 *
 * @ORM\Table(name="tax", indexes={@ORM\Index(name="tax_table_id", columns={"tax_table_id"})})
 * @ORM\Entity
 */
class Tax
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
}

