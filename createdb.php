<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\SQLiteCreateTable;

/**
 * NSW Property Sales 2017-2022
 * 
 * This script adds NSW property sales data for 2017-2022 to an SQLite3 db - db/NSWSalesData.db
 * Data downloaded from Valuer General NSW Valuation Portal: https://valuation.property.nsw.gov.au/embed/propertySalesInformation
 * 
 * WARNING: This operation will take a long time!
 * 
 * This software is the original academic work of Ian McEwaine s3863018@student.rmit.edu.au
 * It has been prepared as market research material for COSC2454 Professional Computing Practice, RMIT University
 * @ Ian McElwaine 2023
 */

// Get program start time
$startTime = date_create_from_format("U", time());

print("----------------------------------------\nNSW Property Sales Records 2017-2022\n\nThis script converts the NSW property sales\ndata files into an SQLite3 db\n\nWARNING: THIS WILL TAKE A LONG TIME!\n\nPress ctrl-c to escape this operation\n----------------------------------------\n");

// Sales data years to import 
$years = array("2017", "2018", "2019", "2020", "2021", "2022", "2023");

// Create dir for db
if (!file_exists("db")) mkdir("db");

// Get the db connection
$pdo = (new SQLiteConnection())->connect();

// Create the table in the database
(new SQLiteCreateTable($pdo))->createTable();

// Initialise log file
$logfile = fopen("createdb.log", "w") or die("Unable to open file!");
fwrite($logfile, "DataFilePath,DealingNumber,PropertyId,ContractDate,SettlementDate,PurchasePrice\n");
fclose($logfile);

// Total number of data files
$numOfFiles = 0;

// Find total number of data files
for ($a = 0; $a < sizeof($years); $a++) {
    $dataFiles = getFileNames($years[$a]);
    $numOfFiles = $numOfFiles + sizeof($dataFiles);
}

// Counter for processed files
$fileCounter = 0;

// Counter for 'B' records processed
$recordCounter = 0;

// Add each years data to db
for ($a = 0; $a < sizeof($years); $a++) {

    print("Processing " . $years[$a] . " property sales data\n");

    // Get the list of data file names
    $dataFiles = getFileNames($years[$a]);

    // Convert to csv and add to db
    for ($b = 0; $b < sizeof($dataFiles); $b++) {

        // Get the data file and convert to array
        print($fileCounter + 1 . " of " . $numOfFiles . " - " . $dataFiles[$b]);
        $data = csvToArray('data/' . $years[$a] . "/" . $dataFiles[$b]);

        // Find the 'B' records and add to db
        // Refer to: https://www.valuergeneral.nsw.gov.au/__data/assets/pdf_file/0015/216402/Current_Property_Sales_Data_File_Format_2001_to_Current.pdf
        for ($c = 0; $c < sizeof($data); $c++) {
            if ($data[$c][0] == "B") {
                sendToDb(
                    // Active db connection
                    $pdo,
                    // Data file name for logging
                    $years[$a] . "/" . $dataFiles[$b],
                    // PropertyId
                    $data[$c][2],
                    // PropertyLocality
                    htmlspecialchars($data[$c][9]),
                    // PropertyPostCode
                    $data[$c][10],
                    // Area
                    $data[$c][11],
                    // AreaType
                    $data[$c][12],
                    // ContractDate
                    $data[$c][13],
                    // SettlementDate
                    $data[$c][14],
                    // PurchasePrice
                    $data[$c][15],
                    // NatureOfProperty
                    $data[$c][17],
                    // PrimaryPurpose
                    htmlspecialchars($data[$c][18]),
                    // PercentInterestOfSale
                    $data[$c][22],
                    // DealingNumber
                    $data[$c][23]
                );
                $recordCounter++;
            }
        }
        $fileCounter++;
        print("\n");
    }
}

// Show program run time and stats
$finishTime = date_create_from_format("U", time());
$runTime = date_diff($startTime, $finishTime);
$rt = $runTime->format("%H:%i:%s");
print("\n\n--------------\nAll done\n--------------\n\nProgram run time = $rt\nFiles processed: $fileCounter of $numOfFiles\n'B' Records processed: $recordCounter\nSee createdb.log for duplicate records in original dataset\n\n--------------\n\n");

/**
 * Get the list of data file names
 */
function getFileNames($year)
{
    $dataFiles = scandir("data/$year/");
    array_shift($dataFiles);
    array_shift($dataFiles);
    return $dataFiles;
}

/**
 * Insert data into db
 */
function sendToDb(
    $pdo,
    $datafileName,
    $propertyId,
    $propertyLocality,
    $propertyPostCode,
    $area,
    $areaType,
    $contractDate,
    $settlementDate,
    $purchasePrice,
    $natureOfProperty,
    $primaryPurpose,
    $percentInterestOfSale,
    $dealingNumber
) {
    // Create the SQL statement
    $insert =
        "INSERT INTO NSWPropertySales
    VALUES (
        '$propertyId',
        '$propertyLocality',
        '$propertyPostCode',
        '$area',
        '$areaType',
        '$contractDate',
        '$settlementDate',
        '$purchasePrice',
        '$natureOfProperty',
        '$primaryPurpose',
        '$percentInterestOfSale',
        '$dealingNumber',
        '$datafileName')";

    // Execute statement
    try {
        $pdo->exec($insert);
    } catch (PDOException $e) {
        // There are many duplicate records in dataset. Add duplicates to a csv file for later review.
        logWriter($datafileName . "," . $dealingNumber . "," . $propertyId . "," . $contractDate . "," . $settlementDate . "," . $purchasePrice . "\n");
    }
}

/**
 * Load a data file as an array
 */
function csvToArray($csvFile)
{
    $file_to_read = fopen($csvFile, 'r');
    while (!feof($file_to_read)) {
        $lines[] = fgetcsv($file_to_read, 1000, ';');
    }
    fclose($file_to_read);

    // Get rid of the boolean at the end
    array_pop($lines);

    return $lines;
}

/**
 * Write logs
 */
function logWriter($log)
{
    $logfile = fopen("createdb.log", "a") or die("Unable to open file!");
    fwrite($logfile, $log);
    fclose($logfile);
}
