<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MarketplaceController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('marketplace/index.html.twig', [
            'controller_name' => 'MarketplaceController',
        ]);
    }

    /**
     * @Route("/annonces", name="annonces")
     */
    public function annonces()
    {
        return $this->render('marketplace/annonces.html.twig', [
            'controller_name' => 'MarketplaceController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('marketplace/admin.html.twig', [
            'controller_name' => 'MarketplaceController',
        ]);
    }

    /**
     * @Route("/membre", name="membre")
     */
    public function membre()
    {
        return $this->render('marketplace/membre.html.twig', [
            'controller_name' => 'MarketplaceController',
        ]);
    }

}
