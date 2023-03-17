<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\ShopRepository;
use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminSearchController extends AbstractController
{
    /**
     * @Route("admin/search", name="admin_search")
     */
    public function AdminSearch(SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository,  ClubRepository $clubRepository, ShopRepository $shopRepository,  UserRepository $userRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);
        $skateparks = $skateparkRepository->searchByTitle($word);
        $clubs = $clubRepository->searchByTitle($word);
        $users = $userRepository->searchByTitle($word);
        $shops = $shopRepository->searchByTitle($word);


        return $this->render('admin/admin_search.html.twig', [
            'sessions' => $sessions,
            'skateparks' => $skateparks,
            'clubs' => $clubs,
            'users' => $users,
            'shop' => $shops,
        ]);
    }
     /**
     * @Route("admin/searchs", name="admin_search_all")
     */
    public function AdminSearchs(SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository,  ClubRepository $clubRepository, ShopRepository $shopRepository,  UserRepository $userRepository, Request $request)
    {
            // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
            $word = $request->query->get('query');

            // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
            $clubs = $clubRepository->searchByTitle($word);
            $sessions = $sessionRepository->searchByTitle($word);
            $shops = $shopRepository->searchByTitle($word);
            $skateparks = $skateparkRepository->searchByTitle($word);
            $users = $userRepository->searchByTitle($word);
    
            $lastSkateparks =$skateparkRepository->searchByTitle($word);
            $lastSessions =$sessionRepository->searchByTitle($word);
            $lastClubs =$clubRepository->searchByTitle($word);
            $lastShops = $shopRepository->searchByTitle($word);
            $lastUsers = $userRepository->searchByTitle($word);
    
            $skateparks = $skateparkRepository->findAll();
            $sessions = $sessionRepository->findAll();
            $clubs = $clubRepository->findAll();
            $shops = $shopRepository->findAll();
            $users = $userRepository->findAll();

            return $this->render('admin/admin_searchs.html.twig', [
                'clubs' => $clubs,
                'skateparks' => $skateparks,
                'sessions' => $sessions,
                'shops' => $shops,
                'users' => $users,
                'lastClubs' => $lastClubs,
                'lastSkateparks' => $lastSkateparks,
                'lastSessions' => $lastSessions,
                'lastUsers' => $lastUsers,
                'lastShops' =>$lastShops
            ]);
        }
}