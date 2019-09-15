<?php


namespace App\Service\Gm;


use App\Repository\PlotGenreRepository;
use App\Repository\PlotRepository;
use App\Service\AbstractPlotService;

class ServiceFactory implements \App\Service\ServiceFactory
{

    /**
     * @var PlotRepository
     */
    private $plotRepository;
    /**
     * @var PlotGenreRepository
     */
    private $plotGenreRepository;

    /**
     * ServiceFactory constructor.
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
     * @return AbstractPlotService
     */
    public function getPlotService (): AbstractPlotService
    {
        return new PlotService($this->plotRepository, $this->plotGenreRepository);
    }

    public function getEpisodeService ()
    {
        // TODO: Implement getEpisodeService() method.
    }

    public function getEvaluationService ()
    {
        // TODO: Implement getEvaluationService() method.
    }

    public function getLogService ()
    {
        // TODO: Implement getLogService() method.
    }


}