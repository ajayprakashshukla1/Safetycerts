<style type="text/css">
.statistic-box.active {
    transform: scale(1.06);
    box-shadow: 1px 1px 30px #848282;
}	
</style>

    <div class="page-content">
        <div class="container-fluid">
		
		<?php $i=1; $validd = ''; $expiringd = ''; $expiredd = ''; $valid = 0; $expire = 0; $exp_soon=0;	
			  
			  $row=''; $valid_row=''; $expsoon_row=''; $expire_row=''; $pending_row='';
				
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
						$row .= $vrow= '<tr>
										<td> '.$i.' </td>
			            				<td>'.$AC['certificate_type_name'].'</td>
			            				<!--<td>'. $AC['certificate_type_name'].'</td>-->
										<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            				<td>'.$AC['certificate_date'].'</td>
			            				<td><a  href="">'.$AC['name'].'</a></td>
			            				<td>'.$AC['certificate_expire'].'</td>
			            				<td><span class="label label-pill label-success">Valid</span></td>
			           					<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'"  class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        				</tr>';

			        	// put it in seprate var			
			        	$valid_row .= $vrow;			
			        	
						/*===============================Valid End====================================*/             	
					}else if((strtotime(date('d-m-Y')) < $new_date) && (in_array($display_date,$get_all_dates))){
					   	/*=======================expiring===========================================*/
					   	$exp_soon++;
					    $row .= $exrow= '<tr>
											<td> '.$i.' </td>
			            					<!--<td>'.$AC['certificate_name'].'</td>-->
											<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            					<td>'. $AC['certificate_type_name'].'</td>
			            					<td>'.$AC['certificate_date'].'</td>
			            					<td><a  href="">'.$AC['name'].'</a></td>
			            					<td>'.$AC['certificate_expire'].'</td>
			            					<td><span class="label label-pill label-warning">Expiring Soon</span></td>
			           						<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'"  class="tabledit-edit-button btn btn-sm btn-primary" title="Download">
											<span class="glyphicon glyphicon-download-alt"></span></a></td>
			        					</tr>';
			        	$expsoon_row .= $exrow; 
			        				
					   	/*================================Expiring End ==============================*/
					}else{
						$expire++;
						$row .= $exprow='<tr>
											<td> '.$i.' </td>
			            					<!--<td>'.$AC['certificate_name'].'</td>-->
											<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            					<td>'. $AC['certificate_type_name'].'</td>
			            					<td>'.$AC['certificate_date'].'</td>
			            					<td><a  href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            					<td>'.$AC['certificate_expire'].'</td>
			            					<td><span class="label label-pill label-danger">Expired</span></td>
			           						<td><a href="" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        					</tr>';
			            $expire_row .= $exprow;					
			        	
					}
					$i++;
			    } 


		   ?>
             
           <div class="row">
				 <a class="col-sm-3" href="<?php echo base_url()?>user/parent_certificate/valid">
                    <article class="statistic-box green <?php echo ($this->uri->segment(3)=='valid') ? 'active' : '' ?>">
                        <div>
                            <div class="number"><?php echo $valid; ?></div>
                            <div class="caption"><div>Valid Certificates</div></div>
                            <div class="percent">
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->

                <!--  -->
				<a class="col-sm-3" href="<?php echo base_url()?>user/parent_certificate/exp_soon">
                    <article class="statistic-box yellow <?php echo ($this->uri->segment(3)=='exp_soon') ? 'active' : '' ?>">
                        <div>
                            <div class="number"><?php echo $exp_soon; ?></div>
                            <div class="caption"><div>Expiring Soon</div></div>
                            <div class="percent">
                              
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
				
                    <!--  -->
                	<a class="col-sm-3" href="<?php echo base_url()?>user/parent_certificate/expired">
                    <article class="statistic-box red <?php echo ($this->uri->segment(3)=='expired') ? 'active' : '' ?>">
                        <div>
                            <div class="number"><?php echo $expire; ?></div>
                            <div class="caption"><div>Expired</div></div>
                            <div class="percent">
                             
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
                <?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ ?>   
               <!--  -->
               <a class="col-sm-3" href="<?php echo base_url()?>user/parent_certificate/pending_status">
                    <article class="statistic-box default <?php echo ($this->uri->segment(3)=='pending_status') ? 'active' : '' ?>">
                        <div>
                            <?php $ijj=0; $CI =& get_instance(); $CI->load->model('assignjob_model'); 
			                        
                                    //echo "<pre>"; print_r($admin_assigned_list); exit;
			                        
			                        foreach($admin_assigned_list as $joblist){   
			                        	$certificatesselected=json_decode($joblist['certficate_id']);

										foreach($certificatesselected as $key=>$val){
											$current_certificates= $CI->assignjob_model->getcertificate($val);
											//echo "<pre>"; print_r($current_certificates); exit;
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
                            <div class="percent">
                               
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
                 <?php } ?>
               
				
            </div><!--.row--> 
            
        </div><!--.row-->

        <div class="row" style="<?php echo ($this->uri->segment(3)=='pending_status') ? 'display: none' : ''; ?>">
            <div class="col-xl-12 dahsboard-column">
               
                <section class="card">
                    <div class="card-block">
					<h3 class="m-t-lg with-border">Parents Certificates</h3>
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
                                <!--<th>Certificate Name</th> -->
                                <th>Certificate Type</th>
                                <th>Certificate Date</th>
								<th>Property Name</th>
                                <th>Certificate Expiration</th>
                                <th>Certificate Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
							<?php 
                             if($this->uri->segment(3)=='valid'){
                                echo $valid_row; 
                             }else if($this->uri->segment(3)=='exp_soon'){
                             	echo $expsoon_row; 
                             }else if($this->uri->segment(3)=='expired'){
                             	echo $expire_row; 
                             }else{
                             	echo $row;
                             }
							 
							?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </section>
            </div><!--.col-->
           
        </div>


        <!-- pending for test -->
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
					                 		<td><a href=""><?php echo $joblist['name']; ?></a></td>
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
        <!-- pending test end -->
    </div><!--.container-fluid-->
</div><!--.page-content-->
