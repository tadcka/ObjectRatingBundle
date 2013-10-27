<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tadcka\ObjectRatingBundle\Entity\ObjectRating;

class ObjectRatingEvent extends Event
{
    /**
     * @var ObjectRating
     */
    protected $objectRating;

    public function __construct(ObjectRating $objectRating)
    {
        $this->objectRating = $objectRating;
    }

    /**
     * Get objectRating.
     *
     * @return ObjectRating
     */
    public function getObjectRating()
    {
        return $this->objectRating;
    }
}
