<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function annonces(AnnonceRepository $annonceRepository): Response
    {
        // ICI ON VEUT AFFICHER LA LISTE DES ANNONCES
        // => SCENARIO CRUD : READ LISTE

        return $this->render('marketplace/annonces.html.twig', [
            // ON TRANSMET DE PHP A TWIG LA LISTE DES ANNONCES
            // DANS LA VARIABLE TWIG annonces
            // => INJECTION DE DEPENDANCES ENTRE PHP ET TWIG
            'annonces' => $annonceRepository->findBy([], [ "datePublication" => "DESC" ]),
            // COMPTER TOUTES LES LIGNES DANS LA TABLE SQL annonce
            'annoncesTotal' => $annonceRepository->count([]),
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
