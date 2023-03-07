<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FrontClubController extends AbstractController
{
    /**
     * @Route("front/clubs", name="front_clubs")
     */
    public function Clubs(ClubRepository $clubRepository)
    {
        $clubs = $clubRepository->findAll();
        return $this->render('front/clubs.html.twig', [
            'clubs' => $clubs
        ]);
    }
    /**
     * @Route("front/club/create", name="front_club_create")
     */
    public function frontCreateClub(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $club = new Club();
        $clubForm = $this->createForm(ClubType::class, $club);
        $clubForm->handleRequest($request);

        if ($clubForm->isSubmitted() && $clubForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $clubForm->get('coverFilename')->getData();

            if ($coverFile) {
                // 2 recupérer le nom du fichiers uploadé
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // 3 renommer le fichier avec un nom unique
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();

                // 4 déplacer le fichier dans le dossier publique
                $coverFile->move(
                    $this->getParameter( 'cover_directory'),
                    $newFilename
                );

                // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                    $club->setCoverFilename($newFilename);
            }

            $entityManager->persist($club);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le club existe déja ou... !");
        $this->addFlash('success', "Le Club a bien été créer !");

        return $this->render('front/front_club_create.html.twig',[
            'clubForm' => $clubForm->createView()
        ]);
    }
    /**
     * @Route("front/club/update/{id}", name="front_club_update")
     */
    public function frontUpdateClub($id, Request $request, ClubRepository $clubRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $club = $clubRepository->find($id);

        $clubForm = $this->createForm(ClubType::class, $club);
        $clubForm->handleRequest($request);

        if ($clubForm->isSubmitted() && $clubForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $clubForm->get('coverFilename')->getData();

            if ($coverFile) {
                // 2 recupérer le nom du fichiers uploadé
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // 3 renommer le fichier avec un nom unique
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $coverFile->guessExtension();

                // 4 déplacer le fichier dans le dossier publique
                $coverFile->move(
                    $this->getParameter('cover_directory'),
                    $newFilename
                );

                // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                $club->setCoverFilename($newFilename);
            }

            $entityManager->persist($club);
            $entityManager->flush();

        }
        // $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le Club a bien été modifié !");

        return $this->render('front/front_club_update.html.twig',[
            'clubForm' => $clubForm->createView()
        ]);
    }
    /**
     * @Route("front/club/{id}", name="front_club")
     */
    public function Club($id, ClubRepository $clubRepository)
    {
        $club = $clubRepository->find($id);

        // si le club n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($club)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'club' => $club
            ]);
        }

        $club = $clubRepository->find($id);
        return $this->render('front/club.html.twig', [
            'club' => $club
        ]);
    }
    /**
     * @Route("front/clubs/search", name="front_search_clubs")
     */
    public function SearchClubs(ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);

        return $this->render('front/clubs_search.html.twig', [
            'clubs' => $clubs,
        ]);
    }
}