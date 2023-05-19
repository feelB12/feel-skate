<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class  ProfileEventController extends AbstractController
{
     /**
     * @Route("profile/events", name="profile_events")
     */
    public function profileEvents(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();
        return $this->render('profile/profile_events.html.twig', [
            'events' => $events
        ]);
    }
    /**
     * @Route("profile/event/create", name="profile_event_create")
     */
    public function profileCreateEvent(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $event = new Event();
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $eventForm->get('coverFilename')->getData();

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
                    $event->setCoverFilename($newFilename);
            }

            $entityManager->persist($event);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le Event existe déja ou... !");
        $this->addFlash('success', "Le Event a bien été créer !");

        return $this->render('profile/profile_event_create.html.twig',[
            'eventForm' => $eventForm->createView()
        ]);
    }
    /**
     * @Route("profile/event/update/{id}", name="profile_event_update")
     */
    public function profileUpdateEvent($id, Request $request, EventRepository $eventRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $event = $eventRepository->find($id);

        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $eventForm->get('coverFilename')->getData();

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
                $event->setCoverFilename($newFilename);
            }

            $entityManager->persist($event);
            $entityManager->flush();

        }
        // $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le Event a bien été modifié !");

        return $this->render('profile/profile_event_update.html.twig',[
            'eventForm' => $eventForm->createView()
        ]);
    }
    /**
     * @Route("profile/event/{id}", name="profile_event")
     */
    public function profileEvent($id, EventRepository $eventRepository)
    {
        $event = $eventRepository->find($id);

        // si le event n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($event)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'event' => $event
            ]);
        }
        $event = $eventRepository->find($id);
        return $this->render('profile/profile_event.html.twig', [
            'event' => $event
        ]);
    }
    /**
     * @Route("profile/event/delete/{id}", name="profile_event_delete")
     */
    public function profileDeleteEvent($id, EntityManagerInterface $entityManager, EventRepository $eventRepository)
    {
        $event = $eventRepository->find($id);

        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute("profile_events");
    }
    /**
     * @Route("profile/search", name="profile_search_events")
     */
    public function profileSearchEvents(EventRepository $eventRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $events = $eventRepository->searchByTitle($word);

        return $this->render('profile/profile_events_search.html.twig', [
            'events' => $events
        ]);
    }
}