<?php


namespace App\Repository;


use Doctrine\DBAL\Connection;

class PlotGenreRepository
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * PlotGenreRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct (Connection $connection)
    {
        $this->db = $connection;
    }

    /**
     * @return array
     */
    public function fetchAvailableGenres ()
    {
        return [
            'Horror', 'Mystery', 'Action', 'Comedy', 'Romance', 'Slice of Life', 'Sport', 'Drama', 'Krimi', 'Forschung'
        ];
    }

    /**
     * @param $plotId
     * @param array $genres
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function setPlotGenres ($plotId, array $genres = [])
    {
        $stmt = $this->db->prepare('INSERT INTO plotGenres (plotId, genre) VALUES (?, ?)');
        foreach ($genres as $genre) {
            $stmt->execute([$plotId, $genre]);
        }
    }

}