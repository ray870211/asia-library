<?php
include("./sql_connect.php");
$table_title = $_POST['table_title'];
$table_keys = array_keys($_POST);
$table_values = array_values($_POST);
for ($i = 2; $i < count($table_keys); $i++) {
    // 0是title 從1是id
    $sql = "UPDATE $table_title set $table_keys[$i] = '$table_values[$i]' where id = $table_values[1]";
    $query = mysqli_query($connection, $sql);
    var_dump($query);
}
