<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Entity\Shop;
use App\Form\ShopType;
use App\Entity\Session;
use App\Form\SessionType;
use App\Entity\Skatepark;
use App\Form\SkateparkType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "index.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);

    }
    /**
     * @Route("/home", name="home")
     */
    public function Home(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository)
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'shops' => $lastShops,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'lastShops' =>$lastShops
        ]);
    }
    /**
     * @Route("/", name="accueil")
     */
    public function Accueil(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);
    }
    /**
     * @Route("/searchs", name="search_all")
     */
    public function FrontSearchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
    {
            // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
            $word = $request->query->get('query');

            // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
            $clubs = $clubRepository->searchByTitle($word);
            $sessions = $sessionRepository->searchByTitle($word);
            $shops = $shopRepository->searchByTitle($word);
            $skateparks = $skateparkRepository->searchByTitle($word);
    
            $lastSkateparks =$skateparkRepository->searchByTitle($word);
            $lastSessions =$sessionRepository->searchByTitle($word);
            $lastClubs =$clubRepository->searchByTitle($word);
            $lastShops = $shopRepository->searchByTitle($word);
    
            $skateparks = $skateparkRepository->findAll();
            $sessions = $sessionRepository->findAll();
            $clubs = $clubRepository->findAll();
            $shops = $shopRepository->findAll();

            return $this->render('search.html.twig', [
                'clubs' => $clubs,
                'skateparks' => $skateparks,
                'sessions' => $sessions,
                'shops' => $lastShops,
                'lastClubs' => $lastClubs,
                'lastSkateparks' => $lastSkateparks,
                'lastSessions' => $lastSessions,
                'lastShops' =>$lastShops
            ]);
        }
        /**
     * @Route("/search", name="search")
     */
    public function Search(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
    {
            // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
            $word = $request->query->get('query');

            // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
            $clubs = $clubRepository->searchByTitle($word);
            $sessions = $sessionRepository->searchByTitle($word);
            $shops = $shopRepository->searchByTitle($word);
            $skateparks = $skateparkRepository->searchByTitle($word);
    
            $lastSkateparks =$skateparkRepository->searchByTitle($word);
            $lastSessions =$sessionRepository->searchByTitle($word);
            $lastClubs =$clubRepository->searchByTitle($word);
            $lastShops = $shopRepository->searchByTitle($word);
    
            $skateparks = $skateparkRepository->findAll();
            $sessions = $sessionRepository->findAll();
            $clubs = $clubRepository->findAll();
            $shops = $shopRepository->findAll();

            return $this->render('search.html.twig', [
                'clubs' => $clubs,
                'skateparks' => $skateparks,
                'sessions' => $sessions,
                'shops' => $lastShops,
                'lastClubs' => $lastClubs,
                'lastSkateparks' => $lastSkateparks,
                'lastSessions' => $lastSessions,
                'lastShops' =>$lastShops
            ]);
        }
}

