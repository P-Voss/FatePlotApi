<?php


namespace App\Service\User;


use App\Exception\PermissionDeniedException;
use App\Model\Plot;
use App\Service\AbstractPlotService;
use Exception;

class PlotService extends AbstractPlotService
{

    /**
     * @param int $plotId
     *
     * @return Plot
     * @throws PermissionDeniedException
     */
    public function fetchPlot (int $plotId): Plot
    {
        throw new PermissionDeniedException('User may not execute this action.');
    }

    /**
     * @param Plot $plot
     *
     * @throws PermissionDeniedException
     */
    public function closePlot (Plot $plot): void
    {
        throw new PermissionDeniedException('User may not execute this action.');
    }

    /**
     * @param Plot $plot
     * @param int $characterId
     *
     * @throws PermissionDeniedException
     */
    public function inviteCharacter (Plot $plot, int $characterId)
    {
        throw new PermissionDeniedException('User may not execute this action.');
    }

    /**
     * @param Plot $plot
     * @param int $characterId
     *
     * @throws PermissionDeniedException
     */
    public function kickCharacter (Plot $plot, int $characterId)
    {
        throw new PermissionDeniedException('User may not execute this action.');
    }


}