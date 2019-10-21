<?php

namespace App\Controller;

use App\Repository\ActionRepository;
use App\Repository\MediumRepository;
use App\Repository\SpeciesRepository;
use App\Repository\StageRepository;
use App\Repository\UserRepository;
use App\Repository\PlantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserAccountController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $plantRepository;

    public function __construct(UserRepository $userRepository,
                                PlantRepository $plantRepository,
                                MediumRepository $mediumRepository,
                                StageRepository $stageRepository,
                                ActionRepository $actionRepository,
                                SpeciesRepository $speciesRepository,
                                EntityManagerInterface $entityManager){
        $this->userRepository = $userRepository;
        $this->plantRepository = $plantRepository;
        $this->entityManager = $entityManager;
        $this->mediumRepository = $mediumRepository;
        $this->stageRepository = $stageRepository;
        $this->actionRepository = $actionRepository;
        $this->speciesRepository = $speciesRepository;
    }

    /**
     * @Route("/user/account", name="user_account")
     */
    public function index()
    {
        //checking to see if the user has any plants, if it doesn't have, encourage them to upload
      //  $users = $this->userRepository->findAll();

        return $this->render('user_account/index.html.twig', [
            'controller_name' => 'UserAccountController',
        ]);
    }
}
