<!-- =============Contractor job============= -->
<?php if($login_user->role=='contractor'){ ?>
	<div class="page-content">	
	  	<div class="container-fluid">		
			<div class="row">
	    		<div class="col-xl-12 dahsboard-column">	       
	        		<section class="card">
	          			<div class="card-block">
							<h3 class="m-t-lg with-border">All Assign Job</h3>
							<div class="table-responsive">
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
											<td><a href="<?php echo base_url('user/property_details/'.$joblist['prop_unique_id']); ?>"><?php echo $joblist['name'] ?></a></td>
		                					<td><?php echo $joblist['address'] ?></td>						
											<td><?php echo $current_certificates_value; ?></td>
		                					<td class="color-blue-grey-lighter">
		                						<?php echo date('d/m/Y',strtotime($joblist['created_date'])); ?></td>
		                					<td class="table-icon-cell">
		                 						<?php if($uploded_certificate==0){ ?>
		                 							<span class="label label-danger">Pending</span>
		                 						<?php } else if($uploded_certificate < $required_certificates){ ?>
										 			<span class="label" style="background-color:#fdad2a">In Progress</span>
										 		<?php } else{ ?>
								 					<span class="label label-success">Completed</span>
								 				<?php } ?>
		                					</td>
											<td><?php echo $uploded_certificate." / ".$required_certificates ?></td>
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
	          			</div>
	        		</section>
	    		</div><!--.col-->	   
			</div>
			<div class="row">
	    		<div class="col-xl-12 dahsboard-column">	       
	        		<section class="card">
	          			<div class="card-block">
							<h3 class="m-t-lg with-border">View All Certificate</h3>
							<div class="table-responsive">
	              				<table id="example" class="display table table-striped table-bordered">
		            				<thead>
		            					<tr>
		              						<th>#</th>
                      						<!--<th>Certificate Name</th> -->
                      						<th>Certificate Type</th>
                      						<th>Certificate Date</th>
					  						<th>Property Name</th>
                      						<th>Certificate Expiration</th>
                      						<th>Action</th>		             
		            					</tr>
		            				</thead>
		            				<tbody>
		             				<?php  $i=1; foreach($all_certificate as $AC){ ?>
		              					<tr>
							                <td><?php echo $i; ?></td>
											<!--<td><?php echo $AC['certificate_name'] ?></td>-->
							                <td><?php echo $AC['certificate_type_name'] ?></td>
							                <td><?php echo $AC['certificate_date']; #date('d/m/y',strtotime($AC['certificate_date']))  ?></td>
							                <td><?php echo $AC['name'] ?></td>
							                <td><?php echo $AC['certificate_expire'] ?></td>
							                <td><a href="<?php echo base_url("jobs/certificate_download/".$AC['certificate_unique_id']) ?>" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
		              					</tr>
		             				<?php $i++; } ?>
		           	 				</tbody>
		          				</table>
	            			</div>
	          			</div>
	        		</section>
	    		</div><!--.col-->	   
			</div>
		</div>
	</div>		
<?php } ?>
<?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ ?>  
	<div class="page-content">	
	  	<div class="container-fluid">  
	  		<?php $i=1;$j=1;$k=1;
				$validd = '';
				$expiringd = '';
			    $expiredd = '';
				$valid = 0;
				$expire = 0;
				$exp_soon=0;
				foreach($all_certificate as $AC){
			         $date = $AC['certificate_date']; 
					
                     $date1 = str_replace('/', '-', $date);
			         $date = strtotime($date1); 
				
			        $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
					//echo $new_date;
				    $display_date = date('d/m/Y', $new_date);
					
					
					if((strtotime(date('d-m-Y')) < $new_date) && (!in_array($display_date,$get_all_dates))){
			   			/*===============================Valid Start=================================*/
			   			$valid++;
						$validd .= '<tr>
										<td> '.$i.' </td>
			            				<td>'.$AC['certificate_type_name'].'</td>
			            				<!--<td>'. $AC['certificate_type_name'].'</td>-->
										<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            				<td>'.$AC['certificate_date'].'</td>
			            				<td><a  href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            				<td>'.$AC['certificate_expire'].'</td>
			            				<td><span class="label label-pill label-success">Valid</span></td>
			           					<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        				</tr>';
			        	$i++;
						/*===============================Valid End====================================*/             	
					}else if((strtotime(date('d-m-Y')) < $new_date) && (in_array($display_date,$get_all_dates))){
					   	/*=======================expiring===========================================*/
					   	$exp_soon++;
					    $expiringd .=   '<tr>
											<td> '.$j.' </td>
			            					<!--<td>'.$AC['certificate_name'].'</td>-->
											<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            					<td>'. $AC['certificate_type_name'].'</td>
			            					<td>'.$AC['certificate_date'].'</td>
			            					<td><a href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            					<td>'.$AC['certificate_expire'].'</td>
			            					<td><span class="label label-pill label-warning">Expiring Soon</span></td>
			           						<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        					</tr>';
			        	$j++;				
					   	/*================================Expiring End ==============================*/
					}else{
						$expire++;
						$expiredd .= 	'<tr>
											<td> '.$k.' </td>
			            					<!--<td>'.$AC['certificate_name'].'</td>-->
											<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            					<td>'. $AC['certificate_type_name'].'</td>
			            					<td>'.$AC['certificate_date'].'</td>
			            					<td><a  href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            					<td>'.$AC['certificate_expire'].'</td>
			            					<td><span class="label label-pill label-danger">Expired</span></td>
			           						<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        					</tr>';
			        	$k++;
					}
			    } 
			?>  


            <div class="row">
				<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/valid" >
                    <article class="statistic-box green <?php if($this->uri->segment(3)=="valid" || $this->uri->segment(3)==""){echo "active";}?>">
                        <div>
                            <div class="number"><?php echo $valid; ?></div>
                            <div class="caption"><div>Valid Certificates</div></div>
                            <div class="percent"></div>
                        </div>
                    </article>
                </a><!--.col-->
				
				<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/exp_soon">
                    <article class="statistic-box yellow <?php if($this->uri->segment(3)=="exp_soon"){echo "active";}?>">
                        <div>
                            <div class="number"><?php print_r($exp_soon); ?></div>
                            <div class="caption"><div>Expiring Soon</div></div>
                            <div class="percent"></div>
                        </div>
                    </article>
                </a><!--.col-->				 
				
               	<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/expired">
                    <article class="statistic-box red <?php if($this->uri->segment(3)=="expired"){echo "active";}?>">
                        <div>
                            <div class="number"><?php echo $expire; ?></div>
                            <div class="caption"><div>Expired</div></div>
                            <div class="percent"></div>
                        </div>
                    </article>
                </a><!--.col-->
              
              	<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/pending_status">
                    <article class="statistic-box default <?php if($this->uri->segment(3)=="pending_status"){echo "active";}?>">
                        <div>  
                          <?php $ijj=0; $CI =& get_instance(); $CI->load->model('assignjob_model'); 
			                        foreach($admin_assigned_list as $joblist){   
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
                                         if($uploded_certificate != $required_certificates){ 
					              		    $ijj++;
                                         }
				            		} ?>

                            <div class="number"><?php echo $ijj; ?></div>
                            <div class="caption"><div>Certificates Booked For Testing</div></div>
                            <div class="percent"></div>
                        </div>
                    </article>
                </a>				
            </div><!--.row--> 
			
			<?php if($this->uri->segment(3)!='pending_status'){ ?>
		        <div class="row">
		            <div class="col-xl-12 dahsboard-column">               
		                <section class="card">
		                  	<div class="card-block">
								<div class="m-t-lg with-border">
									<h3  class="pull-left"><?php if($this->uri->segment(3)=='valid'){$table=$validd ; echo "Valid Certificates";}
									      else if($this->uri->segment(3)=='exp_soon'){$table=$expiringd ; echo "Expiring Soon";}
										  else if($this->uri->segment(3)=='expired'){$table=$expiredd ; echo "Expired";}
									      else{ $table=$validd ; echo "Valid Certificates";}
									?>
									</h3>
									<div class="pull-right" style="font-size: 17px;margin-right: 20px;font-weight: 600;">
										<a style="text-align:right;" href="<?php echo base_url(); ?>user/view_all_certificates">View all certificates</a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="table-responsive">
				                    <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
				                        <thead>
				                            <tr>
											    <th>#</th>
				                                <!--<th>Certificate Name</th>-->
				                                <th>Certificate Type</th>
				                                <th>Certificate Date</th>
												<th>Property Name</th>
				                                <th>Certificate Expiration</th>
				                                <th>Certificate Status</th>
				                                <th>Action</th>
				                            </tr>
				                        </thead>
				                        <tfoot>
				                            <tr>
											    <th>#</th>
				                                <!--<th>Certificate Name</th>-->
				                                <th>Certificate Type</th>
				                                <th>Certificate Date</th>
												 <th>Property Name</th>
				                                <th>Certificate Expiration</th>
				                                <th>Certificate Status</th>
				                                <th>Action</th>
				                            </tr>
				                        </tfoot>
				                        <tbody>
											<?php echo $table; ?>
				                        </tbody>
				                    </table>
			                    </div>
		                  	</div>
		                </section>
		            </div><!--.col-->           
		        </div>
		   	<?php } ?>
		   	<?php if($this->uri->segment(3)=='pending_status'){ ?>
		        <div class="row">
		            <div class="col-xl-12 dahsboard-column">               
		                <section class="card">
		                  	<div class="card-block">
								<h3 class="m-t-lg with-border">Certificates Booked For Testing</h3>
								<div class="table-responsive">
			                    <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
			                        <thead>
			                            <tr>
										    <th>#</th>
											<th>Property Name</th>
											<th>Address</th>
			                                <th>Certificates</th>
			                                <th>Test Created</th>
			                                <th>Job Status</th>
			                            </tr>
			                        </thead>
			                        <tfoot>
			                            <tr>
										    <th>#</th>
											<th>Property Name</th>
											<th>Address</th>
			                                <th>Certificates</th>
			                                <th>Test Created</th>
			                                <th>Job Status</th>
			                            </tr>
			                        </tfoot>
			                        <tbody>
			                        <?php $i=1; $CI =& get_instance(); $CI->load->model('assignjob_model'); 
			                        //echo "<pre>"; print_r($admin_assigned_list); exit;
			                        foreach($admin_assigned_list as $joblist){  

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
                                        <?php if($uploded_certificate != $required_certificates){ ?>
					              		<tr>
					                 		<td><?php echo $i; ?></td>
					                 		<td><a href="<?php echo base_url('user/property_details/'.$joblist['prop_unique_id']); ?>"><?php echo $joblist['name']; ?></a></td>
					                 		<td><?php echo $joblist['address'] ?></td>
					                 		<td><?php echo $current_certificates_value; ?></td>
					                 		<td class="color-blue-grey-lighter"><?php echo date('d/m/Y',strtotime($joblist['created_date'] )); ?></td>
					                 		<td class="table-icon-cell">
                                            <!--<span class="label label-danger">Pending</span>-->
												<?php if($uploded_certificate==0){
													echo '<span class="label label-danger">Pending</span>'; 
												}else if($uploded_certificate < $required_certificates){
													echo '<span class="label" style="background-color:#fdad2a">In Progress</span>'; 
												}else{
													 echo '<span class="label label-success">Completed</span>';
												} ?> 
					                		</td>               
					              		</tr>
                                        <?php }?>
				            		<?php $i++; } ?>
			                        </tbody>
			                    </table>
			                    </div>
		                  	</div>
		                </section>
		            </div><!--.col-->           
		        </div>
			<?php } ?>    
		</div>
	</div>	
	<?php /*<div class="page-content" style="padding-top: 0">
        <div class="container-fluid">		
			<?php $i=1; $row = ''; 		
				foreach($all_certificate as $AC){ 
		            $row .= '<tr>
					    		<td> '.$i.' </td>
		                		<!--<td>'.$AC['certificate_name'].'</td>-->
								<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
		                		<td>'. $AC['certificate_type_name'].'</td>
		                		<td>'.$AC['certificate_date'].'</td>';
						
				                $date = $AC['certificate_date']; 
				                $date = strtotime($date); 
				                $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
								$display_date = date('d/m/Y', $new_date); 
		                
					$row .=		'<td><a href="'.base_url().'user/property_details/'.$AC['unique_id'].'">'.$AC['name'].'</a></td>
		                		<td>'.$AC['certificate_expire'].'</td>
		            		</tr>';
		           		$i++; 
	           	} ?>   
        	<div class="row">
            	<div class="col-xl-12 dahsboard-column">               
                	<section class="card">
                    	<div class="card-block">
							<h3 class="m-t-lg with-border">All Certificates</h3>
                      		<div class="table-responsive"> 
		                        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
		                            <thead>
		                            <tr>
									     <th>#</th>
		                                <!--<th>Certificate Name</th>-->
		                                <th>Certificate Type</th>
		                                <th>Certificate Date</th>
										 <th>Property Name</th>
		                                <th>Certificate Expiration</th>                                
		                            </tr>
		                            </thead>
		                            <tfoot>
			                            <tr>
										    <th>#</th>
			                                <!--<th>Certificate Name</th>-->
			                                <th>Certificate Type</th>
			                                <th>Certificate Date</th>
											 <th>Property Name</th>
			                                <th>Certificate Expiration</th>
			                                
			                            </tr>
		                            </tfoot>
		                            <tbody>
										<?php echo $row ?>
		                            </tbody>
		                        </table>
		                    </div>
                    	</div>
                	</section>
            	</div><!--.col-->           
        	</div>
        </div>	
    </div>*/  ?>
<?php } ?> 