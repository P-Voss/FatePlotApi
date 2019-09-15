<?php


namespace App\Service;


interface ServiceFactory
{

    /**
     * @return AbstractPlotService
     */
    public function getPlotService (): AbstractPlotService;


    public function getEpisodeService ();


    public function getEvaluationService ();


    public function getLogService ();

    /**
     * @return UserService
     */
    public function getUserService (): UserService;

}