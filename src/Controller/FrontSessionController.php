<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class  FrontSessionController extends AbstractController
{
     /**
     * @Route("front/sessions", name="front_sessions")
     */
    public function frontSessions(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('front/front_sessions.html.twig', [
            'sessions' => $sessions
        ]);
    }
    /**
     * @Route("front/session/create", name="front_session_create")
     */
    public function frontCreateSession(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $sessionForm->get('coverFilename')->getData();

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
                    $session->setCoverFilename($newFilename);
            }

            $entityManager->persist($session);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le Session existe déja ou... !");
        $this->addFlash('success', "Le Session a bien été créer !");

        return $this->render('front/front_session_create.html.twig',[
            'sessionForm' => $sessionForm->createView()
        ]);
    }
    /**
     * @Route("front/session/update/{id}", name="front_session_update")
     */
    public function frontUpdateSession($id, Request $request, SessionRepository $sessionRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $session = $sessionRepository->find($id);

        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $sessionForm->get('coverFilename')->getData();

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
                $session->setCoverFilename($newFilename);
            }

            $entityManager->persist($session);
            $entityManager->flush();

        }
        // $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le Session a bien été modifié !");

        return $this->render('front/front_session_update.html.twig',[
            'sessionForm' => $sessionForm->createView()
        ]);
    }
    /**
     * @Route("front/session/{id}", name="front_session")
     */
    public function frontSession($id, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);

        // si le session n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($session)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'session' => $session
            ]);
        }
        $session = $sessionRepository->find($id);
        return $this->render('front/front_session.html.twig', [
            'session' => $session
        ]);
    }
    /**
     * @Route("front/session/delete/{id}", name="front_session_delete")
     */
    public function frontDeleteSession($id, EntityManagerInterface $entityManager, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);

        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute("front_sessions");
    }
    /**
     * @Route("front/search", name="front_search_sessions")
     */
    public function frontSearchSessions(SessionRepository $sessionRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);

        return $this->render('front/front_sessions_search.html.twig', [
            'sessions' => $sessions
        ]);
    }
}