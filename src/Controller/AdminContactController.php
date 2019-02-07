<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/admin/contacts", name="admin_contacts")
     */
    public function index(ContactRepository $repo)
    {
        return $this->render('admin/contact/index.html.twig', [
            'controller_name' => 'AdminContactController',
            'contacts' => $repo->findAll(),
        ]);
    }
}
