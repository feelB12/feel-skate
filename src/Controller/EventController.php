<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\LoaderInterface;

use App\Bootsrtap;
use App\Calendar\Month;
use App\Calendar\Event;

use App\Repository\EventRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Bundle\MakerBundle\MakerBundle;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class EventController extends AbstractController
{
    /**
     * @Route("/events", name="events")
     */
    public function Events(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();
        return $this->render('events.html.twig', [
            'events' => $events
        ]);
    }

    /**
     * @Route("event/{id}", name="event")
     */
    public function Event($id, EventRepository $eventRepository)
    {
       
        $event = $eventRepository->find($id);

        // si l' event n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($event)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'event' => $event
            ]);
        }
        $event = $eventRepository->find($id);
        return $this->render('event.html.twig', [
            'event' => $event
        ]);
    }

    /**
     * @Route("events/search", name="search_events")
     */
    public function searchEvents(EventRepository $eventRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $events = $eventRepository->searchByName($word);

        return $this->render('events_search.html.twig', [
            'events' => $events
        ]);
    }
    
}