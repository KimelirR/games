<html>

<head>
    <!-- The meta viewport will scale my content to any device width -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specific Data</title>
        <!-- Link to my stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> 
    
</head>
	
<body>
    <div class="container">

<?php 

use ParseCsv\Csv;

require_once __DIR__ . '/vendor/autoload.php';

$csv = new Csv();
$response = (array) $csv->parseFile('./data/CYNTHIA.csv');

$count = 0;
$sum = 0;
echo '
<table class="table table-bordered">
    <tr>
        <th>Receipt No.</th>
        <th>Completion Time</th>
        <th>Details</th>
        <th>Transaction Status</th>
        <th>Paid In</th>
        <th>Withdrawn</th>
        <th>Balance</th>
    </tr>
    ';
foreach($response as $row){
    if(is_array($row)){
        if(count($row) == 8 && $row['Transaction Status'] === 'Completed'){
            $count++;
            // if (!empty($row['Paid In'])) {
            //     print_r($row['Paid In'].PHP_EOL);
            // }

            print_r($row["Withdrawn"].PHP_EOL);
            $dateTime = new DateTime($row["Completion Time"]);
            $comparison = $dateTime->format('Y-m');

            $pickedDate = '2022-09';
            if($pickedDate == $comparison){
                // print_r($row["Paid In"].PHP_EOL);
                $sum += (float) str_replace(',', '', $row["Paid In"]);
            }
           
            $table_data = '<tr>
                            <td>' . $row["Receipt No."] . '</td>
                            <td>' . $row["Completion Time"] . '</td>
                            <td>' . $row["Details"] . '</td>
                            <td>' . $row["Transaction Status"] . '</td>
                            <td>' . $row["Paid In"] . '</td>
                            <td>' . $row["Withdrawn"] . '</td>
                            <td>' . $row["Balance"] . '</td>
                        </tr>';
            echo $table_data;

           
        }
    }
}

echo '</table>';

echo $sum;
?>

</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



