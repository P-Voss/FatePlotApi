<?php


namespace App\Service;

use App\Model\User;
use Symfony\Component\Security\Core\Security;

class UserService
{

    /**
     * @var Security
     */
    private $securityService;

    /**
     * UserService constructor.
     *
     * @param Security $securityService
     */
    public function __construct (Security $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * @return User
     */
    public function getUser (): User
    {
        /** @var User $user */
        $user = $this->securityService->getUser();
//        var_dump($this->securityService->isGranted())
        return $user;
    }

}