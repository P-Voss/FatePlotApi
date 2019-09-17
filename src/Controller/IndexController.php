<?php


namespace App\Controller;


use App\Model\Plot;
use App\Service\ServiceFactory;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
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
     * @Route("/", name="index")
     * @param ServiceFactory $serviceFactory
     *
     * @return JsonResponse
     */
    public function index(ServiceFactory $serviceFactory)
    {
        $plotService = $serviceFactory->getPlotService();
        $user = $this->userService->getUser();

        $publicPlots = $plotService->fetchPublicPlots();
        $ownPlots = $plotService->fetchUserPlots($user->getUserId());
        $participantPlots = $plotService->fetchCharacterPlots($user->getCharacterId());

        return new JsonResponse(
            [
                'publicPlots' => array_map(function (Plot $plot) {
                    $plotData = $plot->jsonSerialize();
                    $plotData['links'] = [
                        'self' => [
                            'rel' => 'plots',
                            'type' => 'GET',
                            'href' => $this->generateUrl('get_plot', ['plotId' => $plot->getPlotId()])
                        ]
                    ];
                    return $plotData;
                }, $publicPlots),
                'ownPlots' => array_map(function (Plot $plot) {
                    $plotData = $plot->jsonSerialize();
                    $plotData['links'] = [
                        'self' => [
                            'rel' => 'plots',
                            'type' => 'GET',
                            'href' => $this->generateUrl('get_plot', ['plotId' => $plot->getPlotId()])
                        ]
                    ];
                    return $plotData;
                }, $ownPlots),
                'participantPlots' => array_map(function (Plot $plot) {
                    $plotData = $plot->jsonSerialize();
                    $plotData['links'] = [
                        'self' => [
                            'rel' => 'plots',
                            'type' => 'GET',
                            'href' => $this->generateUrl('get_plot', ['plotId' => $plot->getPlotId()])
                        ]
                    ];
                    return $plotData;
                }, $participantPlots),
                'plotGenres' => $plotService->getPlotgenres(),
                'links' => [
                    'createPlot' => [
                        'href' => $this->generateUrl('create_plot'),
                        'rel' => 'plots',
                        'method' => 'POST'
                    ],
                    'index' => [
                        'href' => $this->generateUrl('index'),
                        'rel' => 'plots',
                        'method' => 'GET'
                    ]
                ]
            ]
        );
    }

}