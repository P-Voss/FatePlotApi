<?php


namespace App\Service;


interface ServiceFactory
{


    public function getPlotService ();


    public function getEpisodeService ();


    public function getEvaluationService ();


    public function getLogService ();

}