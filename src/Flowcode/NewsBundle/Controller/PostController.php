<?php

namespace Flowcode\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 * @Route("/{_locale}/post")
 */
class PostController extends Controller {

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {

        $seoPage = $this->container->get('sonata.seo.page');

        $em = $this->getDoctrine()->getManager();

        $pageNumber = $request->get("page", 1);
        $posts = $this->getDoctrine()->getRepository("AmulenNewsBundle:Post")->findAllEnabled();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $this->get('request')->query->get('page', $pageNumber), 2);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{slug}", name="post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmulenNewsBundle:Post')->findOneBy(array("slug" => $slug));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    public function lastsAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AmulenNewsBundle:Post')->findBy(array(), null, 5);

        return $this->render(
                        'FlowcodeNewsBundle:Post:lastsWidget.html.twig', array('entities' => $entities)
        );
    }

}
