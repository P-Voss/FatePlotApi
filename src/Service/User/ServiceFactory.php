<?php


namespace App\Service\User;


use App\Repository\PlotRepository;

class ServiceFactory implements \App\Service\ServiceFactory
{

    /**
     * @var PlotRepository
     */
    private $plotRepository;

    /**
     * ServiceFactory constructor.
     *
     * @param PlotRepository $plotRepository
     */
    public function __construct (PlotRepository $plotRepository)
    {
        $this->plotRepository = $plotRepository;
    }

    /**
     * @return PlotService
     */
    public function getPlotService ()
    {
        return new PlotService($this->plotRepository);
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