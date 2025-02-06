<?php
session_start();
include './connect.php';
include './uploads/logfunctions/LoginLog.php';
if(isset($_POST['submit'])){
    $id = $_SESSION['id'];
$newpass = $_POST['newpass'];
mysqli_query($c, "update user set password = '$newpass' where email = '$id'");
LoginLog($_SESSION['id'], 'was used to change the password');
if($_SESSION['role'] == 1){
    header('Location: admindashboard.php');
    }
    else if($_SESSION['role'] == 0){
        header('Location: userdashboard.php');  
    }
    else{
        header('Location: adminlogin.php');
    }

}