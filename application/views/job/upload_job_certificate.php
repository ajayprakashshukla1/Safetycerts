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
          <a href="<?php echo base_url('jobs') ?>" style="color:#FFFFFF"> <button type="submit" style="" class="btn btn-inline">All Jobs</button></a> 
           <?php } ?>

           <a style="color:#FFFFFF" href="<?php echo base_url('jobs/view_certificate/'.$unique_id) ?>"><button type="submit" style="" class="btn btn-inline">View All Certificates</button></a>

         </div>

        </h5>
		 

			<div class="card-block row">
			<?php 
            if($this->session->flashdata('message')) {?>
            <div class="alert alert-success fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
             <strong>Success!</strong> <?php echo $this->session->flashdata('message');?>
            </div>
            <?php 
			} ?>
			
			<?php 
            if($this->session->flashdata('error')) {?>
            <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
             <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
            </div>
            <?php 
			} ?>
			<?php //echo validation_errors(); ?>
			<form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1">
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
									<option value="<?php echo $CL['id']; ?>" <?php echo in_array($CL['id'], $certificatestodisable) ? "disabled" : ''; ?>><?php echo $CL['name']; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('certificate_type'); ?>
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
							<?php 
								$options = array();

								$options['1 Month']='1 Month';
								$options['3 Months']='3 Months';
								$options['6 Months']='6 Months';
								$options['1 year']='1 Year';
								$options['3 years']='3 Years';								
								$options['5 years']='5 Years';
								$options['10 years']='10 Years';
									
									$js = array(
								        'class'       => 'form-control',
								);
								   
								echo form_dropdown('certificate_expire', $options, set_value('certificate_expire'),$js);?>
							<small class="text-muted">it will be valid from Certificate Date.</small>
							<?php echo form_error('certificate_expire'); ?>
						</fieldset>
						
					</div>
					
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label" for="exampleInputPassword1">Certificate File</label>
							<input class="form-control" id="exampleInputPassword1" value="<?php echo set_value('certificate_file'); ?>"  name="certificate_file"  type="file"> 
							<?php echo form_error('certificate_file'); ?>
						</fieldset>
						<input type="hidden" name="certificate_file" id="certificate_file"/>
						<div id="uploaded_file"></div>
					</div>
					
					<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label" for="file_input">Other Certificate File</label>
								<input class="form-control" id="file_input" value=""  name="other_certificate_file[]"  type="file" multiple="multiple"> 
								<?php //echo form_error('certificate_file'); ?>
															
							</fieldset>
							<div id="uploaded_multiple_file"></div>
						</div>	
					
					
					
					
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-group">
							
							<button type="submit" style="" class="btn btn-inline btn-lg">Upload Now</button>
							 <a href="<?php echo base_url('jobs/view_certificate/'.$unique_id."/".$job_id) ?>" ><button type="button" style="" class="btn btn-inline danger btn-lg">Cancel</button></a>
							
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
$(function(){
	$("#file_input").change(function(){
		var flag=0;
		$('.loading').css('display','block');
		var totallength=$(this).get(0).files.length;
		for (var i = 0; i < $(this).get(0).files.length; ++i) {
			var file_data = $(this).prop('files')[i];
			var base_url="<?php echo base_url(); ?>";
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			var url=base_url+"jobs/uploadmultiplejobcertificates";
			
			$.ajax({
                url: url, // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
				async: true,
                success: function(php_script_response){
					$("#file_input").val('');
					if(php_script_response)
						flag++;
					
					var html='<div class="alert alert-success fade in">';
                    html +='<a href="#" class="close close_multiple" id='+i+'>×</a>';
                    html +='<a class="multiple_files" id="file_link_'+i+'" href="<?php echo base_url(); ?>uploads/cert/'+php_script_response+'" title="View file">'+php_script_response+'</a>';
                    html +='</div>';
					
					$("#uploaded_multiple_file").append(html);
					
					var input_html="<input type=hidden class='other_certificate_uploaded' name='other_certificate[]' value='"+php_script_response+"'/>";
					
					$("#uploaded_multiple_file").append(input_html);
					
					if(flag==totallength && php_script_response)
						$('.loading').css('display','none'); // display response from the PHP script, if any
					
                }
			});
		}
		
	})
})
</script>

<script type="text/javascript">
$(function(){
	$("#exampleInputPassword1").change(function(){
		var file_data = $(this).prop('files')[0];
		var base_url="<?php echo base_url(); ?>";
		$('.loading').css('display','block');
		var form_data = new FormData();                  
		form_data.append('file', file_data);
		var url=base_url+"user/uploadjobcertificates";
		
		$.ajax({
                url: url, // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
					$("#exampleInputPassword1").val('');
					$("#exampleInputPassword1").removeAttr('required');
                    var html='<div class="alert alert-success fade in">';
                    html +='<a href="#" class="close close_cert">×</a>';
                    html +='<a id="file_link_single" href="<?php echo base_url(); ?>uploads/cert/'+php_script_response+'" title="View file">'+php_script_response+'</a>';
                    html +='</div>';
					
					$("#uploaded_file").html(html);
					$("#certificate_file").val(php_script_response);
					$('.loading').css('display','none'); // display response from the PHP script, if any
                }
			}); 
	})
})
</script>

<script type="text/javascript">
$(function(){
	$(document).on('click','.close_cert',function(e){
		e.preventDefault();
		var filename=$('#file_link_single').text();
		var base_url="<?php echo base_url(); ?>";
		var url=base_url+"jobs/removeuploadjobcertificates/"+filename;
		
		swal({
          title: "Are you sure?",
          text: "You want to delete certificate?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Certificate",
          closeOnConfirm: true
        },
        function(){
			$.ajax({
                url: url, // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                type: 'GET',
                success: function(php_script_response){
					$("#uploaded_file").html('');
					$("#exampleInputPassword1").attr('required','required');
                }
			});  
        });
	});
})
</script>

<script type="text/javascript">
$(function(){
	$(document).on('click','.close_multiple',function(e){
		e.preventDefault();
		var filename=$(this).siblings("a").text();
		
		swal({
          title: "Are you sure?",
          text: "You want to delete certificate?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Certificate",
          closeOnConfirm: true
        },
        function(){
			var base_url="<?php echo base_url(); ?>";
			var url=base_url+"user/removeuploadjobcertificates/"+filename;
			
			$.ajax({
					url: url, // point to server-side PHP script 
					dataType: 'text',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false,
					processData: false,
					type: 'GET',
					success: function(php_script_response){
						console.log('success');
					}
				}); 
			$(".multiple_files").each(function(i){
				if($(this).text()==filename){
					$(this).parent("div").remove();
				}
			});  
			
			$(".other_certificate_uploaded").each(function(i){
				if($(this).val()==filename)
					$(this).remove();
			});
        });
	});
})
</script>