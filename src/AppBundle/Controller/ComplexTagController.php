<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ComplexTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Complextag controller.
 *
 */
class ComplexTagController extends Controller
{
    /**
     * Lists all complexTag entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $complexTags = $em->getRepository('AppBundle:ComplexTag')->findAll();

        return $this->render('complextag/index.html.twig', array(
            'complexTags' => $complexTags,
        ));
    }

    /**
     * Creates a new complexTag entity.
     *
     */
    public function newAction(Request $request)
    {
        $complexTag = new Complextag();
        $form = $this->createForm('AppBundle\Form\Type\ComplexTagType', $complexTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($complexTag);
            $em->flush($complexTag);

            return $this->redirectToRoute('admin_complextag_show', array('id' => $complexTag->getId()));
        }

        return $this->render('complextag/new.html.twig', array(
            'complexTag' => $complexTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a complexTag entity.
     *
     */
    public function showAction(ComplexTag $complexTag)
    {
        $deleteForm = $this->createDeleteForm($complexTag);

        return $this->render('complextag/show.html.twig', array(
            'complexTag' => $complexTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing complexTag entity.
     *
     */
    public function editAction(Request $request, ComplexTag $complexTag)
    {
        $deleteForm = $this->createDeleteForm($complexTag);
        $editForm = $this->createForm('AppBundle\Form\Type\ComplexTagType', $complexTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_complextag_edit', array('id' => $complexTag->getId()));
        }

        return $this->render('complextag/edit.html.twig', array(
            'complexTag' => $complexTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a complexTag entity.
     *
     */
    public function deleteAction(Request $request, ComplexTag $complexTag)
    {
        $form = $this->createDeleteForm($complexTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($complexTag);
            $em->flush($complexTag);
        }

        return $this->redirectToRoute('admin_complextag_index');
    }

    /**
     * Creates a form to delete a complexTag entity.
     *
     * @param ComplexTag $complexTag The complexTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ComplexTag $complexTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_complextag_delete', array('id' => $complexTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
