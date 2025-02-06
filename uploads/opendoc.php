<?php
session_start();
require ('../vendor/dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
$content = '';
$path = $_GET['value'];
$name = explode('/', $path);
$name = $name[1];
require '../vendor/autoload.php';
$phpWord = \PhpOffice\PhpWord\IOFactory::load($name);

try {
    //code...
    foreach($phpWord->getSections() as $section) {
        foreach($section->getElements() as $element) {
            if (method_exists($element, 'getElements')) {
                foreach($element->getElements() as $childElement) {
                    if (method_exists($childElement, 'getText')) {
                        $content .= $childElement->getText() . '  ' ;
                    }
                    else if (method_exists($childElement, 'getContent')) {
                        $content .= $childElement->getContent() . '  ';
                    }
                }
            }
            else if (method_exists($element, 'getText')) {
                $content .= $element->getText() . '';
            }
        }
    }
} catch (\Throwable $th) {
    //throw $th;
}
// $handle = fopen('amapiano.txt', 'w');
// $data = $content;
// fwrite($handle, $data);
// $html = file_get_contents('amapiano.txt');
// // unlink('amapiano.txt');
// fclose($handle);
// $dompdf = new Dompdf();
// $dompdf->loadHtml($html);
// $dompdf->render();
// $dompdf->stream($name, array('Attachment'=> 0));
$handle = fopen('amapiano.txt', 'w');
$data = $content;
fwrite($handle, $data);
$html = file_get_contents('amapiano.txt');
unlink('amapiano.txt');
fclose($handle);

$hand = fopen('./logs/'.$_SESSION['id'].'.txt', 'a');
$con = date('d/m/y h:m:s').' - '.$_SESSION['id'].' was used to open '. $name . PHP_EOL;
fwrite($hand, $con);
fclose($hand);

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream($name, array('Attachment'=> 0));

