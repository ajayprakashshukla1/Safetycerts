
    <div class="page-content">
        <div class="container-fluid">
		
		<?php // echo "<pre>"; print_r($all_certificate); exit;
		
       /* $i=1; $row = ''; $valid = 0; $expire = 0; $exp_soon=0;
		
		foreach($all_certificate as $AC){ 
                 $exp = explode('/',$AC['certificate_date']);
                 $certificate_date = $exp[0]."/".$exp[1]."/".$exp[2];
            $row .= '<tr>
			    <td> '.$i.' </td>
                <!--<td>'.$AC['certificate_name'].'</td> <td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
                <td>'. $AC['certificate_type_name'].'</td>
                <td>'.$AC['certificate_date'].'</td>';
				
                $date = $AC['certificate_date']; 
                $date = strtotime($date); 
                $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
				$display_date = date('d/m/Y', $new_date); 
                
				$row .='<td><a href="'.base_url().'user/property_details/'.$AC['unique_id'].'">'.$AC['name'].'</a></td>
                <td>'.$AC['certificate_expire'].'</td>
				
                <td>';
			  
			   if(strtotime(date('d/m/Y')) < $new_date){
				  $row_ex= '<span class="label label-pill label-success">Valid</span>';
                  if(!in_array($display_date,$get_all_dates))
					$valid++;
                  if(in_array($display_date,$get_all_dates)){
					 $exp_soon++; 
					 $row_ex= '<span class="label label-pill label-warning">Expiring Sooon</span>';
				  }	
                $row .= $row_ex;								  
			   }else{
				  $row .= '<span class="label label-pill label-danger">Expired</span>';
				  $expire++;
			   }

    			$row .='</td>
               <td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'">Download Certificate</a></td>
            </tr>';
           $i++; } */

             $i=1;
				$validd = '';
				$expiringd = '';
			    $expiredd = '';
				$valid = 0;
				$expire = 0;
				$exp_soon=0;
				$row='';
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
						$row .= '<tr>
										<td> '.$i.' </td>
			            				<td>'.$AC['certificate_type_name'].'</td>
			            				<!--<td>'. $AC['certificate_type_name'].'</td>-->
										<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            				<td>'.$AC['certificate_date'].'</td>
			            				<td><a  href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            				<td>'.$AC['certificate_expire'].'</td>
			            				<td><span class="label label-pill label-success">Valid</span></td>
			           					<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'"  class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        				</tr>';
			        	
						/*===============================Valid End====================================*/             	
					}else if((strtotime(date('d-m-Y')) < $new_date) && (in_array($display_date,$get_all_dates))){
					   	/*=======================expiring===========================================*/
					   	$exp_soon++;
					    $row .=   '<tr>
											<td> '.$i.' </td>
			            					<!--<td>'.$AC['certificate_name'].'</td>-->
											<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            					<td>'. $AC['certificate_type_name'].'</td>
			            					<td>'.$AC['certificate_date'].'</td>
			            					<td><a  href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            					<td>'.$AC['certificate_expire'].'</td>
			            					<td><span class="label label-pill label-warning">Expiring Soon</span></td>
			           						<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'"  class="tabledit-edit-button btn btn-sm btn-primary" title="Download">
											<span class="glyphicon glyphicon-download-alt"></span></a></td>
			        					</tr>';
			        				
					   	/*================================Expiring End ==============================*/
					}else{
						$expire++;
						$row .= 	'<tr>
											<td> '.$i.' </td>
			            					<!--<td>'.$AC['certificate_name'].'</td>-->
											<!--<td>'.date('d/m/y',strtotime($AC['certificate_date'])).'</td>-->
			            					<td>'. $AC['certificate_type_name'].'</td>
			            					<td>'.$AC['certificate_date'].'</td>
			            					<td><a  href="'.base_url("user/property_details/".$AC['unique_id']).'">'.$AC['name'].'</a></td>
			            					<td>'.$AC['certificate_expire'].'</td>
			            					<td><span class="label label-pill label-danger">Expired</span></td>
			           						<td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></td>
			        					</tr>';
			        	
					}
					$i++;
			    } 


		   ?>
             
           <div class="row">
				 <a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/valid" >
                    <article class="statistic-box green">
                        <div>
                            <div class="number"><?php echo $valid; ?></div>
                            <div class="caption"><div>Valid Certificates</div></div>
                            <div class="percent">
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
				<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/exp_soon">
                    <article class="statistic-box yellow">
                        <div>
                            <div class="number"><?php echo $exp_soon; ?></div>
                            <div class="caption"><div>Expiring Soon</div></div>
                            <div class="percent">
                              
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
				
               
                	<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/expired">
                    <article class="statistic-box red">
                        <div>
                            <div class="number"><?php echo $expire; ?></div>
                            <div class="caption"><div>Expired</div></div>
                            <div class="percent">
                             
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
                <?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ ?>   
               <a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/pending_status">
                    <article class="statistic-box default">
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
                            <div class="percent">
                               
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
                 <?php } ?>
               
				
            </div><!--.row--> 
            
        </div><!--.row-->

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
							<?php echo $row ?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </section>
            </div><!--.col-->
           
        </div>
    </div><!--.container-fluid-->
</div><!--.page-content-->

