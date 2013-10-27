<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Twig;

class ObjectRatingExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'tadcka_format_object_rating_number' => new \Twig_Function_Method($this, 'formatObjectRatingNumber', array()),
        );
    }

    public function formatObjectRatingNumber($number)
    {
        if ($number > 5) {
            return 5;
        }

        $whole = floor($number);
        $fraction = $number - $whole;

        if ($fraction == 0) {
            return $whole;
        } else if ($fraction < 0.5 && $fraction > 0) {
            return $whole + 0.5;
        }

        return $whole + 1;
    }

    public function getName()
    {
        return "tadcka_object_rating";
    }
}
