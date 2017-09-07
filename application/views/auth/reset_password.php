
<style type="text/css">
.sign-box .sign-avatar {
    height: 60px;
    margin: 0 auto 10px;
    width: 100%;
} 
.alert span p{
  margin-bottom: 0px!important;
}
span.font-icon.fa.fa-check-square-o {
    margin: 5px 5px 0px 0px;
}
</style>
<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
        	<div id="infoMessage"><?php echo $message;?></div>

        	<?php echo form_open('auth/reset_password/' . $code,array('class' => 'sign-box'));?>
	        	<div class="sign-avatar">
	                <img src="<?php echo base_url(); ?>assest/img/logo.png" alt="">
	            </div>
	            <header class="sign-title"><?php echo lang('reset_password_heading');?></header>
	            <div class="form-group">
	            	<label for="new_password">
	            		<?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?>
	            	</label>
	                <?php $new_password['class']='form-control';?>
                    <?php echo form_input($new_password,array('class'=>'form-control'));?>
	            </div>
	            <div class="form-group">
	            	<label for="new_password">
	            		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
	            	</label> 
	                <?php $new_password_confirm['class']='form-control';?>
                    <?php echo form_input($new_password_confirm,array('class'=>'form-control'));?>
	            </div>
				<?php echo form_input($user_id);?>
				<?php echo form_hidden($csrf); ?>
				<?php echo form_submit('submit', lang('reset_password_submit_btn'),array('class'=>'btn btn-rounded'));?>
			<?php echo form_close();?>
		</div>
	</div>
</div>			



<?php /*

<h1><?php echo lang('reset_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('auth/reset_password/' . $code);?>

	<p>
		<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
		<?php echo form_input($new_password);?>
	</p>

	<p>
		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
		<?php echo form_input($new_password_confirm);?>
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></p>

<?php echo form_close();?>*/?>