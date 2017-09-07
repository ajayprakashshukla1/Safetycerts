<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
		
        <h5 class="m-t-lg with-border">All Assign Job</h5>
			<div class="card-block row">
			<table id="example" class="display table table-striped table-bordered">
            <thead>
            <tr>
              <th width="1">#</th>
			  <th>Property Name</th>
              <th>Property Address</th>
              <th>Certificates</th>
              <th>Assign Date</th>
              <th class="table-icon-cell">Status</th>
              <th class="table-icon-cell">Uploaded<br/>Certificates</th>
			        <th class="table-icon-cell">Action</th>
             
            </tr>
            </thead>
            <tbody>
             <?php $i=1; $CI =& get_instance(); $CI->load->model('assignjob_model');
			       foreach($job_lists as $joblist){
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
					$uploded_certificate=count($CI->assignjob_model->list_all_property_certificate($prop_id,$joblist['job_id']));	 ?> 
				   
              <tr>
                <td><?php echo $i; ?></td>
				        <td><a href="<?php echo base_url('user/property_details/'.$joblist['prop_unique_id']); ?>"><?php echo $joblist['name'] ?></a></td>

                <td><?php echo $joblist['address'] ?></td>
				
				<td><?php echo $current_certificates_value; ?></td>

                <td class="color-blue-grey-lighter"><?php echo date('d/m/Y',strtotime($joblist['created_date'])); ?></td>
		
                <td class="table-icon-cell">
                 <?php
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
                  <a href="<?php echo base_url('jobs/upload_job_certificate/'.$joblist['prop_unique_id']."/".base64_encode($job_lists[0]['job_id'])) ?>" title="Upload Certificates"><i class="font-icon font-icon-upload"></i></a> | 
						<?php } else { ?>
							<i class="font-icon font-icon-upload"></i> |
						<?php } ?>

                  <a href="<?php echo base_url('jobs/view_certificate/'.$joblist['prop_unique_id']."/".base64_encode($job_lists[0]['job_id'])) ?>" title="View Certificate"><i class="font-icon font-icon-eye"></i></a>

                </td>
                
              </tr>
             <?php $i++; } ?>
              
             
            </tbody>
          </table>
	</div>

        
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>