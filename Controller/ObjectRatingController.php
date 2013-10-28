<?php

/*
 * This file is part of the Tadcka object rating package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tadcka\ObjectRatingBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Tadcka\ObjectRatingBundle\Entity\ObjectRating;
use Tadcka\ObjectRatingBundle\Event\ObjectRatingEvent;
use Tadcka\ObjectRatingBundle\Form\Type\ObjectRatingFormType;

class ObjectRatingController extends ContainerAware
{
    /**
     * Get a user from the Security Context.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     */
    private function getUser()
    {
        if (!$this->container->has('security.context')) {
            return null;
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

    public function indexAction($objectType, $objectId)
    {
        $objectRating = new ObjectRating();
        $form = $this->container->get('form.factory')->create(new ObjectRatingFormType(), $objectRating, array());
        $request = $this->container->get('request');

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $objectRating->setUserId($this->getUser() !== null ? $this->getUser()->getId() : null);
                $objectRating->setObjectType($objectType);
                $objectRating->setObjectId($objectId);
                $objectRating->setUserIp($request->getClientIp());

                $dispatcher = $this->container->get('event_dispatcher');
                $event = new ObjectRatingEvent($objectRating);
                $dispatcher->dispatch('tadcka_object_rating.event.' . $objectType, $event);

                return new Response();
            }
        }

        return $this->container->get('templating')->renderResponse(
            'TadckaObjectRatingBundle::object_rating.html.twig',
            array(
                'form' => $form->createView(),
                'objectType' => $objectType,
                'objectId' => $objectId,
            ),
            null
        );
    }
}
