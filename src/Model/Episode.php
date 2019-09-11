<?php


namespace App\Model;


class Episode
{

    private $episodeId;
    private $name;
    private $description;
    private $creationDate;
    private $currentState = EpisodeState::EPISODE_STATE_PLANNING;
    private $participants = [];


}