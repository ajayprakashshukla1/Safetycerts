<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>
<?php
$ci =&get_instance();
$ci->load->model('assignjob_model');
$propertyid=$ci->assignjob_model->get_property_unique_id($assigned_jobs['job_prop_id']);
$propertyid=$propertyid['unique_id'];

$certificates=json_decode($assigned_jobs['certficate_id']);

?>
<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
      	<p>
      	<?php
	  		if(isset($msg) && !empty($msg)){
      			if(base64_decode($msg) == 'success'){
					
      	?>
		<div class="alert alert-success alert-dismissable">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Success!</strong> Job details updated successfully.
		</div>
			<?php
      			}
      		 
      		}
      		?>
      	
      	</p>
        <h5 class="m-t-lg with-border">Edit Job</h5>

		  <div class="row">
		    <div class="col-md-4">
				Select Property
			</div>
			<div class="col-md-4">
				<select class="select2 select2-hidden-accessible form-control" tabindex="-1" data-validation="[NOTEMPTY]" id="property_id" aria-hidden="true">
				   <option value="">Select Property</option>
				   <?php foreach($property_list as $PL){ ?>    
					  <option value="<?php echo $PL['unique_id'] ?>" <?php echo ($propertyid==$PL['unique_id']) ? 'selected' : ''; ?>><?php echo $PL['name']; ?></option>
					<?php } ?>
				</select>
				<div id="msg" style="color:red"></div>
				<br><br>
			</div>
			
			
			<div style="clear:both;"></div>
			
			<div class="col-md-4">
				Select Certificates
			</div>
			
			<div style="clear:both;">&nbsp;</div>
		
			<div class="col-md-12">
				<?php foreach($allcertificates as $PL){ ?>    
				  <div class="col-md-6">
					<input type="checkbox" name="certificate[]" value="<?php echo $PL['certificate_id']; ?>" class="certificate_id certificate_<?php echo $PL['certificate_id']; ?>" <?php echo in_array($PL['certificate_id'],$certificates) ? 'checked' : ''; ?>> <?php echo $PL['certificate_name'] ?>
				  </div>	
				<?php } ?>
				<div style="clear:both;">&nbsp;</div>
				<div id="certificate_msg" style="color:red"></div>
				<br><br>
			</div>
			
			<div class="col-md-12" style="float:right;">
				<input type="hidden" value="<?php echo $assigned_jobs['job_id']; ?>" id="job_id"/>
				<input type="hidden" value="<?php echo base64_encode($assigned_jobs['job_id']); ?>" id="job_id_encoded"/>
				<input type="hidden" value="<?php echo base64_encode("success"); ?>" id="message"/>
				<input type="hidden" value="<?php echo $unique_id; ?>" id="unique_id"/>
				<button class="btn" type="submit" id="assign_job">Edit Job</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">Cancel</button>
			</div>
		 </div>
	  </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>

<script type="text/javascript">
	$(function(){
		$("#assign_job").click(function(){

		  if($("#property_id").val()==''){
			  $('#msg').html('Please select Property');
			  return false;
		  }
		  
		   if($("#certificates_id").val()==''){
			  $('#certificate_msg').html('Please select Certificate');
			  return false;
		  }
		  
			 var arr = [];
			 var i=0;
			   $('.certificate_id:checked').each(function () {
				   arr[i++] = $(this).val();
			   });      
			
			if(arr.length==0){
			  $('#certificate_msg').html('Please select Certificate');
			  return false;
			}   
			
			
			$.post("<?php echo base_url('assign_job/edit_job') ?>",
			{
				job_prop_id: $("#property_id").val(),
				certificate_id: arr,
				job_id: $("#job_id").val()
			},
			function(data, status){
				var var_data = $.parseJSON(data);
				if(var_data.status=="ok"){
					
				var url="<?php echo base_url('assign_job/edit/'); ?>"+$("#unique_id").val()+"/"+$("#job_id_encoded").val()+"/"+$("#message").val();
				
				  window.location.href=url;
				}

			});
			
		});
		
		$("#cancel").click(function(){
			var url="<?php echo base_url('assign_job/add/'); ?>"+$("#unique_id").val();
				
			window.location.href=url;
		});
	});
</script>