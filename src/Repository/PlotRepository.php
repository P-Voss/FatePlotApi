<?php


namespace App\Repository;


use App\Model\Plot;
use Doctrine\DBAL\Connection;
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
        }
        return $plots;
    }


}