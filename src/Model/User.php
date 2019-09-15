<?php


namespace App\Model;


use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Model
 */
class User implements UserInterface
{

    const USER_ROLE_GM = 'ROLE_GM';
    const USER_ROLE_PLAYER = 'ROLE_PLAYER';

    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $username = '';
    /**
     * @var string
     */
    private $characterName = '';
    /**
     * @var int
     */
    private $characterId;
    /**
     * @var array
     */
    private $roles = [];


    /**
     * @return int
     */
    public function getUserId (): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return User
     */
    public function setUserId (int $userId): User
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles ()
    {
        return $this->roles;
    }

    /**
     * @return string|null
     */
    public function getPassword ()
    {
        return '';
    }

    /**
     * @return string|null
     */
    public function getSalt ()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getUsername ()
    {
        return $this->username;
    }

    /**
     *
     */
    public function eraseCredentials ()
    {

    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername (string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return int
     */
    public function getCharacterId (): int
    {
        return $this->characterId;
    }

    /**
     * @param int $characterId
     *
     * @return User
     */
    public function setCharacterId (int $characterId): User
    {
        $this->characterId = $characterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharacterName ()
    {
        return $this->characterName;
    }

    /**
     * @param string $characterName
     *
     * @return User
     */
    public function setCharacterName ($characterName)
    {
        $this->characterName = $characterName;
        return $this;
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function addRole (string $role)
    {
        $this->roles[] = $role;
        return $this;
    }

}