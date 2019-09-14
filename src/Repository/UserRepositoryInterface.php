<?php


namespace App\Repository;


use App\Model\User;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserRepositoryInterface
{

    /**
     * @param string $accessToken
     *
     * @return User|UserInterface|null
     * @throws DBALException
     * @throws \Exception
     */
    public function loadUserByUsername ($accessToken);

    /**
     * @param UserInterface $user
     *
     * @return User
     */
    public function refreshUser (UserInterface $user);

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass ($class):bool;


    /**
     * @param string $accessToken
     * @param int $plotId
     * @param int $episodeId
     *
     * @return User
     * @throws \Exception
     */
    public function getUser (string $accessToken, int $plotId, int $episodeId):UserInterface;

    public function getCharacter (string $accessToken);
}