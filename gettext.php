<?php
require './vendor/autoload.php';
$content = '';
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$path = $array['id'];

$phpWord = \PhpOffice\PhpWord\IOFactory::load($path);

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
echo $content;