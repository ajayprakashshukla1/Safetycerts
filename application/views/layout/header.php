
<?php $title=''; 
if($this->uri->segment(2)=='login'){
   $title="Login";
}else if($this->uri->segment(2)=='forgot_password'){
   $title="Forgot Password";
}else if($this->uri->segment(2)=='reset_password'){
   $title="Reset Password";
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SafetyCerts - <?php echo $title; ?></title>

	<!--<link href="<?php echo base_url(); ?>assest/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="<?php echo base_url(); ?>assest/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="<?php echo base_url(); ?>assest/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="<?php echo base_url(); ?>assest/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="<?php echo base_url(); ?>assest/img/favicon.png" rel="icon" type="image/png">-->

	<link href="<?php echo base_url(); ?>assest/img/favicon-16x16.png" rel="icon" type="image/png">
    <link href="<?php echo base_url(); ?>assest/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/main.css">
</head>
<body>