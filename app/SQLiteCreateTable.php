<?php

namespace App;

/**
 * SQLite Create Data Tables
 */
class SQLiteCreateTable
{

    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * Connect to the SQLite database
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create tables 
     */
    public function createTables($year)
    {
        $command =
            'CREATE TABLE IF NOT EXISTS `' . $year . '` (
                        PropertyId TEXT NOT NULL,
                        PropertyLocality TEXT NOT NULL,
                        PropertyPostCode INTEGER NOT NULL,
                        Area REAL,
                        AreaType TEXT,
                        ContractData INTEGER,
                        SettlementDate INTEGER,
                        PurchasePrice INTEGER,
                        NatureOfProperty TEXT,
                        PrimaryPurpose TEXT,
                        PercentInterestOfSale TEXT,
                        DealingNumber TEXT
                      )';

        $this->pdo->exec($command);
    }

    // /**
    //  * get the table list in the database
    //  */
    // public function getTableList()
    // {

    //     $stmt = $this->pdo->query("SELECT name
    //                                FROM sqlite_master
    //                                WHERE type = 'table'
    //                                ORDER BY name");
    //     $tables = [];
    //     while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    //         $tables[] = $row['name'];
    //     }

    //     return $tables;
    // }
}
