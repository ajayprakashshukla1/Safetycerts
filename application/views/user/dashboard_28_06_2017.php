<?php // echo "<pre>"; print_r($login_user); ?>
<div class="page-content">	
  <div class="container-fluid">
  

  <!-- =============Contractor job============= -->

	<?php if($login_user->role=='contractor'){ ?>

	<div class="row">
	    <div class="col-xl-12 dahsboard-column">
	       
	        <section class="card">
	          <div class="card-block">
				<h3 class="m-t-lg with-border">
				 All Assign Job
				</h3>
				<div class="table-responsive">
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
		             $i=1; foreach($job_lists as $joblist){ ?> 
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
	          </div>
	        </section>
	    </div><!--.col-->
	   
	</div>


	<div class="row">
	    <div class="col-xl-12 dahsboard-column">
	       
	        <section class="card">
	          <div class="card-block">
				<h3 class="m-t-lg with-border">
				 View All Certificate
				</h3>
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
		             <?php // echo "<pre>"; print_r($all_certificate); exit;
		             $i=1; foreach($all_certificate as $AC){ ?> 
		              <tr>

		                <td><?php echo $i; ?></td>
						<!--<td><?php echo $AC['certificate_name'] ?></td>-->
		                <td><?php echo $AC['certificate_type_name'] ?></td>
		                <td><?php echo $AC['certificate_date'] ?></td>
		                <td><?php echo $AC['name'] ?></td>
		                <td><?php echo $AC['certificate_expire'] ?></td>
		                <td><a href="<?php echo base_url("jobs/certificate_download/".$AC['certificate_unique_id']) ?>">Download Certificate</a></td>

		              </tr>
		             <?php $i++; } ?>
		              
		             
		            </tbody>
		          </table>
	            </div>
	          </div>
	        </section>
	    </div><!--.col-->
	   
	</div>

	<?php } ?>
	<!--========================================== -->

	       
	<?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ 
            
	$i=1; $row = ''; $valid = 0; $expire = 0; $exp_soon=0; 
					
	foreach($all_certificate as $AC){ 
            $row .= '<tr>
			    <td> '.$i.' </td>
                <!--<td>'.$AC['certificate_name'].'</td>-->
                <td>'. $AC['certificate_type_name'].'</td>
                <td>'.$AC['certificate_date'].'</td>';
				
                $date = $AC['certificate_date']; 
                $date = strtotime($date); 
                $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
				$display_date = date('m/d/Y', $new_date); 
                
				$row .='<td>'.$AC['name'].'</td>
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
				
				<a class="col-sm-3" href="<?php echo base_url()?>user/dashboard/exp_soon">
                    <article class="statistic-box yellow">
                        <div>
                            <div class="number"><?php print_r($exp_soon); ?></div>
                            <div class="caption"><div>Expiring Soon</div></div>
                            <div class="percent">
                              
                                
                            </div>
                        </div>
                    </article>
                </a><!--.col-->
				 
				
                <div class="col-sm-3">
                <a href="<?php echo base_url()?>user/dashboard/pending_status">
                    <article class="statistic-box green">
                        <div>
                
                            <div class="number"><?php echo $pending_status; ?></div>
                          
                            <div class="caoption"><div>Pending Tests</div></div>
                            <div class="percent">
                                
                            </div>
                        </div>
                    </article>
                    </a>
                </div><!--.col-->
				
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
              
              
				
            </div><!--.row--> 
	            <?php } ?> 
	      </div><!--.row-->



	
	<?php 
    $i=1;
	$validd = '';
	$expiringd = '';
    $expiredd = '';
	$valid = 0;
	$expire = 0;
	$exp_soon=0;
	foreach($all_certificate as $AC){ 

               $date = $AC['certificate_date']; 
               $date = strtotime($date); 
               $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
			   $display_date = date('m/d/Y', $new_date);




          if((strtotime(date('m/d/Y')) < $new_date) && (!in_array($display_date,$get_all_dates))){

   /*===============================Valid Start=================================*/
			                              $validd .= '<tr>
		<td> '.$i.' </td>
            <td>'.$AC['certificate_type_name'].'</td>
            <!--<td>'. $AC['certificate_type_name'].'</td>-->
            <td>'.$AC['certificate_date'].'</td>';
		$validd .='<td>'.$AC['name'].'</td>
            <td>'.$AC['certificate_expire'].'</td>
           <td>';
		  
		   if(strtotime(date('m/d/Y')) < $new_date){
			  $validd_ex= '<span class="label label-pill label-success">Valid</span>';
              $valid++;
              if(in_array($display_date,$get_all_dates)){
				 $exp_soon++; 
				  $validd_ex= '<span class="label label-pill label-warning">Expiring Sooon</span>';
			  }	
            $validd .= $validd_ex;								  
		   }else{
			  $validd .= '<span class="label label-pill label-danger">Expired</span>';
			  $expire++;
		   }

			$validd .='</td>
           <td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'">Download Certificate</a></td>
        </tr>';

			  /*===============================Valid End====================================*/
             	
		   }else if((strtotime(date('m/d/Y')) < $new_date) && (in_array($display_date,$get_all_dates))){
		   	/*=======================expiring===========================================*/
		                   $expiringd .= '<tr>
		<td> '.$i.' </td>
            <!--<td>'.$AC['certificate_name'].'</td>-->
            <td>'. $AC['certificate_type_name'].'</td>
            <td>'.$AC['certificate_date'].'</td>';
		$expiringd .='<td>'.$AC['name'].'</td>
            <td>'.$AC['certificate_expire'].'</td>
           <td>';
		  
		   if(strtotime(date('m/d/Y')) < $new_date){
			  $expiringd_ex= '<span class="label label-pill label-success">Valid</span>';
              $valid++;
              if(in_array($display_date,$get_all_dates)){
				 $exp_soon++; 
				  $expiringd_ex= '<span class="label label-pill label-warning">Expiring Sooon</span>';
			  }	
            $expiringd .= $expiringd_ex;								  
		   }else{
			  $expiringd .= '<span class="label label-pill label-danger">Expired</span>';
			  $expire++;
		   }

			$expiringd .='</td>
           <td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'">Download Certificate</a></td>
        </tr>';

		   	/*================================Expiring End ==============================*/

		   }
		   else{
			  $expiredd .= '<tr>
		<td> '.$i.' </td>
            <!--<td>'.$AC['certificate_name'].'</td>-->
            <td>'. $AC['certificate_type_name'].'</td>
            <td>'.$AC['certificate_date'].'</td>';
		$expiredd .='<td>'.$AC['name'].'</td>
            <td>'.$AC['certificate_expire'].'</td>
           <td>';
		  
		   if(strtotime(date('m/d/Y')) < $new_date){
			  $expiredd_ex= '<span class="label label-pill label-success">Valid</span>';
              $valid++;
              if(in_array($display_date,$get_all_dates)){
				 $exp_soon++; 
				  $expiredd_ex= '<span class="label label-pill label-warning">Expiring Sooon</span>';
			  }	
            $expiredd .= $expiredd_ex;								  
		   }else{
			  $expiredd .= '<span class="label label-pill label-danger">Expired</span>';
			  $expire++;
		   }

			$expiredd .='</td>
           <td><a href="'.base_url("jobs/certificate_download/".$AC['certificate_unique_id']).'">Download Certificate</a></td>
        </tr>';
		   }

       $i++; } 



       ?>

       <?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ ?>
       <?php if($this->uri->segment(3)!='pending_status'){ ?>
        <div class="row">
            <div class="col-xl-12 dahsboard-column">
               
                <section class="card">
                  <div class="card-block">
					<h3 class="m-t-lg with-border">
					<?php 
					      if($this->uri->segment(3)=='valid'){$table=$validd.$expiringd ; echo "Valid Certificate";}
					      else if($this->uri->segment(3)=='exp_soon'){$table=$expiringd ; echo "Expiring Soon";}
						  else if($this->uri->segment(3)=='expired'){$table=$expiredd ; echo "Expired";}
					      else{ $table=$validd.$expiringd ; echo "Valid Certificate";}
					?>
					
					</h3>
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
							<?php 

							echo $table;

							 ?>
                        </tbody>
                    </table>
                    </div>
                  </div>
                </section>
            </div><!--.col-->
           
        </div>
	   <?php } } ?>


	   <?php if($this->uri->segment(3)=='pending_status'){ ?>


         <div class="row">
            <div class="col-xl-12 dahsboard-column">
               
                <section class="card">
                  <div class="card-block">
					<h3 class="m-t-lg with-border">
					  Pending Test
					</h3>
					<div class="table-responsive">
                    <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
							    <th>#</th>
								<th>Property Name</th>
								<th>Address</th>
                                <th>Property type</th>
                                <th>Test Created</th>
                                <th>Certificate Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
							    <th>#</th>
								<th>Property Name</th>
								<th>Address</th>
                                <th>Property type</th>
                                <th>Test Created</th>
                                <th>Certificate Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?  if(isset($pending_test) && !empty($pending_test)) 
    						 {
							?>
       					<? $i = 1; foreach($pending_test as $pending) { ?>
                          
							<tr>
							    <td><?=$i ?></td>
								<td><?=$pending['name'] ?></td>
								<td><?=$pending['address'] ?></td>
                                <td><?=$pending['property_type'] ?></td>
                                <td><?php echo date('d/m/Y',strtotime($pending['created'] )); ?>
                                </td>
                                <td class="text-center"><span class="label label-pill label-success">Pending</span></td>
                            </tr>
                            <?php $i++; } 
                            } ?>
                        </tbody>
                    </table>
                    </div>
                  </div>
                </section>
            </div><!--.col-->
           
        </div>
	   <?php } ?>    



 <?php if($this->ion_auth->is_admin() || $login_user->role=='members'){ ?>
   </div><!--.container-fluid-->
 </div><!--.page-content-->

    <div class="page-content" style="padding-top: 0">
        <div class="container-fluid">
		
		<?php // echo "<pre>"; print_r($all_certificate); exit;
		
        $i=1; $row = ''; 
		
		foreach($all_certificate as $AC){ 
            $row .= '<tr>
			    <td> '.$i.' </td>
                <!--<td>'.$AC['certificate_name'].'</td>-->
                <td>'. $AC['certificate_type_name'].'</td>
                <td>'.$AC['certificate_date'].'</td>';
				
                $date = $AC['certificate_date']; 
                $date = strtotime($date); 
                $new_date = strtotime('+'.$AC['certificate_expire'], $date); 
				$display_date = date('m/d/Y', $new_date); 
                
				$row .='<td><a href="'.base_url().'user/property_details/'.$AC['unique_id'].'">'.$AC['name'].'</a></td>
                <td>'.$AC['certificate_expire'].'</td>
				
               
               
            </tr>';
           $i++; } ?>
             
           
            
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
    </div><!--.container-fluid-->
</div><!--.page-content-->
<? } ?>



