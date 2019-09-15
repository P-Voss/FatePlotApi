<?php


namespace App\Service\Gm;


use App\Repository\PlotGenreRepository;
use App\Repository\PlotRepository;
use App\Service\AbstractPlotService;
use App\Service\UserService;
use Symfony\Component\Security\Core\Security;

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
     * @var Security
     */
    private $security;

    /**
     * ServiceFactory constructor.
     *
     * @param PlotRepository $plotRepository
     * @param PlotGenreRepository $plotGenreRepository
     */
    public function __construct (PlotRepository $plotRepository, PlotGenreRepository $plotGenreRepository, Security $security)
    {
        $this->plotRepository = $plotRepository;
        $this->plotGenreRepository = $plotGenreRepository;
        $this->security = $security;
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

    /**
     * @return UserService
     */
    public function getUserService (): UserService
    {
        return new UserService($this->security);
    }


}