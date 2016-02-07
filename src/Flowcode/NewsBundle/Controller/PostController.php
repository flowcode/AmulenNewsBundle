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
class PostController extends Controller
{

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/tags-with-weight", name="post_tags_weight")
     * @Method("GET")
     */
    public function getTagsWithWeightAction()
    {

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
    public function indexAction(Request $request, $parameterBag = null)
    {

        $em = $this->getDoctrine()->getManager();

        $pageNumber = $request->get("page", 1);
        $filters = array();
        if ($parameterBag && isset($parameterBag["page"])) {
            $pageNumber = $parameterBag["page"];
        }

        $tag = null;
        if ($parameterBag && isset($parameterBag["tag"])) {
            $filters['tag'] = $parameterBag["tag"];
            $tag = $filters['tag'];
        }

        $qb = $this->getDoctrine()->getRepository("AmulenNewsBundle:Post")->findPublishedQueryBuilder($filters);
        $posts = $qb;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $pageNumber, 10);

        return array(
            'tag' => $tag,
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
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmulenNewsBundle:Post')->findOneBy(array("slug" => $slug));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $seoPage = $this->container->get('sonata.seo.page');

        $pageTitle = $entity->getTitle() . " - " . $seoPage->getTitle();
        $pageDescription = $entity->getAbstract();

        $baseUrl = $this->container->getParameter('router.request_context.scheme') . "://";
        $baseUrl .= $this->container->getParameter('router.request_context.host');
        $baseUrl .= $this->container->getParameter('router.request_context.base_url');

        $seoPage
            ->setTitle($pageTitle)
            ->addMeta('name', 'description', $pageDescription)
            ->addMeta('property', 'og:title', $entity->getTitle())
            ->addMeta('property', 'og:description', $pageDescription)
            ->addMeta('property', 'og:image', $baseUrl . $entity->getImage())
        ;

        return array(
            'entity' => $entity,
        );
    }

    public function lastsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AmulenNewsBundle:Post')->findPublished(null, 5);

        return $this->render(
            'FlowcodeNewsBundle:Post:lastsWidget.html.twig', array('entities' => $entities)
        );
    }


}
