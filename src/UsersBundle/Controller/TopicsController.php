<?php

namespace UsersBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UsersBundle\Entity\Topics;
use UsersBundle\Form\TopicsType;

/**
 * Topics controller.
 *
 * @Route("/topics")
 */
class TopicsController extends Controller
{
    /**
     * Lists all Topics entities.
     *
     * @Route("/", name="topics_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('UsersBundle:Topics')->findAll();

        return $this->render('topics/index.html.twig', array(
            'topics' => $topics,
        ));
    }

    /**
     * Creates a new Topics entity.
     *
     * @Route("/new", name="topics_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $topic = new Topics();
        $form = $this->createForm('UsersBundle\Form\TopicsType', $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('topics_show', array('id' => $topic->getId()));
        }

        return $this->render('topics/new.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Topics entity.
     *
     * @Route("/{id}", name="topics_show")
     * @Method("GET")
     */
    public function showAction(Topics $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);

        return $this->render('topics/show.html.twig', array(
            'topic' => $topic,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Topics entity.
     *
     * @Route("/{id}/edit", name="topics_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Topics $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        $editForm = $this->createForm('UsersBundle\Form\TopicsType', $topic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('topics_edit', array('id' => $topic->getId()));
        }

        return $this->render('topics/edit.html.twig', array(
            'topic' => $topic,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Topics entity.
     *
     * @Route("/{id}", name="topics_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Topics $topic)
    {
        $form = $this->createDeleteForm($topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($topic);
            $em->flush();
        }

        return $this->redirectToRoute('topics_index');
    }

    /**
     * Creates a form to delete a Topics entity.
     *
     * @param Topics $topic The Topics entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Topics $topic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('topics_delete', array('id' => $topic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
