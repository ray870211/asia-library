<?php
// $image = '';
ini_set('display_errors', '1');
// $return_data = array(
//     "status" => "200";
// )
// error_reporting(E_ALL);
// $file_pointer = "gfg.txt"; 
// $user_image = "/home/aupm/Desktop/library/data/head_cut/" . "1640756059.1683865.jpg";
$file = "/home/aupm/Desktop/library/" . $_POST['image_url'];
//$file = $user_image;
if(file_exists($file)){
    // echo $$user_image;
    unlink($file);//將檔案刪除
}else{
    // $return_data['status'] = 400
}
// echo json_encode($return_data);

$image = '';
