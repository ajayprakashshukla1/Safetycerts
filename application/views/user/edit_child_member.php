<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
        <h5 class="m-t-lg with-border">Edit Child Member</h5>
        <?php echo form_open("user/update_child_member");?>
          
          <?php if(isset($message)){ ?>
          <div class="form-error-text-block">
            <?php echo $message;?>
          </div>
          <?php } ?>


          <?php echo form_input($id);?>

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
            <label for="" class="col-sm-2 form-control-label"></label>
            <div class="col-sm-10">
              <?php echo form_submit('submit', 'Update',array('class'=>'btn btn-rounded btn-inline'));?>
            </div>
          </div>
        <?php echo form_close();?>
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>


