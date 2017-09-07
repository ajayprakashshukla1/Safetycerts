<style type="text/css">
	.sweet-alert .btn{
	  min-width: 0px;
	}
	.error { color:red; } 

	h1.with-border, h2.with-border, h3.with-border, h4.with-border, h5.with-border, h6.with-border {
	    padding-bottom: 1.8rem;
	} 
</style>
<div class="loading" style="display:none;">Loading&#8230;</div>
<div class="page-content">
   	<div class="container-fluid">
      	<div class="box-typical box-typical-padding">		
        	<h5 class="m-t-lg with-border">Upload Certificate         
	         	<div style="float: right">
	           		<?php if($this->ion_auth->is_admin() || $login_user->role=='contractor'){ ?>		
		          		<a href="<?php echo base_url('jobs') ?>" style="color:#FFFFFF">
		          			<button type="submit" style="" class="btn btn-inline">All Jobs</button>
		          		</a> 
	           		<?php } ?>
	           		<a style="color:#FFFFFF" href="<?php echo base_url('jobs/view_certificate/'.$unique_id) ?>">
	           			<button type="submit" style="" class="btn btn-inline">View All Certificates</button>
	           		</a>
	         	</div>
	        </h5>
			<div class="card-block row">
				<?php if($this->session->flashdata('message')) {?>
	            	<div class="alert alert-success fade in">
	            		<a href="#" class="close" data-dismiss="alert">&times;</a>
	             		<strong>Success!</strong> 
	             		<?php echo $this->session->flashdata('message');?>
	            	</div>
	            <?php } ?>
				<?php //echo validation_errors(); ?>
				<form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1">
				<input type="hidden" name="token" id="token" value="<?php echo $token ?>">
					<div class="row">
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="certificate_name">Cerificate Name</label>
								<input class="form-control" id="certificate_name"  placeholder="Enter Certificate name" value="<?php echo set_value('certificate_name'); ?>" name="certificate_name" type="text">
								<?php echo form_error('certificate_name'); ?>							
							</fieldset>
						</div>
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label" for="certificate_date">Certificate Type</label>
								
								<select name="certificate_type" class="form-control">
									<?php foreach($certificate_list as $CL){ ?>
									 <option value="<?php echo $CL['certificate_id']; ?>" <?php echo (isset($type) && $type==$CL['certificate_id']) ? 'selected' : ''; ?>><?php echo $CL['certificate_name']; ?></option>
									<?php
										
										}
										
										echo form_error('certificate_type');
									?>
								</select>
								</select>
							</fieldset>
						</div>
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label" for="certificate_date">Certificate Date</label>
								<div class="input-group date">
									<input class="form-control datepicker" value="<?php echo set_value('certificate_date'); ?>"  name="certificate_date" id="daterange3" placeholder="" value="" type="text">
									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
								<?php echo form_error('certificate_date'); ?>
							</fieldset>						
						</div>					
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInputPassword1">Certificate Expire time</label>
								<?php  $options = array();
									$options['1 Month']='1 Month';
									$options['3 Months']='3 Months';
									$options['6 Months']='6 Months';
									$options['1 year']='1 Year';
									$options['3 years']='3 Years';								
									$options['5 years']='5 Years';
									$options['10 years']='10 Years';
									
									$js = array('class'       => 'form-control');
									   
									echo form_dropdown('certificate_expire', $options, set_value('certificate_expire'),$js);?>
								<small class="text-muted">it will be valid from Certificate Date.</small>
								<?php echo form_error('certificate_expire'); ?>
							</fieldset>						
						</div>					
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInputPassword1">Certificate File</label>
								<input class="form-control" id="exampleInputPassword1" value="<?php echo set_value('certificate_file'); ?>"  name="certificate_file"  type="file"  onchange="uploadcertfile(this.files[0],'certificate_file','exampleInputPassword1')"> 
								<?php //echo form_error('certificate_file'); ?>

								<div id="uploaded_cert_file"></div>
							</fieldset>						
						</div>
						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label" for="file_input">Other Certificate File</label>
								<input class="form-control" id="other_certificate_file" value=""  name="other_certificate_file[]"  type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'certificate_file','other_certificate_file')"> 
								<?php //echo form_error('certificate_file'); ?>
									<div id="uploaded_other_certificate_file"></div>						
							</fieldset>
						</div>				
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<fieldset class="form-group">							
								<button type="submit" style="" class="btn btn-inline btn-lg">Upload Now</button>
								<a href="<?php echo base_url('jobs/view_certificate/'.$unique_id) ?>" ><button type="button" style="" class="btn btn-inline danger btn-lg">Cancel</button></a>							
							</fieldset>
						</div>					
					</div>
				</form>
			</div>        
	    </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>
