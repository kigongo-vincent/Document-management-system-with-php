<?php
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$p = $array['id'];
session_start();
$end = explode('/', $p);
$end = end($end);
$date =date('d/m/y h:m:s');
$path = '../logs/'.$_SESSION['id'].'.txt';
$handle = fopen($path, 'a');
$text = 'was used to download '.$end;
$content =$date. ' - '. $_SESSION['id'].' '.$text . PHP_EOL;
fwrite($handle, $content);
fclose($handle);