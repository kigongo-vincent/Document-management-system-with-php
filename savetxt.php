<?php
include './uploads/logfunctions/LoginLog.php';
session_start();
$contents = trim(file_get_contents('php://input'));


$array = json_decode($contents, TRUE);
$path = $array['id'];
$end = explode('/', $path);
$end = end($end);
LoginLog($_SESSION['id'], 'was used to apply changes to '.$end);
$value = $array['text'];
$handle = fopen($path, 'w');
fwrite($handle, $value);
fclose($handle);