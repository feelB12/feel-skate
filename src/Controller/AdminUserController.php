<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUserController extends AbstractController
{
    /**
     * @Route("admin/users", name="admin_users")
     */
     // je récupère la class request car elle va contenir les données POST form
    public function AdminUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('admin/admin_users.html.twig', [
            'users' => $users
        ]);
    }
    /**
     * @Route("admin/user/create", name="admin_user_create", methods={"GET","POST"})
     */
    // je récupère la class request car elle va contenir les données POST form
    public function AdminCreateUser(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        // je veux créer un nouvel enregistrement dans la table  user
        //donc je crée une instance de l'entité user 
        $user = new user();

        // j'utilise la méthose createForm (d'absstractController) qui va me permettre de créer un
        // formulaire en utilisant le gabarit généré (UserType) en lignes de commandes
        // et je lui associe l'instance de l'entité User
        $userForm = $this->createForm(UserType::class, $user);

        // Associer le formulaire à la classe Request ( le formulaire
        // lui est associé à la l'instance de l'entité User)
        $userForm->handleRequest($request);

        // véridier que le formulaire a été envoyé 
        // IsValid empèche que des données invalides par rapport au type de colonnes 
        // ne soient insérées + prévient des injection SQL
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            // On enregistre l'entité en bdd avec l'entité manager ( vu que l'instance de l'entité est reliée
            // au form et que le formulaire est relié à la class Request), symfony  va
            // automatiquement mettre les données du form dans l'instance de l'entité
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $userForm->get('coverFilename')->getData();
            $portraitFile = $userForm->get('portraitFilename')->getData();

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
                $user->setCoverFilename($newFilename);
                if ($portraitFile) {
                    // 2 recupérer le nom du fichiers uploadé
                    $originalFilename = pathinfo($portraitFile->getClientOriginalName(), PATHINFO_FILENAME);

                    // 3 renommer le fichier avec un nom unique
                    $saveFilename = $slugger->slug($originalFilename);
                    $idFilename = $saveFilename.'-'.uniqid().'.'.$portraitFile->guessExtension();

                    // 4 déplacer le fichier dans le dossier publique
                    $portraitFile->move(
                        $this->getParameter( 'portrait_directory'),
                        $idFilename
                    );
                    // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                    $user->setPortraitFilename($idFilename);
                }
            }
            //
            $entityManager->persist($user);
            $entityManager->flush();
        }
        // permet d'enregistré un message qui devra ensuite être affiché dans le twig 
        $this->addFlash('success', "L'utilisateur a bien été créer !");
        $this->addFlash('error', "Le user existe déja ou... !");

        //return $this->redirectToRoute('admin_users')

        // return $this->render('registration/register.html.twig',[
        //     'userForm' => $userForm->createView()
        // ]);

        // j'envoie à mon twig la variable contenant le formulaire 
        // préparé pour l'affichage (avec la méthode createView)
        return $this->render('admin/admin_user_update.html.twig',[
        'userForm' => $userForm->createView()
        ]);
    }
    /**
     * @Route("admin/user/update/{id}", name="admin_user_update")
     */
    public function AdminUpdateUser($id, Request $request, UserRepository $userRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->find($id);

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $userForm->get('coverFilename')->getData();
            $portraitFile = $userForm->get('portraitFilename')->getData();

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
                $user->setCoverFilename($newFilename);
                if ($portraitFile) {
                    // 2 recupérer le nom du fichiers uploadé
                    $originalFilename = pathinfo($portraitFile->getClientOriginalName(), PATHINFO_FILENAME);

                    // 3 renommer le fichier avec un nom unique
                    $saveFilename = $slugger->slug($originalFilename);
                    $idFilename = $saveFilename.'-'.uniqid().'.'.$portraitFile->guessExtension();

                    // 4 déplacer le fichier dans le dossier publique
                    $portraitFile->move(
                        $this->getParameter( 'portrait_directory'),
                        $idFilename
                    );
                    // 5 enregistrer le nom du fichier dan sla colonne portraitFilename
                    $user->setPortraitFilename($idFilename);
                }
            }
            $entityManager->persist($user);
            $entityManager->flush();
            //return $this->redirectToRoute('admin_users')
        }    
        $this->addFlash('error', "les champs n'ont pas tous été modifié!");
        $this->addFlash('success', "Le user a bien été modifié !");
        // j'envoie à mon twig la variable contenant le formulaire 
        // préparé pour l'affichage (avec la méthode createView)
        return $this->render('admin/admin_user_update.html.twig',[
            'userForm' => $userForm->createView()
        ]);
    }
    /**
     * @Route("admin/user/{id}", name="admin_user")
     */
    public function AdminUser($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        return $this->render('admin/admin_user.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("admin/user/delete/{id}", name="admin_user_delete")
     */
    public function AdminDeleteUser($id, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("admin_users");
    }
    /**
     * @Route("admin/user/search", name="admin_search_users")
     */
    public function AdminSearchUsers(UserRepository $userRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $users = $userRepository->searchByTitle($word);

        return $this->render('admin/admin_users_search.html.twig', [
            'users' => $users
        ]);
    }
}