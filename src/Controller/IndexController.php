<?php


namespace App\Controller;


use App\Service\User\ServiceFactory;
use App\Service\UserService;
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
     */
    public function index()
    {
        var_dump($this->userService->getUser());
        exit;
        $plotService = $serviceFactory->getPlotService();


    }

}