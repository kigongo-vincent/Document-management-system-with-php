<?php
session_start();
require ('./vendor/dompdf/vendor/autoload.php');
include './uploads/logfunctions/LoginLog.php';
use Dompdf\Dompdf;
include './connect.php';
$description = $_POST['description'];
$category = $_POST['category'];
$userID = $_SESSION['userID'];
$status = $_POST['status'];
$compose = $_POST['compose'];
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $destination = '';
    $compose = $_POST['compose'];
    
    if(isset($_FILES['upload']['name'])){
        $filename = $_FILES['upload']['name'];
        $temp = $_FILES['upload']['tmp_name'];
        
        $ext = explode('.', $filename);
        
        $ext = end($ext);
        $ext = strtolower($ext);
        $newname = $title.'.'.$ext;
        $destination = 'uploads/'.$newname;
        // unlink($destination);
        move_uploaded_file($temp, $destination);
        if($_FILES['upload']['name'] !== ''){
            $text = 'was used to upload '.$newname. ' under '.$category .' documents';
        LoginLog($_SESSION['id'], $text);
        }

    }
    if(!($_FILES['upload']['name'])){
        // $comp = './uploads/'.$title.'.txt';
        // $handle = fopen($comp, 'w');
        // fwrite($handle,$compose);
        // fclose($handle);
        // $destination = $comp;
        $comp = './uploads/'.$title.'.pdf';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($compose);
        $dompdf->render();
        $output = $dompdf->output();
        $oldfile = $title;
        file_put_contents($comp, $output);
        $text = 'was used to create '.$newname. 'pdf under '.$category .' documents';
        LoginLog($_SESSION['id'], $text);
        $destination = $comp;
       
    }
    

    
    if($status){
        $status = 1;
    }
    else{
        $status = 0;
    }
if($title){
    $qin = mysqli_query($c, "select docID from document where doct = '$title'");
    $qinr = mysqli_fetch_assoc($qin);
    $qinr = $qinr['docID'];
    if(!$qinr){
        mysqli_query($c, "INSERT INTO `document` (`docID`, `doct`, `description`, `path`, `created`, `category`, `userID`, `access`) VALUES (NULL, '$title', '$description', '$destination', CURRENT_TIMESTAMP, '$category', '$userID', '$status');");
    }
    else{
        mysqli_query($c, "update document set path = '$destination' where docID = '$qinr'");

    }
}

   
    
    
}
if($_SESSION['role'] == 1){
    header('Location: admindashboard.php');
    }
    else if($_SESSION['role'] == 0){
        header('Location: userdashboard.php');  
    }
    else{
        header('Location: adminlogin.php');
    }