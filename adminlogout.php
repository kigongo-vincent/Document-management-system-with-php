<?php
include './uploads/logfunctions/LoginLog.php';
session_start();
$email = $_SESSION['id'];
LoginLog($email,'was logged out');
session_destroy();
header('Location: adminlogin.html');