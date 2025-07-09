<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response, RedirectResponse, JsonResponse, Cookie};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
#[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
public function login(
    Request $request,
    EntityManagerInterface $em,
    UserPasswordHasherInterface $hasher,
    JWTTokenManagerInterface $jwtManager
): Response {
    if ($request->isMethod('GET')) {
        return $this->render('security/login.html.twig', [
            'error' => null
        ]);
    }

    $email = $request->request->get('email');
    $password = $request->request->get('password');

    $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

    if (!$user || !$hasher->isPasswordValid($user, $password)) {
        return $this->render('security/login.html.twig', [
            'error' => 'Email ou mot de passe invalide.'
        ]);
    }

  $jwt = $jwtManager->create($user);

$cookie = Cookie::create(
    'BEARER',
    $jwt,
    time() + 600,
    '/',
    null,
    false,
    true,
    false,
    'Strict'
);


$response = new RedirectResponse($this->generateUrl('app_project_index'));
$response->headers->setCookie($cookie);
return $response;
}


    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
 throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}


// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// class SecurityController extends AbstractController
// {
//     #[Route(path: '/', name: 'app_login')]
// public function login(AuthenticationUtils $authenticationUtils)
// {
//     if ($this->getUser()) {
//         // Si déjà connecté, redirige vers une autre page (ex: tableau de bord)
//         return $this->redirectToRoute('app_user_index');
//     }
    
//     // Sinon, afficher le formulaire login
//     $error = $authenticationUtils->getLastAuthenticationError();
//     $lastUsername = $authenticationUtils->getLastUsername();

//     return $this->render('security/login.html.twig', [
//         'last_username' => $lastUsername,
//         'error' => $error,
//     ]);
// }

//     #[Route(path: '/logout', name: 'app_logout')]
//     public function logout(): void
//     {
//         throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//     }
// }
