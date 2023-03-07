<?php

namespace App\Controller;

use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SkateparkController extends AbstractController
{
    /**
     * @Route("skateparks", name="skateparks")
     */
    public function Skateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
    /**
     * @Route("skatepark/{id}", name="skatepark")
     */
    public function Skatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);

        // si le skatepark n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($skatepark)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'skatepark' => $skatepark
            ]);
        }
        $skatepark =$skateparkRepository->find($id);
        return $this->render('skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
    /**
     * @Route("search", name="search_skateparks")
     */
    public function searchSkateparks(SkateparkRepository $skateparkRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $skateparks = $skateparkRepository->searchByTitle($word);

        return $this->render('skateparks_search.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
}