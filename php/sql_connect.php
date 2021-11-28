<?php
$url = "127.0.0.1";
$password = "csbccsbc";
$connection = mysqli_connect($url, "csbc", $password, "library");

if (!$connection) {
    exit('<h1>連線失敗</h1>');
}
header("content-Type:text/html;charset=utf-8");
mysqli_set_charset($connection, 'utf8');