<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>

<script type="text/javascript">

function uploadcertfile(file,cert_type,file_id){
    
	var token= $('#token').val();
    var path="<?php echo base_url() ?>/jobs/uploadCertAjax?cert_type="+cert_type+"&token="+token+"";
    $('.loading').css('display','block');
	  $.ajax({
	   type: 'POST', 
	   url: path,
	   //enctype: 'multipart/form-data',
	   data:new FormData($('#form-signin_v1')[0]),
	   contentType: false,
	   processData: false,
	   cache: false,
	   success: function(response){
	      if(response){
	      	 $('#uploaded_cert_file').empty();
	      	 $('#uploaded_cert_file').append('<div class="alert alert-success fade in">'+
	                      	   '<a href="javascript:void(0)" class="close close_cert"  onclick="deleted_cert_files('+token+','+"'"+cert_type+"'"+','+"'"+response+"'"+')">×</a>'+
	                   		   '<a href="http://www.safetycerts.co.uk/safetycerts/uploads/cert/'+response+'" title="View file">'+response+'</a>'+
                     	       '</div>');
	      }

	      $('.loading').css('display','none');

	      var $el = $('#'+file_id);
          $el.wrap('<form>').closest('form').get(0).reset();
          $el.unwrap();

          //$('#'+file_id).attr('required',false);

	   }
	 });
}



function uploadothercertfile(file,cert_type,file_id){

	var token= $('#token').val();
    var path="<?php echo base_url() ?>/jobs/uploadOtherCertAjax?cert_type="+cert_type+"&token="+token+"&cert_name="+file_id+"";
    $('.loading').css('display','block');
	  $.ajax({
	   type: 'POST', 
	   url: path,
	   //enctype: 'multipart/form-data',
	   data:new FormData($('#form-signin_v1')[0]),
	   contentType: false,
	   processData: false,
	   cache: false,
	   success: function(response){
	      if(response){
	      	var obj = $.parseJSON(response);
	      	$.each(obj, function( index, value ) {
			   
			   $('#uploaded_other_certificate_file').append('<div class="alert alert-success fade in" id="other_'+index+'">'+
	                      	   '<a href="javascript:void(0)" class="close close_cert" onclick="deleted_Othercert_files('+token+','+"'"+cert_type+"'"+','+"'"+file_id+"'"+','+"'"+value+"'"+','+index+')">×</a>'+
	                   		   '<a href="http://www.safetycerts.co.uk/safetycerts/uploads/cert/'+value+'" title="View file">'+value+'</a>'+
                     	       '</div>');
			});
	      	 
	      }

	      var $el = $('#'+file_id);
          $el.wrap('<form>').closest('form').get(0).reset();
          $el.unwrap();

	      $('.loading').css('display','none');

	   }
	 });
}

</script>


<script type="text/javascript">

function deleted_cert_files(token,cert_type,file_name){
	
    var path="<?php echo base_url() ?>user/removecertificatesfiles";
    //alert(path);
    $.ajax({
	    type: 'POST',
        url: path,
        data: {token:token,cert_type:cert_type,file_name:file_name},                         
        success: function(response){
        	if(response=="deleted"){
        		$("#uploaded_cert_file").html('');	
        	}
			
			
        }
	});
}


</script>

<script type="text/javascript">

function deleted_Othercert_files(token,cert_type,other_cert_type,file_name,index){
    var path="<?php echo base_url() ?>user/removeOthercertificatesfiles";

    //alert(path);
    $.ajax({
	    type: 'POST',
        url: path,
        data: {token:token,cert_type:cert_type,other_cert_type:other_cert_type,file_name:file_name},                         
        success: function(response){
			if(response=="deleted"){
				$("#other_"+index).remove();
			}	
        }
	});
		
}


</script>
