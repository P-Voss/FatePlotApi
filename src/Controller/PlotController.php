<?php


namespace App\Controller;


use App\Model\Plot;
use App\Service\ServiceFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlotController extends AbstractController
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
     * @Route("/plot/create", name="create_plot", methods={"POST"})
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
                'url' => $this->generateUrl('get_plot', ['plotId' => $plotId]),
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @Route("/plot/{plotId}", name="get_plot", methods={"GET"})
     * @param int $plotId
     *
     * @return JsonResponse
     */
    public function show (int $plotId)
    {
        $plotService = $this->serviceFactory->getPlotService();
        $plot = $plotService->load($plotId);
        return new JsonResponse([
            'plot' => $plot
        ]);
    }

}