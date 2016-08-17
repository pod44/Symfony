<?php

namespace UsersBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UsersBundle\Entity\Comments;
use UsersBundle\Form\CommentsType;

/**
 * Comments controller.
 *
 * @Route("/comments")
 */
class CommentsController extends Controller
{
    /**
     * Lists all Comments entities.
     *
     * @Route("/", name="comments_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('UsersBundle:Comments')->findAll();

        return $this->render('comments/index.html.twig', array(
            'comments' => $comments,
        ));
    }

    /**
     * Creates a new Comments entity.
     *
     * @Route("/new", name="comments_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $comment = new Comments();
        $form = $this->createForm('UsersBundle\Form\CommentsType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comments_show', array('id' => $comment->getId()));
        }

        return $this->render('comments/new.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comments entity.
     *
     * @Route("/{id}", name="comments_show")
     * @Method("GET")
     */
    public function showAction(Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comments/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comments entity.
     *
     * @Route("/{id}/edit", name="comments_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('UsersBundle\Form\CommentsType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comments_edit', array('id' => $comment->getId()));
        }

        return $this->render('comments/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comments entity.
     *
     * @Route("/{id}", name="comments_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comments $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comments_index');
    }

    /**
     * Creates a form to delete a Comments entity.
     *
     * @param Comments $comment The Comments entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comments $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comments_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
