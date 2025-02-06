<?php
require ('./vendor/dompdf/vendor/autoload.php');
include './uploads/logfunctions/LoginLog.php';
session_start();
use Dompdf\Dompdf;
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$path = $array['id'];
$end = explode('/', $path);
$end = end($end);
LoginLog($_SESSION['id'], 'was used to apply changes to '.$end);
$value = $array['text'];
$dompdf = new Dompdf();
$dompdf->loadHtml($value);
$dompdf->render();
$output = $dompdf->output();
file_put_contents($path, $output);

