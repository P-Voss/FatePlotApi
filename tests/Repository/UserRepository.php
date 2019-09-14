<?php


namespace App\Tests\Repository;


use App\Model\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository implements UserRepositoryInterface, UserProviderInterface
{

    const VALID_PLAYER_TOKEN = "valid";
    const VALID_GM_TOKEN = "GM";
    const INVALID_TOKEN = "invalid";


    public function loadUserByUsername ($accessToken)
    {
        if ($accessToken === self::VALID_GM_TOKEN) {
            $user = new User();
        }
    }

    public function refreshUser (UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    public function supportsClass ($class): bool
    {
        // TODO: Implement supportsClass() method.
    }

    /**
     * @param string $accessToken
     * @param int $plotId
     * @param int $episodeId
     *
     * @return UserInterface
     * @throws \Exception
     */
    public function getUser (string $accessToken, int $plotId, int $episodeId): UserInterface
    {
        if ($accessToken === self::VALID_PLAYER_TOKEN) {
            $user = new User();
            $user->addRole(User::USER_ROLE_PLAYER);
            return $user;
        }
        if ($accessToken === self::VALID_GM_TOKEN) {
            $user = new User();
            $user->addRole(User::USER_ROLE_PLAYER);
            $user->addRole(User::USER_ROLE_GM);
            return $user;
        }
        throw new \Exception('User does not exist');
    }

    public function getCharacter (string $accessToken)
    {
        // TODO: Implement getCharacter() method.
    }


}