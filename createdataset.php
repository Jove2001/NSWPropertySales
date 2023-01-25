<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;

/**
 * NSW Property Sales 2017-2022 dataset generator
 * 
 * This script runs the SQL scripts to retrieve NSW property sales data for 2017-2022 from the generated SQLite3 db - db/NSWSalesData.db
 * Creates csv files in csv directory
 * Data downloaded from Valuer General NSW Valuation Portal: https://valuation.property.nsw.gov.au/embed/propertySalesInformation
 * 
 * This software is the original academic work of Ian McEwaine s3863018@student.rmit.edu.au
 * It has been prepared as market research material for COSC2454 Professional Computing Practice, RMIT University
 * @ Ian McElwaine 2023
 */

 // Create dir for dataset
if (!file_exists("csv")) mkdir("csv");

// Get the db connection
$pdo = (new SQLiteConnection())->connect();

