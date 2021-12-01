<?php
include("./sql_connect.php");

$items = [];
$tables = array(
    "Account" =>  [],
    "Employee" => [],
    "Record" => [],
);


$account_sql = "SELECT * FROM Account";
$account_query = mysqli_query($connection, $account_sql);
while ($item = mysqli_fetch_assoc($account_query)) {
    array_push($tables['Account'], $item);
}

$employee_sql = "SELECT * FROM Employee";
$employee_query = mysqli_query($connection, $employee_sql);
while ($item = mysqli_fetch_assoc($employee_query)) {
    array_push($tables['Employee'], $item);
}

$record_sql = "SELECT * FROM Record";
$record_query = mysqli_query($connection, $record_sql);
while ($item = mysqli_fetch_assoc($record_query)) {
    array_push($tables['Record'], $item);
}
echo json_encode($tables);
