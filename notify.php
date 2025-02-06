<?php
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$path = $array['id'];
include 'connect.php';
mysqli_query($c, "update notification set status = 1");
echo '';