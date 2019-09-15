<?php


namespace App\Controller;


use App\Service\ServiceFactory;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * IndexController constructor.
     *
     * @param UserService $userService
     */
    public function __construct (UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/")
     * @param ServiceFactory $serviceFactory
     *
     * @return JsonResponse
     */
    public function index(ServiceFactory $serviceFactory)
    {
        $plotService = $serviceFactory->getPlotService();
        $user = $this->userService->getUser();
        return new JsonResponse(
            [
                'publicPlots' => $plotService->fetchPublicPlots(),
                'ownPlots' => $plotService->fetchUserPlots($user->getUserId()),
                'participantPlots' => $plotService->fetchCharacterPlots($user->getCharacterId()),
                'plotGenres' => $plotService->getPlotgenres()
            ]
        );
    }

}