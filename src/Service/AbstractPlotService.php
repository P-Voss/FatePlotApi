<?php


namespace App\Service;


use App\Exception\PermissionDeniedException;
use App\Model\Plot;
use App\Repository\PlotRepository;
use App\Repository\UserRepository;
use Exception;

abstract class AbstractPlotService
{

    /**
     * @var PlotRepository
     */
    protected $plotRepository;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * AbstractPlotService constructor.
     *
     * @param PlotRepository $plotRepository
     * @param UserRepository $userRepository
     */
    public function __construct (PlotRepository $plotRepository, UserRepository $userRepository)
    {
        $this->plotRepository = $plotRepository;
        $this->userRepository = $userRepository;
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