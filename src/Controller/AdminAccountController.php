<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * Permet de se connecter
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {


        // Récupère le dernier nom d'utilisateur saisie
        $username = $utils->getLastUsername();
        // Récupère l'erreur de la dernière authentification
        $error = $utils->getLastAuthenticationError();
        //dump($error);
        //dump($username);

        return $this->render('admin/account/login.html.twig', [
            'controller_name' => 'AdminAccountController',
            'hasError' => $error !== null,
            //'hasError' => $error,
            'Username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * @Route("/admin/logout", name="admin_account_logout")
     * 
     * @return void
     */
    public function logout()
    {

    }
}
