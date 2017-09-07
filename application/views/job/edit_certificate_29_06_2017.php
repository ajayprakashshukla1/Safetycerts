<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}
.error { color:red; } 

h1.with-border, h2.with-border, h3.with-border, h4.with-border, h5.with-border, h6.with-border {
    padding-bottom: 1.8rem;
} 
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
		
        <h5 class="m-t-lg with-border">Edit Certificate
         
         

        </h5>
		 

			<div class="card-block row">
			<?php 
           if($this->session->flashdata('message')) {?>
            <div class="alert alert-success fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
             <strong>Success!</strong> <?php echo $this->session->flashdata('message'); ?>
            </div>
            <?php 
			} ?>
			<?php //echo validation_errors(); ?>
			<form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1"  action="">
			<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="certificate_name">Cerificate Name</label>
							<input class="form-control" id="certificate_name" value="<?=$all_certificate['certificate_name']?>"  placeholder="Enter Certificate name"  name="certificate_name" type="text">
							<?php echo form_error('certificate_name'); ?>
							
						</fieldset>
					</div>
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label" for="certificate_type">Certificate Type</label>
							<select class="form-control" name="certificate_type">
							<?php foreach($cert_types as $cert_type) { ?>
								<option value="<?php echo $cert_type['certificate_id'] ?>" <?php if($cert_type['certificate_id']==$all_certificate['certificate_type']){echo 'selected="selected"';} ?>><?=$cert_type['certificate_name']?></option>
								<? } ?>
							</select>
							<?php echo form_error('certificate_type'); ?>
							
							
							
						</fieldset>
					</div>
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label" for="certificate_date">Certificate Date</label>
							<div class="input-group date">
									<input class="form-control datepicker" name="certificate_date" id="daterange3" placeholder="" value="<?=$all_certificate['certificate_date']?>" type="text">
									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
								<?php echo form_error('certificate_date'); ?>
							
						</fieldset>
						
					</div>
					
					<div class="col-lg-12">
						<div class="form-group" style="">
							       <div class='input-group'>
							         <label>Validity period</label>
								     <select class="form-control" name="certificate_expire">
								        
				                        <option value="1 Month"<?php if($all_certificate['certificate_expire'] == '1 Month') { ?> selected="selected"<? } ?>>1 Month</option>
				                        <option value="3 Months"<?php if($all_certificate['certificate_expire'] == '3 Months') { ?> selected="selected"<? } ?>>3 Months</option>
				                        <option value="6 Months"<?php if($all_certificate['certificate_expire'] == '6 Months') { ?> selected="selected"<? } ?>>6 Months</option>
				                        <option value="1 Year"<?php if($all_certificate['certificate_expire'] == '1 Year') { ?> selected="selected"<? } ?>>1 Year</option>
				                        <option value="3 Years"<?php if($all_certificate['certificate_expire'] == '3 Years') { ?> selected="selected"<? } ?>>3 Years</option>
				                        <option value="5 Years"<?php if($all_certificate['certificate_expire'] == '5 Years') { ?> selected="selected"<? } ?>>5 Years</option>
				                        <option value="10 Years"<?php if($all_certificate['certificate_expire'] == '10 Years') { ?> selected="selected"<? } ?>>10 Years</option>
								     </select>
									 <?php echo form_error('certificate_expire'); ?>
							      </div>
						      </div>
						
					</div>
					
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label" for="exampleInputPassword1">Certificate File</label>
							<input class="form-control" id="exampleInputPassword1" value=""  name="certificate_file"  type="file"> 
							<?php echo form_error('certificate_file'); ?>
							
						</fieldset>

						<div class="alert alert-success fade in">
	                      <a href="#" class="close" data-dismiss="alert">&times;</a>
	                   <a href="<?php echo base_url() ?>uploads/cert/<?php echo $all_certificate['certificate_file'] ?>" title="View file"><?php echo $all_certificate['certificate_file'] ?></a>
                     </div>
						
					</div>
					
					
					
					
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-group">
							
							<button type="submit" style="" class="btn btn-inline btn-lg">Update Certificate</button>
							 
							 <a href="<?php echo base_url('jobs/view_certificate/'.$property_unique_id) ?>" ><button type="button" style="" class="btn btn-inline danger btn-lg">Cancel</button></a>
							
						</fieldset>
					</div>
					
				</div>
				</form>
				
				
	</div>

        
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>