<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\ActionHistory;
use App\Entity\Place;
use App\Entity\Plant;
use App\Entity\StageHistory;
use App\Form\PlaceType;
use App\Form\PlantType;
use App\Form\StageHistoryType;
use App\Form\ActionHistoryType;
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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UserAccountController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $plantRepository;
    private $placeRepository;
    private $mediumRepository;
    private $speciesRepository;
    private $stageRepository;

    public function __construct(UserRepository $userRepository,
                                PlantRepository $plantRepository,
                                PlaceRepository $placeRepository,
                                MediumRepository $mediumRepository,
                                SpeciesRepository $speciesRepository,
                                StageRepository $stageRepository,
                                ActionRepository $actionRepository,
                                EntityManagerInterface $entityManager
                                ){
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
     * @Route("/user/account", name="user_account", options={"expose"=true})
     */
    public function index(UserInterface $user, Request $request)
    {

        //checking to see if the user has any plants, if they don't have, encourage them to upload
        $userID = $user->getId();
        $plants = $this->userRepository->find($userID)->getPlants();
        //saving the time last watered in an array
        $timesLastWatered = [];
       // if ($plants) {
            foreach ($plants as $plant) {
                $timeLastWatered = $this->plantRepository->getLastTimeWatered($plant->getId());
                $timesLastWatered[$plant->getId()] = $timeLastWatered;
            }
     //   }
        dump($timesLastWatered);

     /*   echo'<pre>';
        var_dump($plants); exit;*/
        foreach ($plants as $plant){
            foreach ($plant->getStageHistories() as $rec){

            }

        }
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
            'plants' => $plants,
            'timesLastWatered' => $timesLastWatered
        ]);
    }


    /**
     * @Route("/user/account/places", name="user_account_places", options={"expose"=true})
     */
    public function indexPlaces(UserInterface $user, Request $request)
    {

        //checking to see if the user has any plants, if they don't have, encourage them to upload
        $userID = $user->getId();
        $plants = $this->userRepository->find($userID)->getPlants();
        //saving the time last watered in an array
        $timesLastWatered = [];
        // if ($plants) {
        foreach ($plants as $plant) {
            $timeLastWatered = $this->plantRepository->getLastTimeWatered($plant->getId());
            $timesLastWatered[$plant->getId()] = $timeLastWatered;
        }
        //   }
        dump($timesLastWatered);

        /*   echo'<pre>';
           var_dump($plants); exit;*/
        foreach ($plants as $plant){
            foreach ($plant->getStageHistories() as $rec){

            }

        }
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

        //send $nPlaces empty forms plantForm to the twig, to allow the adding of new plants (accordion)
     /*   $formArray =[];
        foreach ($places as $place){
            $plant = new Plant();
            $plantForm = $this->createForm(PlantType::class, $plant);
            $id = $place->getId();
            $formArray[$id] = $plantForm->createView();
        }*/



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

            return $this->redirectToRoute('user_account_places');

            // TODO : send a message
            //TODO : modify here

            //  what's the problem with temperature? -> mediumTemperature
        }
        return $this->render('user_account/index-places.html.twig', [
            'placeForm' => $form->createView(),
            'edit' => false,
            'numberOfPlants' =>  $nPlants,
            'numberOfPlaces' =>  $nPlaces,
            'places' => $places,
            'plants' => $plants,
            'timesLastWatered' => $timesLastWatered
           // 'plantFormArray' => $formArray
        ]);
    }


    //-----------------------------------Place-----------------------------------------------//
    /**
     * @Route("/user/edit/place/{id}-", name="user-edit-place-")
     */
    public function editPlace(Request $request, $id)
    {
        $place  = $this->placeRepository->find($id);

        //checking to see if the user has right to do this
        $this->denyAccessUnlessGranted('PLACE_EDIT', $place);

        $nameBefore = $place->getName();
        $oldfile = $place->getPhoto();

        $form = $this->createForm(PlaceType::class, $place);
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

            $nameAfter = $place->getName();
            if ($nameBefore == $nameAfter){
                $message = "'". $nameBefore . "' updated.";
            }else {
                $message = "'". $nameBefore . "' updated. It's now '". $nameAfter ."'.";
            }

            $this->addFlash('success', $message);
            // TODO : send a different message for error

            return $this->redirectToRoute('user_account');
        }

        return $this->render('user_account/place-edit.html.twig', [
            'placeForm' => $form->createView(),
            'edit' => true
        ]);

        // TODO : send a message
    }

    /**
     * @Route("/user/edit/place/{id}", name="user-edit-place", methods={"GET", "POST"}, options={"expose"=true})
     */
    public function editPlaceWithCropper(Request $request, $id)
    {
        $place  = $this->placeRepository->find($id);

        //checking to see if the user has right to do this
        $this->denyAccessUnlessGranted('PLACE_EDIT', $place);

        $nameBefore = $place->getName();
        $oldfile = $place->getPhoto();

        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ($request->isXmlHttpRequest()) {
               // $file = $request->files->get('place');
              //  $file = $file['photoFile'];
                $file = $_FILES['file'];
                $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type']);
                $uploads_directory = $this->getParameter('places_upload_directory'); //defined in services.yaml
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
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
                    $filesystem->remove($uploads_directory . '/' . $oldfile);
                    //https://symfony.com/doc/current/components/filesystem.html#remove

                } catch (IOExceptionInterface $exception) {
                    echo "An error occurred while creating your directory at " . $exception->getPath();
                }
                //-----------------------------------------

                $place->setPhoto($filename);
                $place->setName($form->get('name')->getData());


                $place->setCreatedAt(new \DateTime('now'));
                $this->entityManager->persist($place);
                $this->entityManager->flush();

                $nameAfter = $place->getName();
                if ($nameBefore == $nameAfter) {
                    $message = "'" . $nameBefore . "' updated.";
                } else {
                    $message = "'" . $nameBefore . "' updated. It's now '" . $nameAfter . "'.";
                }

                $this->addFlash('success', $message);
                // TODO : send a different message for error
                return new JsonResponse("This is an ajax request!");
                return $this->redirectToRoute('user_account');
            }//req
            else {
                return new JsonResponse("This is not an ajax request!");
            }
        } //form submited, valid

        return $this->render('user_account/place-edit.html.twig', [
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
        $name = $placeToDelete->getName();
        $nPlants = count($placeToDelete->getPlants());
        //checking to see if the user has right to do this
        $this->denyAccessUnlessGranted('PLACE_DELETE', $placeToDelete);

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

        //preparing the message to be displayed
        if ($nPlants == 1){
            $message = $name. ' was deleted. The ' . $nPlants . ' plant in it, too.';
        }else if ($nPlants == 0) {
            $message = $name. ' was deleted. It didn\'t contain any plant.';
        }else {
            $message = $name. ' was deleted. The ' . $nPlants . ' plants in it, too.';
        }
        $this->addFlash('success', $message);
     //   return $this->redirectToRoute('user_account'); // v1
        return $this->redirectToRoute('user_account_places');

        // TODO : send a message
        // TODO : upload files into the assets folder and use webpack watch to save them into the public folder(?)
    }


    /**
     * @Route("/user/add/place-", name="user-add-place-")
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
     * @Route("/user/add/place", name="user-add-place", methods={"POST"}, options={"expose"=true})
     */

    public function addNewPlaceWithCropper(UserInterface $user, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $userID = $user->getId();
            $place = new Place();
            $place->setOwner($user);
            $form = $this->createForm(PlaceType::class, $place);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //https://www.youtube.com/watch?v=zTv0UFkAKFA
                /*       echo '<pre>';
                       var_dump($request); die; */
                //! $file = $request->files->get('place');
                /*   echo '<pre>';
                  var_dump($file); die; */
                /*  echo '<pre>';
                var_dump($file); die;*/
                //!     $file = $file['photoFile'];
                /*    echo '<pre>';
                  var_dump($file); die;*/

                $file = $_FILES['file'];

                $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type']);

                $uploads_directory = $this->getParameter('places_upload_directory'); //defined in services.yaml
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
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
                /* echo '<pre>';
                 var_dump($place);*/

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($place);
                $entityManager->flush();

                return new JsonResponse("This is an ajax request!");
                return $this->redirectToRoute('user_account');

                // TODO : send a message
                //TODO : modify here

            }

            return $this->render('user_account/place.html.twig', [
                'placeForm' => $form->createView(),
                'edit' => false,
            ]);
        }
        return new JsonResponse("This is not an ajax request");
    }

    //-----------------------------------Plant-----------------------------------------------//
    /**
     * @Route("/user/add/plant/to/the/place/with/{id}-", name="user-add-plant-")
     */
    function addNewPlant(UserInterface $user, Request $request, $id){

        //the place where to add a plant, to be sent in the twig
        $place = $this->placeRepository->find($id);

        //checking to see if the user has right to do this
        $this->denyAccessUnlessGranted('PLACE_ACTION',  $place);

        $userID = $user->getId();
        $plants = $this->userRepository->find($userID)->getPlants();
        $places = $this->userRepository->find($userID)->getPlaces();
        $nPlants = count($plants);
        $nPlaces = count($places);

        $allThePlantsInThisPlace = $place->getPlants();
        $nOfPlantsInThisPlace = count( $allThePlantsInThisPlace);
            $plant= new Plant();
            $form = $this->createForm(PlantType::class, $plant);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $request->files->get('plant');
                $file = $file['photoFile'];
             //   $medium = $form->get('id_medium')->getData();
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

                //prepare a StageHistory object to save in the stage_history table the photo and the stage + date
                $record = new StageHistory();
                $record->setIdStage($form->get('id_stage')->getData());
                $record->setDate(new \DateTime('now'));
                $record->setPhoto($filename);
                //will save the plant into the database and then get the id
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($plant);
                $entityManager->flush();
                $plantId = $plant->getId();
                $record->setIdPlant($plant);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($record);
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
        ]);
    }



    /**
     * @Route("/user/add/plant/to/the/place/with/{id}", name="user-add-plant", methods={"POST", "GET"}, options={"expose"=true})
     */
    //don't change the path of the route, it's used in app.js (place)
    function addNewPlantWithCropper(UserInterface $user, Request $request, $id)
    {
        //the place where to add a plant, to be sent in the twig
        $place = $this->placeRepository->find($id);

        //checking to see if the user has right to do this
        $this->denyAccessUnlessGranted('PLACE_ACTION', $place);

        $userID = $user->getId();
        $plants = $this->userRepository->find($userID)->getPlants();
        $places = $this->userRepository->find($userID)->getPlaces();
        $nPlants = count($plants);
        $nPlaces = count($places);

        $allThePlantsInThisPlace = $place->getPlants();
        $nOfPlantsInThisPlace = count($allThePlantsInThisPlace);
        $plant = new Plant();
        $form = $this->createForm(PlantType::class, $plant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isXmlHttpRequest()) {
            $file = $request->files->get('plant');
            //  $file = $file['photoFile'];
            $file = $_FILES['file'];
            $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type']);
            //   $medium = $form->get('id_medium')->getData();
            /* echo '<pre>';
             var_dump($medium.id); exit;*/
            //saving the photo to disk
            $uploads_directory = $this->getParameter('plants_upload_directory'); //defined in services.yaml
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
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

            //prepare a StageHistory object to save in the stage_history table the photo and the stage + date
            $record = new StageHistory();
            $record->setIdStage($form->get('id_stage')->getData());
            $record->setDate(new \DateTime('now'));
            $record->setPhoto($filename);
            //will save the plant into the database and then get the id
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plant);
            $entityManager->flush();
            $plantId = $plant->getId();
            $record->setIdPlant($plant);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            return new JsonResponse("This is an ajax request!");
            return $this->redirectToRoute('user_account');
            // TODO : send a message
            //TODO : modify here
        }else {
                return new JsonResponse("This is not an ajax request");
            }
    }
            return $this->render('user_account/plant.html.twig', [
                'plantForm' => $form->createView(),
                'edit' => false,
                'numberOfPlants' => $nPlants,
                'numberOfPlaces' => $nPlaces,
                'idOfThePlace' => $id,
                'place' => $place,
                'allThePlantsHere' => $allThePlantsInThisPlace,
                'nOfPlantsInThisPlace' => $nOfPlantsInThisPlace,
            ]);
        //}
        //return new JsonResponse("This is not an ajax request");
    }



    /**
     * @Route("/user/add/photo/and/stage/of/the/plant/with/{id}-", name="user-plant-add-photos-and-stage-")
     * @param Request $request
     * @param $id //the id of the plant
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    function addPhotoAndStageForAPlant(Request $request, $id)
    {
        //checking to see if the user has right to do this
        $plant= $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_ACTION',  $plant);

        $record = new StageHistory();
        $record->setIdPlant($this->plantRepository->find($id));
        $form = $this->createForm(StageHistoryType::class, $record);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*echo '<pre>';
            var_dump($form); exit; */
             $file = $request->files->get('stage_history');
             $file = $file['photoFile'];
             $stage = $form->get('id_stage')->getData();
             $record->setIdStage($stage);
             $record->setDate(new \DateTime('now'));

              //saving the photo to disk
               $uploads_directory = $this->getParameter('plants_upload_directory'); //defined in services.yaml
               $filename = md5(uniqid()).'.'.$file->guessExtension();
               $file->move(
                    $uploads_directory,
                    $filename
                );

               $record->setPhoto($filename);
               $entityManager = $this->getDoctrine()->getManager();
               // will change the current stage in the plant table with the stage given in the form
               $plant = $this->plantRepository->find($id);
               $plant->setIdStage($stage);

               $entityManager->persist($record);
               $entityManager->persist($plant);
               $entityManager->flush();
               return $this->redirectToRoute('user_account');
        }
            return $this->render('user_account/plant-add-record-full.html.twig', [
                'stageHistoryForm' => $form->createView(),
                'edit' => false,
            ]);
    }


    /**
     * @Route("/user/add/photo/and/stage/of/the/plant/with/{id}", name="user-plant-add-photos-and-stage", methods={"POST", "GET"}, options={"expose"=true})
     * @param Request $request
     * @param $id //the id of the plant
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    //don't change the path, it's used in app.js ('plant', 'stage')
    function addPhotoAndStageForAPlantWithCropper(Request $request, $id)
    {
        //checking to see if the user has right to do this
        $plant = $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_ACTION', $plant);

        $record = new StageHistory();
        $record->setIdPlant($this->plantRepository->find($id));
        $form = $this->createForm(StageHistoryType::class, $record);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isXmlHttpRequest()) {
            /*echo '<pre>';
            var_dump($form); exit; */
           // $file = $request->files->get('stage_history');
       //     $file = $file['photoFile'];

            $file = $_FILES['file'];
            $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type']);
            $stage = $form->get('id_stage')->getData();
            $record->setIdStage($stage);
            $record->setDate(new \DateTime('now'));

            //saving the photo to disk
            $uploads_directory = $this->getParameter('plants_upload_directory'); //defined in services.yaml
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );

            $record->setPhoto($filename);
            $entityManager = $this->getDoctrine()->getManager();
            // will change the current stage in the plant table with the stage given in the form
            $plant = $this->plantRepository->find($id);
            $plant->setIdStage($stage);

            $entityManager->persist($record);
            $entityManager->persist($plant);
            $entityManager->flush();

            return new JsonResponse("This is an ajax request!");
            return $this->redirectToRoute('user_account');
        } else {
                return new JsonResponse("This is not an ajax request");
            }
    }
        return $this->render('user_account/plant-add-record-full.html.twig', [
            'stageHistoryForm' => $form->createView(),
            'edit' => false,
        ]);
    }


    /**
     * @Route("/user/add/action/on/the/plant/with/{id}", name="user-plant-add-action")
     */
    function addActionOnAPlant(UserInterface $user, Request $request, $id)
    {
        //checking to see if the user has right to do this
        $plant= $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_ACTION',  $plant);

        $actionRecord = new ActionHistory();
        $actionRecord->setIdPlant($this->plantRepository->find($id));
        $form = $this->createForm(ActionHistoryType::class, $actionRecord);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $action= $form->get('id_action')->getData();
            $actionRecord->setIdAction($action);
            $actionRecord->setQuantity($form->get('quantity')->getData());
            $actionRecord->setDate(new \DateTime('now'));
            $actionRecord->setIdUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actionRecord);
            $entityManager->flush();
            return $this->redirectToRoute('user_account');
        }
        return $this->render('user_account/plant-add-action-full.html.twig', [
            'actionHistoryForm' => $form->createView(),
            'edit' => false,
        ]);
    }

