<?php

namespace App\Controller;

use App\Entity\Medium;
use App\Entity\Stage;
use App\Entity\Action;
use App\Entity\Species;
use App\Repository\ActionRepository;
use App\Repository\MediumRepository;
use App\Repository\StageRepository;
use App\Repository\UserRepository;
use App\Repository\SpeciesRepository;
use App\Form\UserType;
use App\Form\MediumType;
use App\Form\StageType;
use App\Form\ActionType;
use App\Form\SpeciesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class AdminBoardController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $mediumRepository;
    private $stageRepository;
    private $actionRepository;
    private $speciesRepository;

    public function __construct(UserRepository $userRepository,
                                MediumRepository $mediumRepository,
                                StageRepository $stageRepository,
                                ActionRepository $actionRepository,
                                SpeciesRepository $speciesRepository,
                                EntityManagerInterface $entityManager){
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->mediumRepository = $mediumRepository;
        $this->stageRepository = $stageRepository;
        $this->actionRepository = $actionRepository;
        $this->speciesRepository = $speciesRepository;
    }

    /**
     * @Route("/admin/board", name="admin_board")
     */
    public function index()
    {
        return $this->render('admin_board/index.html.twig', [
            'controller_name' => 'AdminBoardController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function showUsers(Request $request)
    {
        $message = "";
        if($request->query->get('message')) {
            $message = $request->query->get('message');
        };
        $users = $this->userRepository->findAll();
        $mediums = $this->mediumRepository->findAll();
        $stages = $this->stageRepository->findAll();
        $actions = $this->actionRepository->findAll();
        $species = $this->speciesRepository->findAll();

        return $this->render('admin_board/index.html.twig', [
            'users' => $users,
            'message' => $message,
            'mediums' => $mediums,
            'stages' => $stages,
            'actions' => $actions,
            'species' => $species
        ]);

    }


    //-----------------------------------Users-----------------------------------------------//
    /**
     * @Route("/admin/edit/user/{id}", name="admin-edit-user")
     */
    public function editUser(Request $request, $id)
    {
        $user  = $this->userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin', array('message'=> "The user info was updated."));
        }

        return $this->render('admin_board/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
        // TODO : send a message
    }

    /**
     * @Route("/admin/delete/user/{id}", name="admin-delete-user")
     */
    public function deleteUser($id)
    {
        $userToDelete  = $this->userRepository->find($id);
        $this->entityManager->remove($userToDelete);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin', array('message'=> "User deleted."));
        // TODO : send a message
     }

    //-----------------------------------Mediums-----------------------------------------------//
    /**
     * @Route("/admin/add/medium", name="admin-add-medium")
     */
    public function addNewMedium(Request $request)
    {
        $medium = new Medium();
        $form = $this->createForm(MediumType::class, $medium);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setName($form->get('name')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->redirectToRoute('admin');

            // TODO : send a success message

        }
        return $this->render('admin_board/medium.html.twig', [
            'mediumForm' => $form->createView(),
            'edit' => false,
        ]);

    }


    /**
     * @Route("/admin/edit/medium/{id}", name="admin-edit-medium")
     */
    public function editMedium(Request $request, $id)
    {
        $medium  = $this->mediumRepository->find($id);
        $form = $this->createForm(MediumType::class, $medium);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($medium);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin', array('message'=> "The info for the medium was updated."));
        }

        return $this->render('admin_board/medium.html.twig', [
            'mediumForm' => $form->createView(),
            'edit' => true
        ]);
        // TODO : send a message
    }

    /**
     * @Route("/admin/delete/medium/{id}", name="admin-delete-medium")
     */
    public function deleteMedium($id)
    {
        $mediumToDelete  = $this->mediumRepository->find($id);
        $this->entityManager->remove($mediumToDelete);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin', array('message'=> "Medium deleted."));

        // TODO : send a message
    }

    //-----------------------------------Stages-----------------------------------------------//
    /**
     * @Route("/admin/edit/stage/{id}", name="admin-edit-stage")
     */
    public function editStage(Request $request, $id)
    {
        $stage  = $this->stageRepository->find($id);
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($stage);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin', array('message'=> "The info for the  stage was updated."));
        }

        return $this->render('admin_board/stage.html.twig', [
            'stageForm' => $form->createView(),
            'edit' => true
        ]);

        // TODO : send a message
    }

    /**
     * @Route("/admin/delete/stage/{id}", name="admin-delete-stage")
     */
    public function deleteStage($id)
    {
        $stageToDelete  = $this->stageRepository->find($id);
        $this->entityManager->remove($stageToDelete);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin', array('message'=> "Stage deleted."));

        // TODO : send a message
    }


    /**
     * @Route("/admin/add/stage", name="admin-add-stage")
     */
    public function addNewStage(Request $request)
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stage->setName($form->get('name')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('admin');

            // TODO : send a message

        }
        return $this->render('admin_board/stage.html.twig', [
            'stageForm' => $form->createView(),
            'edit' => false,
        ]);
    }


    //-----------------------------------Actions-----------------------------------------------//
    /**
     * @Route("/admin/edit/action/{id}", name="admin-edit-action")
     */
    public function editAction(Request $request, $id)
    {
        $action  = $this->actionRepository->find($id);
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($action);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin', array('message'=> "The info for the action was updated."));
        }

        return $this->render('admin_board/stage.html.twig', [
            'actionForm' => $form->createView(),
            'edit' => true
        ]);

        // TODO : send a message
    }

    /**
     * @Route("/admin/delete/action/{id}", name="admin-delete-action")
     */
    public function deleteAction($id)
    {
        $actionToDelete  = $this->actionRepository->find($id);
        $this->entityManager->remove($actionToDelete);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin', array('message'=> "Action deleted."));

        // TODO : send a message
    }


    /**
     * @Route("/admin/add/action", name="admin-add-action")
     */
    public function addNewAction(Request $request)
    {
        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $action->setName($form->get('name')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($action);
            $entityManager->flush();
            return $this->redirectToRoute('admin');

            // TODO : send a message

        }
        return $this->render('admin_board/action.html.twig', [
            'actionForm' => $form->createView(),
            'edit' => false,
        ]);
    }



    //-----------------------------------Species-----------------------------------------------//
    /**
     * @Route("/admin/edit/species/{id}", name="admin-edit-species")
     */
    public function editSpecies(Request $request, $id)
    {
        $species  = $this->speciesRepository->find($id);
        $oldfile = $species->getPhoto();

        $form = $this->createForm(SpeciesType::class, $species);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file = $request->files->get('species');
            $file = $file['photoFile'];
            $uploads_directory = $this->getParameter('uploads_directory'); //defined in services.yaml
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );

            //---delete the old file---------------------------------
            $filesystem = new Filesystem();
            try {
                $uploads_directory = $this->getParameter('uploads_directory');

                /*   echo '<pre>';
                   var_dump($uploads_directory.'/'.$oldfile); die;*/
                $filesystem->remove($uploads_directory.'/'.$oldfile);
                //https://symfony.com/doc/current/components/filesystem.html#remove

            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at ".$exception->getPath();
            }
            //-----------------------------------------

            $species->setPhoto($filename);
            $species->setName($form->get('name')->getData());


            $species->setCreatedAt(new \DateTime('now'));
            $this->entityManager->persist($species);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin', array('message'=> "The info for the species was updated."));
        }

        return $this->render('admin_board/species.html.twig', [
            'speciesForm' => $form->createView(),
            'edit' => true
        ]);

        // TODO : send a message
    }

    /**
     * @Route("/admin/delete/species/{id}", name="admin-delete-species")
     */
    public function deleteSpecies($id)
    {
        $speciesToDelete  = $this->speciesRepository->find($id);

        $filesystem = new Filesystem();

        try {
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = $speciesToDelete->getPhoto();
         /*   echo '<pre>';
            var_dump($uploads_directory.'/'.$filename); die;*/
            $filesystem->remove($uploads_directory.'/'.$filename);
            //https://symfony.com/doc/current/components/filesystem.html#remove

        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }

        $this->entityManager->remove($speciesToDelete);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin', array('message'=> "Species deleted."));

        // TODO : send a message
        // TODO : upload files into the assets folder and use webpack watch to save them into the public folder(?)
    }


    /**
     * @Route("/admin/add/species", name="admin-add-species")
     */
    public function addNewSpecies(Request $request)
    {
        $species = new Species();
        $form = $this->createForm(SpeciesType::class, $species);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //https://www.youtube.com/watch?v=zTv0UFkAKFA
         /*   echo '<pre>';
            var_dump($request); die; */
            $file = $request->files->get('species');
          /*   echo '<pre>';
            var_dump($file); die; */
           /*    echo '<pre>';
            var_dump($file); die;*/
            $file = $file['photoFile'];
          /*    echo '<pre>';
            var_dump($file); die;*/

            $uploads_directory = $this->getParameter('uploads_directory'); //defined in services.yaml
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $species->setPhoto($filename);
            $species->setName($form->get('name')->getData());
/*
            echo '<pre>';
            var_dump($species);
            echo '<pre>';
            var_dump($form->get('name')->getData());
            die;
*/

            $species->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($species);
            $entityManager->flush();
             return $this->redirectToRoute('admin');

            // TODO : send a message
            //TODO : modify here

        }
        return $this->render('admin_board/species.html.twig', [
            'speciesForm' => $form->createView(),
            'edit' => false,
        ]);
    }

}
