<?php

namespace App;

/**
 * SQLite Create Data Tables
 * Based on https://www.sqlitetutorial.net/sqlite-php/connect/
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
     * Create table
     */
    public function createTable()
    {
        $command =
            'CREATE TABLE IF NOT EXISTS NSWPropertySales (
                        PropertyId TEXT NOT NULL,
                        PropertyLocality TEXT NOT NULL,
                        PropertyPostCode INTEGER NOT NULL,
                        Area REAL,
                        AreaType TEXT,
                        ContractDate INTEGER,
                        SettlementDate INTEGER,
                        PurchasePrice INTEGER,
                        NatureOfProperty TEXT,
                        PrimaryPurpose TEXT,
                        PercentInterestOfSale TEXT,
                        DealingNumber TEXT NOT NULL,
                        DataFileOrigin TEXT,
                        PRIMARY KEY(PropertyId,DealingNumber)
                      )';

        $this->pdo->exec($command);
    }
}
