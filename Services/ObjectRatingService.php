<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Services;

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
     * @param string $userId
     * @param int $objectId
     * @param string $objectType
     * @param int $count
     *
     * @return boolean
     */
    public function validateByUser($userId, $objectId, $objectType, $count)
    {
        $where = array(
            'objectId' => $objectId,
            'objectType' => $objectType,
        );

        if ($userId !== null) {
            $where['userId'] = $userId;
        } else {
            return false;
        }

        return $this->validate($where, $count);
    }

    /**
     * Validate by ip with limit rating.
     *
     * @param string $userIp
     * @param int $objectId
     * @param string $objectType
     * @param int $count
     *
     * @return bool
     */
    public function validateByIp($userIp, $objectId, $objectType, $count)
    {
        $where = array(
            'userIp' => $userIp,
            'objectId' => $objectId,
            'objectType' => $objectType,
        );

        return $this->validate($where, $count);
    }

    /**
     * Validate by user and ip with limit rating.
     *
     * @param string $userId
     * @param string $userIp
     * @param int $objectId
     * @param string $objectType
     * @param int $count
     *
     * @return bool
     */
    public function validateByUserAndIp($userId, $userIp, $objectId, $objectType, $count)
    {
        $where = array(
            'userIp' => $userIp,
            'objectId' => $objectId,
            'objectType' => $objectType,
        );

        if ($userId !== null) {
            $where['userId'] = $userId;
        } else {
            return false;
        }

        return $this->validate($where, $count);
    }

    /**
     * Validate.
     *
     * @param array $where
     * @param int $count
     *
     * @return bool
     */
    private function validate(array $where, $count)
    {
        if ($count > 0) {
            $objectRatings = $this->doctrine->getRepository('TadckaObjectRatingBundle:ObjectRating')->findBy($where);

            if (count($objectRatings) < $count) {
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
