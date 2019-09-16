<?php


namespace App\Repository;


use App\Model\Episode;
use Doctrine\DBAL\Connection;

class EpisodeRepository
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * EpisodeRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->db = $connection;
    }

    /**
     * @param int $episodeId
     *
     * @return Episode
     * @throws \Exception
     */
    public function load (int $episodeId)
    {
        $stmt = $this->db->prepare('SELECT * FROM episoden WHERE episodenId = ?');
        $stmt->execute([$episodeId]);
        $row = $stmt->fetch();
        $episode = new Episode();
        $episode->setName($row['name'])
            ->setDescription($row['description'])
            ->setCurrentState($row['statusId'])
            ->setCreationDate($row['creationdate']);
        return $episode;
    }

    /**
     * @param int $plotId
     *
     * @return array
     */
    public function fetchEpisodesByPlotId (int $plotId)
    {
        try {
            $episodes = [];
            $stmt = $this->db->prepare('SELECT * FROM episoden WHERE plotId = ?');
            $stmt->execute([$plotId]);
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $episode = new Episode();
                $episode->setName($row['name'])
                    ->setDescription($row['description'])
                    ->setCurrentState($row['statusId'])
                    ->setCreationDate($row['creationdate']);
                $episodes[] = $episode;
            }
            return $episodes;
        } catch (\Exception $exception) {
            return [];
        }
    }


}