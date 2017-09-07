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
              <th>Job Address</th>
              <th>Certificates</th>
              <th>Assign Date</th>
              <th class="table-icon-cell">Status</th>
			  <th class="table-icon-cell">Action</th>
             
            </tr>
           </thead>
           <tbody id='table_data'>
             <?php // echo "<pre>"; print_r($job_lists); ?>
             <?php $i=1; foreach($job_lists as $joblist){  ?> 
             
              <tr>
                 <td><?php echo $i; ?></td>
                 <td><?php echo $joblist['address'] ?></td>
                 <td><?php echo $joblist['certificate_name'] ?></td>
                 <td class="color-blue-grey-lighter"><?php echo date('d/m/Y',strtotime($joblist['created_date'] )); ?></td>
                 
                 <td class="table-icon-cell">
                   <?php echo ($joblist['prop_status']==1) ? '<span class="label label-success">Completed</span>' : '<span class="label label-danger">Pending</span>'; ?>
                 </td>
				 
				 <td class="table-icon-cell">
				   
				   <a href="<?php echo base_url('jobs/upload_certificate/'.$joblist['prop_unique_id']) ?>" title="Upload Certificates"><i class="font-icon font-icon-upload"></i></a> | 

				   <a href="<?php echo base_url('jobs/view_certificate/'.$joblist['prop_unique_id']) ?>" title="View Certificate"><i class="font-icon font-icon-eye"></i></a>

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
				  <option value="<?php echo $PL['unique_id'] ?>" <?php echo (in_array($PL['unique_id'], $assign_prop_uids)) ? 'disabled' : '' ?>><?php echo $PL['name']; ?></option>
				<?php } ?>
			</select>
			<div id="msg" style="color:red"></div>
			<br><br>

		</div>
		
		<div style="clear:both;"></div>
		
		<div class="col-md-4">
			Select Certificates
		</div>
	    
	    <div class="col-md-4">
			<select class="select2 select2-hidden-accessible form-control" tabindex="-1" data-validation="[NOTEMPTY]" id="certificates_id" aria-hidden="true">
			   <option value="">Select Certificates</option>
			   <?php foreach($certificates as $PL){ ?>    
				  <option value="<?php echo $PL['certificate_id'] ?>"><?php echo $PL['certificate_name']; ?></option>
				<?php } ?>
			</select>
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

	$.post("<?php echo base_url('assign_job/add_job') ?>",
    {
        job_prop_id: $("#property_id").val(),
        certificate_id: $("#certificates_id").val(),
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