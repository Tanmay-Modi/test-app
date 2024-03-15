<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Service\UserService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{

    public function __construct(private readonly UserRepository $userRepository, private UserService $userService)
    {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/create', name: 'create_user', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->userService->createUser($user);
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_user', methods: ['POST', 'GET'])]
    public function edit(Request $request, $id)
    {

        $user =  $this->userRepository->find($id);
        if (!$user) {
            return new Response(
                'No User Found'
            );
        }
        $form = $this->createForm(UserFormType::class, $user, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->userService->createUser($user);
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_user', methods: ['GET'])]
    public function delete($id)
    {

        $user =  $this->userRepository->find($id);
        if (!$user) {
            return new Response(
                'No User Found'
            );
        }

        $this->userService->deleteUser($user);
        $this->addFlash('success', 'User deleted successfully.');
        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
}
