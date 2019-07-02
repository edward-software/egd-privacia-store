<?php
/**
 * Created by PhpStorm.
 * User: frede
 * Date: 30/11/2018
 * Time: 16:42
 */

namespace Paprec\CatalogBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Paprec\CatalogBundle\Entity\PostalCode;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostalCodeManager
{

    private $em;
    private $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function get($postalCode)
    {
        $id = $postalCode;
        if ($postalCode instanceof PostalCode) {
            $id = $postalCode->getId();
        }
        try {

            $postalCode = $this->em->getRepository('PaprecCatalogBundle:PostalCode')->find($id);

            if ($postalCode === null || $this->isDeleted($postalCode)) {
                throw new EntityNotFoundException('postalCodeNotFound');
            }

            return $postalCode;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Vérification qu'à ce jour le postalCode  n'est pas supprimé
     *
     * @param PostalCode $postalCode
     * @param bool $throwException
     * @return bool
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function isDeleted(PostalCode $postalCode, $throwException = false)
    {
        $now = new \DateTime();

        if ($postalCode->getDeleted() !== null && $postalCode->getDeleted() instanceof \DateTime && $postalCode->getDeleted() < $now) {

            if ($throwException) {
                throw new EntityNotFoundException('postalCodeNotFound');
            }
            return true;
        }
        return false;
    }
}
