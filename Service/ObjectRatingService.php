<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Service;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Tadcka\ObjectRatingBundle\Entity\ObjectRating;

class ObjectRatingService
{
    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * Constructor.
     *
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Validate by user with limit object rating.
     *
     * @param ObjectRating $objectRating
     * @param string $objectId
     * @param string $objectType
     * @param integer $count
     *
     * @return boolean
     */
    public function validateByUser(ObjectRating $objectRating, $objectId, $objectType, $count)
    {
        $where = array(
            'objectId' => $objectId,
            'objectType' => $objectType,
        );

        if ($objectRating->getUserId() !== null) {
            $where['userId'] = $objectRating->getUserId();
        } else {
            return false;
        }

        if ($count > 0) {
            $objectRatings = $this->doctrine->getRepository('TadckaObjectRatingBundle:ObjectRating')->findOneBy($where);

            if (count($objectRatings) < $count) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate by ip with limit rating.
     *
     * @param ObjectRating $objectRating
     * @param string $objectId
     * @param string $objectType
     * @param integer $count
     *
     * @return boolean
     */
    public function validateByIp(ObjectRating $objectRating, $objectId, $objectType, $count)
    {
        $where = array(
            'userIp' => $objectRating->getUserIp(),
            'objectId' => $objectId,
            'objectType' => $objectType,
        );

        if ($count > 0) {
            $objectRatings = $this->doctrine->getRepository('TadckaObjectRatingBundle:ObjectRating')->findOneBy($where);

            if (count($objectRatings) < $count) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate by user and ip with limit rating.
     *
     * @param ObjectRating $objectRating
     * @param string $objectId
     * @param string $objectType
     * @param integer $count
     *
     * @return boolean
     */
    public function validateByUserAndIp(ObjectRating $objectRating, $objectId, $objectType, $count)
    {
        $where = array(
            'userIp' => $objectRating->getUserIp(),
            'objectId' => $objectId,
            'objectType' => $objectType,
        );

        if ($objectRating->getUserId() !== null) {
            $where['userId'] = $objectRating->getUserId();
        } else {
            return false;
        }

        if ($count > 0) {
            $objectRatings = $this->doctrine->getRepository('TadckaObjectRatingBundle:ObjectRating')->findOneBy($where);

            if (count($objectRatings) < $count) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set object rating ant count.
     *
     * @param ObjectRating $objectRating
     * @param string $entityName
     *
     * @return boolean
     */
    public function setObjectRating($objectRating, $entityName)
    {
        if ($objectRating->getObjectId()) {
            $object = $this->doctrine->getRepository($entityName)->find($objectRating->getObjectId());

            if ($object !== null) {
                $object->setRating($object->getRating() + $objectRating->getRating());
                $object->setRatesCount($object->getRatesCount() + 1);
                $this->doctrine->getManager()->persist($object);

                return true;
            }
        }

        return false;
    }

    /**
     * Subscribe object rating.
     *
     * @param ObjectRating $objectRating
     * @param bool $flush
     */
    public function subscribe(ObjectRating $objectRating, $flush =true)
    {
        $om = $this->doctrine->getManager();
        $om->persist($objectRating);

        if ($flush) {
            $om->flush();
        }
    }
}
