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
              <th>Assign Date</th>
              <th class="table-icon-cell">Status</th>
			        <th class="table-icon-cell">Action</th>
             
            </tr>
            </thead>
            <tbody>
             <?php
             $i=1; // echo "<pre>"; print_r($job_lists); exit;
			       foreach($job_lists as $joblist){ ?> 
              <tr>
                <td><?php echo $i; ?></td>
				        <td><a href="<?php echo base_url('user/property_details/'.$joblist['prop_unique_id']); ?>"><?php echo $joblist['name'] ?></a></td>

                <td><?php echo $joblist['address'] ?></td>

                <td class="color-blue-grey-lighter"><?php echo date('m/d/Y',strtotime($joblist['created_date'])); ?></td>

                <td class="table-icon-cell">
                  <?php echo ($joblist['prop_status']==0) ? '<span class="label label-danger">Pending</span>' : '<span class="label label-success">Completed</span>'; ?>
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

        
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>