//TODO : can add: only change photo, only change other info; if stage was wrongly added (?=>) can delete
// in the stage_history

    /**
     * @Route("/user/edit/the/plant/with/{id}-", name="user-edit-plant-")
     */
    function editPlant(UserInterface $user, Request $request, $id){
        //checking to see if the user has right to do this
        $plant= $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_DELETE',  $plant);

       // $place = $this->placeRepository->find($id);
        $oldfile = $plant->getPhoto();
        //TODO : if user doesn't select a photo, leave the old photo
        $form = $this->createForm(PlantType::class, $plant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('plant');
             if ($file){
                $file = $file['photoFile'];
                //saving the photo to disk
                $uploads_directory = $this->getParameter('plants_upload_directory'); //defined in services.yaml
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                //leave the old file, it will be recorded in the stages
                 // TODO : check here
                 //problem: may exist a record in the stage_history that is wrong (?)
                //---delete the old file---------------------------------
              /*  $filesystem = new Filesystem();
                try {
                    $uploads_directory = $this->getParameter('plants_upload_directory');
                    $filesystem->remove($uploads_directory.'/'.$oldfile);
                    //https://symfony.com/doc/current/components/filesystem.html#remove
                } catch (IOExceptionInterface $exception) {
                    echo "An error occurred while creating your directory at ".$exception->getPath();
                }*/
                //-----------------------------------------
            }
            $plant->setPhoto($filename);
            $plant->setName($form->get('name')->getData());
            $plant->setIdSpecies($form->get('id_species')->getData());
            $plant->setIdMedium($form->get('id_medium')->getData());
            $plant->setIdStage($form->get('id_stage')->getData());
            $plant->setIdPlace($form->get('id_place')->getData());
            $plant->setOwnerId($user);
            //$plant->setIdPlace($place);

            //prepare a StageHistory object to save in the stage_history table the photo and the stage + date
            $record = new StageHistory();
            $record->setIdStage($form->get('id_stage')->getData());
            $record->setDate(new \DateTime('now'));
            $record->setPhoto($filename);
            //will save the plant into the database and then get the id
           $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plant);
            $entityManager->flush();
            $plantId = $plant->getId();
            $record->setIdPlant($plant);

          /*  var_dump($plant);
            var_dump($record);*/
          $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            return $this->redirectToRoute('user_account');
        }

        return $this->render('user_account/plant-edit.html.twig', [
            'plantForm' => $form->createView(),
            'edit' => false,
        ]);
        //TODO : continue
    }


    /**
     * @Route("/user/edit/the/plant/with/{id}", name="user-edit-plant",  methods={"POST", "GET"}, options={"expose"=true})
     */
    //don't change the path of the route, it's used in app.js ('plant', 'edit')
    function editPlantWithCropper(UserInterface $user, Request $request, $id){
        //checking to see if the user has right to do this
        $plant= $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_DELETE',  $plant);

        // $place = $this->placeRepository->find($id);
        $oldfile = $plant->getPhoto();
        //TODO : if user doesn't select a photo, leave the old photo
        $form = $this->createForm(PlantType::class, $plant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $_FILES['file'];
           // $file = $request->files->get('plant');
            if ($file){
                $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type']);
            //    $file = $file['photoFile'];
                //saving the photo to disk
                $uploads_directory = $this->getParameter('plants_upload_directory'); //defined in services.yaml
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                //leave the old file, it will be recorded in the stages
                // TODO : check here
                //problem: may exist a record in the stage_history that is wrong (?)
                //---delete the old file---------------------------------
                /*  $filesystem = new Filesystem();
                  try {
                      $uploads_directory = $this->getParameter('plants_upload_directory');
                      $filesystem->remove($uploads_directory.'/'.$oldfile);
                      //https://symfony.com/doc/current/components/filesystem.html#remove
                  } catch (IOExceptionInterface $exception) {
                      echo "An error occurred while creating your directory at ".$exception->getPath();
                  }*/
                //-----------------------------------------
            }
            $plant->setPhoto($filename);
            $plant->setName($form->get('name')->getData());
            $plant->setIdSpecies($form->get('id_species')->getData());
            $plant->setIdMedium($form->get('id_medium')->getData());
            $plant->setIdStage($form->get('id_stage')->getData());
            $plant->setIdPlace($form->get('id_place')->getData());
            $plant->setOwnerId($user);
            //$plant->setIdPlace($place);

            //prepare a StageHistory object to save in the stage_history table the photo and the stage + date
            $record = new StageHistory();
            $record->setIdStage($form->get('id_stage')->getData());
            $record->setDate(new \DateTime('now'));
            $record->setPhoto($filename);
            //will save the plant into the database and then get the id
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plant);
            $entityManager->flush();
            $plantId = $plant->getId();
            $record->setIdPlant($plant);

            /*  var_dump($plant);
              var_dump($record);*/
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            return $this->redirectToRoute('user_account');
        }

        return $this->render('user_account/plant-edit.html.twig', [
            'plantForm' => $form->createView(),
            'edit' => false,
        ]);
        //TODO : continue
    }

    /**
     * @Route("/user/delete/the/plant/with/{id}", name="user-delete-plant")
     */
    public function deletePlant($id)
    {
        //checking to see if the user has right to do this
        $plantToDelete  = $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_DELETE',  $plantToDelete);

        $name = $plantToDelete->getName();
        //must delete the plant from all the records: stage_history, action_history
        $filesystem = new Filesystem();
        try {
            $uploads_directory = $this->getParameter('plants_upload_directory');
            $filename = $plantToDelete->getPhoto();
            $filesystem->remove($uploads_directory.'/'.$filename);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }

        $this->entityManager->remove($plantToDelete);
        $this->entityManager->flush();
        $this->addFlash('success', $name .' deleted.');
        // TODO : send a different message for error
        return $this->redirectToRoute('user_account');

        // TODO : send a message
        // TODO : upload files into the assets folder and use webpack watch to save them into the public folder(?)
    }

    /**
     * @Route("/user/view/place/with/{id}", name="user-view-place")
     */
    public function displayPlace($id){
        return $this->render('user_account/place-view.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/user/view/plant/with/{id}", name="user-view-plant")
     */
    public function displayPlant($id){
        $plant= $this->plantRepository->find($id);
        $this->denyAccessUnlessGranted('PLANT_EDIT',  $plant);

        return $this->render('user_account/plant-view.html.twig', [
            'plant' => $plant,
        ]);
    }

    /**
     * @Route("/user/settings", name="user_settings")
     */
    public function userSettings()
    {
        return $this->render('user_account/settings.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

}
