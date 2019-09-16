<?php


namespace App\Service\Gm;

use App\Model\Plot;
use App\Repository\EpisodeRepository;
use App\Repository\PlotGenreRepository;
use App\Repository\PlotRepository;
use App\Repository\UserRepository;
use App\Service\AbstractPlotService;
use Exception;

class PlotService extends AbstractPlotService
{

    /**
     * @var EpisodeRepository
     */
    private $episodeRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * PlotService constructor.
     *
     * @param PlotRepository $plotRepository
     * @param PlotGenreRepository $plotGenreRepository
     * @param EpisodeRepository $episodeRepository
     * @param UserRepository $userRepository
     */
    public function __construct (
        PlotRepository $plotRepository,
        PlotGenreRepository $plotGenreRepository,
        EpisodeRepository $episodeRepository,
        UserRepository $userRepository)
    {
        parent::__construct($plotRepository, $plotGenreRepository);
        $this->episodeRepository = $episodeRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $plotId
     *
     * @return Plot
     * @throws Exception
     */
    public function load (int $plotId): Plot
    {
        $plot = $this->plotRepository->load($plotId);
        $plot->setEpisodes($this->episodeRepository->fetchEpisodesByPlotId($plotId));

        return $plot;
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