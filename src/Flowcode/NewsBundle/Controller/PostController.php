<?php

namespace Flowcode\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Post controller.
 *
 * @Route("/{_locale}/post")
 */
class PostController extends Controller {

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/tags-with-weight", name="post_tags_weight")
     * @Method("GET")
     */
    public function getTagsWithWeightAction(){

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AmulenClassificationBundle:Tag')->getWithWeight();

        $tagArr = array();
        foreach ($entities as $tag) {
            $tagArr[] = array(
                "text" => $tag["name"],
                "weight" => $tag["weight"],
                "link" => $this->generateUrl("page", array("slug" => "news", "tag" => $tag["name"])),
            );
        }

        return new JsonResponse($tagArr, 200);
    }


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
        $pagination = $paginator->paginate($posts, $this->get('request')->query->get('page', $pageNumber), 10);

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
