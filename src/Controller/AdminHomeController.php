<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Shop;
use App\Form\ShopType;
use App\Entity\Session;
use App\Form\SessionType;
use App\Entity\Skatepark;
use App\Form\SkateparkType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("admin/index", name="admin_index")
     */
    public function AdminIndex(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "admin/admin_index.html.twig", [
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
     * @Route("admin/home", name="admin_home")
     */
    public function AdminHome(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository)
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "admin/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'shops' => $lastShops,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'lastShops' =>$lastShops
        ]);
        $this->addFlash('success', "Bienvenue vous êtes bien connecté!");
    }
    /**
     * @Route("admin/", name="admin_accueil")
     */
    public function AdminAccueil(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "admin/home.html.twig", [
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
     * @Route("admin/searchs", name="admin_search_all")
     */
    public function AdminSearchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
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

            return $this->render('admin/admin_search.html.twig', [
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
     * @Route("admin/search", name="admin_search")
     */
    public function AdminSearch(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
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

            return $this->render('admin/admin_search.html.twig', [
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

