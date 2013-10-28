<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle;

class ObjectRatingInfo
{
    /**
     * @var float
     */
    private $objectRating;

    /**
     * @var int
     */
    private $objectRatesCount;

    /**
     * Constructor.
     *
     * @param float $objectRating
     * @param int $objectRatesCount
     */
    public function __construct($objectRating, $objectRatesCount)
    {
        $this->objectRating = $objectRating;
        $this->objectRatesCount = $objectRatesCount;
    }

    /**
     * Set objectRatesCount.
     *
     * @param int $objectRatesCount
     *
     * @return ObjectRatingInfo
     */
    public function setObjectRatesCount($objectRatesCount)
    {
        $this->objectRatesCount = $objectRatesCount;

        return $this;
    }

    /**
     * Get objectRatesCount.
     *
     * @return int
     */
    public function getObjectRatesCount()
    {
        return $this->objectRatesCount;
    }

    /**
     * Set objectRating.
     *
     * @param float $objectRating
     *
     * @return ObjectRatingInfo
     */
    public function setObjectRating($objectRating)
    {
        $this->objectRating = $objectRating;

        return $this;
    }

    /**
     * Get objectRating.
     *
     * @return float
     */
    public function getObjectRating()
    {
        return $this->objectRating;
    }

    /**
     * Check or object rating is not empty/
     *
     * @return bool
     */
    public function isEmpty()
    {
        if ($this->getObjectRating() && $this->getObjectRatesCount()) {
            return false;
        }

        return true;
    }
}
