<?php


$bodytext = 'TESTING EMAIL<br><br>';
foreach ($_POST as $key=>$val) {
    $bodytext .= $key . ' - ' . $val.'<br>';
}
//echo '<pre>';
//print_r($_POST);
//print_r($_FILES);
//print_r($bodytext);
//echo '</pre>';




require_once('PHPMailer-master/PHPMailerAutoload.php');
$email = new PHPMailer();
$email->From      = 'info@safetycerts.co.uk'; // domain name need be ONLY safetycerts.co.uk
$email->FromName  = 'Safety Certs';
$email->IsHTML(true);
$email->Subject   = 'You email has been received';
$email->Body      = $bodytext;
$email->AddAddress( 'kevin@londonsparks.com');
$email->AddAddress( 'tim@ignitestudio.co.uk');

if(!empty($_FILES)){
    $file_to_attach = $_FILES[0]['tmp_name'];
    $email->AddAttachment( $file_to_attach , $_FILES[0]['name'] );
}

if($email->Send()){
    echo 1;
}else{
    echo 2;
}
die();

