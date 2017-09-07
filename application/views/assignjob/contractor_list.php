<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>


<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
      	
        <h5 class="m-t-lg with-border">Assign Job</h5>

		  <div class="row">
		     <div class="col-md-3">
			    Select Contractor
			 </div>

      	
			 <div class="col-md-3">
				<select class="select2 select2-hidden-accessible form-control" tabindex="-1" aria-hidden="true" onchange="go_contractor(this.value)">
				 <option value="">Select Contractor</option>
				  <?php foreach($user_lists as $user){ ?> 
					<option value="<?php echo $user->unique_id ?>" <?php if($unique_id==$user->unique_id){ echo "selected='selected'";} ?>><?php echo $user->first_name." ".$user->last_name ?></option>
				  <?php } ?>
				</select>
				<br>
				<br>
				
			 </div>

			<?php if($unique_id){ ?>				
			  <div class="col-md-6">
			    <button type="button" style="float:right" class="btn btn-inline btn-lg" data-toggle="modal" data-target="#myModal">Assign Job to <?php echo ucfirst($contractor_details->first_name." ".$contractor_details->last_name);?></button>
			  </div>
			<?php } ?>
		 </div>
			
			
			

<?php if(isset($_GET['msg'])) { ?>			
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Success!</strong> Job deleted successfully
	</div>
<?php } ?>
			

<?php if($unique_id){ ?>			


 <h5 class="m-t-lg with-border">My Assigned Jobs to <a href="<?php echo base_url('user/edit_contrator/'.$contractor_details->unique_id) ?>"><?php echo ucfirst($contractor_details->first_name." ".$contractor_details->last_name); ?></a></h5>

	<div class="card-block row">
		<table id="example" class="display table table-striped table-bordered">
          <thead>
            <tr>
              <th width="1">#</th>
              <th>Property Name</th>
              <th>Job Address</th>
              <th>Certificates</th>
              <th>Assign Date</th>
			  <th class="table-icon-cell">Status</th>
			  <th class="table-icon-cell">Uploaded<br/>Certificates</th>
              <th class="table-icon-cell" style="width:70px;">Action</th>
            </tr>
           </thead>
           <tbody id='table_data'>
             <?php // echo "<pre>"; print_r($job_lists); ?>
             <?php $i=1; $CI =& get_instance(); $CI->load->model('assignjob_model'); foreach($job_lists as $joblist){  ?> 
				<?php 
					$certificatesselected=json_decode($joblist['certficate_id']);
					foreach($certificatesselected as $key=>$val){
						$current_certificates= $CI->assignjob_model->getcertificate($val);
						if($key==0)
							$current_certificates_value=$current_certificates[0]['certificate_name'];
						else
							$current_certificates_value.=$current_certificates[0]['certificate_name'];
						
						if (array_key_exists($key+1,$certificatesselected)){
							$current_certificates_value.=" , ";
						}
					}
					
					$CI =& get_instance();
					$CI->load->model('assignjob_model');
					$prop_id = $CI->assignjob_model->get_prop_by_uniqueid($joblist['prop_unique_id']);
					
					$assigned_job =$CI->assignjob_model->list_all_property_job($prop_id);
					$certificate_ids=json_decode($assigned_job[0]['certficate_id']);	
					$required_certificates=count($certificate_ids);	
					$uploded_certificate=count($CI->assignjob_model->list_all_property_certificate($prop_id,$joblist['job_id']));	
				
				?>
              <tr>
                 <td><?php echo $i; ?></td>
                 <td><a href="<?php echo base_url('user/property_details/'.$joblist['prop_unique_id']); ?>"><?php echo $joblist['name']; ?></a></td>
                 <td><?php echo $joblist['address'] ?></td>
                 <td><?php echo $current_certificates_value; ?></td>
                 <td class="color-blue-grey-lighter"><?php echo date('d/m/Y',strtotime($joblist['created_date'] )); ?></td>
                 
                 <td class="table-icon-cell">
					<?php 
					/*
					 if($joblist['prop_status']==1){
						 echo '<span class="label label-success">Completed</span>';
					 }
					 else if($joblist['prop_status']==2){
						echo '<span class="label" style="background-color:#fdad2a">In Progress</span>'; 
					 }
					 else
					 {
						 echo '<span class="label label-danger">Pending</span>'; 
					 }
					 */
					 
					 if($uploded_certificate==0){
						 echo '<span class="label label-danger">Pending</span>'; 
					 }
					 else if($uploded_certificate < $required_certificates){
						 echo '<span class="label" style="background-color:#fdad2a">In Progress</span>'; 
					 }
					 else{
						 echo '<span class="label label-success">Completed</span>';
					 }
					?> 
                 </td>
				 <th style="text-align:center;"><?php echo $uploded_certificate." / ".$required_certificates ?></th>
				 <td class="table-icon-cell">
				   <?php if($uploded_certificate != $required_certificates) { ?>
						<a href="<?php echo base_url('jobs/upload_job_certificate/'.$joblist['prop_unique_id']."/".base64_encode($joblist['job_id'])) ?>" title="Upload Certificates" class="menu"><i class="font-icon font-icon-upload"></i></a> | 
				   <?php } else { ?>	
						<i class="font-icon font-icon-upload" class="menu"></i> | 
				   <?php } ?>

				   <a href="<?php echo base_url('jobs/view_certificate/'.$joblist['prop_unique_id']."/".base64_encode($joblist['job_id'])) ?>" title="View Certificate" class="menu"><i class="font-icon font-icon-eye"></i></a> |
				   
				   <?php /*
				   <a href="<?php echo base_url('assign_job/edit/'.$unique_id."/".base64_encode($joblist['job_id'])) ?>"  title="Edit" id="edit">
				   */?>
				   <a href="#" title="Edit" class="edit" data-unique="<?php echo $unique_id; ?>" data-job="<?php echo base64_encode($joblist['job_id']); ?>" data-raw-id="<?php echo $joblist['job_id']; ?>" class="menu">
						<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> 
					</a> |
					
					<a href="#" class="del_prop swal-btn-warning " id="<?php echo $joblist['job_id']; ?>" pid="<?php echo base64_encode($joblist['job_id']); ?>" title="Delete Job" class="menu">
						<span class="glyphicon glyphicon-trash"></span>
				     </a>

				 </td>
                
              </tr>
             <?php $i++; } ?>
              
             
            </tbody>
          </table>
	   </div>
     <?php } ?>
        
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>



