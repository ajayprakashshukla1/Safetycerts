<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>


<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
      	<p>
      	<?php
      		if(isset($_REQUEST['msg'])){
      			if($_REQUEST['msg'] == 'success'){
      				echo 'test msg';
      			}
      		 
      		}
      		?>
      	
      	</p>
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
              <th class="table-icon-cell">Action</th>
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
                 <td><?php echo $joblist['name']; ?></td>
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
						<a href="<?php echo base_url('jobs/upload_job_certificate/'.$joblist['prop_unique_id']."/".base64_encode($joblist['job_id'])) ?>" title="Upload Certificates"><i class="font-icon font-icon-upload"></i></a> | 
				   <?php } else { ?>	
						<i class="font-icon font-icon-upload"></i> | 
				   <?php } ?>

				   <a href="<?php echo base_url('jobs/view_certificate/'.$joblist['prop_unique_id']."/".base64_encode($joblist['job_id'])) ?>" title="View Certificate"><i class="font-icon font-icon-eye"></i></a> |
				   
				   <a href="<?php echo base_url('assign_job/edit/'.$unique_id."/".base64_encode($joblist['job_id'])) ?>"  title="Edit">
						<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
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


<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script type="text/javascript">
 function go_contractor(unique_id){
	 window.location.href="<?php echo base_url()  ?>assign_job/add/"+unique_id;
 }

<?php if($unique_id){ ?> 
$(document).ready(function(){

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
