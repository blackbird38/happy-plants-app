<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\Plant;
use App\Form\PlaceType;
use App\Form\PlantType;
use App\Repository\ActionRepository;
use App\Repository\MediumRepository;
use App\Repository\SpeciesRepository;
use App\Repository\StageRepository;
use App\Repository\UserRepository;
use App\Repository\PlantRepository;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class UserAccountController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $plantRepository;
    private $placeRepository;
    private $mediumRepository;
    private $speciesRepository;

    public function __construct(UserRepository $userRepository,
                                PlantRepository $plantRepository,
                                PlaceRepository $placeRepository,
                                MediumRepository $mediumRepository,
                                SpeciesRepository $speciesRepository,
                                StageRepository $stageRepository,
                                ActionRepository $actionRepository,
                                EntityManagerInterface $entityManager){
        $this->userRepository = $userRepository;
        $this->plantRepository = $plantRepository;
        $this->placeRepository = $placeRepository;
        $this->speciesRepository = $speciesRepository;
        $this->entityManager = $entityManager;
        $this->mediumRepository = $mediumRepository;
        $this->stageRepository = $stageRepository;
       // $this->actionRepository = $actionRepository;

    }

    /**
     * @Route("/user/account", name="user_account")
     */
    public function index(UserInterface $user, Request $request)
    {
        //checking to see if the user has any plants, if it doesn't have, encourage them to upload
        $userID = $user->getId();
        $plants = $this->userRepository->find($userID)->getPlants();
   /*     foreach ($plants as $plant) {
            dump($plant->getIdMedium());
        }*/

        //species, medium, stage nulls

        $places = $this->userRepository->find($userID)->getPlaces();


        $nPlants = count($plants);
        $nPlaces = count($places);

        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('place');
            $file = $file['photoFile'];
            $uploads_directory = $this->getParameter('places_upload_directory'); //defined in services.yaml
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $place->setPhoto($filename);
            $place->setName($form->get('name')->getData());
            $place->setCreatedAt(new \DateTime('now'));
            $place->setOwner($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($place);
            $entityManager->flush();

       /*     echo '<pre>';
            var_dump($places); die;*/

            return $this->redirectToRoute('user_account');

            // TODO : send a message
            //TODO : modify here

            //TODO : what's the problem with temperature?
        }
        return $this->render('user_account/index.html.twig', [
            'placeForm' => $form->createView(),
            'edit' => false,
            'numberOfPlants' =>  $nPlants,
            'numberOfPlaces' =>  $nPlaces,
            'places' => $places,
            'plants' => $plants
        ]);
    }




    //-----------------------------------Place-----------------------------------------------//
    /**
     * @Route("/user/edit/place/{id}", name="user-edit-place")
     */
    public function editPlace(Request $request, $id)
    {
        $place  = $this->placeRepository->find($id);
        $oldfile = $place->getPhoto();

        $form = $this->createForm(SpeciesType::class, $place);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file = $request->files->get('place');
            $file = $file['photoFile'];
            $uploads_directory = $this->getParameter('places_upload_directory'); //defined in services.yaml
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );

            //---delete the old file---------------------------------
            $filesystem = new Filesystem();
            try {
                $uploads_directory = $this->getParameter('places_upload_directory');

                /*   echo '<pre>';
                   var_dump($uploads_directory.'/'.$oldfile); die;*/
                $filesystem->remove($uploads_directory.'/'.$oldfile);
                //https://symfony.com/doc/current/components/filesystem.html#remove

            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at ".$exception->getPath();
            }
            //-----------------------------------------

            $place->setPhoto($filename);
            $place->setName($form->get('name')->getData());


            $place->setCreatedAt(new \DateTime('now'));
            $this->entityManager->persist($place);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin', array('message'=> "The info for the place was updated."));
        }

        return $this->render('user_account/place.html.twig', [
            'placeForm' => $form->createView(),
            'edit' => true
        ]);

        // TODO : send a message
    }

    /**
     * @Route("/user/delete/place/{id}", name="user-delete-place")
     */
    public function deletePlace($id)
    {
        $placeToDelete  = $this->placeRepository->find($id);

        $filesystem = new Filesystem();

        try {
            $uploads_directory = $this->getParameter('places_upload_directory');
            $filename = $placeToDelete->getPhoto();
            /*   echo '<pre>';
               var_dump($uploads_directory.'/'.$filename); die;*/
            $filesystem->remove($uploads_directory.'/'.$filename);
            //https://symfony.com/doc/current/components/filesystem.html#remove

        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }

        $this->entityManager->remove($placeToDelete);
        $this->entityManager->flush();
        return $this->redirectToRoute('user_account', array('message'=> "Species deleted."));

        // TODO : send a message
        // TODO : upload files into the assets folder and use webpack watch to save them into the public folder(?)
    }


    /**
     * @Route("/user/add/place", name="user-add-place")
     */
    public function addNewPlace(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //https://www.youtube.com/watch?v=zTv0UFkAKFA
            /*   echo '<pre>';
               var_dump($request); die; */
            $file = $request->files->get('place');
            /*   echo '<pre>';
              var_dump($file); die; */
            /*    echo '<pre>';
             var_dump($file); die;*/
            $file = $file['photoFile'];
            /*    echo '<pre>';
              var_dump($file); die;*/

            $uploads_directory = $this->getParameter('places_upload_directory'); //defined in services.yaml
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $place->setPhoto($filename);
            $place->setName($form->get('name')->getData());
            /*
                        echo '<pre>';
                        var_dump($place);
                        echo '<pre>';
                        var_dump($form->get('name')->getData());
                        die;
            */

            $place->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($place);
            $entityManager->flush();
            return $this->redirectToRoute('user_account');

            // TODO : send a message
            //TODO : modify here

        }
        return $this->render('user_account/place.html.twig', [
            'placeForm' => $form->createView(),
            'edit' => false,
        ]);
    }

    /**
     * @Route("/user/add/plant/to/the/place/with/{id}", name="user-add-plant")
     */
    function addNewPlant(UserInterface $user, Request $request, $id){


        $userID = $user->getId();
        $plants = $this->userRepository->find($userID)->getPlants();
        $places = $this->userRepository->find($userID)->getPlaces();


        $nPlants = count($plants);
        $nPlaces = count($places);

        //the place where to add a plant, to be sent in the twig
        $place = $this->placeRepository->find($id);


        $allThePlantsInThisPlace = $place->getPlants();
        $nOfPlantsInThisPlace = count( $allThePlantsInThisPlace);

        //prepare the species and the plants to send to the twig
     //   $species = $this->speciesRepository->findAll();
     //   $mediums = $this->mediumRepository->findAll();
      //  $stages = $this->stageRepository->findAll();


            $plant= new Plant();
            $form = $this->createForm(PlantType::class, $plant);
            $form->handleRequest($request);



            if ($form->isSubmitted() && $form->isValid()) {
                $file = $request->files->get('plant');
                $file = $file['photoFile'];
                $medium = $form->get('id_medium')->getData();
               /* echo '<pre>';
                var_dump($medium.id); exit;*/

                //saving the photo to disk
                $uploads_directory = $this->getParameter('plants_upload_directory'); //defined in services.yaml
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );

                $plant->setPhoto($filename);
                $plant->setName($form->get('name')->getData());
                $plant->setIdSpecies($form->get('id_species')->getData());
                $plant->setIdMedium($form->get('id_medium')->getData());
                $plant->setIdStage($form->get('id_stage')->getData());
                $plant->setOwnerId($user);
                $plant->setIdPlace($place);
             //   $plant->setCreatedAt(new \DateTime('now'));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($plant);
                $entityManager->flush();
                return $this->redirectToRoute('user_account');

                // TODO : send a message
                //TODO : modify here

            }
        return $this->render('user_account/plant.html.twig', [
            'plantForm' => $form->createView(),
            'edit' => false,
            'numberOfPlants' => $nPlants,
            'numberOfPlaces' => $nPlaces,
            'idOfThePlace' =>$id,
            'place' => $place,
            'allThePlantsHere' => $allThePlantsInThisPlace,
            'nOfPlantsInThisPlace' => $nOfPlantsInThisPlace,
         //   'species' => $species,
          //  'mediums' => $mediums,
          //  'stages' => $stages
        ]);
    }


    /**
     * @Route("/user/water/the/plant/with/{id}", name="user-water-plant")
     */
    function waterPlant(Request $request, $id){
        //TODO : continue
    }

}