<!-- Modal  start-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Job to <?php echo ucfirst($contractor_details->first_name." ".$contractor_details->last_name);?></h4>
      </div>
      <div class="modal-body">
       <div class="row">
	    <div class="col-md-4">
			Select Property
		</div>

	    <div class="col-md-4">
			<select class="select2 select2-hidden-accessible form-control" tabindex="-1" data-validation="[NOTEMPTY]" id="property_id" aria-hidden="true">
			   <option value="">Select Property</option>
			   <?php foreach($property_list as $PL){ ?>    
				  <?php /*
				  <option value="<?php echo $PL['unique_id'] ?>" <?php echo (in_array($PL['unique_id'], $assign_prop_uids)) ? 'disabled' : '' ?>><?php echo $PL['name']; ?></option>
				  */ ?>
				  
				  <option value="<?php echo $PL['unique_id'] ?>" ><?php echo $PL['name']; ?></option>
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
			<?php foreach($certificates as $PL){ ?>    
			  <div class="col-md-6">
				<input type="checkbox" name="certificate[]" value="<?php echo $PL['certificate_id']; ?>" class="certificate_id certificate_<?php echo $PL['certificate_id']; ?>"> <?php echo $PL['certificate_name'] ?>
			  </div>	
			<?php } ?>
			<div style="clear:both;">&nbsp;</div>
			<div id="certificate_msg" style="color:red"></div>
			<br><br>

		</div>


	   </div>
      </div>
      <div class="modal-footer">
	    <button class="btn" type="submit" id="assign_job">Assign Now</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Model end -->

<!-- Edit Modal  start-->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Job to <?php echo ucfirst($contractor_details->first_name." ".$contractor_details->last_name);?></h4>
		
		
		<div class="alert alert-success alert-dismissable" id="message" style="margin-top:5px;">
		  
		</div>
      </div>
      <div class="modal-body" id="">
       <div class="row">
	    <div class="col-md-4">
			Select Property
		</div>

	    <div class="col-md-4">
			<select class="select2 select2-hidden-accessible form-control" tabindex="-1" data-validation="[NOTEMPTY]" id="edit_property_id" aria-hidden="true">
			   <option value="">Select Property</option>
			   <?php foreach($property_list as $PL){ ?>    
				  <?php /*
				  <option value="<?php echo $PL['unique_id'] ?>" <?php echo (in_array($PL['unique_id'], $assign_prop_uids)) ? 'disabled' : '' ?>><?php echo $PL['name']; ?></option>
				  */ ?>
				  
				  <option value="<?php echo $PL['unique_id'] ?>" ><?php echo $PL['name']; ?></option>
				<?php } ?>
			</select>
			<div id="property-error-msg" style="color:red"></div>
			<br><br>

		</div>
		
		<div style="clear:both;"></div>
		
		<div class="col-md-4">
			Select Certificates
		</div>
	    
		<div style="clear:both;">&nbsp;</div>
		
	    <div class="col-md-12">
			<?php foreach($certificates as $PL){ ?>    
			  <div class="col-md-6">
				<input type="checkbox" name="certificate[]" value="<?php echo $PL['certificate_id']; ?>" class="certificate_id edit_certificate_<?php echo $PL['certificate_id']; ?>"> <?php echo $PL['certificate_name'] ?>
			  </div>	
			<?php } ?>
			<div style="clear:both;">&nbsp;</div>
			<div id="certificate_error_msg" style="color:red"></div>
			<br><br>

		</div>


	   </div>
      </div>
      <div class="modal-footer">
		<input type="hidden" value="<?php echo $joblist['job_id']; ?>" id="job_id"/>
		<input type="hidden" value="<?php echo base64_encode($joblist['job_id']); ?>" id="job_id_encoded"/>
	    <button class="btn" type="submit" id="edit_job">Edit Job</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Model end -->


<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script type="text/javascript">
 function go_contractor(unique_id){
	 window.location.href="<?php echo base_url()  ?>assign_job/add/"+unique_id;
 }

<?php if($unique_id){ ?> 
$(document).ready(function(){
	$("#message").hide();

$('#property_id').change(function(){
	$('#msg').html('');
})

	 
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
	
	$.post("<?php echo base_url('assign_job/add_job') ?>",
    {
        job_prop_id: $("#property_id").val(),
        certificate_id: arr,
        job_con_id: "<?php echo $unique_id ?>" // unique id is contrator unique id
    },
    function(data, status){
        var var_data = $.parseJSON(data);
		if(var_data.status=="ok"){
		  window.location.href=var_data.url+"?msg=success";
		}

    });
		 
	 })
 })
