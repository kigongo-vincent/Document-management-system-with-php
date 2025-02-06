<?php
session_start();
include './uploads/logfunctions/LoginLog.php';
if(isset($_GET['p'])){
    $p = $_GET['p'];
include 'connect.php';
mysqli_query($c, "delete from document where path = '$p'");
$end = explode('/', $p);
$end = end($end);
$text ='was used to delete '.$end;
unlink($p);
LoginLog($_SESSION['id'],$text );
}
if($_SESSION['role'] == 1){
    header('Location: admindashboard.php');
    }
    else if($_SESSION['role'] == 0){
        header('Location: userdashboard.php');  
    }
    else{
        header('Location: adminlogin.php');
    }
