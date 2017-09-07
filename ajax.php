<?php 
$action = $_REQUEST['action'];

$conn = mysqli_connect('localhost','cl39-safety','admin123!@#','cl39-safety');




if($action == renew){
$fname=$_REQUEST['fname'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$padd= $_REQUEST['paddress'];
$certi= $_REQUEST['ncertificate'];
$date= $_REQUEST['date'];
$adinfo= $_REQUEST['addinfo'];
$pid= $_REQUEST['pid'];
$test_type= $_REQUEST['test_type'];

$subject="Renewal";
$headers.= "MIME-Version: 1.0\r\n";
$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$sendmessage='Hello Admin. You have a certificate renewal enquiry<br/><br/>';
$sendmessage.='First name:' . $fname . '<br/>';
$sendmessage.='Phone Number:' . $phone . '<br/>';
$sendmessage.='Email Address: ' . $email . '<br/>';
$sendmessage.='Property Address:' . $padd. '<br/>';
$sendmessage.='Certificate:' . $certi. '<br/>';
$sendmessage.='Date:' . $date. '<br/>';
$sendmessage.='Additional Info:' . $adinfo. '<br/>';
$sendmessage.='Test Type:' . $test_type. '<br/>';


echo mail("kevin@safetycerts.co.uk",$subject,$sendmessage ,$headers);



}
if($action == formfill){


$id = $_REQUEST['id'];

$user_id = $_REQUEST['user_id'];

$sql = "SELECT * FROM `properties` WHERE `id` = '$id' ";
$res = mysqli_query($conn,$sql);
$prop = mysqli_fetch_array($res);


$sql = "SELECT * FROM `users` WHERE `id` = '$user_id' ";
$res = mysqli_query($conn,$sql);
$users = mysqli_fetch_array($res);

$full_name = $users['first_name'].''.$users['last_name'];
$email = $users['email'];
$phone = $users['phone'];

$property_address = $prop['address'];

echo $full_name."||".$email."||".$phone."||".$property_address;
	
}

if($action==createprop)
{
	
	$sql = "SELECT * FROM  `certificate_types`";
	$res = mysqli_query($conn,$sql);
    $arr = array();
	while($ct = mysqli_fetch_array($res))
	{
		array_push($arr,$ct);
	}
	
	$html = '';
	foreach($arr as $key)
	{
		if($key['certificate_id	']==1)
		{
            $html = '<div class="row-input-list">
              <label class="label-form" for="title">ELECTICAL TEST</label>
              <input class="w-input input-form in-grey" id="choices" type="radio" name="choices" data-name="choices">
              <div class="separator-fields"></div>
            </div>
            <div class="background-grey last"></div>';	
			
		}
		
	}
	
	echo $html;
	
}


?>