<?php } ?>

</script>

<script type="text/javascript">
$(function(){
	$(".edit").click(function(event){
		event.preventDefault();
		uniqueid=$(this).attr('data-unique');
		jobid=$(this).attr('data-job');
		$("#job_id").val($(this).attr('data-raw-id'));
		var request = $.ajax({
							  url: "<?php echo base_url('assign_job/edit') ?>",
							  type: "POST",
							  data: {uniqueid : uniqueid,jobid : jobid},
							  success: function(data){
								gotdata=jQuery.parseJSON(data);
								newdata=gotdata.split('/')
								$("#edit_property_id option[value='"+newdata[0]+"']").attr('selected','selected');
								var gotarray=jQuery.parseJSON(newdata[1]);
								var arrayLength = gotarray.length;
								for (var i = 0; i < arrayLength; i++) {
									$('.edit_certificate_'+gotarray[i]).prop('checked', true);
								}
							  }
							});

		$('#editModal').modal('show');
	});
})
</script>

<script type="text/javascript">
	$(function(){
		$('#editModal').on('hidden.bs.modal', function () {
		 location.reload();
		});
		$("#edit_job").click(function(){

		  if($("#edit_property_id").val()==''){
			  $('#property-error-msg').html('Please select Property');
			  return false;
		  }
		  
		   if($("#edit_certificates_id").val()==''){
			  $('#certificate_error_msg').html('Please select Certificate');
			  return false;
		  }
		  
			 var arr = [];
			 var i=0;
			   $('.certificate_id:checked').each(function () {
				   arr[i++] = $(this).val();
			   });      
			
			if(arr.length==0){
			  $('#certificate_error_msg').html('Please select Certificate');
			  return false;
			}   
			
			var propertyid=$("#edit_property_id").val();
			var certificate_id=arr;
			var jobid=$("#job_id").val();
			
			var request = $.ajax({
							  url: "<?php echo base_url('assign_job/save_edit_data') ?>",
							  type: "POST",
							  data: {job_prop_id : propertyid,job_id : jobid,certificate_id:arr},
							  success: function(data){
								$("#message").html("Assigned job updated Successfully");
								$("#message").show();
							  },
							  error: function(xhr, status, error) {
									  var err = eval("(" + xhr.responseText + ")");
									  alert(err.Message);
									}
							});
			
		});
		
		
	});
</script>

<script>
 $('.swal-btn-warning').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to delete this Job ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Job",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url('assign_job/delete_job') ?>"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url('assign_job/add/'.$unique_id."?msg=success") ?>';
                   }
                }
             });
          
          

        });
  });
</script>