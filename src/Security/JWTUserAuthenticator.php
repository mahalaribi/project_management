<?php

namespace App\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class JWTUserAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private JWTTokenManagerInterface $jwtManager;
    private UserProviderInterface $userProvider;

    public function __construct(JWTTokenManagerInterface $jwtManager, UserProviderInterface $userProvider)
    {
        $this->jwtManager = $jwtManager;
        $this->userProvider = $userProvider;
    }

    public function supports(Request $request): ?bool
    {
        return $request->cookies->has('BEARER');
    }

    public function authenticate(Request $request): Passport
    {
        $token = $request->cookies->get('BEARER');

        if (!$token) {
            throw new AuthenticationException('Aucun token trouvé dans les cookies.');
        }

        try {
            $payload = $this->jwtManager->parse($token);
            $username = $payload['username'] ?? null;

            if (!$username) {
                throw new AuthenticationException('Nom d’utilisateur introuvable dans le token.');
            }

            return new SelfValidatingPassport(
                new UserBadge($username, fn ($userIdentifier) => $this->userProvider->loadUserByIdentifier($userIdentifier))
            );
        } catch (\Exception $e) {
            throw new AuthenticationException('Token invalide ou expiré.');
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Laisser passer la requête
        return null;
    }
public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
{
    return new RedirectResponse('/login');
}

public function start(Request $request, AuthenticationException $authException = null): Response
{
    // Redirige vers la route /login
    return new RedirectResponse('/login');

}

}
