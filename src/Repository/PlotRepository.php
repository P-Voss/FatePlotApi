<?php


namespace App\Repository;


use App\Model\Plot;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Exception;

class PlotRepository
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * PlotRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct (Connection $connection)
    {
        $this->db = $connection;
    }

    /**
     * @param Plot $plot
     *
     * @return string
     * @throws Exception
     */
    public function create (Plot $plot)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO plots (userId, name, isOpen, isSecret, isActive, creationdate, targetPlayerNumber, description) VALUES (?, ?, ?, ?, ?, ?, ? ,?)'
        );
        $stmt->execute(
            [
                $plot->getUserId(),
                $plot->getName(),
                $plot->isOpen() ? 1 : 0,
                $plot->isSecret() ? 1 : 0,
                $plot->isActive() ? 1 : 0,
                $plot->getCreationDate(),
                $plot->getTargetPlayerNumber(),
                $plot->getDescription()
            ]
        );
        return $this->db->lastInsertId();
    }

    /**
     * @return Plot[]
     * @throws Exception
     */
    public function fetchPublicPlots ()
    {
        $plots = [];
        $result = $this->db->query("SELECT * FROM plots WHERE isActive = 0 AND isOpen = 1")->fetchAll();
        foreach ($result as $row) {
            $plot = new Plot();
            $plot->setPlotId($row['plotId']);
            $plot->setUserId($row['userId']);
            $plot->setName($row['name']);
            $plot->setDescription($row['description']);
            $plot->setCreationDate($row['creationdate']);
            $plot->setTargetPlayerNumber($row['targetPlayerNumber']);
            $plots[] = $plot;
        }
        return $plots;
    }

    /**
     * @param int $userId
     *
     * @return Plot[]
     * @throws DBALException
     */
    public function fetchOwnPlots (int $userId): array
    {
        $plots = [];
        $stmt = $this->db->prepare("SELECT * FROM plots WHERE userId = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $plot = new Plot();
            $plot->setPlotId($row['plotId']);
            $plot->setUserId($row['userId']);
            $plot->setName($row['name']);
            $plot->setDescription($row['description']);
            $plot->setCreationDate($row['creationdate']);
            $plot->setTargetPlayerNumber($row['targetPlayerNumber']);
            $plots[] = $plot;
        }
        return $plots;
    }

    /**
     * @param int $characterId
     *
     * @return Plot[]
     * @throws DBALException
     */
    public function fetchParticipantsPlot (int $characterId): array
    {
        $plots = [];
        $stmt = $this->db->prepare(
"SELECT plots.* 
    FROM plots 
    INNER JOIN charakterPlots ON charakterPlots.plotId = plots.plotId
    WHERE charakterPlots.charakterId = ?");

        $stmt->execute([$characterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $plot = new Plot();
            $plot->setPlotId($row['plotId']);
            $plot->setUserId($row['userId']);
            $plot->setName($row['name']);
            $plot->setDescription($row['description']);
            $plot->setCreationDate($row['creationdate']);
            $plot->setTargetPlayerNumber($row['targetPlayerNumber']);
            $plots[] = $plot;
        }
        return $plots;
    }


}