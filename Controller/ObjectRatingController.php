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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tadcka\ObjectRatingBundle\Entity\ObjectRating;
use Tadcka\ObjectRatingBundle\Form\Type\ObjectRatingFormType;
use Tadcka\ObjectRatingBundle\Form\Handler\ObjectRatingFormHandler;

class ObjectRatingController extends ContainerAware
{
    /**
     * Get a user id from the Security Context.
     *
     * @return null|int
     */
    private function getUserId()
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

        return $user->getId();
    }

    public function indexAction(Request $request, $objectType, $objectId)
    {
        $formHandler = new ObjectRatingFormHandler($request, $this->container->get('event_dispatcher'));
        $objectRating = new ObjectRating($objectType, $objectId, $this->getUserId());
        $form = $this->container->get('form.factory')->create(new ObjectRatingFormType(), $objectRating, array());
        if (true === $formHandler->process($form)) {
            return new Response();
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
