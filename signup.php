<?php
include './connect.php';
if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $position = $_POST['position'];

    mysqli_query($c, "INSERT INTO `notification` (`notID`, `fullname`, `title`, `email`, `contact`) VALUES (NULL, '$fullname', '$position', '$email', '$contact')");


}
header('Location: adminlogin.html');