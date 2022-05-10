<?php
$user_data = "../data/studens.csv";
$fp = fopen($user_data, 'r');
$data = array(
    "studens" =>[],
    
);
if (file_exists($user_data)) {
    $i = 0;
    while (!feof($fp)) {
        $data['studens'][$i]=(fgetcsv($fp));
        $i++;
    }
    fclose($fp);
}

$json = json_encode($data);
echo($json);
