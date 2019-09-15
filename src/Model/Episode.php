<?php


namespace App\Model;


class Episode implements \JsonSerializable
{

    /**
     * @var int
     */
    private $episodeId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $creationDate;
    /**
     * @var int
     */
    private $currentState = EpisodeState::EPISODE_STATE_PLANNING;
    /**
     * @var Character[]
     */
    private $participants = [];

    /**
     * @return int
     */
    public function getEpisodeId (): int
    {
        return $this->episodeId;
    }

    /**
     * @param int $episodeId
     *
     * @return Episode
     */
    public function setEpisodeId (int $episodeId): Episode
    {
        $this->episodeId = $episodeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Episode
     */
    public function setName (string $name): Episode
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription (): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Episode
     */
    public function setDescription (string $description): Episode
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreationDate (): string
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     *
     * @return Episode
     */
    public function setCreationDate (string $creationDate): Episode
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentState (): int
    {
        return $this->currentState;
    }

    /**
     * @param int $currentState
     *
     * @return Episode
     */
    public function setCurrentState (int $currentState): Episode
    {
        $this->currentState = $currentState;
        return $this;
    }

    /**
     * @return Character[]
     */
    public function getParticipants (): array
    {
        return $this->participants;
    }

    /**
     * @param Character[] $participants
     *
     * @return Episode
     */
    public function setParticipants (array $participants): Episode
    {
        $this->participants = $participants;
        return $this;
    }

    /**
     * @param Character $participant
     *
     * @return Episode
     */
    public function addParticipant (Character $participant): Episode
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
            'episodeId' => $this->episodeId,
            'name' => $this->name,
            'description' => $this->description,
            'creationDate' => $this->creationDate,
            'currentState' => $this->currentState,
            'participants' => array_map(function (Character $character) {return $character->jsonSerialize();}, $this->participants),
        ];
    }


}