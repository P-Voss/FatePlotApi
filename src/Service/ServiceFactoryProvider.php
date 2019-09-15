<?php


namespace App\Service;


use App\Model\User;
use App\Repository\PlotGenreRepository;
use App\Repository\PlotRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Security;

class ServiceFactoryProvider
{

    /**
     * @param Security $security
     *
     * @param Connection $connection
     *
     * @return ServiceFactory
     */
    public static function createFactory (Security $security, Connection $connection)
    {
        if (in_array(User::USER_ROLE_GM, $security->getUser()->getRoles())){
            $serviceFactory = new \App\Service\Gm\ServiceFactory(
                new PlotRepository($connection),
                new PlotGenreRepository($connection)
            );
        } else {
            $serviceFactory = new \App\Service\User\ServiceFactory(
                new PlotRepository($connection),
                new PlotGenreRepository($connection)
            );
        }

        return $serviceFactory;
    }

}