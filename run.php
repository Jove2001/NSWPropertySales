<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;

/**
 * This script adds NSW property sales data for 2020; 2021; 2022 to an SQLite3 db - db/NSWSalesData.db
 * Data downloaded from Valuer General NSW Valuation Portal: https://valuation.property.nsw.gov.au/embed/propertySalesInformation
 * 
 * WARNING: This operation may take over 12 hrs to complete!
 * 
 * This software is the original academic work of Ian McEwaine s3863018@student.rmit.edu.au
 * It has been prepared as market research material for COSC2454 Professional Computing Practice, RMIT University
 * @ Ian McElwaine 2023
 */

print("----------------------------------------\nThis script will convert the NSW property sales data files into an SQLite3 db\nWARNING: THIS MAY TAKE > 12HRS\nPress ctrl-c to escape this operation\n----------------------------------------\n");

// Sales data years to import 
$years = array("2020", "2021", "2022");

// Add each years data to db
for ($a = 0; $a < sizeof($years); $a++) {

    print("Processing " . $years[$a] . " property sales data\n");

    // Get the list of data file names
    $dataFiles = getFileNames($years[$a]);

    // Convert to csv and add to db
    for ($b = 0; $b < sizeof($dataFiles); $b++) {

        // Get the data file and convert to array
        print($b + 1 . " of " . sizeof($dataFiles) . " - " . $dataFiles[$b]);
        $data = csvToArray('data/' . $years[$a] . "/" . $dataFiles[$b]);

        // Find the 'B' records and add to db
        for ($c = 0; $c < sizeof($data); $c++) {
            if ($data[$c][0] == "B") {
                sendToDb(
                    // The year of the data
                    $years[$a],
                    // PropertyId
                    $data[$c][2],
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
                    $data[$c][18],
                    // DealingNumber
                    $data[$c][23]
                );
            }
        }
        print(" - Done\n");
    }
}

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
    $year,
    $propertyId,
    $propertyPostCode,
    $area,
    $areaType,
    $contractDate,
    $settlementDate,
    $purchasePrice,
    $natureOfProperty,
    $primaryPurpose,
    $dealingNumber
) {
    // Get the connection
    $pdo = (new SQLiteConnection())->connect();

    // Create the SQL statement
    $insert =
        "INSERT INTO `$year`
    VALUES (
        '$propertyId',
        '$propertyPostCode',
        '$area',
        '$areaType',
        '$contractDate',
        '$settlementDate',
        '$purchasePrice',
        '$natureOfProperty',
        '$primaryPurpose',
        '$dealingNumber')";

    // Execute statement
    $stmt = $pdo->exec($insert);
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
