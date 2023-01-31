<?php 

use ParseCsv\Csv;

require_once __DIR__ . '/vendor/autoload.php';

$csv = new Csv();
$response = (array) $csv->parseFile('./data/cleaned_mpesa.csv');


/**
 * We can search name of the target if it appears in array
 *
 * @param [type] $needle
 * @param [type] $haystack
 * @return void
 */

function filterArray($needle,$haystack){
    foreach($haystack as $v){
        if (stripos($v, $needle) !== false) return true;
    };
    return false;
}

$items = array_filter($response, function ($v){
    $name = 'CYNTHIA';
    return filterArray($name, $v);
});


$csv->heading = true;
$csv->titles = ["Receipt No.","Completion Time","Details","Transaction Status","Paid In","Withdrawn","Balance",""];

$datas = [];

$produce = array_values($items);

$count = 0;
foreach($produce as $row){
    if(is_array($row)){
        if(count($row) == 8 && $row['Transaction Status'] === 'Completed'){
            $count++;

            // if (!empty($row['Paid In'])) {
            //     print_r($row['Paid In'].PHP_EOL);
            // }

            $datas[] = array_values($row);
            // $datas[] = array_values($row);
            /**
             * Need to unset old mpesa.csv
             */
        }
    }
}

/**
 * Undocumented function
 *
 * @param [type] $a
 * @param [type] $b
 * @return void
 */

function sortFunction( $a, $b ) {
    return strtotime($a[1]) - strtotime($b[1]);
}
usort($datas, "sortFunction");

$csv->data = $datas;
$csv->save('./data/CYNTHIA.csv');


header("Location: finalTable.php");
exit();