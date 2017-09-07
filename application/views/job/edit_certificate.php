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
								<?php if(!empty($job_id)) { ?>
									<option value="<?php echo $cert_type['certificate_id'] ?>" <?php if($cert_type['certificate_id']==$all_certificate['certificate_type']){echo 'selected="selected"';} ?> <?php echo (in_array($cert_type['certificate_id'],$certificatestodisable) && $cert_type['certificate_id']!=$all_certificate['certificate_type']) ? 'disabled' : ''; ?>><?=$cert_type['certificate_name']?></option>
								<?php } else{ ?>
									<option value="<?php echo $cert_type['certificate_id'] ?>" <?php if($cert_type['certificate_id']==$all_certificate['certificate_type']){echo 'selected="selected"';} ?> ><?=$cert_type['certificate_name']?></option>
								<?php } ?>
								<? } ?>
							</select>
							<?php echo form_error('certificate_type'); ?>
							
							
							
						</fieldset>
					</div>
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label" for="certificate_date">Certificate Date</label>
							<div class="input-group date">
									<input class="form-control datepicker" name="certificate_date" id="daterange3" placeholder="" value="<?php echo $all_certificate['certificate_date'];?>" type="text">
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
							<input class="form-control" id="exampleInputPassword1" value=""  name="certificate_file"  type="file" <?php if(empty($all_certificate['certificate_file'])){ echo "required";}?>> 
							<?php echo form_error('certificate_file'); ?>
							
						</fieldset>
						<input type="hidden" name="certificate_file" id="certificate_file"/>
						<input type="hidden" name="old_certificate_file" id="old_certificate_file"/>
						<div id="uploaded_file"></div>
						<?php  if($all_certificate['certificate_file']) { ?>
						<div class="alert alert-success fade in existing_file">
	                      	<a href="#" class="close close_cert" id="<?php echo $all_certificate['certificate_unique_id'] ?>">&times;</a>
	                   		<a href="<?php echo base_url() ?>uploads/cert/<?php echo $all_certificate['certificate_file'] ?>" title="View file" id="certificate_file_name"><?php echo $all_certificate['certificate_file'] ?></a>
                     	</div>
                     	<?php }  ?>
						
					</div>
					
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label" for="file_input">Other Certificate File</label>
							<input class="form-control" id="file_input" value=""  name="other_certificate_file[]"  type="file" multiple="multiple"> 
							<?php //echo form_error('certificate_file'); ?>
							<input type="hidden" name="certificate_property_id" value="<?php echo $all_certificate['certificate_property_id'] ?>" >
							
						</fieldset>	
						<div id="uploaded_multiple_file"></div>
						<?php  if(!empty($other_certificate)) { 
							//echo "<pre>";print_r($other_certificate); echo "</pre>"; exit();
							foreach ($other_certificate as $other_cert) {?>
								<div class="alert alert-success fade in">
			                      	<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
			                   		<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file"><?php echo $other_cert['other_certificate_file'] ?></a>
		                     	</div>
	                     	<?php }  ?>	
                     	<?php }  ?>			
					</div>
					
					
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-group">
							
							<button type="submit" style="" class="btn btn-inline btn-lg">Update Certificate</button>
							 
							 <a href="<?php echo base_url('jobs/view_certificate/'.$property_unique_id."/".$job_id) ?>" ><button type="button" style="" class="btn btn-inline danger btn-lg">Cancel</button></a>
							
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
$(document).on("click",".close_other_cert",function(e){
    e.preventDefault();
    var certificate_unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to Delete this Certificate ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Certificate",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>jobs/delete_otherCertificateAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{certificate_unique_id:certificate_unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url() ?>jobs/edit_certificate/<?php echo $this->uri->segment(3); ?>/';

                   }
                }
             });
          
         

        });
  }); 
</script>
<script type="text/javascript">
$(document).on("click",".close_cert",function(e){
    e.preventDefault();
    var certificate_unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to Delete this Certificate ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Certificate",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>jobs/delete_CertificateAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{certificate_unique_id:certificate_unique_id},
                success:function(result){
                   if(result=='updated'){
                       window.location.href='<?php echo base_url() ?>jobs/edit_certificate/<?php echo $this->uri->segment(3); ?>/';

                   }
                }
             });
          
         

        });
  }); 
</script>

<script type="text/javascript">
$(document).on("click",".close_multiple",function(e){
    e.preventDefault();
    var filename=$(this).siblings("a").text();
    swal({
          title: "Are you sure?",
          text: "You want to Delete this Certificate ?",
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
</script>

<script type="text/javascript">
$(function(){
	$("#exampleInputPassword1").change(function(){
		var file_data = $(this).prop('files')[0];
		var certificate_id=$(".existing_file > .close_cert").attr('id');
		$("#exampleInputPassword1").val('');
		$("#exampleInputPassword1").removeAttr('required');
			var base_url="<?php echo base_url(); ?>";
			$('.loading').css('display','block');
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			var url=base_url+"jobs/uploadjobcertificates";
			$.ajax({
                url: url, // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    var html='<div class="alert alert-success fade in">';
                    html +='<a href="#" class="close close_cert" id='+certificate_id+'>×</a>';
                    html +='<a id="file_link_single" href="<?php echo base_url(); ?>uploads/cert/'+php_script_response+'" title="View file">'+php_script_response+'</a>';
                    html +='</div>';
					
					$("#old_certificate_file").val($(".existing_file > #certificate_file_name").text());
				    $(".existing_file").remove();	
						
					$("#uploaded_file").html(html);
					$("#certificate_file").val(php_script_response);
					$('.loading').css('display','none'); // display response from the PHP script, if any
                }
			});
	});
});
</script>

<script type="text/javascript">
$(function(){
	$("#file_input").change(function(){
		var flag=0;
		$('.loading').css('display','block');
		var totallength=$(this).get(0).files.length;
		var certificate_id=$(".existing_file > .close_cert").attr('id');
		for (var i = 0; i < $(this).get(0).files.length; ++i) {
			var file_data = $(this).prop('files')[i];
			var base_url="<?php echo base_url(); ?>";
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			var url=base_url+"user/uploadmultiplejobcertificates";
			
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
});
</script>