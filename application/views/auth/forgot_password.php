<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
            
            <?php echo form_open("auth/forgot_password",array('class'=>'sign-box reset-password-box'));?>
                <!--<div class="sign-avatar">
                    <img src="img/avatar-sign.png" alt="">
                </div>-->
                <header class="sign-title">Reset Password</header>
                
                <?php if(isset($message)){ ?>
                <div role="alert" class="alert alert-danger animated fadeInDown">
                   <button data-notify="dismiss" class="close" aria-hidden="true" type="button">×</button>
                   <span data-notify="icon" class="font-icon font-icon-warning"></span>
                   <span data-notify="title"><strong>Error</strong></span>
                   <span data-notify="message">
                     <p><?php echo $message ?></p>
                   </span><a data-notify="url" target="_blank" href="#"></a>
                </div>
                <?php } ?>

                <div class="form-group">
                    <!-- <input type="text" class="form-control" placeholder="E-Mail or Phone"/> -->
                    <?php $identity['class']='form-control'; $identity['placeholder']='E-Mail' ?>
                    <?php echo form_input($identity);?>
                </div>
                <!-- <button type="submit" class="btn btn-rounded">Reset</button> -->
                <?php echo form_submit('submit', lang('forgot_password_submit_btn'),array('class'=>'btn btn-rounded'));?>

                or <a href="<?php echo base_url() ?>auth/login">Sign in</a>
            <?php echo form_close();?>
        </div>
    </div>
</div><!--.page-center-->


<?php /*

<h1><?php echo lang('forgot_password_heading');?></h1>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity);?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>

<?php echo form_close();?>
*/ ?>