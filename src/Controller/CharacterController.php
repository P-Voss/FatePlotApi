<?php


namespace App\Controller;

use App\Model\Plot;
use App\Service\ServiceFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CharacterController extends AbstractController
{

    public function PlotcharacterAction ()
    {

    }


    /**
     * @Route("/invite/{$plotId}/{$characterId}", name="invite_character", methods={"POST"})
     *
     * @param $plotId
     * @param $characterId
     *
     * @return JsonResponse
     */
    public function InviteAction ($plotId, $characterId)
    {
        $id = 12;
        return new JsonResponse(
            [
                '_links' => [
                    'plot' => [
                        'href' => $this->generateUrl('get_plot', ['plotId' => $plotId]),
                        'rel' => 'plots',
                        'method' => 'GET'
                    ],
                    'kickCharacter' => [
                        'href' => $this->generateUrl('kick_character', ['plotId' => $plotId, 'characterPlotId' => $id]),
                        'rel' => 'characters',
                        'method' => 'DELETE'
                    ]
                ],
            ]
        );
    }


    /**
     * @Route("/invite/{$plotId}/{$characterPlotId}", name="kick_character", methods={"DELETE"})
     *
     * @param $plotId
     * @param $characterPlotId
     *
     * @return JsonResponse
     */
    public function KickAction ($plotId, $characterPlotId)
    {
        return new JsonResponse(
            [
                '_links' => [
                    'plot' => [
                        'href' => $this->generateUrl('get_plot', ['plotId' => $plotId]),
                        'rel' => 'plots',
                        'method' => 'GET'
                    ]
                ],
            ]
        );
    }


    public function FilterAction ()
    {

    }


}