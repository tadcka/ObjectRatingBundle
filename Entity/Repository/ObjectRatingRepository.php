<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ObjectRatingRepository extends EntityRepository
{
    /**
     * Get object ratings.
     *
     * @param string $objectType
     * @param integer $objectId
     * @param bool $status
     *
     * @return array
     */
    public function getObjectRatings($objectType, $objectId, $status = true)
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.objectType = :objectType')
            ->setParameter('objectType', $objectType)
            ->andWhere('r.objectId = :objectId')
            ->setParameter('objectId', $objectId)
            ->select('r.rating');

        if ($status !== null) {
            $query->andWhere('r.status = :status')
                ->setParameter('status', $status);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Get objects ratings.
     *
     * @param string $objectType
     * @param array $objectsId
     * @param bool $status
     *
     * @return array
     */
    public function getObjectsRatings($objectType, array $objectsId, $status = true)
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.objectType = :objectType')
            ->setParameter('objectType', $objectType)
            ->andWhere('r.objectId IN (:objectsId)')
            ->setParameter('objectsId', $objectsId)
            ->select('r.rating, r.objectId');

        if ($status !== null) {
            $query->andWhere('r.status = :status')
                ->setParameter('status', $status);
        }

        return $query->getQuery()->getResult();
    }
}
