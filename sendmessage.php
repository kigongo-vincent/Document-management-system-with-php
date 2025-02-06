<?php
session_start();
include './uploads/logfunctions/LoginLog.php';
// if(isset($_POST['submit'])){
    include './connect.php';
    $body = $_POST['body'];
    $id = $_SESSION['userID'];

    mysqli_query($c, "insert into message(body, userID) values('$body', '$id')");
    LoginLog($_SESSION['id'], "was used to send ('$body') to the Chat room ");
// }
if($_SESSION['role'] == 1){
header('Location: admindashboard.php');
}
else if($_SESSION['role'] == 0){
    header('Location: userdashboard.php');  
}
else{
    header('Location: adminlogin.php');
}