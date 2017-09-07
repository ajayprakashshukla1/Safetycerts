<style type="text/css">
.sign-box .sign-avatar {
    height: 100px;
    margin: 0 auto 10px;
    width: 100%;
}  
</style>

<div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                
                <?php echo form_open("auth/login",array('class' => 'sign-box'));?>
                    <div class="sign-avatar">
                        <img src="<?php echo base_url(); ?>assest/img/logo.jpg" alt="">
                    </div>
                    <header class="sign-title">Sign In</header>

                    <?php if(isset($message)){ ?>
                    <div role="alert" class="alert alert-danger animated fadeInDown">
                       <button data-notify="dismiss" class="close" aria-hidden="true" type="button">×</button>
                       <span data-notify="icon" class="font-icon font-icon-warning"></span>
                       <span data-notify="title"><strong>Error</strong></span>
                       <span data-notify="message"><?php echo $message;?></span><a data-notify="url" target="_blank" href="#"></a>
                    </div>
                    <?php } ?>



                    <div class="form-group">
                       
                       <?php $identity['class']='form-control'; $identity['placeholder']='Email'; ?>
                       <?php echo form_input($identity,array('class'=>'form-control'));?>
                    </div>
                    <div class="form-group">
                        <?php $password['class']='form-control'; $password['placeholder']='Password'; ?>
                        <?php echo form_input($password);?>
                    </div>
                    <div class="form-group">
                        <!-- <div class="checkbox float-left">
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
                            <label for="signed-in">Keep me signed in</label>
                        </div> -->
                        <div class="float-right reset">
                            <a href="forgot_password"><?php echo 'Reset Password'; ?></a>
                        </div>
                    </div>
                    
                    <?php echo form_submit('submit', lang('login_submit_btn'),array('class'=>'btn btn-rounded'));?>

                    <p class="sign-note">New to our website? <a href="<?php echo base_url() ?>apply">Sign up</a></p>
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                <?php echo form_close();?>
            </div>
        </div>
    </div><!--.page-center-->





<?php /*


<h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>

  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

<?php echo form_close();?>

<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>


*/ ?>