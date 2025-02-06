<?php
include './connect.php';
include './uploads/logfunctions/LoginLog.php';
session_start();
if(isset($_GET['r'])){
    $v = $_GET['r'];
    mysqli_query($c, "update user set role = 0 where email = '$v'");
    LoginLog($_SESSION['id'], 'was used to revoke admin rights from user under the email of '.$v);

}
if(isset($_GET['g'])){
    $v = $_GET['g'];
    mysqli_query($c, "update user set role = 1 where email = '$v'");
    LoginLog($_SESSION['id'], 'was used to grant admin rights to user under the email of '.$v);
}
if(isset($_GET['d'])){
    $v = $_GET['d'];
    mysqli_query($c, "update user set status = 1 where email = '$v'");
    LoginLog($_SESSION['id'], 'was used to deactivate user account under the email of '.$v);

}

header('Location: admindashboard.php');