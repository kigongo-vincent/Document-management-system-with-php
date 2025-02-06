<?php
include 'connect.php';
include './uploads/logfunctions/LoginLog.php';
session_start();
$content = trim(file_get_contents('php://input'));
$array = json_decode($content, TRUE);

if($array['n']){
    $fullname = $array['n'];
    $email = $array['e'];
    $password = $array['r'];
    $title = $array['t'];
    $contact = $array['c'];

    mysqli_query($c, "INSERT INTO `user` (`userID`, `fullname`, `email`, `password`, `title`, `role`, `tel`, `status`) VALUES (NULL, '$fullname', '$email', '$password', '$title', '0', '$contact', '0')");
    $path = './uploads/logs/'.$email.'.txt';
    $handle = fopen($path,'w' );
    $content = '';
    
    
    fwrite($handle, $content);
    fclose($handle);
    LoginLog($_SESSION['id'], 'was used to create an account under the email of '.$email);
}

// $msg = "Hello '$fullname', An account was successfully created for you on the MoICT Document management system, please use this email for logging in, the password is '$password', ensure to change your password on loggin in for security purposes!";




// try {
//     //Server settings
//     $mail->isSMTP(true);
//     $mail->Host = 'smtp.gmail.com';
//     $mail->SMTPAuth = true;
//     $mail->Username = 'kigongovincent625@gmail.com';
//     $mail->Password = 'vincent2002';
//     $mail->SMTPSecure = 'tls';
//     $mail->Port = 587;

//     //Recipients
//     $mail->setFrom('kigongovincent625@gmail.com', '');
//     $mail->addAddress('kigongovincent625@gmail.com', 'kigongovincent625');

//     //Content
//     $mail->isHTML(true);
//     $mail->Subject = 'Account Creation';
//     $mail->Body = 9;
//     $mail->SMTPDebug = 2; 
//     $mail->send();
//     echo 'Email sent successfully!';
// } catch (Exception $e) {
//     echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
   
// }
echo 'account created';
