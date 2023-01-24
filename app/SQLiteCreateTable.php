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
}
