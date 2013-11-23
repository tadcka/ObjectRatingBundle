<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectRatingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', new StarRatingFormType(), array(
            'label_attr' => array(
                'class' => 'label_form'
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tadcka\ObjectRatingBundle\Entity\ObjectRating',
        ));
    }

    public function getName()
    {
        return "tadcka_object_rating";
    }
}
