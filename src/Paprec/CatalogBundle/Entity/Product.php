<?php

namespace Paprec\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Paprec\CatalogBundle\Repository\ProductRepository")
 */
class Product
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
     * Le volume du produit
     * @ORM\Column(name="capacity", type="string", length=10)
     * @Assert\NotBlank()
     */
    private $capacity;

    /**
     * @var string
     * L'unité du volume du produit (litre, m²,..)
     * @ORM\Column(name="capacityUnit", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $capacityUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="dimensions", type="string", length=500)
     * @Assert\NotBlank()
     */
    private $dimensions;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isDisabled", type="boolean")
     * @Assert\NotBlank()
     */
    private $isDisabled;

    /**
     * @var text
     * @ORM\Column(name="availablePostalCodeIds", type="text", nullable=true)
     * @Assert\Regex(
     *     pattern="/^(\d{2}(\*|(?:\d{3}))(,\s*)?)+$/",
     *     match=true,
     *     message="Les codes postaux doivent être des nombres séparés par des virgules. (ex: 75*, 92150, 36*)"
     * )
     */
    private $availablePostalCodes;

    /**
     * @var int
     *
     * @ORM\Column(name="rentalUnitPrice", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\d{1,6}((\.|\,)\d{1,2})?$/",
     *     match=true,
     *     message="la valeur doit être un nombre entre 0 et 999 999,99 ('.' autorisé)"
     * )
     */
    private $rentalUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="transportUnitPrice", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\d{1,6}((\.|\,)\d{1,2})?$/",
     *     match=true,
     *     message="la valeur doit être un nombre entre 0 et 999 999,99 ('.' autorisé)"
     * )
     */
    private $transportUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="treatmentUnitPrice", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\d{1,6}((\.|\,)\d{1,2})?$/",
     *     match=true,
     *     message="la valeur doit être un nombre entre 0 et 999 999,99 ('.' autorisé)"
     * )
     */
    private $treatmentUnitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="traceabilityUnitPrice", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\d{1,6}((\.|\,)\d{1,2})?$/",
     *     match=true,
     *     message="la valeur doit être un nombre entre 0 et 999 999,99 ('.' autorisé)"
     * )
     */
    private $traceabilityUnitPrice;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="position", type="integer")
     */
    private $position;


    /**
     * #################################
     *              SYSTEM USER ASSOCIATION
     * #################################
     */

    /**
     * @ORM\ManyToOne(targetEntity="Paprec\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="userCreationId", referencedColumnName="id", nullable=false)
     */
    private $userCreation;

    /**
     * @ORM\ManyToOne(targetEntity="Paprec\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="userUpdateId", referencedColumnName="id", nullable=true)
     */
    private $userUpdate;

    /**
     * #################################
     *              Relations
     * #################################
     */

    /**
     * @ORM\OneToMany(targetEntity="Paprec\CatalogBundle\Entity\Picture", mappedBy="product", cascade={"all"})
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity="Paprec\CatalogBundle\Entity\ProductLabel", mappedBy="product", cascade={"all"})
     */
    private $productLabels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->pictures = new ArrayCollection();
        $this->productLabels = new ArrayCollection();
    }


    /**
     * ##########################################
     */

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
     * Set dimensions.
     *
     * @param string $dimensions
     *
     * @return Product
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * Get dimensions.
     *
     * @return string
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Set capacityUnit.
     *
     * @param string $capacityUnit
     *
     * @return Product
     */
    public function setCapacityUnit($capacityUnit)
    {
        $this->capacityUnit = $capacityUnit;

        return $this;
    }

    /**
     * Get capacityUnit.
     *
     * @return string
     */
    public function getCapacityUnit()
    {
        return $this->capacityUnit;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set availablePostalCodes.
     *
     * @param string|null $availablePostalCodes
     *
     * @return Product
     */
    public function setAvailablePostalCodes($availablePostalCodes = null)
    {
        $this->availablePostalCodes = $availablePostalCodes;

        return $this;
    }

    /**
     * Get availablePostalCodes.
     *
     * @return string|null
     */
    public function getAvailablePostalCodes()
    {
        return $this->availablePostalCodes;
    }

    /**
     * Set isDisabled.
     *
     * @param bool $isDisabled
     *
     * @return Product
     */
    public function setIsDisabled($isDisabled)
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    /**
     * Get isDisabled.
     *
     * @return bool
     */
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }

    /**
     * Set userCreation
     *
     * @param \Paprec\UserBundle\Entity\User $userCreation
     *
     * @return Product
     */
    public function setUserCreation(\Paprec\UserBundle\Entity\User $userCreation)
    {
        $this->userCreation = $userCreation;

        return $this;
    }

    /**
     * Get userCreation
     *
     * @return \Paprec\UserBundle\Entity\User
     */
    public function getUserCreation()
    {
        return $this->userCreation;
    }

    /**
     * Set userUpdate
     *
     * @param \Paprec\UserBundle\Entity\User $userUpdate
     *
     * @return Product
     */
    public function setUserUpdate(\Paprec\UserBundle\Entity\User $userUpdate = null)
    {
        $this->userUpdate = $userUpdate;

        return $this;
    }

    /**
     * Get userUpdate
     *
     * @return \Paprec\UserBundle\Entity\User
     */
    public function getUserUpdate()
    {
        return $this->userUpdate;
    }

    /**
     * Add picture.
     *
     * @param \Paprec\CatalogBundle\Entity\Picture $picture
     *
     * @return Product
     */
    public function addPicture(\Paprec\CatalogBundle\Entity\Picture $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture.
     *
     * @param \Paprec\CatalogBundle\Entity\Picture $picture
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePicture(\Paprec\CatalogBundle\Entity\Picture $picture)
    {
        return $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    public function getPilotPictures()
    {
        $pilotPictures = array();
        foreach ($this->pictures as $picture) {
            if ($picture->getType() == 'PILOTPICTURE') {
                $pilotPictures[] = $picture;
            }
        }
        return $pilotPictures;
    }

    public function getPictos()
    {
        $pictos = array();
        foreach ($this->pictures as $picture) {
            if ($picture->getType() == 'PICTO') {
                $pictos[] = $picture;
            }
        }
        return $pictos;
    }

    public function getPicturesPictures()
    {
        $pictures = array();
        foreach ($this->pictures as $picture) {
            if ($picture->getType() == 'PICTURE') {
                $pictures[] = $picture;
            }
        }
        return $pictures;
    }


    /**
     * Add productLabel.
     *
     * @param \Paprec\CatalogBundle\Entity\ProductLabel $productLabel
     *
     * @return Product
     */
    public function addProductLabel(\Paprec\CatalogBundle\Entity\ProductLabel $productLabel)
    {
        $this->productLabels[] = $productLabel;

        return $this;
    }

    /**
     * Remove productLabel.
     *
     * @param \Paprec\CatalogBundle\Entity\ProductLabel $productLabel
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProductLabel(\Paprec\CatalogBundle\Entity\ProductLabel $productLabel)
    {
        return $this->productLabels->removeElement($productLabel);
    }

    /**
     * Get productLabels.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductLabels()
    {
        return $this->productLabels;
    }
    

    /**
     * Set capacity.
     *
     * @param string $capacity
     *
     * @return Product
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity.
     *
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set rentalUnitPrice.
     *
     * @param int|null $rentalUnitPrice
     *
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set position.
     *
     * @param int $position
     *
     * @return Product
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

}
