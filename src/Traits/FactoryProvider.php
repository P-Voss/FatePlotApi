<?php


namespace App\Traits;


use App\Service\User\ServiceFactory;
use Symfony\Component\HttpFoundation\Request;

trait FactoryProvider
{


    public function getFactory (Request $request)
    {
//        return new ServiceFactory()
    }


    public function getFactoryByPlot (Request $request)
    {

    }


    public function getFactoryByEpisode (Request $request)
    {

    }

}