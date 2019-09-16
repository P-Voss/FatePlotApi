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

    /**
     * @param int $plotId
     *
     * @return Plot
     */
    abstract public function load (int $plotId): Plot;

    /**
     * @param Plot $plot
     *
     * @return string
     * @throws Exception
     */
    public function createPlot (Plot $plot)
    {
        try {
            $plotId = $this->plotRepository->create($plot);
        } catch (Exception $exception) {
            throw new Exception("Could not create Plot");
        }
        try {
            $this->plotGenreRepository->setPlotGenres($plotId, $plot->getGenres());
        } catch (Exception $exception) {}
        return $plotId;
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
     * @return Plot[]
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