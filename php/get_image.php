<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);
//$user_image = "/home/aupm/Desktop/pages/data/image/" . $_POST['image_url'].".jpg";
$file = "/home/aupm/Desktop/library/" . $_POST['image_url'];
//$file = $user_image;
$fp = fopen($file, 'r');
if (file_exists($file)) {
    while (!feof($fp)) {
        $image = $image . fgetc($fp);
    }
    fclose($fp);
}
$base64 = chunk_split(base64_encode($image));
// var_dump($items);
$data = array(
    "image" => $base64,
);
echo json_encode($data);