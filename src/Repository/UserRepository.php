<?php


namespace App\Repository;


use App\Model\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository implements UserProviderInterface, UserRepositoryInterface
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * UserRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct (Connection $connection)
    {
        $this->db = $connection;
    }

    /**
     * @param string $accessToken
     *
     * @return User|UserInterface|null
     * @throws DBALException
     * @throws \Exception
     */
    public function loadUserByUsername ($accessToken)
    {
        return $this->getUser($accessToken, 0, 0);
    }

    public function refreshUser (UserInterface $user)
    {
        var_dump('refreshing');
        var_dump($user);
        exit;
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
    }


    /**
     * @param string $accessToken
     * @param int $plotId
     * @param int $episodeId
     *
     * @return User
     * @throws \Exception
     */
    public function getUser (string $accessToken, int $plotId, int $episodeId): UserInterface
    {
        $stmt = $this->db->prepare(
            'SELECT benutzerdaten.userId, profilname, charakter.charakterId, charakter.vorname, charakter.nachname 
            FROM benutzerdaten 
            LEFT JOIN charakter ON charakter.userId = benutzerdaten.userId AND charakter.active = 1
            WHERE accessKey = ?'
        );
        $stmt->execute([$accessToken]);
        if ($stmt->rowCount() === 0) {
            throw new \Exception('User does not exist');
        }
        $result = $stmt->fetch();
        $user = new User();
        $user->setUserId($result['userId'])
            ->setUsername($result['profilname'])
            ->setCharacterId($result['charakterId'])
            ->setCharacterName($result['vorname'] . ' ' . $result['nachname']);

        if ($plotId > 0) {
            if ($this->isPlotGm($user->getUserId(), $plotId)){
                $user->addRole(User::USER_ROLE_GM)
                    ->addRole(User::USER_ROLE_PLAYER);
                return $user;
            }
            if ($this->isPlotPlayer($user->getUserId(), $plotId)) {
                $user->addRole(User::USER_ROLE_PLAYER);
                return $user;
            }

            throw new \Exception('User does not participate');
        }
        if ($episodeId > 0) {
            if ($this->isEpisodeGm($user->getUserId(), $episodeId)) {
                $user->addRole(User::USER_ROLE_GM)
                    ->addRole(User::USER_ROLE_PLAYER);
                return $user;
            }
            if ($this->isEpisodePlayer($user->getUserId(), $episodeId)) {
                $user->addRole(User::USER_ROLE_PLAYER);
                return $user;
            }

            throw new \Exception('User does not participate');
        }
        $user->addRole(User::USER_ROLE_PLAYER);

        return $user;
    }

    /**
     * @param $userId
     * @param $plotId
     *
     * @return bool
     */
    private function isPlotGm($userId, $plotId): bool {
        try {
            $stmt = $this->db->prepare('SELECT * FROM plots WHERE userId = ? AND plotId = ?');
            $stmt->execute([$userId, $plotId]);
            return $stmt->rowCount() > 0;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $userId
     * @param $plotId
     *
     * @return bool
     */
    private function isPlotPlayer($userId, $plotId): bool  {
        try {
            $stmt = $this->db->prepare(
                'SELECT * FROM charakterPlots 
                INNER JOIN charakter ON charakter.charakterId = charakterPlots.charakterId 
                WHERE charakter.userId = ? AND plotId = ?'
            );
            $stmt->execute([$userId, $plotId]);
            return $stmt->rowCount() > 0;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $userId
     * @param $episodeId
     *
     * @return bool
     */
    private function isEpisodeGm($userId, $episodeId): bool  {
        try {
            $stmt = $this->db->prepare(
    'SELECT * FROM episoden
                INNER JOIN plots ON plots.plotId = episoden.episodenId
                WHERE plots.userId = ? AND episoden.episodenId = ?'
            );
            $stmt->execute([$userId, $episodeId]);
            return $stmt->rowCount() > 0;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $userId
     * @param $episodeId
     *
     * @return bool
     */
    private function isEpisodePlayer($userId, $episodeId): bool  {
        try {
            $stmt = $this->db->prepare(
                'SELECT * FROM episodenToCharakter 
                INNER JOIN charakter ON charakter.charakterId = episodenToCharakter.charakterId 
                WHERE charakter.userId = ? AND episodenToCharakter.episodenId = ?'
            );            $stmt->execute([$userId, $episodeId]);
            return $stmt->rowCount() > 0;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getCharacter (string $accessToken)
    {

    }

}