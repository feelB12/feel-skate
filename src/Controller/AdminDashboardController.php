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
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AdminDashboardController extends AbstractController
{
    /**
     * @Route("admin/dashboard", name="admin_dashboard")
     */
    public function AdminDashboard(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository , UserRepository $userRepository )
    {
       
        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();
        $users = $userRepository->findAll();

        return $this->render( "admin/dashboard.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'shops' => $shops,
            'users' => $users
        ]);
       
    }
   
        /**
     * @Route("admin/dashboard/search", name="admin_dashboard_search")
     */
    public function AdminDashboardSearch(SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository,  ClubRepository $clubRepository, ShopRepository $shopRepository,  UserRepository $userRepository, Request $request)
    {
            // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
            $word = $request->query->get('query');

            // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
            $clubs = $clubRepository->searchByTitle($word);
            $sessions = $sessionRepository->searchByTitle($word);
            $shops = $shopRepository->searchByTitle($word);
            $skateparks = $skateparkRepository->searchByTitle($word);
            $users = $userRepository->searchByTitle($word);
    
            $skateparks = $skateparkRepository->findAll();
            $sessions = $sessionRepository->findAll();
            $clubs = $clubRepository->findAll();
            $shops = $shopRepository->findAll();
            $users = $userRepository->findAll();

            return $this->render('admin/dashboard_search.html.twig', [
                'clubs' => $clubs,
                'skateparks' => $skateparks,
                'sessions' => $sessions,
                'shops' => $shops,
                'users' => $users
            ]);
        }
}

