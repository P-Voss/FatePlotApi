<?php


namespace App\Service;


use App\Exception\PermissionDeniedException;
use App\Model\Plot;
use App\Repository\PlotRepository;
use Exception;

abstract class AbstractPlotService
{

    /**
     * @var PlotRepository
     */
    protected $plotRepository;

    /**
     * AbstractPlotService constructor.
     *
     * @param PlotRepository $plotRepository
     */
    public function __construct (PlotRepository $plotRepository)
    {
        $this->plotRepository = $plotRepository;
    }


    public function createPlot (Plot $plot)
    {

    }

    public function fetchUserPlots (int $userId)
    {

    }


    public function fetchCharacterPlots (int $characterId)
    {

    }

    /**
     * @return array
     */
    public function fetchPublicPlots ()
    {
        try {
            return $this->plotRepository->fetchPublicPlots();
        } catch (Exception $exception) {
            return [];
        }
    }


    abstract public function fetchPlot (int $plotId): Plot;

    /**
     * @param Plot $plot
     * @throws PermissionDeniedException
     * @throws Exception
     */
    abstract public function closePlot (Plot $plot): void ;

    /**
     * @param Plot $plot
     * @param int $characterId
     */
    abstract public function inviteCharacter (Plot $plot, int $characterId);

    /**
     * @param Plot $plot
     * @param int $characterId
     */
    abstract public function kickCharacter (Plot $plot, int $characterId);

}