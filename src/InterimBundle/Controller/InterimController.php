<?php

namespace InterimBundle\Controller;

use InterimBundle\Entity\Interim;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Interim controller.
 *
 * @Route("interim")
 */
class InterimController extends Controller
{
    /**
     * Lists all interim entities.
     *
     * @Route("/", name="interim_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interims = $em->getRepository('InterimBundle:Interim')->findAll();

        return $this->render('@Interim/interim/index.html.twig', array(
            'interims' => $interims,
        ));
    }

    /**
     * Creates a new interim entity.
     *
     * @Route("/new", name="interim_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $interim = new Interim();
        $form = $this->createForm('InterimBundle\Form\InterimType', $interim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interim);
            $em->flush();

            return $this->redirectToRoute('interim_show', array('id' => $interim->getId()));
        }

        return $this->render('@Interim/interim/new.html.twig', array(
            'interim' => $interim,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a interim entity.
     *
     * @Route("/{id}", name="interim_show")
     * @Method("GET")
     */
    public function showAction(Interim $interim)
    {
        $deleteForm = $this->createDeleteForm($interim);
        $note = $this->get('interimManager')->getNoteByInterim($interim);

        return $this->render('@Interim/interim/show.html.twig', array(
            'interim' => $interim,
            'delete_form' => $deleteForm->createView(),
            'note'  => $note
        ));
    }

    /**
     * Displays a form to edit an existing interim entity.
     *
     * @Route("/{id}/edit", name="interim_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Interim $interim)
    {
        $deleteForm = $this->createDeleteForm($interim);
        $editForm = $this->createForm('InterimBundle\Form\InterimType', $interim);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('interim_edit', array('id' => $interim->getId()));
        }

        return $this->render('@Interim/interim/edit.html.twig', array(
            'interim' => $interim,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a interim entity.
     *
     * @Route("/{id}", name="interim_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Interim $interim)
    {
        $form = $this->createDeleteForm($interim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($interim);
            $em->flush();
        }

        return $this->redirectToRoute('interim_index');
    }

    /**
     * Creates a form to delete a interim entity.
     *
     * @param Interim $interim The interim entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Interim $interim)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interim_delete', array('id' => $interim->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
