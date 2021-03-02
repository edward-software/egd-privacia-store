<?php

namespace Paprec\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Paprec\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, repositoryMethod="isMailUnique")
 * @UniqueEntity(fields={"username"}, repositoryMethod="isUsernameUnique")
 * @UniqueEntity(fields={"usernameCanonical"}, repositoryMethod="isUsernameCanonicalUnique")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     * @Assert\NotBlank(groups={"password"})
     * @var string
     */
    protected $plainPassword;


    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email(
     *      message = "email_error",
     *      checkMX = true
     * )
     */
    protected $email;

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
     * @ORM\Column(name="companyName", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=255, nullable=true)
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="mobileNumber", type="string", length=255, nullable=true)
     */
    private $mobileNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="jobTitle", type="string", length=255, nullable=true)
     */
    private $jobTitle;

    /**
     * #################################
     *              Relations
     * #################################
     */

    /**
     * @ORM\OneToMany(targetEntity="Paprec\CommercialBundle\Entity\QuoteRequest", mappedBy="userInCharge")
     */
    private $quoteRequests;

    /**
     * @ORM\OneToMany(targetEntity="Paprec\CatalogBundle\Entity\Agency", mappedBy="salesman")
     */
    private $salesmanAgencies;

    /**
     * @ORM\OneToMany(targetEntity="Paprec\CatalogBundle\Entity\Agency", mappedBy="assistant")
     */
    private $assistantAgencies;

    public function __construct()
    {
        parent::__construct();

        $this->dateCreation = new \DateTime();
        $this->products = new ArrayCollection();
        $this->assistantAgencies = new ArrayCollection();
        $this->salesmanAgencies = new ArrayCollection();
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
     * Set companyName.
     *
     * @param string|null $companyName
     *
     * @return User
     */
    public function setCompanyName($companyName = null)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName.
     *
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return User
     */
    public function setLastName($lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return User
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Fonction manuelle pour afficher Prénom + Nom dans un tableau Goondi
     */
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->getLastName();
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * Add product.
     *
     * @param \Paprec\CatalogBundle\Entity\Product $product
     *
     * @return User
     */
    public function addProduct(\Paprec\CatalogBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product.
     *
     * @param \Paprec\CatalogBundle\Entity\product $product
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProduct(\Paprec\CatalogBundle\Entity\product $product)
    {
        return $this->products->removeElement($product);
    }

    /**
     * Add quoteRequest.
     *
     * @param \Paprec\CommercialBundle\Entity\QuoteRequest $quoteRequest
     *
     * @return User
     */
    public function addQuoteRequest(\Paprec\CommercialBundle\Entity\QuoteRequest $quoteRequest)
    {
        $this->quoteRequests[] = $quoteRequest;

        return $this;
    }

    /**
     * Remove quoteRequest.
     *
     * @param \Paprec\CommercialBundle\Entity\QuoteRequest $quoteRequest
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeQuoteRequest(\Paprec\CommercialBundle\Entity\QuoteRequest $quoteRequest)
    {
        return $this->quoteRequests->removeElement($quoteRequest);
    }

    /**
     * Get quoteRequests.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuoteRequests()
    {
        return $this->quoteRequests;
    }


    /**
     * Add salesmanAgency.
     *
     * @param \Paprec\CatalogBundle\Entity\Agency $agency
     *
     * @return User
     */
    public function addSalesmanAgency(\Paprec\CatalogBundle\Entity\Agency $agency)
    {
        $this->salesmanAgencies[] = $agency;

        return $this;
    }

    /**
     * Remove salesmanAgency.
     *
     * @param \Paprec\CatalogBundle\Entity\Agency $agency
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSalesmanAgency(\Paprec\CatalogBundle\Entity\Agency $agency)
    {
        return $this->salesmanAgencies->removeElement($agency);
    }

    /**
     * Get salesmanAgencies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSalesmanAgencies()
    {
        return $this->salesmanAgencies;
    }

    /**
     * Add assistantAgency.
     *
     * @param \Paprec\CatalogBundle\Entity\Agency $agency
     *
     * @return User
     */
    public function addAssistantAgency(\Paprec\CatalogBundle\Entity\Agency $agency)
    {
        $this->assistantAgencies[] = $agency;

        return $this;
    }

    /**
     * Remove assistantAgency.
     *
     * @param \Paprec\CatalogBundle\Entity\Agency $agency
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removAssistantAgency(\Paprec\CatalogBundle\Entity\Agency $agency)
    {
        return $this->assistantAgencies->removeElement($agency);
    }

    /**
     * Get assistantAgencies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssistantAgencies()
    {
        return $this->assistantAgencies;
    }

    /**
     * Set lang.
     *
     * @param string|null $lang
     *
     * @return User
     */
    public function setLang($lang = null)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang.
     *
     * @return string|null
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @param string $jobTitle
     * @return User
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param string $mobileNumber
     * @return User
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

}
