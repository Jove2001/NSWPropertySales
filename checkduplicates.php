<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\SQLiteCreateTable;

// Sales data years to check 
$years = array("2020", "2021", "2022");

for ($a = 0; $a < sizeof($years); $a++) {

    // Get the list of data file names
    $dataFiles = getFileNames($years[$a]);

    // Convert to array
    for ($b = 0; $b < sizeof($dataFiles); $b++) {
        // Get the data file and convert to array
        // print($b + 1 . " of " . sizeof($dataFiles) . " - " . $dataFiles[$b]);
        $data = csvToArray('data/' . $years[$a] . "/" . $dataFiles[$b]);

        for ($c = 0; $c < sizeof($data); $c++) {
            if ($data[$c][0] == "B") {
                $records[] = array(
                    'Year' => $years[$a],
                    'PropertyId' => $data[$c][2],
                    'DealingNumber' => $data[$c][23]
                );
            }
        }
    }
}

print(sizeof($records)." records\n");
var_dump($records[0]);

for ($a=0;$a<sizeof($records);$a++) {
    if ($records[$a]['DealingNumber'] == 'AQ918018') {
        var_dump($records[$a]);
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
 * Get the list of data file names
 */
function getFileNames($year)
{
    $dataFiles = scandir("data/$year/");
    array_shift($dataFiles);
    array_shift($dataFiles);
    return $dataFiles;
}
