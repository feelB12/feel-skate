<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("front/index", name="front_index")
     */
    public function Frontindex(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "front/index.html.twig", [
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
     * @Route("front/home", name="front_home")
     */
    public function FrontHome(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository)
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "front/home.html.twig", [
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
     * @Route("front/", name="front_accueil")
     */
    public function FrontAccueil(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "front/home.html.twig", [
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
     * @Route("front/searchs", name="front_search_all")
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

            return $this->render('front/search.html.twig', [
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

