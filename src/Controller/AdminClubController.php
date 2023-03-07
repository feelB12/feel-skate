<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class  AdminClubController extends AbstractController
{
     /**
     * @Route("admin/clubs", name="admin_clubs")
     */
    public function adminClubs(ClubRepository $clubRepository)
    {
        $clubs = $clubRepository->findAll();
        return $this->render('admin/admin_clubs.html.twig', [
            'clubs' => $clubs
        ]);
    }
    /**
     * @Route("admin/club/create", name="admin_club_create")
     */
    public function adminCreateClub(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
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

        return $this->render('admin/admin_club_create.html.twig',[
            'clubForm' => $clubForm->createView()
        ]);
    }
    /**
     * @Route("admin/club/update/{id}", name="admin_club_update")
     */
    public function adminUpdateClub($id, Request $request, ClubRepository $clubRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
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

        return $this->render('admin/admin_club_update.html.twig',[
            'clubForm' => $clubForm->createView()
        ]);
    }
    /**
     * @Route("admin/club/{id}", name="admin_club")
     */
    public function adminClub($id, ClubRepository $clubRepository)
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
        return $this->render('admin/admin_club.html.twig', [
            'club' => $club
        ]);
    }
    /**
     * @Route("admin/club/delete/{id}", name="admin_club_delete")
     */
    public function adminDeleteClub($id, EntityManagerInterface $entityManager, ClubRepository $clubRepository)
    {
        $club = $clubRepository->find($id);

        $entityManager->remove($club);
        $entityManager->flush();

        return $this->redirectToRoute("admin_clubs");
    }
    /**
     * @Route("admin/search", name="admin_search_clubs")
     */
    public function adminSearchClubs(ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);

        return $this->render('admin/admin_clubs_search.html.twig', [
            'clubs' => $clubs
        ]);
    }
}