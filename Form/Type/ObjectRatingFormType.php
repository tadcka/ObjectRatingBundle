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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;

class ObjectRatingFormType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = $options['configs'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'number' => 5,
            "label" => "rating",
            'configs' => array(
                "object_rating_class" => "object_rating",
            ),
            'expanded' => true,
            'choices' => function (Options $options) {
                $choices = array();
                for ($i = 1; $i <= $options['number']; $i++) {
                    $choices[$i] = null;
                }
                return $choices;
            },
            "translation_domain" => "TadckaObjectRatingBundle",
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return "tadcka_object_rating";
    }
}