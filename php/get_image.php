<?php
$image = '';
$file = "/home/aupm/Desktop/library/" . $_POST['image_url'];
echo $file;

$fp = fopen($file, 'r');
var_dump($fp);
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
