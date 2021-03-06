<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegisterType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegisterController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this -> createForm(RegisterType::class, $user);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){

            $user = $form -> getData();

            $passwordHashed = $passwordHasher -> hashPassword($user, $user -> getPassword());
            $user -> setPassword($passwordHashed);

            $this -> entityManager -> persist($user);
            $this -> entityManager -> flush();

            return $this->redirectToRoute('app_login');
        }


        
        return $this->render('register/index.html.twig', [
            'form' => $form -> createView()
        ]);
    }
}
