<?php
session_start();
include './connect.php';
include './uploads/logfunctions/LoginLog.php';
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = mysqli_query($c, "select email,password,role, userID from user where email = '$email' and status = 0");
    $array =mysqli_fetch_assoc($query);
   if($array['password'] == $password && $array['email'] == $email){
    $_SESSION['id'] = $email;
    LoginLog($email,'was used to login');
    $_SESSION['userID'] = $array['userID'];
    $_SESSION['role'] = $array['role'];
    $_SESSION['password'] = $password;
            if($array['role'] == 1){
                header('Location: admindashboard.php');
             }
   else{
    header('Location: userdashboard.php');
   }
   }
   else{
    header('Location: adminlogin.html');
   }
}
else{
    header('Location: adminlogin.html');
}
