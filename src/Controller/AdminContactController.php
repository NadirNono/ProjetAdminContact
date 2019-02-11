<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contact")
 */
class AdminContactController extends AbstractController
{
    /**
     * @Route("/", name="admin_contact", methods={"GET"})
     */
    public function index(ContactRepository $repo) : Response
    {
        return $this->render('admin/contact/index.html.twig', [
            // LA LIGNE CI-DESSOUS EST SYMPA MAIS PAS REALISTE
            // CETTE LIGNE EST DONNEE PAR DEFAUT LORS DU CRUD
            'controller_name' => 'AdminContactController',
            'contacts' => $repo->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="admin_contact_new", methods={"GET","POST"})
     */
    public function new(Request $request) : Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On on récupère la date du jour de la création du contact en php
            $contact->setDateContact(new \DateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('admin_contact');
        }

        return $this->render('admin/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_contact_show", methods={"GET"})
     */
    public function show(Contact $contact) : Response
    {
        return $this->render('admin/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact) : Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_contact', [
                'id' => $contact->getId(),
            ]);
        }

        return $this->render('admin/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_contact');
    }
}
