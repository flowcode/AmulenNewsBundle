<?php

namespace Flowcode\NewsBundle\Controller;

use Amulen\ClassificationBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("/admin/news/category")
 */
class AdminCategoryController extends Controller {

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_news_category")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $rootName = $this->container->getParameter('flowcode_news.root_category');
        $root = $em->getRepository('AmulenClassificationBundle:Category')->findOneBy(array("name" => $rootName));
        $entities = $em->getRepository('AmulenClassificationBundle:Category')->getChildren($root);

        return array(
            'entities' => $entities,
            'rootcategory' => $root,
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/", name="admin_news_category_create")
     * @Method("POST")
     * @Template("FlowcodeNewsBundle:Category:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_news_category_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Category $entity) {
        $form = $this->createForm($this->get("amulen.classification.form.category"), $entity, array(
            'action' => $this->generateUrl('admin_news_category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new/{parent_id}", name="admin_news_category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($parent_id) {
        $em = $this->getDoctrine()->getManager();

        $parent = $em->getRepository('AmulenClassificationBundle:Category')->findOneBy(array("id" => $parent_id));

        $entity = new Category();
        $entity->setParent($parent);

        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Select parent.
     *
     * @Route("/childrens/{id}", name="admin_news_category_children")
     * @Method("GET")
     * @Template()
     */
    public function childrensAction($id) {
        $em = $this->getDoctrine()->getManager();

        $parent = $em->getRepository('AmulenClassificationBundle:Category')->findOneBy(array("id" => $id));
        $childrens = $em->getRepository('AmulenClassificationBundle:Category')->getChildren($parent, true);

        return array(
            'entities' => $childrens,
            'parent' => $parent,
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="admin_news_category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmulenClassificationBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_news_category_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmulenClassificationBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm(Category $entity) {
        $form = $this->createForm($this->get("amulen.classification.form.category"), $entity, array(
            'action' => $this->generateUrl('admin_news_category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="admin_news_category_update")
     * @Method("PUT")
     * @Template("FlowcodeNewsBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmulenClassificationBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_news_category_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="admin_news_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmulenClassificationBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_news_category'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_news_category_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete',
                            'attr' => array(
                                    'onclick' => 'return confirm("Estás seguro?")'
                            )))
                        ->getForm()
        ;
    }

}
