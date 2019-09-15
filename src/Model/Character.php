<?php


namespace App\Model;


class Character implements \JsonSerializable
{

    /**
     * @var int
     */
    private $characterId;
    /**
     * @var string
     */
    private $vorname;
    /**
     * @var string
     */
    private $nachname;

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
     * @return Character
     */
    public function setCharacterId (int $characterId): Character
    {
        $this->characterId = $characterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getVorname (): string
    {
        return $this->vorname;
    }

    /**
     * @param string $vorname
     *
     * @return Character
     */
    public function setVorname (string $vorname): Character
    {
        $this->vorname = $vorname;
        return $this;
    }

    /**
     * @return string
     */
    public function getNachname (): string
    {
        return $this->nachname;
    }

    /**
     * @param string $nachname
     *
     * @return Character
     */
    public function setNachname (string $nachname): Character
    {
        $this->nachname = $nachname;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return [
            'characterId' => $this->characterId,
            'firstname' => $this->vorname,
            'surname' => $this->nachname,
        ];
    }

}