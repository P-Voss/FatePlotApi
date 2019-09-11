<?php


namespace App\Controller;


use App\Service\User\ServiceFactory;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * IndexController constructor.
     *
     * @param Request $request
     */
//    public function __construct (Request $request)
//    {
//        if (!$this->auth($request)) {
//            exit('no login');
//        }
//        $user = $this->getServiceFactory($request);
//    }

    /**
     * @Route("/")
     * @param \App\Service\ServiceFactory $serviceFactory
     *
     * @return JsonResponse
     */
    public function index(\App\Service\ServiceFactory $serviceFactory)
    {
        $plotService = $serviceFactory->getPlotService();
//        $plotService->fetchCharacterPlots()
        return new JsonResponse(
            [
                'publicPlots' => $plotService->fetchPublicPlots()
            ]
        );
    }

}