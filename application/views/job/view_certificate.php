<style type="text/css">
  .sweet-alert .btn{
    min-width: 0px;
  }
  .error { color:red; } 

  /***new css *****/
  .dropdown {
      position: relative;
      display: inline-block;
  }

  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      right: 0;
  }

  .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
  }

  .dropdown-content a:hover {background-color: #f1f1f1}

  .dropdown:hover .dropdown-content {
      display: block;
  }

  .dropdown:hover .dropbtn {
      background-color: #3e8e41;
  }

  .cert-valid{
    background-color: #46c35f;
      text-align: center;
      padding: 10px;
      color: #fff;
      margin-bottom: 14px;
  }
</style>
<?php
  $CI =& get_instance();
  $CI->load->model('assignjob_model');
  $prop_id = $CI->assignjob_model->get_prop_by_uniqueid($unique_id);

  $assigned_job =$CI->assignjob_model->list_all_property_job($prop_id);
  if(isset($assigned_job[0]['certficate_id'])){
  	$certificate_ids=json_decode($assigned_job[0]['certficate_id']);	
  }
  else{
  	$certificate_ids=0;
  }
  $required_certificates=count($certificate_ids);	
  $uploded_certificate=count($CI->assignjob_model->list_all_property_certificate($prop_id,base64_decode($job_id)));	
?>
<div class="page-content">
  <div class="container-fluid ">
    <div class="box-typical box-typical-padding">		
      <h5 class="m-t-lg with-border">View Certificate</h5>
      <div class="row">
				<div class="col-lg-12">	
          <?php if($this->ion_auth->is_admin() || $login_user->role=='contractor'){ ?>					
	          <button type="submit" style="" class="btn btn-inline">
              <a href="<?php echo base_url('jobs') ?>" style="color:#FFFFFF">All Jobs</a>
            </button> 
          <?php } ?> 
					<?php if(empty($job_id)) { ?>
						<a style="color:#FFFFFF" href="<?php echo base_url('jobs/upload_certificate/'.$unique_id) ?>">
              <button type="submit" style="" class="btn btn-inline">Upload Certificate</button>
            </a>
					<?php } else { ?>	
					<?php if($uploded_certificate==0 || $uploded_certificate!=$required_certificates) { ?>
						<a style="color:#FFFFFF" href="<?php echo base_url('jobs/upload_job_certificate/'.$unique_id."/".$job_id) ?>">
              <button type="submit" style="" class="btn btn-inline">Upload Certificate</button>
            </a>
						<?php } ?>
						<button type="submit" style="" class="btn btn-inline">
              <a href="<?php echo base_url('jobs/view_certificate/'.$unique_id) ?>" style="color:#FFFFFF">View All Certificates</a>
            </button>
					<?php } ?>

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
        			         <th>Certificate Type</th>
                       <th>Certificate Date</th>
                       <th class="">Property Name</th>
                       <th class="table-icon-cell">Date Added</th>

                       <th class="table-icon-cell">Certificate Expiration</th>
                       <th class="table-icon-cell">Certificate Status</th>
        			        <th class="" style="width:100px !important;">Action</th>
                     
                    </tr>
                    </thead>
                  <tbody>
                     
                     <?php $i=1; foreach($all_certificates as $all_certificate){ 

                       $date = $all_certificate['certificate_date'];           
                       $date1 = str_replace('/', '-', $date);
                       $date = strtotime($date1);         
                       $new_date = strtotime('+'.$all_certificate['certificate_expire'], $date); 
                        //echo $new_date;
                        $display_date = date('d/m/Y', $new_date);

                      ?> 
                     <?php if((strtotime(date('d-m-Y')) < $new_date) && (!in_array($display_date,$get_all_dates))){
                     ?>

                      <tr>
                          <td><?php echo $i; ?></td>
                          <!--<td><?php echo $all_certificate['certificate_name'] ?></td> -->
        				          <td><?php echo $all_certificate['certificate_type_name'] ?></td>
                          <td class="color-blue-grey-lighter"><?php echo $all_certificate['certificate_date']; ?></td>
                          <td><a href="<?php echo base_url() ?>user/property_details/<?php echo $all_certificate['unique_id']; ?>"><?php echo $all_certificate['property_name']?></a></td>
                          <td class="table-icon-cell"><?php echo date('d/m/Y g:i:a',strtotime($all_certificate['uploaded_date'])); ?></td>
                          <td><?php echo $all_certificate['certificate_expire']?></td>
                          <td><span class="label label-pill label-success">Valid</span></td>
        				          <td class="table-icon-cell" style="width:100px !important;">
                          <div style="min-width:120px !important;">
                            <div class="dropdown">
                               <a  class="tabledit-edit-button btn btn-sm btn-primary" title="Download">
                                  <span class="glyphicon glyphicon-download-alt"></span>
                               </a>
                            <div class="dropdown-content">  
                                  <?php if(!empty($all_certificate['certificate_file'] )) { ?>
                                    <a href="<?php echo base_url("jobs/certificate_download/".$all_certificate['certificate_unique_id']) ?>" title="Download"><?php echo $all_certificate['certificate_name'] ?>                            
                                    </a>
                                    <?php } ?> 
                          
                             <?php if($all_certificate['count_other_cert_files'] < 6){ ?>
                                <?php $j=1; foreach ($all_certificate['other_files'] as $other_file) { ?>

                                <a href="<?php echo base_url("jobs/other_certificate_download/".$other_file['unique_id']) ?>" title="Download"><?php echo $other_file['certificate_name'],' ',$j ?></a>
                              
                              <?php $j++;  } ?>

                             <?php } else { ?>
                              <a href="<?php echo base_url() ?>jobs/download_other_certificate/<?=$all_certificate['certificate_unique_id'] ?>">Download Other Certificate</a>
                             <?php } ?>
                                                                    
                              </div>
                           </div>
                                   				
                    				
                            <?php if(empty($job_id)) { ?>
                              <a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span>
                              </a>
                    				<?php } else { ?>
                    					<a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>/<?= $job_id; ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span>
                              </a>
                    				<?php } ?>
                            
                            <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning" id="<?php echo $all_certificate['certificate_unique_id'] ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                            

                          </div>
                      </td>                         
                   </tr>
                               
                 <?php $i++; }  

                    else if((strtotime(date('d-m-Y')) < $new_date) && (in_array($display_date,$get_all_dates))){
                               ?>
                                <tr>
                        <td><?php echo $i; ?></td>
                        <!--<td><?php echo $all_certificate['certificate_name'] ?></td> -->
                        <td><?php echo $all_certificate['certificate_type_name'] ?></td>
                        <td class="color-blue-grey-lighter"><?php echo $all_certificate['certificate_date']; ?></td>
                         <td><a href="<?php echo base_url() ?>user/property_details/<?php echo $all_certificate['unique_id']; ?>"><?php echo $all_certificate['property_name']?></a></td>
                        <td class="table-icon-cell"><?php echo date('d/m/Y g:i:a',strtotime($all_certificate['uploaded_date'])); ?></td>
                        <td><?php echo $all_certificate['certificate_expire']?></td>
                        <td><span class="label label-pill label-warning">Expiring Soon</span></td>
                        
                        <td class="table-icon-cell">
                        <div class="dropdown">
                        <a  class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a>

                          <div class="dropdown-content"> 
                          <?php if(!empty($all_certificate['certificate_file'] )) { ?>                 
                          <a href="<?php echo base_url("jobs/certificate_download/".$all_certificate['certificate_unique_id']) ?>" title="Download"><?php echo $all_certificate['certificate_name']?></a>
                          <?php } ?>
                           
                           <?php if($all_certificate['count_other_cert_files'] < 6){ ?>
                                <?php $j=1; foreach ($all_certificate['other_files'] as $other_file) { ?>

                                <a href="<?php echo base_url("jobs/other_certificate_download/".$other_file['unique_id']) ?>" title="Download"><?php echo $other_file['certificate_name'],' ',$j ?></a>
                              
                              <?php $j++;  } ?>

                             <?php } else { ?>
                              <a href="<?php echo base_url() ?>jobs/download_other_certificate/<?=$all_certificate['certificate_unique_id'] ?>">Download Other Certificate</a>
                             <?php } ?>
                             
                          
                         <?php /* <?php if($all_certificate['count_other_cert_files'] > 0){?>        
                            <a href="<?php echo base_url("jobs/other_certificate_zip/".$all_certificate['property_id']."/".$all_certificate['certificate_type']."/".$all_certificate['job_id']) ?>" title="Download">Other files (<?php echo $all_certificate['count_other_cert_files'] ;?>)</a>
                          <?php }else{ ?>
                            <a title="No Files">Other files (<?php echo $all_certificate['count_other_cert_files'] ;?>)</a> 
                          <?php } ?> */?>
                          </div>
                       </div>
                          
                          <?php if(empty($job_id)) { ?>
                            <a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                          <?php } else { ?>
                            <a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>/<?= $job_id; ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                          <?php } ?>

                                  <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning" id="<?php echo $all_certificate['certificate_unique_id'] ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                                  
                                </tr>
                                <?php $i++; }  

                               else{
                               ?>
                                <tr>
                        <td><?php echo $i; ?></td>
                        <!--<td><?php echo $all_certificate['certificate_name'] ?></td> -->
                        <td><?php echo $all_certificate['certificate_type_name'] ?></td>
                        <td class="color-blue-grey-lighter"><?php echo $all_certificate['certificate_date']; ?></td>
                         <td><a href="<?php echo base_url() ?>user/property_details/<?php echo $all_certificate['unique_id']; ?>"><?php echo $all_certificate['property_name']?></a></td>
                        <td class="table-icon-cell"><?php echo date('d/m/Y g:i:a',strtotime($all_certificate['uploaded_date'])); ?></td>
                        <td><?php echo $all_certificate['certificate_expire']?></td>
                        <td><span class="label label-pill label-danger">Expired</span></td>
                        <td class="table-icon-cell">
                        <div class="dropdown">
                              <a class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a>
                          <div class="dropdown-content">
                            <?php if(!empty($all_certificate['certificate_file'] )) { ?>                    
                          <a href="<?php echo base_url("jobs/certificate_download/".$all_certificate['certificate_unique_id']) ?>" title="Download"><?php echo $all_certificate['certificate_name'] ?></a>
                          <?php } ?>  
                           <?php if($all_certificate['count_other_cert_files'] < 6){ ?>
                                <?php $j=1; foreach ($all_certificate['other_files'] as $other_file) { ?>

                                <a href="<?php echo base_url("jobs/other_certificate_download/".$other_file['unique_id']) ?>" title="Download"><?php echo $other_file['certificate_name'],' ',$j ?></a>
                              
                              <?php $j++;  } ?>

                             <?php } else { ?>
                              <a href="<?php echo base_url() ?>jobs/download_other_certificate/<?=$all_certificate['certificate_unique_id'] ?>">Download Other Certificate</a>
                             <?php } ?>
                          <?php /*<?php if($all_certificate['count_other_cert_files'] > 0){?>        
                            <a href="<?php echo base_url("jobs/other_certificate_zip/".$all_certificate['property_id']."/".$all_certificate['certificate_type']."/".$all_certificate['job_id']) ?>" title="Download">Other files (<?php echo $all_certificate['count_other_cert_files'] ;?>)</a>
                          <?php }else{ ?>
                            <a title="No Files">Other files (<?php echo $all_certificate['count_other_cert_files'] ;?>)</a> 
                          <?php } ?>*/?>

                          </div>
                       </div>
                          
                          <?php if(empty($job_id)) { ?>
                            <a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                          <?php } else { ?>
                            <a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>/<?= $job_id; ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                          <?php } ?>

                                  <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning" id="<?php echo $all_certificate['certificate_unique_id'] ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                                  </td>
                                  
                                </tr>
                                <?php $i++; } 
                                ?> 


                             <?php  }
                               ?>
                      
                     
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
 
<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>

<script type="text/javascript">

 $('.swal-btn-warning').click(function(e){
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
           var path="<?php echo base_url() ?>jobs/deleteCertificateAjax"; 
		   var job_id="<?php echo isset($job_id) ? $job_id : ''; ?>";
           $.ajax({
                type:"POST",
                url:path,
                data:{certificate_unique_id:certificate_unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url() ?>jobs/view_certificate/<?php echo $this->uri->segment(3); ?>/'+job_id;

                   }
                }
             });
          
         

        });
  }); 







</script>