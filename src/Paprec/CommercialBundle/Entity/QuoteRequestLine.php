<?php

namespace Paprec\CommercialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * QuoteRequestLine
 *
 * @ORM\Table(name="quoteRequestLines")
 * @ORM\Entity(repositoryClass="Paprec\CommercialBundle\Repository\QuoteRequestLineRepository")
 */
class QuoteRequestLine
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdate", type="datetime", nullable=true)
     */
    private $dateUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @var string
     *
     * @ORM\Column(name="productName", type="string", length=255)
     */
    private $productName;

    /**
     * @var int
     *
     * @ORM\Column(name="setUpPrice", type="integer", nullable=true)
     */
    private $setUpPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="rentalUnitPrice", type="integer", nullable=true)
     */
    private $rentalUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="transportUnitPrice", type="integer", nullable=true)
     */
    private $transportUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="treatmentUnitPrice", type="integer", nullable=true)
     */
    private $treatmentUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="traceabilityUnitPrice", type="integer", nullable=true)
     */
    private $traceabilityUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="transportRate", type="bigint", nullable=true)
     */
    private $transportRate;

    /**
     * @var int
     *
     * @ORM\Column(name="treatmentRate", type="bigint", nullable=true)
     */
    private $treatmentRate;


    /**
     * @var int
     *
     * @ORM\Column(name="traceabilityRate", type="bigint", nullable=true)
     */
    private $traceabilityRate;

    /**
     * @var int
     *
     * @ORM\Column(name="totalAmount", type="integer")
     */
    private $totalAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="integer",
     *     message="La quantité doit être un nombre entier"
     * )
     */
    private $quantity;

    /**************************************************************************************************
     * RELATIONS
     */

    /**
     * @ORM\ManyToOne(targetEntity="Paprec\CatalogBundle\Entity\Product")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id", nullable=false)
     */
    private $product;


    /**
     * @ORM\ManyToOne(targetEntity="Paprec\CommercialBundle\Entity\QuoteRequest", inversedBy="quoteRequestLines")
     * @ORM\JoinColumn(name="quoteRequestId", referencedColumnName="id", nullable=false)
     */
    private $quoteRequest;

    /**
     * QuoteRequestLine constructor.
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return QuoteRequestLine
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateUpdate.
     *
     * @param \DateTime|null $dateUpdate
     *
     * @return QuoteRequestLine
     */
    public function setDateUpdate($dateUpdate = null)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate.
     *
     * @return \DateTime|null
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime|null $deleted
     *
     * @return QuoteRequestLine
     */
    public function setDeleted($deleted = null)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return \DateTime|null
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set productName.
     *
     * @param string $productName
     *
     * @return QuoteRequestLine
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName.
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set unitPrice.
     *
     * @param int $unitPrice
     *
     * @return QuoteRequestLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice.
     *
     * @return int
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set totalAmount.
     *
     * @param int $totalAmount
     *
     * @return QuoteRequestLine
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount.
     *
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return QuoteRequestLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set product.
     *
     * @param \Paprec\CatalogBundle\Entity\Product $product
     *
     * @return QuoteRequestLine
     */
    public function setProduct(\Paprec\CatalogBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \Paprec\CatalogBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set quoteRequest.
     *
     * @param \Paprec\CommercialBundle\Entity\QuoteRequest $quoteRequest
     *
     * @return QuoteRequestLine
     */
    public function setQuoteRequest(\Paprec\CommercialBundle\Entity\QuoteRequest $quoteRequest)
    {
        $this->quoteRequest = $quoteRequest;

        return $this;
    }

    /**
     * Get quoteRequest.
     *
     * @return \Paprec\CommercialBundle\Entity\QuoteRequest
     */
    public function getQuoteRequest()
    {
        return $this->quoteRequest;
    }

    /**
     * Set rentalUnitPrice.
     *
     * @param int|null $rentalUnitPrice
     *
     * @return QuoteRequestLine
     */
    public function setRentalUnitPrice($rentalUnitPrice = null)
    {
        $this->rentalUnitPrice = $rentalUnitPrice;

        return $this;
    }

    /**
     * Get rentalUnitPrice.
     *
     * @return int|null
     */
    public function getRentalUnitPrice()
    {
        return $this->rentalUnitPrice;
    }

    /**
     * Set transportUnitPrice.
     *
     * @param int|null $transportUnitPrice
     *
     * @return QuoteRequestLine
     */
    public function setTransportUnitPrice($transportUnitPrice = null)
    {
        $this->transportUnitPrice = $transportUnitPrice;

        return $this;
    }

    /**
     * Get transportUnitPrice.
     *
     * @return int|null
     */
    public function getTransportUnitPrice()
    {
        return $this->transportUnitPrice;
    }

    /**
     * Set treatmentUnitPrice.
     *
     * @param int|null $treatmentUnitPrice
     *
     * @return QuoteRequestLine
     */
    public function setTreatmentUnitPrice($treatmentUnitPrice = null)
    {
        $this->treatmentUnitPrice = $treatmentUnitPrice;

        return $this;
    }

    /**
     * Get treatmentUnitPrice.
     *
     * @return int|null
     */
    public function getTreatmentUnitPrice()
    {
        return $this->treatmentUnitPrice;
    }

    /**
     * Set traceabilityUnitPrice.
     *
     * @param int|null $traceabilityUnitPrice
     *
     * @return QuoteRequestLine
     */
    public function setTraceabilityUnitPrice($traceabilityUnitPrice = null)
    {
        $this->traceabilityUnitPrice = $traceabilityUnitPrice;

        return $this;
    }

    /**
     * Get traceabilityUnitPrice.
     *
     * @return int|null
     */
    public function getTraceabilityUnitPrice()
    {
        return $this->traceabilityUnitPrice;
    }

    /**
     * Set transportRate.
     *
     * @param int $transportRate
     *
     * @return QuoteRequestLine
     */
    public function setTransportRate($transportRate)
    {
        $this->transportRate = $transportRate;

        return $this;
    }

    /**
     * Get transportRate.
     *
     * @return int
     */
    public function getTransportRate()
    {
        return $this->transportRate;
    }

    /**
     * Set treatmentRate.
     *
     * @param int $treatmentRate
     *
     * @return QuoteRequestLine
     */
    public function setTreatmentRate($treatmentRate)
    {
        $this->treatmentRate = $treatmentRate;

        return $this;
    }

    /**
     * Get treatmentRate.
     *
     * @return int
     */
    public function getTreatmentRate()
    {
        return $this->treatmentRate;
    }

    /**
     * Set traceabilityRate.
     *
     * @param int $traceabilityRate
     *
     * @return QuoteRequestLine
     */
    public function setTraceabilityRate($traceabilityRate)
    {
        $this->traceabilityRate = $traceabilityRate;

        return $this;
    }

    /**
     * Get traceabilityRate.
     *
     * @return int
     */
    public function getTraceabilityRate()
    {
        return $this->traceabilityRate;
    }

    /**
     * Set setUpPrice.
     *
     * @param int $setUpPrice
     *
     * @return QuoteRequestLine
     */
    public function setSetUpPrice($setUpPrice)
    {
        $this->setUpPrice = $setUpPrice;

        return $this;
    }

    /**
     * Get setUpPrice.
     *
     * @return int
     */
    public function getSetUpPrice()
    {
        return $this->setUpPrice;
    }
}
