<?php


namespace App\Tests\Mock\Repository;


use App\Model\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository implements UserRepositoryInterface, UserProviderInterface
{

    const VALID_PLAYER_TOKEN = "valid";
    const VALID_GM_TOKEN = "GM";
    const INVALID_TOKEN = "invalid";

    /**
     * @var array
     */
    private $plots = [
        1 => [
            'GM' => self::VALID_GM_TOKEN,
            'players' => [self::VALID_GM_TOKEN, self::VALID_PLAYER_TOKEN],
            'episodes' => [1, 2, 4, 6]
        ],
        2 => [
            'GM' => self::VALID_GM_TOKEN,
            'players' => [self::VALID_GM_TOKEN],
            'episodes' => [3, 5]
        ]
    ];
    private $episodes = [
        1 => [
            'players' => [self::VALID_GM_TOKEN]
        ],
        2 => [
            'players' => [self::VALID_GM_TOKEN, self::VALID_PLAYER_TOKEN]
        ],
        3 => [
            'players' => [self::VALID_GM_TOKEN]
        ],
        4 => [
            'players' => [self::VALID_GM_TOKEN, self::VALID_PLAYER_TOKEN]
        ],
        5 => [
            'players' => [self::VALID_GM_TOKEN]
        ],
        6 => [
            'players' => [self::VALID_GM_TOKEN, self::VALID_PLAYER_TOKEN]
        ],
    ];

    private $gms = [self::VALID_GM_TOKEN];

    private $players = [self::VALID_GM_TOKEN, self::VALID_PLAYER_TOKEN];

    /**
     * @param string $accessToken
     *
     * @return UserInterface
     * @throws \Exception
     */
    public function loadUserByUsername ($accessToken)
    {
        return $this->getUser($accessToken, 0 , 0);
    }

    public function refreshUser (UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass ($class): bool
    {
        return User::class === $class;
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
        if (!in_array($accessToken, $this->players)) {
            throw new \Exception('User does not exist');
        }
        if ((int) $plotId === null && (int) $episodeId === null) {
            $user = new User();
            $user->addRole(User::USER_ROLE_PLAYER);
            return $user;
        }

        if ($plotId > 0) {
            if (!isset($this->plots[$plotId])) {
                throw new \Exception('Plot does not exist');
            }
            if ($this->plots[$plotId]['GM'] === $accessToken) {
                $user = new User();
                $user->addRole(User::USER_ROLE_GM)
                    ->addRole(User::USER_ROLE_PLAYER);
                return $user;
            }
        }

        $user = new User();
        $user->addRole(User::USER_ROLE_PLAYER);
        return $user;
    }

    public function getCharacter (string $accessToken)
    {
        // TODO: Implement getCharacter() method.
    }


}