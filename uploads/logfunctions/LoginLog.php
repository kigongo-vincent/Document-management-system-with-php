<?php
function LoginLog($email, $text){
    $date =date('d/m/y h:m:s');
    $path = './uploads/logs/'.$email.'.txt';
    $handle = fopen($path, 'a');
    $content =$date. ' - '. $email.' '.$text . PHP_EOL;
    fwrite($handle, $content);
    fclose($handle);
}
