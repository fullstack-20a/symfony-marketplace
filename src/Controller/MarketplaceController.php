<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceMembreType;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/membre", name="membre", methods={"GET","POST"})
     */
    public function membre(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceMembreType::class, $annonce);
        $form->handleRequest($request);

        $messageConfirmation = "VALEUR PAR DEFAUT FOURNIE PAR PHP";
        if ($form->isSubmitted() && $form->isValid()) {
            // COMPLETER LES INFOS MANQUANTES
            // AJOUTER L'AUTEUR GRACE A L'UTILISATEUR CONNECTE
            $userConnecte = $this->getUser();
            $annonce->setUser($userConnecte);

            // https://www.php.net/manual/fr/class.datetime.php
            $dateActuelle = new \DateTime();                // PAS DE NAMESPACE => \
            $annonce->setDatePublication($dateActuelle);

            // DEBUG: VA AFFICHER LES INFOS SUR LA VARIABLE DANS LA CONSOLE SYMFONY
            dump($annonce);

            $photoFile = $form->get('photo')->getData();
            dump($photoFile);
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension        = $photoFile->guessExtension();

                // A TERME: IL FAUDRA CHANGER LE NOM...
                $newFilename = "$originalFilename.$extension"; // TEMPORAIRE: A AMELIORER...

                // ON DEPLACE LE FICHIER
                $photoFile->move(
                    $this->getParameter('upload_directory'),    
                            // CHEMIN DU DOSSIER QUI STOCKE LES IMAGES UPLOADEES
                            // A CONFIGURER DANS config/services.yaml
                    $newFilename
                );

                // ON CHANGE LE CHEMIN DU FICHIER 
                // POUR POUVOIR STOCKER LE BON CHEMIN DANS SQL
                $annonce->setPhoto($newFilename);

            }
            
            // AJOUT DANS LA BASE DE DONNEES
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            $messageConfirmation = "BRAVO TON ANNONCE EST MAINTENANT PUBLIEE";

            // return $this->redirectToRoute('membre');
        }
        else
        {
            // ...
        }

        return $this->render('marketplace/membre.html.twig', [
            'messageConfirmation'   => $messageConfirmation,
            'annonce'               => $annonce,
            'form'                  => $form->createView(),
        ]);
    }

}
