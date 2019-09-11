<?php


namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * Class AuthService
 * @package App\Service
 */
class AuthService extends AbstractGuardAuthenticator
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct (UserRepository $userRepository)
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
        return $request->headers->has('X-AUTH-TOKEN');
    }

    /**
     * @param Request $request
     *
     * @return mixed|void
     */
    public function getCredentials (Request $request)
    {
        return [
            'token' => $request->headers->get('X-AUTH-TOKEN'),
            'episodeId' => (int) $request->get('episodeId', 0),
            'plotId' => (int) $request->get('plotId', 0),
        ];
    }

    /**
     * @param array $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface
     */
    public function getUser ($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $this->userRepository->getUser($credentials['token'], $credentials['plotId'], $credentials['episodeId']);
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            exit;
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
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success
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