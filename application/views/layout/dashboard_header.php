<?php 

 $user= $this->ion_auth->user()->row();
 $user->role=$this->ion_auth->get_users_groups($user->id)->row()->name;
 $this->loggedin_user=$user;
     
$data['login_user']=$this->loggedin_user;
$login_user = $this->loggedin_user;
$username = $login_user->first_name;


?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SafetyCerts | <?=$title?></title>

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
     <!-- Datepicker CSS start -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/vendor/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/vendor/bootstrap-daterangepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/clockpicker/bootstrap-clockpicker.min.css">
    <!-- Datepicker CSS end -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/lobipanel/lobipanel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/vendor/lobipanel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/pages/widgets.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/main.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/pages/others.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/vendor/datatables-net.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/pages/profile-2.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/vendor/sweet-alert-animations.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/separate/vendor/jquery-steps.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/loading.css">  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/chosen.css">

	 <style type="text/css">
      .site-header .site-header-collapsed .site-header-collapsed-in {
    margin-right: 65px !important;
    zoom: 1;
}   
     </style>
</head>
<body class="with-side-menu control-panel control-panel-compact">

<header class="site-header">
	<div class="container-fluid">	
        <a href="#" class="site-logo">
            <img class="hidden-md-down" src="<?php echo base_url(); ?>assest/img/logo.jpg" alt="">
            <img class="hidden-lg-up" src="<?php echo base_url(); ?>assest/img/logo.jpg" alt="">
        </a>
	
        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>
	
        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    <div class="dropdown dropdown-notification notif">
                       <!-- <a href="#"
                           class="header-alarm dropdown-toggle active"
                           id="dd-notification"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <i class="font-icon-alarm"></i>
                        </a>-->
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
                            <div class="dropdown-menu-notif-header">
                                Notifications
                                <span class="label label-pill label-danger">4</span>
                            </div>
                            <div class="dropdown-menu-notif-list">
                                <div class="dropdown-menu-notif-item">
                                    <div class="photo">
                                        <img src="<?php echo base_url(); ?>assest/img/photo-64-1.jpg" alt="">
                                    </div>
                                    <div class="dot"></div>
                                    <a href="#">Morgan</a> was bothering about something
                                    <div class="color-blue-grey-lighter">7 hours ago</div>
                                </div>
                                <div class="dropdown-menu-notif-item">
                                    <div class="photo">
                                        <img src="<?php echo base_url(); ?>assest/img/photo-64-2.jpg" alt="">
                                    </div>
                                    <div class="dot"></div>
                                    <a href="#">Lioneli</a> had commented on this <a href="#">Super Important Thing</a>
                                    <div class="color-blue-grey-lighter">7 hours ago</div>
                                </div>
                                <div class="dropdown-menu-notif-item">
                                    <div class="photo">
                                        <img src="<?php echo base_url(); ?>assest/img/photo-64-3.jpg" alt="">
                                    </div>
                                    <div class="dot"></div>
                                    <a href="#">Xavier</a> had commented on the <a href="#">Movie title</a>
                                    <div class="color-blue-grey-lighter">7 hours ago</div>
                                </div>
                                <div class="dropdown-menu-notif-item">
                                    <div class="photo">
                                        <img src="<?php echo base_url(); ?>assest/img/photo-64-4.jpg" alt="">
                                    </div>
                                    <a href="#">Lionely</a> wants to go to <a href="#">Cinema</a> with you to see <a href="#">This Movie</a>
                                    <div class="color-blue-grey-lighter">7 hours ago</div>
                                </div>
                            </div>
                            <div class="dropdown-menu-notif-more">
                                <a href="#">See more</a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown dropdown-notification messages">
                       <!-- <a href="#"
                           class="header-alarm dropdown-toggle active"
                           id="dd-messages"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <i class="font-icon-mail"></i>
                        </a>-->
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-messages" aria-labelledby="dd-messages">
                            <div class="dropdown-menu-messages-header">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           data-toggle="tab"
                                           href="#tab-incoming"
                                           role="tab">
                                            Inbox
                                            <span class="label label-pill label-danger">8</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           data-toggle="tab"
                                           href="#tab-outgoing"
                                           role="tab">Outbox</a>
                                    </li>
                                </ul>
                                <!--<button type="button" class="create">
                                    <i class="font-icon font-icon-pen-square"></i>
                                </button>-->
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-incoming" role="tabpanel">
                                    <div class="dropdown-menu-messages-list">
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/photo-64-2.jpg" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/avatar-2-64.png" alt=""></span>
                                            <span class="mess-item-name">Christian Burton</span>
                                            <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/photo-64-2.jpg" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/avatar-2-64.png" alt=""></span>
                                            <span class="mess-item-name">Christian Burton</span>
                                            <span class="mess-item-txt">Morgan was bothering about something...</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-outgoing" role="tabpanel">
                                    <div class="dropdown-menu-messages-list">
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/avatar-2-64.png" alt=""></span>
                                            <span class="mess-item-name">Christian Burton</span>
                                            <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something...</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/photo-64-2.jpg" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/avatar-2-64.png" alt=""></span>
                                            <span class="mess-item-name">Christian Burtons</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="<?php echo base_url(); ?>assest/img/photo-64-2.jpg" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-menu-notif-more">
                                <a href="#">See more</a>
                            </div>
                        </div>
                    </div>                   
                    <div style="float: left;color: #00a8ff;padding-top: 4px;">
                        <span>Hello, <?php echo ucfirst($username)  ?></span>
                    </div>
                    <div class="dropdown user-menu">

                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           
                            <img src="<?php echo base_url(); ?>assest/img/avatar-2-64.png" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="<?php echo base_url() ?>user/profile"><span class="font-icon glyphicon glyphicon-user"></span>Profile</a>
                            <!--
                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Help</a>
                            -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url() ?>auth/logout"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
                        </div>
                    </div>

                    <button type="button" class="burger-right">
                        <i class="font-icon-menu-addl"></i>
                    </button>
                </div><!--.site-header-shown-->

                <div class="mobile-menu-right-overlay"></div>
                <div class="site-header-collapsed">
                    <div class="site-header-collapsed-in">
                        <div class="dropdown dropdown-typical">
                            <div class="dropdown-menu" aria-labelledby="dd-header-sales">
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Quant and Verbal</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real Gmat Test</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep Official App</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer Test</a>
                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third Party Test</a>
                            </div>
                        </div>

                      
                </div><!--.site-header-collapsed-->
            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header><!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	<nav class="side-menu">
	    <ul class="side-menu-list">
	        
	        <li class="grey with-sub <?php if($this->uri->segment(2)=="dashboard"){echo "opened";}?> ">
				<a href="<?php echo base_url() ?>user/dashboard">
				<i class="font-icon font-icon-dashboard"></i>
				<span class="lbl">Dashboard</span>
				</a>
			</li>

			<?php if($this->ion_auth->is_admin()){ ?>
			
			 <li class=" <?php if($this->uri->segment(2)=="profile"){echo "opened";}?>">
	            <a href="<?php echo base_url() ?>user/profile" class="label-right">
	                <i class="font-icon glyphicon glyphicon-user"></i>
	                <span class="lbl">Profile</span>
	            </a>
	        </li>

	       	<!-- <li class="purple with-sub">
	            <span>
	                <i class="font-icon font-icon-comments active"></i>
	                <span class="lbl">Messages</span>
	            </span>
	            <ul>
	                <li><a href="messenger.html"><span class="lbl">Messenger</span></a></li>
	                <li><a href="chat.html"><span class="lbl">Messages</span><span class="label label-custom label-pill label-danger">8</span></a></li>
	                <li><a href="chat-write.html"><span class="lbl">Write Message</span></a></li>
	                <li><a href="chat-index.html"><span class="lbl">Select User</span></a></li>
	            </ul>
	        </li>-->
           
	        <li class="purple with-sub  <?php if($this->uri->segment(2)=="certificate"){echo "opened";}?> ">
				<a href="<?php echo base_url() ?>user/certificate">
				<i class="glyphicon glyphicon-list-alt"></i>
				<span class="lbl">Certificates</span>
				</a>
			</li>

       		<li class="orange-red with-sub 
                <?php if($this->uri->segment(2)=="create_user"){echo "opened";}?>
                <?php if($this->uri->segment(2)=="contractor_list"){echo "opened";}?>
            ">
	            <span>
	                <i class="font-icon font-icon-user"></i>
	                <span class="lbl">Contractor</span>
	            </span>
	            <ul>
	                <li><a href="<?php echo base_url() ?>auth/create_user"><span class="lbl">Add Contractor</span></a></li>
	                <li><a href="<?php echo base_url() ?>user/contractor_list"><span class="lbl">Contractor List</span></a></li>
	            </ul>
	        </li>
			
			<li class="orange-red with-sub
                  <?php if($this->uri->segment(2)=="create_member"){echo "opened";}?>
                  <?php if($this->uri->segment(2)=="client_list"){echo "opened";}?>
                  ">
	            <span>
	                <i class="font-icon font-icon-user"></i>
	                <span class="lbl">Client</span>
	            </span>
	            <ul>
	                <li><a href="<?php echo base_url() ?>auth/create_member"><span class="lbl">Add Client</span></a></li>
	                <li><a href="<?php echo base_url() ?>user/client_list"><span class="lbl">Client List</span></a></li>
	            </ul>
	        </li>


       		<li class="orange-red <?php if($this->uri->segment(2)=="add"){echo "opened";}?> ">
	             <a href="<?php echo base_url('assign_job/add') ?>" class="label-right">
	                <i class="font-icon font-icon-case-2"></i>
	                <span class="lbl">Assign Job</span>
	            </a>
	        </li>

	        <?php } ?>

	        <?php if($login_user->role=='members'){ ?>
            <li class="<?php if($this->uri->segment(2)=="profile"){echo "opened";}?>">
	            <a href="<?php echo base_url() ?>user/profile" class="label-right">
	                <i class="font-icon glyphicon glyphicon-user"></i>
	                <span class="lbl">Profile</span>
	            </a>
	        </li>

            <li class="red <?php if($this->uri->segment(2)=="certificate"){echo "opened";}?>">
	            <a href="<?php echo base_url() ?>user/certificate" class="label-right">
	                <i class="font-icon font-icon-contacts"></i>
	                <span class="lbl">Certificates</span>
	            </a>
	        </li>
            
            <?php /*
            <li class="red <?php if($this->uri->segment(2)=="parent_certificate"){echo "opened";}?>">
                <a href="<?php echo base_url() ?>user/parent_certificate" class="label-right">
                    <i class="font-icon font-icon-contacts"></i>
                    <span class="lbl">Parent Certificates</span>
                </a>
            </li>

            <li class="red <?php if($this->uri->segment(2)=="child_certificate"){echo "opened";}?>">
                <a href="<?php echo base_url() ?>user/child_certificate" class="label-right">
                    <i class="font-icon font-icon-contacts"></i>
                    <span class="lbl">Child Certificates</span>
                </a>
            </li>
            */ ?>
	         
	       
	        <?php } ?>
			
			 <?php if($login_user->role=='members' || ($this->ion_auth->is_admin()) ){ ?>

			  <li class="red with-sub
                    <?php if($this->uri->segment(2)=="addproperty"){echo "opened";}?>
                    <?php if($this->uri->segment(2)=="viewproperty"){echo "opened";}?>
              ">
	            <span>
	                <i class="font-icon font-icon-build"></i>
	                <span class="lbl">Properties</span>
	            </span>
	            <ul>
	                <li><a href="<?php echo base_url() ?>user/addproperty" class="label-right"><span class="lbl">Add Property</span></a></li>
	                <li><a href="<?php echo base_url() ?>user/viewproperty"><span class="lbl">All Properties</span></a></li>
	              
	            </ul>
	        </li>
			 <?php } ?>
             <?php if($this->ion_auth->is_admin()){ ?>
             <!--<li class="red <?php if($this->uri->segment(2)=="certificate"){echo "opened";}?>">
                <a href="<?php echo base_url() ?>user/email_logs" class="label-right">
                    <i class="font-icon font-icon-contacts"></i>
                    <span class="lbl">Email Logs</span>
                </a>
            </li>-->
             
             <?php } ?>
			 
			  <?php if($login_user->role=='members'){ ?>
			  

			  <li class="orange-red with-sub                   
                    <?php if($this->uri->segment(2)=="documentation"){echo "opened";}?>
                    <?php if($this->uri->segment(2)=="faq"){echo "opened";}?>              
                    <?php if($this->uri->segment(2)=="faq_search"){echo "opened";}?> ">
	            <span>
	                <i class="font-icon font-icon-help"></i>
	                <span class="lbl">Support</span>
	            </span>
	            <ul>
	                <li><a href="<?php echo base_url() ?>support/documentation"><span class="lbl">Docs (example)</span></a></li>
	                <li><a href="<?php echo base_url(); ?>support/faq"><span class="lbl">FAQ Simple</span></a></li>
	                <li><a href="<?php echo base_url() ?>support/faq_search"><span class="lbl">FAQ Search</span></a></li>
	            </ul>
	          </li>
			
			  <?php } ?>

              <?php if($login_user->role=='child_member'){ ?>
               
               <li class="red with-sub
                    <?php if($this->uri->segment(2)=="addproperty"){echo "opened";}?>
                    <?php if($this->uri->segment(2)=="viewproperty"){echo "opened";}?>
              ">
                <span>
                    <i class="font-icon font-icon-build"></i>
                    <span class="lbl">Properties</span>
                </span>
                <ul>
                    <li><a href="<?php echo base_url() ?>user/viewproperty"><span class="lbl">All Properties</span></a></li>
                  
                </ul>
               </li>

               <li class="orange-red with-sub                   
                    <?php if($this->uri->segment(2)=="documentation"){echo "opened";}?>
                    <?php if($this->uri->segment(2)=="faq"){echo "opened";}?>              
                    <?php if($this->uri->segment(2)=="faq_search"){echo "opened";}?> ">
                <span>
                    <i class="font-icon font-icon-help"></i>
                    <span class="lbl">Support</span>
                </span>
                <ul>
                    <li><a href="<?php echo base_url() ?>support/documentation"><span class="lbl">Docs (example)</span></a></li>
                    <li><a href="<?php echo base_url(); ?>support/faq"><span class="lbl">FAQ Simple</span></a></li>
                    <li><a href="<?php echo base_url() ?>support/faq_search"><span class="lbl">FAQ Search</span></a></li>
                </ul>
               </li>
              <?php } ?>
			

	        <?php if($login_user->role=='contractor'){ ?>
            <li class="<?php if($this->uri->segment(2)=="profile"){echo "opened";}?>">
	            <a href="<?php echo base_url() ?>user/profile" class="label-right">
	                <i class="font-icon glyphicon glyphicon-user"></i>
	                <span class="lbl">Profile</span>
	            </a>
	        </li>
			
			 <li class="orange-red <?php if($this->uri->segment(1)=="profile"){echo "opened";} ?>">
	            <a href="<?php echo base_url() ?>jobs" class="label-right">
	                <i class="font-icon font-icon-case-2"></i>
	                <span class="lbl">Jobs</span>
	            </a>
	        </li>
			
            <?php } ?>
               
	    </ul>

	  
	</nav><!--.side-menu-->