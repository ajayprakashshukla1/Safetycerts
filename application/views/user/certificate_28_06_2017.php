
    <div class="page-content">
        <div class="container-fluid">
		
		<?php // echo "<pre>"; print_r($all_certificate); exit;
		
        $i=1; $row = ''; $valid = 0; $expire = 0; $exp_soon=0;
		
		foreach($all_certificate as $AC){ 
            $row .= '<tr>
			    <td> '.$i.' </td>
                <!--<td>'.$AC['certificate_name'].'</td> -->
                <td>'. $AC['certificate_type_name'].'</td>
                <td>'.$AC['certificate_date'].'</td>';
				
                $date = $AC['certificate_date']; 
                $date = strtotime($date); 
                $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
				$display_date = date('m/d/Y', $new_date); 
                
				$row .='<td><a href="'.base_url().'user/property_details/'.$AC['unique_id'].'">'.$AC['name'].'</a></td>
                <td>'.$AC['certificate_expire'].'</td>
				
                <td>';
			  
			   if(strtotime(date('m/d/Y')) < $new_date){
				  $row_ex= '<span class="label label-pill label-success">Valid</span>';
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
           $i++; } ?>
             
           <div class="row">
                <div class="col-sm-3">
                    <article class="statistic-box green">
                        <div>
                            <div class="number"><?php echo $valid; ?></div>
                            <div class="caption"><div>Valid Certificate</div></div>
                            <div class="percent">
                                
                            </div>
                        </div>
                    </article>
                </div><!--.col-->
                <div class="col-sm-3">
                    <article class="statistic-box yellow">
                        <div>
                            <div class="number"><?php print_r($exp_soon); ?></div>
                            <div class="caption"><div>Expiring Soon</div></div>
                            <div class="percent">
                              
                                
                            </div>
                        </div>
                    </article>
                </div><!--.col-->
                <div class="col-sm-3">
                    <article class="statistic-box red">
                        <div>
                            <div class="number"><?php echo $expire; ?></div>
                            <div class="caption"><div>Expired</div></div>
                            <div class="percent">
                             
                                
                            </div>
                        </div>
                    </article>
                </div><!--.col-->
				 <?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ ?>	
                <div class="col-sm-3">
                    <article class="statistic-box green">
                        <div>
                            <div class="number"><?php echo $pending_status_test; ?></div>
                            <div class="caption"><div>Pending Tests</div></div>
                            <div class="percent">
                               
                            </div>
                        </div>
                    </article>
                </div><!--.col-->
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

