<?php

namespace App\Controller;

use App\Entity\Skatepark;
use App\Entity\User;
use App\Form\SkateparkType;
use App\Form\UserType;
use App\Repository\SkateparkRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class  AdminSkateparkController extends AbstractController
{
     /**
     * @Route("admin/skateparks", name="admin_skateparks")
     */
    public function adminSkateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('admin/admin_skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
    /**
     * @Route("admin/skatepark/create", name="admin_skatepark_create")
     */
    public function adminCreateSkatepark(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $skatepark = new Skatepark();
        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            //on enregistre l'entité en bdd avec entityManager (vu que l'instance de l'entite est reliée
            // au form et que le formulaire est reliée à la class Request), Symfony va 
            //automatiquement mettre les données du form dans l'instance de l'entité 
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

            //
            $entityManager->persist($skatepark);
            $entityManager->flush();

            //permet d'enregistrer un message qui devra ensuite être affiché dans le twig
            $this->addFlash('error', "Le Skatepark existe déja ou... !");
            
            //permet d'enregistrer un message qui devra ensuite être affiché dans le twig
            $this->addFlash('success', "Le Skatepark a bien été créer !");

            return $this->redirectToRoute('admin_skateparks');
        }
        
        // j'envoie à mon twig la variable contenant le formulaire 
        // préparé pour l'affichage (avec la méthode createView)
        return $this->render('admin/admin_skatepark_create.html.twig',[
            'skateparkForm' => $skateparkForm->createView()
        ]);
    }
    /**
     * @Route("admin/skatepark/update/{id}", name="admin_skatepark_update")
     */
    public function adminUpdateSkatepark($id, $user, Request $request, SkateparkRepository $skateparkRepository, UserRepository $userRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $skatepark = $skateparkRepository->find($id);
        $user = $skateparkRepository->find($user);

        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);
        
            if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
                // on enregistre l'entité en bdd avec entityManager (vu que l'instance de l'entite est reliée
                // au form et que le formulaire est reliée à la class Request), Symfony va 
                //automatiquement mettre les données du form dans l'instance de l'entité 
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
    
                //permet d'enregistrer un message qui devra ensuite être affiché dans le twig
                //$this->addFlash('error', "les champ n'ont pas tous été modifié!");
    
                //permet d'enregistrer un message qui devra ensuite être affiché dans le twig
                //$this->addFlash('success', "Le Skatepark a bien été modifié !");
                
                
                //return $this->redirectToRoute('admin_skatepark', [$id]);
                $skatepark = $skateparkRepository->find($id);
                 return $this->render('admin/admin_skatepark.html.twig', [
                        'skatepark' => $skatepark
                ]);
            }
            // j'envoie à mon twig la variable contenant le formulaire 
            // préparé pour l'affichage (avec la méthode createView)
            return $this->render('admin/admin_skatepark_update.html.twig',[
                'skateparkForm' => $skateparkForm->createView()
            ]);
    }
    /**
     * @Route("admin/skatepark/{id}", name="admin_skatepark")
     */
    public function adminSkatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);

        // si le Skatepark n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($skatepark)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'skatepark' => $skatepark
            ]);
        }
        $skatepark = $skateparkRepository->find($id);
        return $this->render('admin/admin_skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
    /**
     * @Route("admin/skatepark/delete/{id}", name="admin_skatepark_delete")
     */
    public function adminDeleteSkatepark($id, EntityManagerInterface $entityManager, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);

        $entityManager->remove($skatepark);
        $entityManager->flush();

        return $this->redirectToRoute("admin_skateparks");
    }
    /**
     * @Route("admin/skatepark/search", name="admin_search_skateparks")
     */
    public function adminSearchSkateparks(SkateparkRepository $skateparkRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $skateparks = $skateparkRepository->searchByTitle($word);

        return $this->render('admin/admin_skateparks_search.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
}