<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Form\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Tadcka\ObjectRatingBundle\Entity\ObjectRating;
use Tadcka\ObjectRatingBundle\Event\ObjectRatingEvent;

class ObjectRatingFormHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(Request $request, EventDispatcherInterface $dispatcher)
    {
        $this->request = $request;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Process.
     *
     * @param FormInterface $form
     *
     * @return boolean
     */
    public function process(FormInterface $form)
    {
        if ($this->request->isMethod('POST')) {
            $form->bind($this->request);
            if ($form->isValid()) {
                /** @var ObjectRating $objectRating */
                $objectRating = $form->getData();
                $objectRating->setUserIp($this->request->getClientIp());

                $event = new ObjectRatingEvent($objectRating);
                $this->dispatcher->dispatch('tadcka_object_rating.event.' . $objectRating->getObjectType(), $event);

                return true;
            }
        }

        return false;
    }
}
