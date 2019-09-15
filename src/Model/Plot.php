<?php


namespace App\Model;


class Plot implements \JsonSerializable
{

    private $plotId;
    private $userId;
    private $name;
    private $description;
    private $isOpen = false;
    private $isActive = false;
    private $isSecret = true;
    private $creationDate;
    private $targetPlayerNumber = 0;
    private $genres = [];
    private $episodes = [];
    private $participants = [];

    /**
     * @return mixed
     */
    public function getPlotId ()
    {
        return $this->plotId;
    }

    /**
     * @param mixed $plotId
     *
     * @return Plot
     */
    public function setPlotId ($plotId)
    {
        $this->plotId = $plotId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId ()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     *
     * @return Plot
     */
    public function setUserId ($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Plot
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Plot
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen (): bool
    {
        return $this->isOpen;
    }

    /**
     * @param bool $isOpen
     *
     * @return Plot
     */
    public function setIsOpen (bool $isOpen): Plot
    {
        $this->isOpen = $isOpen;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive (): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return Plot
     */
    public function setIsActive (bool $isActive): Plot
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecret (): bool
    {
        return $this->isSecret;
    }

    /**
     * @param bool $isSecret
     *
     * @return Plot
     */
    public function setIsSecret (bool $isSecret): Plot
    {
        $this->isSecret = $isSecret;
        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws \Exception
     */
    public function getCreationDate ($format = 'Y-m-d H:i:s')
    {
        if ($this->creationDate === null) {
            $currentDate = new \DateTime('now');
            $this->creationDate = $currentDate->format($format);
        }
        $creationDate = new \DateTime($this->creationDate);
        return $creationDate->format($format);
    }

    /**
     * @param string $creationDate
     *
     * @return Plot
     */
    public function setCreationDate ($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getTargetPlayerNumber (): int
    {
        return $this->targetPlayerNumber;
    }

    /**
     * @param int $targetPlayerNumber
     *
     * @return Plot
     */
    public function setTargetPlayerNumber (int $targetPlayerNumber): Plot
    {
        $this->targetPlayerNumber = $targetPlayerNumber;
        return $this;
    }

    /**
     * @return array
     */
    public function getGenres (): array
    {
        return $this->genres;
    }

    /**
     * @param array $genres
     *
     * @return Plot
     */
    public function setGenres (array $genres): Plot
    {
        $this->genres = $genres;
        return $this;
    }

    /**
     * @return array
     */
    public function getEpisodes (): array
    {
        return $this->episodes;
    }

    /**
     * @param array $episodes
     *
     * @return Plot
     */
    public function setEpisodes (array $episodes): Plot
    {
        $this->episodes = $episodes;
        return $this;
    }

    /**
     * @param Episode $episode
     *
     * @return Plot
     */
    public function addEpisode (Episode $episode): Plot
    {
        $this->episodes[] = $episode;
        return $this;
    }

    /**
     * @return array
     */
    public function getParticipants (): array
    {
        return $this->participants;
    }

    /**
     * @param Character[] $participants
     *
     * @return Plot
     */
    public function setParticipants (array $participants): Plot
    {
        $this->participants = $participants;
        return $this;
    }

    /**
     * @param Character $participant
     *
     * @return Plot
     */
    public function addParticipant (Character $participant): Plot
    {
        $this->participants[] = $participant;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize ()
    {
        return [
            'plotId' => $this->plotId,
            'userId' => $this->userId,
            'name' => $this->name,
            'description' => $this->description,
            'isOpen' => $this->isOpen,
            'isActive' => $this->isActive,
            'isSecret' => $this->isSecret,
            'creationDate' => $this->creationDate,
            'targetPlayerNumber' => $this->targetPlayerNumber,
            'participants' => array_map(function (Character $character) {return $character->jsonSerialize();}, $this->participants),
            'episodes' => array_map(function (Episode $episode) {return $episode->jsonSerialize();}, $this->episodes),
        ];
    }


}