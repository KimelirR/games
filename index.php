<?php 

use ParseCsv\Csv;

require_once __DIR__ . '/vendor/autoload.php';

$csv = new Csv();
$csv->offset = 11;
$response = (array) $csv->parseFile('./data/mpesa.csv');

/**
 * By this way we get the whole content
 */
$csv->heading = true;
$csv->titles = ["Receipt No.","Completion Time","Details","Transaction Status","Paid In","Withdrawn","Balance",""];

$count = 0;
$items = [];
foreach($response as $row){
    if(is_array($row)){
        if(count($row) == 8 && $row[3] === 'Completed'){
            $count++;
            $items[] = $row;
            /**
             * Need to unset old mpesa.csv
             */
        }
    }
}
$csv->data = $items;
$csv->save('./data/cleaned_mpesa.csv');


    header("Location: data.php");
    exit();


