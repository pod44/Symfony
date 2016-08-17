<?php

namespace UsersBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UsersBundle\Entity\Subjects;
use UsersBundle\Form\SubjectsType;

/**
 * Subjects controller.
 *
 * @Route("/subjects")
 */
class SubjectsController extends Controller
{
    /**
     * Lists all Subjects entities.
     *
     * @Route("/", name="subjects_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subjects = $em->getRepository('UsersBundle:Subjects')->findAll();

        return $this->render('subjects/index.html.twig', array(
            'subjects' => $subjects,
        ));
    }

    /**
     * Creates a new Subjects entity.
     *
     * @Route("/new", name="subjects_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $subject = new Subjects();
        $form = $this->createForm('UsersBundle\Form\SubjectsType', $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subjects_show', array('id' => $subject->getId()));
        }

        return $this->render('subjects/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Subjects entity.
     *
     * @Route("/{id}", name="subjects_show")
     * @Method("GET")
     */
    public function showAction(Subjects $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);

        return $this->render('subjects/show.html.twig', array(
            'subject' => $subject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Subjects entity.
     *
     * @Route("/{id}/edit", name="subjects_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Subjects $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);
        $editForm = $this->createForm('UsersBundle\Form\SubjectsType', $subject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subjects_edit', array('id' => $subject->getId()));
        }

        return $this->render('subjects/edit.html.twig', array(
            'subject' => $subject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Subjects entity.
     *
     * @Route("/{id}", name="subjects_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Subjects $subject)
    {
        $form = $this->createDeleteForm($subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();
        }

        return $this->redirectToRoute('subjects_index');
    }

    /**
     * Creates a form to delete a Subjects entity.
     *
     * @param Subjects $subject The Subjects entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subjects $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subjects_delete', array('id' => $subject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
