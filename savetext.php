<?php
require_once './vendor/autoload.php';
include './uploads/logfunctions/LoginLog.php';
session_start();

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$path = $array['id'];
$value = $array['text'];
$end = explode('/', $path);
$end = end($end);
LoginLog($_SESSION['id'], 'was used to apply changes to '.$end);
$section = $phpWord->addSection();
$section->addText(
    $value

);

$fontStyleName = 'oneUserDefinedStyle';
$phpWord->addFontStyle(
    $fontStyleName,
    array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
);

$fontStyle = new \PhpOffice\PhpWord\Style\Font();
$fontStyle->setBold(true);
$fontStyle->setName('Tahoma');
$fontStyle->setSize(13);

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($path);
