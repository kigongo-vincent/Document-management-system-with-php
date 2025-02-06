<?php
session_start();
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$p = $array['id'];

$end = explode('/', $p);
$end = $end[2];
$date =date('d/m/y h:m:s');
$path = '../logs/'.$_SESSION['id'].'.txt';
$handle = fopen($path, 'a');
$text = 'was used to open '.$end;
$content =$date. ' - '. $_SESSION['id'].' '.$text . PHP_EOL;
fwrite($handle, $content);
fclose($handle);