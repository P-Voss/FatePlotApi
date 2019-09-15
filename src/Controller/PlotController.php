<?php


namespace App\Controller;


use App\Model\Plot;
use App\Service\ServiceFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlotController
{

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    /**
     * IndexController constructor.
     *
     * @param ServiceFactory $serviceFactory
     */
    public function __construct (ServiceFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * @Route("/plot/create", methods={"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create (Request $request)
    {
        $plotService = $this->serviceFactory->getPlotService();
        $userService = $this->serviceFactory->getUserService();
        $plot = new Plot();
        $plot->setName($request->get('name'))
            ->setDescription($request->get('description'))
            ->setTargetPlayerNumber($request->get('targetPlayerNumber'))
            ->setIsActive(0)
            ->setIsOpen((bool) $request->get('isOpen', false))
            ->setIsSecret((bool) $request->get('isSecret', false))
            ->setUserId($userService->getUser()->getUserId())
            ->setGenres($request->get('genres', []));
        try {
            $plotId = $plotService->createPlot($plot);
            return new JsonResponse([
                'success' => true,
                'plotId' => $plotId,
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

}