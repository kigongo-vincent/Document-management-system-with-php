<?php
session_start();
require ('../vendor/dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
$name = $_GET['value'];
$name = explode('/', $name);
$name = $name[1];
$hand = fopen('./logs/'.$_SESSION['id'].'.txt', 'a');
$con = date('d/m/y h:m:s').' - '.$_SESSION['id'].' was used to open '. $name . PHP_EOL;
fwrite($hand, $con);
fclose($hand);
$html = file_get_contents($name);
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream($name, array('Attachment'=> 0));