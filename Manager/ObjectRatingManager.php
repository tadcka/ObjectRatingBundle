<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Manager;


use Symfony\Bridge\Doctrine\RegistryInterface;
use Tadcka\ObjectRatingBundle\ObjectRatingInfo;

class ObjectRatingManager
{
    /**
     * @var RegistryInterface
     */
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Get object rating info.
     *
     * @param string $objectType
     * @param int $objectId
     *
     * @return ObjectRatingInfo
     */
    public function getObjectRatingInfo($objectType, $objectId)
    {
        $result = $this->doctrine->getRepository('TadckaObjectRatingBundle:ObjectRating')
            ->getObjectRatings($objectType, $objectId);

        $count = count($result);
        $rating = 0;
        foreach ($result as $row) {
            if (isset($row['rating'])) {
                $rating += $row['rating'];
            }
        }

        $rating = $count === 0 ? 0 : $rating / $count;
        $objectRatingInfo = new ObjectRatingInfo($rating, $count);

        return $objectRatingInfo;
    }

    /**
     * Get objects ratings.
     *
     * @param string $objectType
     * @param array $objectsId
     *
     * @return array
     */
    public function getObjectsRatingInfo($objectType, array $objectsId)
    {
        $result = $this->doctrine->getRepository('TadckaObjectRatingBundle:ObjectRating')
            ->getObjectsRatings($objectType, $objectsId);

        $data = array();
        foreach ($result as $row) {
            if (isset($row['objectId']) && isset($row['rating'])) {
                $data[$row['objectId']][] = $row['rating'];
            }
        }

        $objectsRatingInfo = array();
        foreach ($objectsId as $id) {
            $count = 0;
            $rating = 0;
            if (isset($data[$id])) {
                $count = count($data[$id]);
                foreach ($data[$id]  as $value) {
                    $rating += $value;
                }
            }
            $rating = $count === 0 ? 0 : $rating / $count;
            $objectsRatingInfo[$id] = new ObjectRatingInfo($rating, $count);
        }

        return $objectsRatingInfo;
    }
}