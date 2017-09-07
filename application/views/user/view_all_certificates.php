<div class="page-content">
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
							<h3 class="m-t-lg with-border">View All Certificates</h3>
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
    </div>	  