<?php


namespace App\Service;


use App\Exception\PermissionDeniedException;
use App\Model\Plot;
use App\Repository\PlotGenreRepository;
use App\Repository\PlotRepository;
use Exception;

abstract class AbstractPlotService
{

    /**
     * @var PlotRepository
     */
    protected $plotRepository;
    /**
     * @var PlotGenreRepository
     */
    private $plotGenreRepository;

    /**
     * AbstractPlotService constructor.
     *
     * @param PlotRepository $plotRepository
     * @param PlotGenreRepository $plotGenreRepository
     */
    public function __construct (PlotRepository $plotRepository, PlotGenreRepository $plotGenreRepository)
    {
        $this->plotRepository = $plotRepository;
        $this->plotGenreRepository = $plotGenreRepository;
    }


    public function createPlot (Plot $plot)
    {

    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function fetchUserPlots (int $userId): array
    {
        try {
            return $this->plotRepository->fetchOwnPlots($userId);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param int $characterId
     *
     * @return Plot[]|array
     */
    public function fetchCharacterPlots (int $characterId)
    {
        try {
            return $this->plotRepository->fetchParticipantsPlot($characterId);
        } catch (Exception $exception) {
            return [];
        }
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

    /**
     * @return array
     */
    public function getPlotgenres ()
    {
        return $this->plotGenreRepository->fetchAvailableGenres();
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