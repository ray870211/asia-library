<?php
session_start();
unset($_SESSION['session_id']);
header("location:../backstage.php");
?>