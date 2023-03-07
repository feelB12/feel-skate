<?php

namespace App\Controller;


use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\ShopRepository;
use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function Search(SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository,  ClubRepository $clubRepository, ShopRepository $shopRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);
        $skateparks = $skateparkRepository->searchByTitle($word);
        $clubs = $clubRepository->searchByTitle($word);
        $shops = $shopRepository->searchByTitle($word);


        return $this->render('search.html.twig', [
            'sessions' => $sessions,
            'skateparks' => $skateparks,
            'clubs' => $clubs,
            'shop' => $shops,
        ]);
    }
}