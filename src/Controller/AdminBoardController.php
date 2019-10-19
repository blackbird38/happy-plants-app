<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminBoardController extends AbstractController
{
    private $entityManager;
    private $userRepository;

    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $entityManager){
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
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

        return $this->render('admin_board/index.html.twig', [
            'users' => $users,
            'message' => $message,
        ]);
    }

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
     }
}
