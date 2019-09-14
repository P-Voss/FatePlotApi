<?php


namespace App\Tests;



use App\Service\AuthService;
use App\Tests\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthServiceTest extends TestCase
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AuthService
     */
    private $authService;


    public function setUp (): void
    {
        $this->userRepository = new UserRepository();
        $this->authService = new AuthService($this->userRepository);
    }



    public function testReturnsBoolOnAuthStart ()
    {
        $request = new Request();

        $request->headers->remove('X-AUTH-TOKEN');
        $request->headers->set('X-AUTH-TOKEN', $this->userRepository::INVALID_TOKEN);
        $this->assertIsBool($this->authService->supports($request));
        $request->headers->remove('X-AUTH-TOKEN');
        $request->headers->set('X-AUTH-TOKEN', $this->userRepository::VALID_GM_TOKEN);
        $this->assertIsBool($this->authService->supports($request));
        $request->headers->remove('X-AUTH-TOKEN');
        $request->headers->set('X-AUTH-TOKEN', $this->userRepository::VALID_PLAYER_TOKEN);
        $this->assertIsBool($this->authService->supports($request));
        $request->headers->remove('X-AUTH-TOKEN');
        $this->assertIsBool($this->authService->supports($request));
    }


    public function testCredentialsContainToken ()
    {
        $request = new Request();
        $this->assertArrayHasKey('token', $this->authService->getCredentials($request));
    }


    public function testCredentialsContainPlotId ()
    {
        $request = new Request();
        $this->assertArrayHasKey('plotId', $this->authService->getCredentials($request));
    }

    public function testCredentialsContainEpisodeId ()
    {
        $request = new Request();
        $this->assertArrayHasKey('episodeId', $this->authService->getCredentials($request));
    }


    public function testFailsOnInvalidToken ()
    {
        $credentials = [
            'token' => $this->userRepository::INVALID_TOKEN,
            'plotId' => 0,
            'episodeId' => 0,
        ];
        $this->expectException(AuthenticationException::class);
        $this->authService->getUser($credentials, $this->userRepository);
    }
}