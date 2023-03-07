<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class  FrontShopController extends AbstractController
{
     /**
     * @Route("front/shops", name="front_shops")
     */
    public function frontShops(ShopRepository $shopRepository)
    {
        $shops = $shopRepository->findAll();
        return $this->render('front/front_shops.html.twig', [
            'shops' => $shops
        ]);
    }
    /**
     * @Route("front/shop/create", name="front_shop_create")
     */
    public function frontCreateShop(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $shop = new Shop();
        $shopForm = $this->createForm(ShopType::class, $shop);
        $shopForm->handleRequest($request);

        if ($shopForm->isSubmitted() && $shopForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $shopForm->get('coverFilename')->getData();

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
                    $shop->setCoverFilename($newFilename);
            }

            $entityManager->persist($shop);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le shop existe déja ou... !");
        $this->addFlash('success', "Le Shop a bien été créer !");

        return $this->render('front/front_shop_create.html.twig',[
            'shopForm' => $shopForm->createView()
        ]);
    }
    /**
     * @Route("front/shop/update/{id}", name="front_shop_update")
     */
    public function frontUpdateShop($id, Request $request, ShopRepository $shopRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $shop = $shopRepository->find($id);

        $shopForm = $this->createForm(ShopType::class, $shop);
        $shopForm->handleRequest($request);

        if ($shopForm->isSubmitted() && $shopForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $shopForm->get('coverFilename')->getData();

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
                $shop->setCoverFilename($newFilename);
            }

            $entityManager->persist($shop);
            $entityManager->flush();

        }
        // $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le Shop a bien été modifié !");

        return $this->render('front/front_shop_update.html.twig',[
            'shopForm' => $shopForm->createView()
        ]);
    }
    /**
     * @Route("front/shop/{id}", name="front_shop")
     */
    public function frontShop($id, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);

        // si le shop n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($shop)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'shop' => $shop
            ]);
        }
        $shop = $shopRepository->find($id);
        return $this->render('front/front_shop.html.twig', [
            'shop' => $shop
        ]);
    }
    /**
     * @Route("front/shop/delete/{id}", name="front_shop_delete")
     */
    public function frontDeleteShop($id, EntityManagerInterface $entityManager, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);

        $entityManager->remove($shop);
        $entityManager->flush();

        return $this->redirectToRoute("front_shops");
    }
    /**
     * @Route("front/search", name="front_search_shops")
     */
    public function frontSearchShops(ShopRepository $shopRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $shops = $shopRepository->searchByTitle($word);

        return $this->render('front/front_shops_search.html.twig', [
            'shops' => $shops
        ]);
    }
}