<?php

namespace App\Controller;

use App\Entity\Skatepark;
use App\Form\SkateparkType;
use App\Repository\SkateparkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class  FrontSkateparkController extends AbstractController
{
     /**
     * @Route("front/skateparks", name="front_skateparks")
     */
    public function frontSkateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('front/front_skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
    /**
     * @Route("front/skatepark/create", name="front_skatepark_create")
     */
    public function frontCreateSkatepark(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $skatepark = new Skatepark();
        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $skateparkForm->get('coverFilename')->getData();

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
                    $skatepark->setCoverFilename($newFilename);
            }

            $entityManager->persist($skatepark);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le Skatepark existe déja ou... !");
        $this->addFlash('success', "Le Skatepark a bien été créer !");

        return $this->render('front/front_skatepark_create.html.twig',[
            'skateparkForm' => $skateparkForm->createView()
        ]);
    }
    /**
     * @Route("front/skatepark/update/{id}", name="front_skatepark_update")
     */
    public function frontUpdateSkatepark($id, Request $request, SkateparkRepository $skateparkRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $skatepark = $skateparkRepository->find($id);

        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $skateparkForm->get('coverFilename')->getData();

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
                $skatepark->setCoverFilename($newFilename);
            }

            $entityManager->persist($skatepark);
            $entityManager->flush();

        }
        // $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le Skatepark a bien été modifié !");

        return $this->render('front/front_skatepark_update.html.twig',[
            'skateparkForm' => $skateparkForm->createView()
        ]);
    }
    /**
     * @Route("front/skatepark/{id}", name="front_skatepark")
     */
    public function frontSkatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);

        // si le skatepark n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($skatepark)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'skatepark' => $skatepark
            ]);
        }
        $skatepark = $skateparkRepository->find($id);
        return $this->render('front/front_skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
    /**
     * @Route("front/skatepark/delete/{id}", name="front_skatepark_delete")
     */
    public function frontDeleteSkatepark($id, EntityManagerInterface $entityManager, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);

        $entityManager->remove($skatepark);
        $entityManager->flush();

        return $this->redirectToRoute("front_skateparks");
    }
    /**
     * @Route("front/search", name="front_search_skateparks")
     */
    public function frontSearchSkateparks(SkateparkRepository $skateparkRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $skateparks = $skateparkRepository->searchByTitle($word);

        return $this->render('front/front_skateparks_search.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
}