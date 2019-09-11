<?php


namespace App\Service\Gm;

use App\Model\Plot;
use App\Service\AbstractPlotService;
use Exception;

class PlotService extends AbstractPlotService
{



    public function fetchPlot (int $plotId): Plot
    {
        // TODO: Implement fetchPlot() method.
    }

    public function closePlot (Plot $plot): void
    {
        // TODO: Implement closePlot() method.
    }

    public function inviteCharacter (Plot $plot, int $characterId)
    {
        // TODO: Implement inviteCharacter() method.
    }

    public function kickCharacter (Plot $plot, int $characterId)
    {
        // TODO: Implement kickCharacter() method.
    }


}