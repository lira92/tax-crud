<?php

namespace Tax\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxTable
 *
 * @ORM\Table(name="tax_table", indexes={@ORM\Index(name="operator_id", columns={"operator_id"})})
 * @ORM\Entity
 */
class TaxTable
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
}

