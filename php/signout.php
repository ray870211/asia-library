<?php
session_set_cookie_params(0);
session_start();
unset($_SESSION['session_id']);
header("location:../backstage.php");
?>