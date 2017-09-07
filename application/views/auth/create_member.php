<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
        <h5 class="m-t-lg with-border">Add Client</h5>
        <?php echo form_open("auth/create_member");?>
          
          <?php if(isset($message)){ ?>
          <div class="form-error-text-block">
            <?php echo $message;?>
          </div>
          <?php } ?>

          <div class="form-group row">
            <label class="col-sm-2 form-control-label">First Name</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $first_name['class']='form-control'; ?>
                <?php echo form_input($first_name);?>
              </p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 form-control-label">Last Name</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $last_name['class']='form-control'; ?>
                <?php echo form_input($last_name);?>
              </p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 form-control-label">Company</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $company['class']='form-control'; ?>
                <?php echo form_input($company);?>
              </p>
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-sm-2 form-control-label">Email</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $email['class']='form-control'; ?>
                <?php echo form_input($email);?>
              </p>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 form-control-label">Phone</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $phone['class']='form-control'; ?>
                <?php echo form_input($phone);?>
              </p>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 form-control-label">Password</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $password['class']='form-control'; ?>
                <?php echo form_input($password);?>
              </p>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 form-control-label">Confirm Password</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <?php $password_confirm['class']='form-control'; ?>
                <?php echo form_input($password_confirm);?>
              </p>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-2 form-control-label"></label>
            <div class="col-sm-10">
              <?php echo form_submit('submit', lang('create_user_submit_btn'),array('class'=>'btn btn-rounded btn-inline'));?>
            </div>
          </div>
        <?php echo form_close();?>
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>




<?php /*
<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>

      <p>
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>
      
      <?php
      if($identity_column!=='email') {
          echo '<p>';
          echo lang('create_user_identity_label', 'identity');
          echo '<br />';
          echo form_error('identity');
          echo form_input($identity);
          echo '</p>';
      }
      ?>

      <p>
            <?php echo lang('create_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close();?>
*/ ?>