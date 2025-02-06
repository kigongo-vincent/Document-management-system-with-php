<?php
include 'connect.php';
$content = trim(file_get_contents('php://input'));
$array = json_decode($content, TRUE);
$value = $array['email'];
$query = mysqli_query($c, "select email from user where email = '$value'");
$result = mysqli_num_rows($query);
echo $result;