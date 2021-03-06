<?php


namespace App\Tests\Mock\Service;


use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class AuthService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct (UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return Response|void
     */
    public function start (Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports (Request $request)
    {
        return true;
    }

    /**
     * @param Request $request
     *
     * @return mixed|void
     */
    public function getCredentials (Request $request)
    {
        return [
            'token' => $request->headers->get('X-AUTH-TOKEN', ''),
            'episodeId' => (int) $request->get('episodeId', 0),
            'plotId' => (int) $request->get('plotId', 0),
        ];
    }

    /**
     * @param array $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface
     * @throws \Exception
     */
    public function getUser ($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $this->userRepository->getUser($credentials['token'], $credentials['plotId'], $credentials['episodeId']);
        } catch (\Exception $exception) {
            throw new AuthenticationException('User does not exist');
        }
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool|void
     */
    public function checkCredentials ($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|void|null
     */
    public function onAuthenticationFailure (Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return Response|void|null
     */
    public function onAuthenticationSuccess (Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    /**
     * @return bool|void
     */
    public function supportsRememberMe ()
    {
        return false;
    }

    /**
     * Shortcut to create a PostAuthenticationGuardToken for you, if you don't really
     * care about which authenticated token you're using.
     *
     * @param UserInterface $user
     * @param string $providerKey
     *
     * @return PostAuthenticationGuardToken
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        return new PostAuthenticationGuardToken(
            $user,
            $providerKey,
            []
        );
    }


}