<!--

	<div class="control-panel-container">
	    <ul>
	        <li class="tasks">
	            <div class="control-item-header">
	                <a href="#" class="icon-toggle">
	                    <span class="caret-down fa fa-caret-down"></span>
	                    <span class="icon fa fa-tasks"></span>
	                </a>
	                <span class="text">Task list</span>
	                <div class="actions">
	                    <a href="#">
	                        <span class="fa fa-refresh"></span>
	                    </a>
	                    <a href="#">
	                        <span class="fa fa-cog"></span>
	                    </a>
	                    <a href="#">
	                        <span class="fa fa-trash"></span>
	                    </a>
	                </div>
	            </div>
	            <div class="control-item-content">
	                <div class="control-item-content-text">You don't have pending tasks.</div>
	            </div>
	        </li>
	        <li class="sticky-note">
	            <div class="control-item-header">
	                <a href="#" class="icon-toggle">
	                    <span class="caret-down fa fa-caret-down"></span>
	                    <span class="icon fa fa-file"></span>
	                </a>
	                <span class="text">Sticky Note</span>
	                <div class="actions">
	                    <a href="#">
	                        <span class="fa fa-refresh"></span>
	                    </a>
	                    <a href="#">
	                        <span class="fa fa-cog"></span>
	                    </a>
	                    <a href="#">
	                        <span class="fa fa-trash"></span>
	                    </a>
	                </div>
	            </div>
	            <div class="control-item-content">
	                <div class="control-item-content-text">
	                    StartUI – a full featured, premium web application admin dashboard built with Twitter Bootstrap 4, JQuery and CSS
	                </div>
	            </div>
	        </li>
	        <li class="emails">
	            <div class="control-item-header">
	                <a href="#" class="icon-toggle">
	                    <span class="caret-down fa fa-caret-down"></span>
	                    <span class="icon fa fa-envelope"></span>
	                </a>
	                <span class="text">Recent e-mails</span>
	                <div class="actions">
	                    <a href="#">
	                        <span class="fa fa-refresh"></span>
	                    </a>
	                    <a href="#">
	                        <span class="fa fa-cog"></span>
	                    </a>
	                    <a href="#">
	                        <span class="fa fa-trash"></span>
	                    </a>
	                </div>
	            </div>
	            <div class="control-item-content">
	                <section class="control-item-actions">
	                    <a href="#" class="link">My e-mails</a>
	                    <a href="#" class="mark">Mark visible as read</a>
	                </section>
	                <ul class="control-item-lists">
	                    <li>
	                        <a href="#">
	                            <h6>Welcome to the Community!</h6>
	                            <div>Hi, welcome to the my app...</div>
	                            <div>
	                                Message text
	                            </div>
	                        </a>
	                        <a href="#" class="reply-all">Reply all</a>
	                    </li>
	                    <li>
	                        <a href="#">
	                            <h6>Welcome to the Community!</h6>
	                            <div>Hi, welcome to the my app...</div>
	                            <div>
	                                Message text
	                            </div>
	                        </a>
	                        <a href="#" class="reply-all">Reply all</a>
	                    </li>
	                    <li>
	                        <a href="#">
	                            <h6>Welcome to the Community!</h6>
	                            <div>Hi, welcome to the my app...</div>
	                            <div>
	                                Message text
	                            </div>
	                        </a>
	                        <a href="#" class="reply-all">Reply all</a>
	                    </li>
	                </ul>
	            </div>
	        </li>
	        <li class="add">
	            <div class="control-item-header">
	                <a href="#" class="icon-toggle no-caret">
	                    <span class="icon fa fa-plus"></span>
	                </a>
	            </div>
	        </li>
	    </ul>
	    <a class="control-panel-toggle">
	        <span class="fa fa-angle-double-left"></span>
	    </a>
	</div>

-->	