<?php
include("./sql_connect.php");
$table_title = $_POST['table_title'];
$id = $_POST['id'];
$u_id = $_POST['u_id'];
$response_message = array(
    "status" => 404,
);
if ($table_title == "Employee") {
    $sql = "DELETE FROM Record where u_id = '$u_id'";
    $query = mysqli_query($connection, $sql);
    $sql = "DELETE FROM Employee where id = $id";
    $query = mysqli_query($connection, $sql);
    if ($query == true) {
        $response_message['status'] = 200;
        echo json_encode($response_message);
    }
}
if ($table_title == "Record") {
    $sql = "DELETE FROM Record where id = $id";
    $query = mysqli_query($connection, $sql);
    if ($query == true) {
        $response_message['status'] = 200;
        echo json_encode($response_message);
    }
}

