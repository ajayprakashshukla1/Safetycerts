<div class="page-content">
  <div class="container-fluid ">
    <div class="box-typical box-typical-padding">		
      <h5 class="m-t-lg with-border">View Certificate</h5>
      <div class="row">
				<div class="col-lg-12">	
          
	        <div class="card-block row">
        			<form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1">
        			   <div class="row">
        					<div class="col-lg-12">
        		         <div class="card-block row table-responsive">

        			         <table id="example" class="display table table-striped table-bordered">
                       <!--<div class="cert-valid">Valid Certificates</div>-->
                    <thead>

                    <tr>
                      <th width="1">#</th>
                      <!--<th>Certificate Name</th> -->
        			         <th>Certificate Name</th>                     
                       <th class="table-icon-cell">Date Added</th>
                        <th>Certificate Expiration</th>
        			        <th class="" style="width:100px !important;">Action</th>
                     
                    </tr>
                    </thead>
                  <tbody>
                    
                      <?php $i=1; foreach ($other_certificate as $other_file) { ?>

                      <tr>
                          <td><?php echo $i; ?></td>
                          
        				          <td><?php echo $other_file['certificate_name'] ?></td>
                          
                          
                          <td class="table-icon-cell"><?php echo date('d/m/Y g:i:a',strtotime($other_file['uploaded_date'])); ?></td> 
                          <td class="color-blue-grey-lighter"><?php echo $other_file['certificate_expire']; ?></td>                        
        				          <td class="table-icon-cell" style="width:100px !important;">
                            <a href="<?php echo base_url("jobs/other_certificate_download/".$other_file['unique_id']) ?>" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a>
                          </td>                         
                   </tr>
                       <?php $i++;  }?>        
              
                </tbody>
            </table>
        	     </div>
        	</div>
      </div>
        				
        				
        			</form>
	       </div>
        </div><!--.box-typical-->
      </div><!--.container-fluid-->
    </div>
  </div>
</div> 