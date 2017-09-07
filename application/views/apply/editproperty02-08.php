<style>
.checkbox input[type=checkbox]:checked+label:after, .radio input[type=checkbox]:checked+label:after {
    content: "\22";
}
.accord-text{
	color: #333;background-color: #f5f5f5;border-color: #ddd;padding: 10px;
	border: 1px solid #ddd;
    margin-bottom: 0;
}
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
</style>
<?php

	$electricalcount=0;
	$emergencycount=0;
	$portablecount=0;
	$firecount=0;
	$smokecount=0;
	$carboncount=0;
	$gassafetycount=0;
	$electrical_certificate_unique_id ='';
	$emergency_certificate_unique_id ='';
	$portable_certificate_unique_id ='';
	$fire_certificate_unique_id ='';
	$smoke_certificate_unique_id ='';
	$carbon_certificate_unique_id ='';
	$gas_certificate_unique_id ='';
	
		
	foreach($certificatedetails as $key=>$val){
		if($val['certificate_name']=='electrical_test'){
			$electrical_validity=$val['certificate_expire'];
			$electrical_unique_id=$val['certificate_unique_id'];
			$electrical_certificate_name=$val['certificate_name'];
			$electrical_certificate_file=$val['certificate_file'];
			$electrical_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
		if($val['certificate_name']=='emergency_test'){
			$emergency_validity=$val['certificate_expire'];
			$emergency_unique_id=$val['certificate_unique_id'];
			$emergency_certificate_name=$val['certificate_name'];
			$emergency_certificate_file=$val['certificate_file'];
			$emergency_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
		if($val['certificate_name']=='portable_test'){
			$portable_validity=$val['certificate_expire'];
			$portable_unique_id=$val['certificate_unique_id'];
			$portable_certificate_name=$val['certificate_name'];
			$portable_certificate_file=$val['certificate_file'];
			$portable_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
		if($val['certificate_name']=='fire_test'){
			$fire_validity=$val['certificate_expire'];
			$fire_unique_id=$val['certificate_unique_id'];
			$fire_certificate_name=$val['certificate_name'];
			$fire_certificate_file=$val['certificate_file'];
			$fire_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
		if($val['certificate_name']=='smoke_test'){
			$smoke_validity=$val['certificate_expire'];
			$smoke_unique_id=$val['certificate_unique_id'];
			$smoke_certificate_name=$val['certificate_name'];
			$smoke_certificate_file=$val['certificate_file'];
			$smoke_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
		if($val['certificate_name']=='carbon_test'){
			$carbon_validity=$val['certificate_expire'];
			$carbon_unique_id=$val['certificate_unique_id'];
			$carbon_certificate_name=$val['certificate_name'];
			$carbon_certificate_file=$val['certificate_file'];
			$carbon_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
		if($val['certificate_name']=='gas_safety_test'){
			$gas_validity=$val['certificate_expire'];
			$gas_unique_id=$val['certificate_unique_id'];
			$gas_certificate_name=$val['certificate_name'];
			$gas_certificate_file=$val['certificate_file'];
			$gas_certificate_unique_id=$val['certificate_unique_id'];
			
		}
		
	}
	foreach($othercertificatedetails as $key=>$val){
		if($val['certificate_type']==1 && !empty($val['other_certificate_file']))
			$electricalcount++;
		
		if($val['certificate_type']==2 && !empty($val['other_certificate_file']))
			$emergencycount++;
		
		if($val['certificate_type']==3 && !empty($val['other_certificate_file']))
			$portablecount++;
		
		if($val['certificate_type']==4 && !empty($val['other_certificate_file']))
			$firecount++;
		
		if($val['certificate_type']==5 && !empty($val['other_certificate_file']))
			$smokecount++;
		
		if($val['certificate_type']==6 && !empty($val['other_certificate_file']))
			$carboncount++;
		
		if($val['certificate_type']==7 && !empty($val['other_certificate_file']))
			$gassafetycount++;
	}
	//echo '<pre>'; print_r($othercertificatedetails); exit();
	foreach($othercertificatedetails as $key=>$val){
		if($val['certificate_type']==1 && !empty($val['other_certificate_file']))
			$electricalarray[]=$val;
		
		if($val['certificate_type']==2 && !empty($val['other_certificate_file']))
			$emergencyarray[]=$val;
		
		if($val['certificate_type']==3 && !empty($val['other_certificate_file']))
			$portablearray[]=$val;
		
		if($val['certificate_type']==4 && !empty($val['other_certificate_file']))
			$firearray[]=$val;

		
		if($val['certificate_type']==5 && !empty($val['other_certificate_file']))
			$smokearray[]=$val;
		
		if($val['certificate_type']==6 && !empty($val['other_certificate_file']))
			$carbonarray[]=$val;
		
		if($val['certificate_type']==7 && !empty($val['other_certificate_file']))
			$gassafetyarray[]=$val;
	}
	
	foreach($certifiles as $key=>$val){
		if($val['certificate_type']==1)
			$electrical_date=date($val['certificate_date']);
		
		if($val['certificate_type']==2)
			$emergency_date=$val['certificate_date'];
		
		if($val['certificate_type']==3)
			$portable_date=$val['certificate_date'];
		
		if($val['certificate_type']==4)
			$fire_date=$val['certificate_date'];
		
		if($val['certificate_type']==5)
			$smoke_date=$val['certificate_date'];
		
		if($val['certificate_type']==6)
			$carbon_date=$val['certificate_date'];
		
		if($val['certificate_type']==7)
			$gas_date=$val['certificate_date'];
	}

?>
<div class="page-content">
   <div class="container-fluid">	
	  <section class="card">
		<div class="card-block">
		  <div class="row">
			<div class="col-md-12">
			<div>
			<div style="border-bottom: solid 1px #d8e2e7; margin-bottom: 20px;padding-bottom: 15px;">
				<h3 class="m-t-lg pull-left" style="margin-bottom: 0;">Property Details for <?php echo $property_data['name'] ; ?>  </h3>
				<div class="pull-right">
					<a href="<?php echo base_url('jobs/view_certificate/'.$this->uri->segment(3)) ?>" >
					<button type="button" class="btn btn-default" style="margin-top: 20px; padding-top: 5px; padding-bottom: 5px;"> View Certificates</button></a>
				</div>
			
				<div class="clearfix"></div>
			</div>

	            <?php if($this->session->flashdata('message')) {?>
		           <div class="alert alert-success fade in">
		              <a href="#" class="close" data-dismiss="alert">&times;</a>
		              <strong>Success!</strong> <?php echo $this->session->flashdata('message');?>
		   				<a href="<?php echo base_url('jobs/view_certificate/'.$this->uri->segment(3)) ?>">View Certificates</a>
		           </div>
	            <?php } ?>
				
				<?php echo form_open('', array('class'=>'email','id' =>'form-signup_v2','name'=>'form-signup_v2','enctype' => 'multipart/form-data'));?>
				
					<input type="hidden" name="id" value="<?php echo $property_data['id'] ; ?>">
					
					<div class="form-group">
					  <label class="form-label" for="signup_v2-name">Name</label>
					  <div class="form-control-wrapper">
					     <input type="text"  id="name"  name="name" class="form-control" value="<?php echo $property_data['name'] ; ?>" placeholder="enter name" required/>
					  </div>
				   </div>

				   <div class="form-group">
					  <label class="form-label" for="signup_v2-name">Address</label>
					  <div class="form-control-wrapper">
						 <textarea rows="4" id="address"  name="address" class="form-control" placeholder="" data-autosize="" style="overflow: hidden; word-wrap: break-word; height: 98px;" required><?php echo $property_data['address']; ?></textarea>		
					  </div>
				   </div>
				   <div class="form-group">
					  <label class="form-label" for="signup_v2-name">PostCode</label>
					  <div class="form-control-wrapper">
						  <input type="text"  id="zip_code"   name="zip_code" class="form-control" value="<?php echo $property_data['zip_code'] ; ?>" placeholder="enter postcode" required/>		
					  </div>
				   </div>

				   
				   <div class="form-group form-group-radios">
					  <label class="form-label" id="property_type">
						Property Type <span class="color-red">*</span>
					  </label>
					  
					  <div class="radio">
				         <input type="radio" name="property_type" id="radio-1" value="domestic" <?php if($property_data['property_type']=='domestic'){ echo "checked";  } ?>>
				         <label for="radio-1">Domestic</label>
			          </div>
				
					  <div class="radio">
				        <input type="radio" name="property_type" id="radio-2" value="commercial" <?php if($property_data['property_type']=='commercial'){ echo "checked";  } ?>>
				        <label for="radio-2">Commercial</label>
			          </div>

			          <div class="radio">
				        <input type="radio" name="property_type" id="radio-3" value="industrial" <?php if($property_data['property_type']=='industrial'){ echo "checked";  } ?>>
				        <label for="radio-3">Industrial</label>
			          </div>
				  </div>
				  
				  <div class="form-group form-group-radios">
					 <label class="form-label" id="signup_v2-gender"></label>
					 <div class="form-control-wrapper"></div>
				  </div>
				   <?php if($login_user->role=='admin'){ ?>
					 <div class="row">
						<div class="form-group">
						   <div class="col-md-6">
							 <label>Client Name <span class="color-red">*</span></label>
							 <select class="form-control" id='user_id' name="user_id" required>
								 <option value="">Select Client</option>
								 <?php foreach($list_of_clients as $list_of_client) { ?>
									<option value="<?php echo $list_of_client->id ?>"<?php if($property_data['user_id']==$list_of_client->id){echo 'selected="selected"';} ?>><?php echo $list_of_client->first_name?> <?php echo $list_of_client->last_name ?></option>
								 <?php } ?>
							 </select>
						   </div>
						</div>
					 </div><br/><br/>
					
				  <?php }  ?>
				  
				 <div class="form-group">
				   <label class="form-label" for="signup_v2-name">Access Details</label>
				   <div class="form-control-wrapper">
					 <input id="access_detail" class="form-control" name="access_details" value="<?php echo $property_data['access_details'] ; ?>" type="text" data-validation="[OPTIONAL, NAME, L>=2, TRIM]">
				   </div>
			    </div>
				
				 <div class="panel-group" id="accordion">
					 <div class="panel panel-default">
					   <div class="panel-heading">
							<h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1">
							  <h5 style="" class="accord-text">Electrical Test</h5>
							  </a>
							</h4>
					   </div>
					   
					   
						<div id="collapse1" class="panel-collapse collapse in">
							 <div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										 <div class="col-md-3">
			                      
											 <div class="checkbox-detailed " id="check_yes1">
												  <input type="radio" name="electrical_test" id="check-det-1" value="yes" class="test_checkbox" <?php if($property_data['electrical_test']=='yes'){ echo "checked";} ?>/>
												  <label for="check-det-1">
													<span class="checkbox-detailed-tbl">
													 <span class="checkbox-detailed-cell">
													<span class="checkbox-detailed-title">Yes</span>
													</span>
													</span>
												  </label>
											 </div>
											 </div>
											<div class="col-md-3">
												<div class="checkbox-detailed "  id="check_no1">
												   <input type="radio" name="electrical_test" id="check-det-2" value="no" class="test_checkbox"  <?php if($property_data['electrical_test']=='no'){ echo "checked";} ?>/>
												   <label for="check-det-2">
												   <span class="checkbox-detailed-tbl">
													<span class="checkbox-detailed-cell">
														<span class="checkbox-detailed-title">No</span>
													</span>
													</span>
												  </label>
											   </div>
											</div>
											
											<?php if($property_data['electrical_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/1' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
										
									</div>
								</div>
								
								<?php $style=($property_data['electrical_test']=='yes') ? "display:block" : "display:none;"; ?>
								<div class="prev_detail_hide1"  style="<?php echo $style; ?>">
									<div class="" style="margin-left: 17px">

										 <div class="form-group">
										 
										  <label class="form-label" for="signup_v2-name">Number of circuits</label>
										  <div class="form-control-wrapper">
											<input id="nr_circuits" class="form-control" name="nr_circuits" type="text"data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%" value="<?php echo $property_data['nr_circuits']; ?>">
										  </div>
										 </div>
									</div>
									
									<section class="card card-default" style="border:0px solid">
										<header class="card-header">Enter Test History Details Here
										  <button type="button" class="modal-close">
											<!-- <i class="font-icon-close-2"></i> -->
										  </button>
										 </header>
									</section>
									
										<div class="form-group" style="margin: 30px 0 25px 16px;">
										   <div class='input-group date'>
											  <input id="daterange1" name="electrical_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date" value="<?php echo (isset($electrical_date) && !empty($electrical_date)) ? $electrical_date : '' ; ?>">
											   <span class="input-group-addon">
												<i class="font-icon font-icon-calend"></i>
												</span>
										   </div>
										</div>
										
										<div class="form-group" style="margin: 30px 0 25px 16px;">
										   <div class='input-group'>
											 <label>Validity period</label>
											 <select class="form-control" name="electrical_expire">
												
												<option value="1 Month" <?php echo (isset($electrical_validity) && $electrical_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
												<option value="3 Months" <?php echo (isset($electrical_validity) && $electrical_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
												<option value="6 Months" <?php echo (isset($electrical_validity) && $electrical_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
												<option value="1 year" <?php echo (isset($electrical_validity) && $electrical_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
												<option value="3 years" <?php echo (isset($electrical_validity) && $electrical_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
												<option value="5 years" <?php echo (isset($electrical_validity) && $electrical_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
												<option value="10 years" <?php echo (isset($electrical_validity) && $electrical_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
											 </select>
										  </div>
										</div>
										
										<?php $required='required="required"';
										if(isset($electrical_certificate_file) && !empty($electrical_certificate_file)){
										 $required = ''; }?>
										
										  <div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											   <label>Upload Certificate</label>										  
											   <input id="file_one" type="file" name="electrical_upload_file" class="form-control" <?php echo $required; ?>>
											</div>
										</div>

									
										<?php if(isset($electrical_certificate_file) && !empty($electrical_certificate_file)) { ?>
										<div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											  
																	
												
												<div class="alert alert-success fade in">
													<a href="#" class="close close_cert" id="<?php echo $electrical_unique_id; ?>">&times;</a>
													<a href="<?php echo base_url() ?>uploads/cert/<?php echo $electrical_certificate_file; ?>" title="View file" download="<?php echo $electrical_certificate_file; ?>"><?php echo $electrical_certificate_file; ?></a>
												</div>
												
											</div>
										</div>
										<?php } ?>
										
										<div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											   <label>Other Certificate File</label>
											  <input class="form-control" id="file_input" value=""  name="other_certificate_file[]" type="file" multiple="multiple"/> 
											</div>
										</div>
										
										 <?php  if(!empty($electricalcount)) {	?>
										<div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											   
																				  
											  
											  <?php
													foreach ($electricalarray as $other_cert) {?>

														<div class="alert alert-success fade in">
															<a href="#" class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;
															</a>
															<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?>
																
															</a>
														</div>
													<?php }  ?>	
											 	
											</div>
										</div>
										
										<?php }  ?>
										
										<input type="hidden" name="is_first_property_certificate_electrical" value="1" />
										<input type="hidden" name="electrical_certificate_unique_id" value="<?php echo $electrical_certificate_unique_id ?>">
										
								</div>
							 </div>
						</div>
					 </div>
					 
					 <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2">
								<h5  class="accord-text">Emergency Lighting Test</h5>
							  </a>
							</h4>
						 </div>
						 
						 <div id="collapse2" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row">
									 <div class="col-md-12">
									  <div class="col-md-3">
											<div class="checkbox-detailed "  id="check_yes2">
											   <input type="radio" name="emergency_test" id="check-det-3" value="yes" class="test_checkbox" <?php if($property_data['emergency_test']=='yes'){ echo "checked";} ?>/>
											   <label for="check-det-3">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">Yes</span>
											   </span>
											  </span>
											  </label>
											</div>
										
										 </div>
										 
										 <div class="col-md-3">
											  <div class="checkbox-detailed "  id="check_no2">
											   <input type="radio" name="emergency_test" id="check-det-4" value="no" class="test_checkbox" <?php if($property_data['emergency_test']=='no'){ echo "checked";} ?>/>
											   <label for="check-det-4">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">No</span>
											   </span>
											  </span>
											  </label>
											</div>
					         
										</div>
										
										<?php if($property_data['emergency_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/2' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
									 </div>
								</div>
								
								<?php $style=($property_data['emergency_test']=='yes') ? "display:block" : "display:none;"; ?>
								<div class="prev_detail_hide2" style="<?php echo $style; ?>">
									<div class="" style="margin-left: 17px">
									<div class="form-group">
									  <label class="form-label" for="signup_v2-name">Number of fittings</label>
									  <div class="form-control-wrapper">
										<input id="nr_fittings" class="form-control" name="nr_fittings" type="text" value="<?php echo $property_data['nr_fittings']; ?>" data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width: 50%">
									  </div>
									 </div>
									</div> 
									 <section class="card card-default" style="border:0px solid">
									<header class="card-header">Enter Test History Details Here
									  <button type="button" class="modal-close">
										<!-- <i class="font-icon-close-2"></i> -->
									  </button>
									 </header>
									 </section>
									
									<!--date-img col-->
									<div class="form-group" style="margin: 15px 0 15px 16px;">
									   <div class='input-group date'>
									  <input id="daterange2" name="emergency_prev_date" type="text"  class="form-control datepicker" placeholder="Previous Test Date" value="<?php echo (isset($emergency_date) && !empty($emergency_date)) ? $emergency_date : '' ; ?>">
									   <span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
										</span>
									  </div>
									</div>

									<div class="form-group" style="margin: 30px 0 25px 16px;">
									   <div class='input-group'>
										 <label>Validity period</label>
										 <select class="form-control" name="emergency_expire">
										   
											<option value="1 Month" <?php echo (isset($emergency_validity) && $emergency_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
											<option value="3 Months" <?php echo (isset($emergency_validity) && $emergency_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
											<option value="6 Months" <?php echo (isset($emergency_validity) && $emergency_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
											<option value="1 year" <?php echo (isset($emergency_validity) && $emergency_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
											<option value="3 years" <?php echo (isset($emergency_validity) && $emergency_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
											<option value="5 years" <?php echo (isset($emergency_validity) && $emergency_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
											<option value="10 years" <?php echo (isset($emergency_validity) && $emergency_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
										 </select>
									  </div>
									</div>
										
									<?php $required='required="required"';
										if(isset($emergency_certificate_file) && !empty($emergency_certificate_file)){
										 $required = ''; }?>
										
									<div class="form-group" style="margin: 15px 0 15px 16px;">
									   <div class='input-group date'>
										 <label>Upload Certificate</label>
										<input id="file_two" type="file" name="emergency_upload_file"  class="form-control" <?php echo $required; ?>>
									   </div>
									</div>
									<?php if(isset($emergency_certificate_file) && !empty($emergency_certificate_file)) { ?>
									<div class="form-group" style="margin: 30px 0 25px 16px;">
										<div class='input-group date'>
										  
																				
											
												<div class="alert alert-success fade in">
													<a href="#" class="close close_cert" id="<?php echo $emergency_unique_id; ?>">&times;</a>
													<a href="<?php echo base_url() ?>uploads/cert/<?php echo $emergency_certificate_file; ?>" title="View file" download="<?php echo $emergency_certificate_file; ?>"><?php echo $emergency_certificate_file; ?></a>
												</div>
												
										</div>
									</div>
									<?php } ?>
																	
									<div class="form-group" style="margin: 30px 0 25px 16px;">
										<div class='input-group date'>
										   <label>Other Certificate File</label>
										  <input class="form-control" id="file_input" value=""  name="other_emergency_certificate_file[]" type="file" multiple="multiple"/> 
										</div>
									</div>
									
									<?php  if(!empty($emergencycount)) { ?>
									<div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											   
																	  
											   
											   <?php
												foreach ($emergencyarray as $other_cert) {?>
													<div class="alert alert-success fade in">
														<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?></a>
													</div>
												<?php }  ?>	
											
											</div>
									</div>
									 <?php }  ?>		
									<input type="hidden" name="is_first_property_certificate_emergency" value="1" />
									<input type="hidden" name="emergency_certificate_unique_id" value="<?php echo $emergency_certificate_unique_id ?>">
									

							   </div>
							</div>
						</div>
					 </div>
					  <div class="panel panel-default">
						  <div class="panel-heading">
							<h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3">
							  <h5  class="accord-text">Portable Appliance Test</h5>
							  </a>
							</h4>
						  </div>
						  <div id="collapse3" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row">
										<div class="col-md-12">
									   
										<div class="col-md-3">
										<div class="checkbox-detailed" id="check_yes3">
										   <input type="radio" name="portable_test" id="check-det-5" value="yes" <?php if($property_data['portable_test']=='yes'){ echo "checked";} ?>/>
										   <label for="check-det-5">
										   <span class="checkbox-detailed-tbl">
											<span class="checkbox-detailed-cell">
											<span class="checkbox-detailed-title">Yes</span>
										   </span>
										  </span>
										  </label>
										</div>
										
										 </div>
										 <div class="col-md-3">
										 <div class="checkbox-detailed" id="check_no3">
										   <input type="radio" name="portable_test" id="check-det-6" value="no" <?php if($property_data['portable_test']=='no'){ echo "checked";} ?>/>
										   <label for="check-det-6">
										   <span class="checkbox-detailed-tbl">
											<span class="checkbox-detailed-cell">
											<span class="checkbox-detailed-title">No</span>
										   </span>
										  </span>
										  </label>
										</div>

										</div>
										
										<?php if($property_data['portable_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/3' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
										
										</div><!--close of md-12>-->
										</div><!--end of row-->
										<?php $style=($property_data['portable_test']=='yes') ? "display:block" : "display:none;"; ?>
									   <div class="prev_detail_hide3" style="<?php echo $style; ?>">
										<div class="" style="margin-left: 17px">
										 <div class="form-group">
										  <label class="form-label" for="signup_v2-name">Number of items</label>
										  <div class="form-control-wrapper">
											<input id="nr_items" class="form-control" name="nr_items" type="text" value="<?php echo $property_data['nr_items']; ?>" data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
										  </div>
										 </div>
										</div>
										 <section class="card card-default" style="border:0px solid">
										<header class="card-header">Enter Test History Details Here
										  <button type="button" class="modal-close">
											<!-- <i class="font-icon-close-2"></i> -->
										  </button>
										 </header>
										 </section>
										
									   <!--date-img col-->
										<div class="form-group" style="margin: 15px 0 15px 16px;">
										   <div class='input-group date'>
										  <input id="daterange3" name="portable_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date" value="<?php echo (isset($portable_date) && !empty($portable_date)) ? $portable_date : '' ; ?>">
										   <span class="input-group-addon">
											<i class="font-icon font-icon-calend"></i>
											</span>
										  </div>
										</div>

										<div class="form-group" style="margin: 30px 0 25px 16px;">
										   <div class='input-group'>
											 <label>Validity period</label>
											 <select class="form-control" name="portable_expire">
											   
												<option value="1 Month" <?php echo (isset($portable_validity) && $portable_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
												<option value="3 Months" <?php echo (isset($portable_validity) && $portable_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
												<option value="6 Months" <?php echo (isset($portable_validity) && $portable_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
												<option value="1 year" <?php echo (isset($portable_validity) && $portable_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
												<option value="3 years" <?php echo (isset($portable_validity) && $portable_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
												<option value="5 years" <?php echo (isset($portable_validity) && $portable_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
												<option value="10 years" <?php echo (isset($portable_validity) && $portable_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
											 </select>
										  </div>
										</div>
										
										<?php $required='required="required"';
										if(isset($portable_certificate_file) && !empty($portable_certificate_file)){
										 $required = ''; }?>	
										 <div class="form-group" style="margin: 15px 0 15px 16px;">
										   <div class='input-group date'>
											 <label>Upload Certificate</label>
											 <input id="file_three" type="file" name="portable_upload_file"  class="form-control" <?php echo $required; ?>>
										   </div>
										</div>
										
										<?php if(isset($portable_certificate_file) && !empty($portable_certificate_file)) { ?>
										<div class="form-group" style="margin: 30px 0 25px 16px;">
												<div class='input-group date'>
												  
													
													<div class="alert alert-success fade in">
														<a href="#" class="close close_cert" id="<?php echo $portable_unique_id; ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $portable_certificate_file; ?>" title="View file" download="<?php echo $portable_certificate_file; ?>"><?php echo $portable_certificate_file; ?></a>
													</div>
													
												</div>
										  </div>
										<?php } ?>
										
										
										<div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											   <label>Other Certificate File</label>
											  <input class="form-control" id="file_input" value=""  name="other_portable_certificate_file[]" type="file" multiple="multiple"/> 
											</div>
										</div>
										<?php  if(!empty($portablecount)) { ?>
										<div class="form-group" style="margin: 30px 0 25px 16px;">
											<div class='input-group date'>
											   
												
												<?php
												foreach ($portablearray as $other_cert) {?>
													<div class="alert alert-success fade in">
														<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?></a>
													</div>
												<?php }  ?>	
											 
											</div>
										</div>
									<?php }  ?>
										<input type="hidden" name="is_first_property_certificate_portable" value="1" />
										<input type="hidden" name="portable_certificate_unique_id" value="<?php echo $portable_certificate_unique_id ?>">
										

								 </div>
							</div>
						  </div>
						</div>
						
						  <div class="panel panel-default">
							  <div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion4" href="#collapse4">
								   <h5  class="accord-text">Fire Alarm Test</h5></a>
								</h4>
							  </div>
							  <div id="collapse4" class="panel-collapse collapse">
								<div class="panel-body">
									  <div class="row">
											<div class="col-md-12">
										  
											<div class="col-md-3">

											<div class="checkbox-detailed" id="check_yes4">
											   <input type="radio" name="fire_test" id="check-det-7" value="yes" <?php if($property_data['fire_test']=='yes'){ echo "checked";} ?>/>
											   <label for="check-det-7">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">Yes</span>
											   </span>
											  </span>
											  </label>
											</div>
											
											 </div>
											 <div class="col-md-3">
											 <div class="checkbox-detailed" id="check_no4">
											   <input type="radio" name="fire_test" id="check-det-8" value="no" <?php if($property_data['fire_test']=='no'){ echo "checked";} ?>/>
											   <label for="check-det-8">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">No</span>
											   </span>
											  </span>
											  </label>
											</div>
											 

											</div>
											
											<?php if($property_data['fire_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/4' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
											
											</div><!--close of md-12>-->
											</div><!--end of row-->
											<?php $style=($property_data['fire_test']=='yes') ? "display:block" : "display:none;"; ?>
										   <div class="prev_detail_hide4" style="<?php echo $style; ?>">
											<div class="" style="margin-left: 17px">
											<div class="form-group">
											  <label class="form-label" for="signup_v2-name">Number of devices</label>
											  <div class="form-control-wrapper">
												<input id="nr_devices" class="form-control" name="nr_devices" type="text" data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%" value="<?php echo $property_data['nr_devices']; ?>"/>
											  </div>
											 </div>
											</div>
											 <section class="card card-default" style="border:0px solid">
											<header class="card-header">Enter Test History Details Here
											  <button type="button" class="modal-close">
												<!-- <i class="font-icon-close-2"></i> -->
											  </button>
											 </header>
											 </section>
											
										   <!--date-img col-->
											<div class="form-group" style="margin: 15px 0 15px 16px;">
											   <div class='input-group date'>
											  <input id="daterange4" name="fire_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date" value="<?php echo (isset($fire_date) && !empty($fire_date)) ? $fire_date : '' ; ?>">
											   <span class="input-group-addon">
												<i class="font-icon font-icon-calend"></i>
												</span>
											  </div>
											</div>

											<div class="form-group" style="margin: 30px 0 25px 16px;">
											   <div class='input-group'>
												 <label>Validity period</label>
												 <select class="form-control" name="fire_expire">							        
													<option value="1 Month" <?php echo (isset($fire_validity) && $fire_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
													<option value="3 Months" <?php echo (isset($fire_validity) && $fire_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
													<option value="6 Months" <?php echo (isset($fire_validity) && $fire_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
													<option value="1 year" <?php echo (isset($fire_validity) && $fire_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
													<option value="3 years" <?php echo (isset($fire_validity) && $fire_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
													<option value="5 years" <?php echo (isset($fire_validity) && $fire_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
													<option value="10 years" <?php echo (isset($fire_validity) && $fire_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
												 </select>
											  </div>
											</div>

											<?php $required='required="required"';
												if(isset($fire_certificate_file) && !empty($fire_certificate_file)){
										 		$required = ''; }?>
												
											 <div class="form-group" style="margin: 15px 0 15px 16px;">
											   <div class='input-group date'>
													<label>Upload Certificate</label>
												   <input id="file_four" type="file" name="fire_upload_file"  class="form-control" <?php echo $required; ?>>
											   </div>
											</div>
												
											<?php if(isset($fire_certificate_file) && !empty($fire_certificate_file)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
												<div class='input-group date'>
												  
																						
												
													<div class="alert alert-success fade in">
														<a href="#" class="close close_cert" id="<?php echo $fire_unique_id; ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $fire_certificate_file; ?>" title="View file" download="<?php echo $fire_certificate_file; ?>"><?php echo $fire_certificate_file; ?></a>
													</div>
													
												</div>
											</div>
											<?php } ?>
										
											
											
											<div class="form-group" style="margin: 30px 0 25px 16px;">
												<div class='input-group date'>
												   <label>Other Certificate File</label>
												  <input class="form-control" id="file_input" value=""  name="other_fire_certificate_file[]" type="file" multiple="multiple"/> 
												</div>
											</div>
											  <?php  if(!empty($firecount)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
												<div class='input-group date'>
												   
											
											  <?php
												foreach ($firearray as $other_cert) {?>
													<div class="alert alert-success fade in">
														<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?></a>
													</div>
												<?php }  ?>	
											 
												</div>
											</div>
											<?php }  ?>
											<input type="hidden" name="is_first_property_certificate_fire" value="1" />
											<input type="hidden" name="fire_certificate_unique_id" value="<?php echo $fire_certificate_unique_id ?>">
											
										</div>
								</div>
							  </div>
							</div>
							
							 <div class="panel panel-default">
							  <div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion5" href="#collapse5">
								   <h5  class="accord-text">Smoke Detector Test</h5></a>
								</h4>
							  </div>
							  <div id="collapse5" class="panel-collapse collapse">
								<div class="panel-body">
									 <div class="row">
											<div class="col-md-12">
											
											<div class="col-md-3">

											 <div class="checkbox-detailed" id="check_yes5">
											   <input type="radio" name="smoke_test" id="check-det-9" value="yes" <?php if($property_data['smoke_test']=='yes'){ echo "checked";} ?>/>
											   <label for="check-det-9">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">Yes</span>
											   </span>
											  </span>
											  </label>
											</div>
										   
											 </div>
											 <div class="col-md-3">
											 <div class="checkbox-detailed" id="check_no5">
											   <input type="radio" name="smoke_test" id="check-det-10" value="no" <?php if($property_data['smoke_test']=='no'){ echo "checked";} ?>/>
											   <label for="check-det-10">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">No</span>
											   </span>
											  </span>
											  </label>
											</div>
											 
											</div>
											
											<?php if($property_data['smoke_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/5' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
											
											</div><!--close of md-12>-->
											</div><!--end of row-->
											<?php $style=($property_data['smoke_test']=='yes') ? "display:block" : "display:none;"; ?>
										   <div class="prev_detail_hide5" style="<?php echo $style; ?>">
										   <div class=" " style="margin-left: 17px">
											<div class="form-group">
											  <label class="form-label" for="signup_v2-name">Number of sensors</label>
											  <div class="form-control-wrapper">
												<input id="nr_sensors"
													   class="form-control"
													   name="nr_sensors"
													   type="text"
													   value="<?php echo $property_data['nr_sensors']; ?>"
													   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
											  </div>
											 </div>
											</div>
										   <section class="card card-default" style="border:0px solid">
											 <header class="card-header">Enter Test History Details Here
											  <button type="button" class="modal-close">
												<!-- <i class="font-icon-close-2"></i> -->
											  </button>
											 </header>
										   <div class="card-block">
											 
											 <div class="form-group">
											   <div class='input-group date'>
											  <input id="daterange5" name="smoke_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date" value="<?php echo (isset($smoke_date) && !empty($smoke_date)) ? $smoke_date : '' ; ?>">
											   <span class="input-group-addon">
												<i class="font-icon font-icon-calend"></i>
												</span>
											  </div>
											</div>

											<div class="form-group" style="margin: 30px 0 25px 0px;">
											   <div class='input-group'>
												 <label>Validity period</label>
												 <select class="form-control" name="smoke_expire">
													
													<option value="1 Month" <?php echo (isset($smoke_validity) && $smoke_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
													<option value="3 Months" <?php echo (isset($smoke_validity) && $smoke_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
													<option value="6 Months" <?php echo (isset($smoke_validity) && $smoke_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
													<option value="1 year" <?php echo (isset($smoke_validity) && $smoke_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
													<option value="3 years" <?php echo (isset($smoke_validity) && $smoke_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
													<option value="5 years" <?php echo (isset($smoke_validity) && $smoke_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
													<option value="10 years" <?php echo (isset($smoke_validity) && $smoke_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
												 </select>
											  </div>
											</div>
											<?php $required='required="required"';
												if(isset($smoke_certificate_file) && !empty($smoke_certificate_file)){
										 		$required = ''; }?>
											 <div class="form-group">
												<div class='input-group date'>
													<label>Upload Certificate</label>
												   <input id="file" type="file" name="smoke_upload_file"  class="form-control" <?php echo $required; ?>>
												</div>
											</div>
											
											<?php if(isset($smoke_certificate_file) && !empty($smoke_certificate_file)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
													<div class='input-group date'>
													  
											
											<div class="alert alert-success fade in">
												<a href="#" class="close close_cert" id="<?php echo $smoke_unique_id; ?>">&times;</a>
												<a href="<?php echo base_url() ?>uploads/cert/<?php echo $smoke_certificate_file; ?>" title="View file" download="<?php echo $smoke_certificate_file; ?>"><?php echo $smoke_certificate_file; ?></a>
											</div>
											
											  </div>
											  </div>
												<?php } ?>
											
											<div class="form-group" style="margin: 30px 0 25px 0;">
												<div class='input-group date'>
												   <label>Other Certificate File</label>
												  <input class="form-control" id="file_input" value=""  name="other_smoke_certificate_file[]" type="file" multiple="multiple"/> 
												</div>
											</div>
											
											 <?php  if(!empty($smokecount)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
													<div class='input-group date'>
													   
											 
											  <?php
												foreach ($smokearray as $other_cert) {?>
													<div class="alert alert-success fade in">
														<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?></a>
													</div>
												<?php }  ?>	
											 
											 </div></div>
											 <?php }  ?>
											
											<input type="hidden" name="is_first_property_certificate_smoke" value="1" />
											<input type="hidden" name="smoke_certificate_unique_id" value="<?php echo $smoke_certificate_unique_id ?>">
											
									 </div>
									 </section>
							  </div>
							</div>
						  </div> 
						  <div class="panel panel-default">
							  <div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion6" href="#collapse6">
								  <h5 style="" class="accord-text">Carbon monoxide detector</h5>
								  </a>
								</h4>
							  </div>
							  <div id="collapse6" class="panel-collapse collapse">
								<div class="panel-body">
									 <div class="row">
											<div class="col-md-12">
											
											   <div class="col-md-3">
											  
											 <div class="checkbox-detailed" id="check_yes6">
											  <input type="radio" name="carbon_test" id="check-det-11" value="yes" <?php if($property_data['carbon_test']=='yes'){ echo "checked";} ?>/>
											  <label for="check-det-11">
												<span class="checkbox-detailed-tbl">
												 <span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">Yes</span>
												</span>
												</span>
											  </label>
											 </div>

											 </div>
											 <div class="col-md-3">
											 <div class="checkbox-detailed" id="check_no6">
											   <input type="radio" name="carbon_test" id="check-det-12" value="no" <?php if($property_data['carbon_test']=='no'){ echo "checked";} ?>/>
											   <label for="check-det-12">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">No</span>
											   </span>
											  </span>
											  </label>
											   </div>
											</div>
											
											<?php if($property_data['carbon_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/6' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
										   

											</div><!--close of md-12>-->
											</div><!--end of row-->
											<?php $style=($property_data['carbon_test']=='yes') ? "display:block" : "display:none;"; ?>
											<div class="prev_detail_hide6" style="<?php echo $style; ?>">
											<div class="" style="margin-left: 17px">

											 <div class="form-group">
											 
											  <label class="form-label" for="signup_v2-name">Number of devices</label>
											  <div class="form-control-wrapper">
												<input id="nr_carbon"
													   class="form-control"
													   name="nr_carbon"
													   type="text"
														value="<?php echo $property_data['nr_carbon']; ?>"
													   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
											  </div>
											 </div>
											</div>
											<section class="card card-default" style="border:0px solid">
											<header class="card-header">Enter Test History Details Here
											  
											 </header>
											 </section>
											
										   <!--date-img col-->
											<div class="form-group" style="margin: 15px 0 15px 16px;">
											   <div class='input-group date'>
											  <input id="daterange6" name="carbon_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date" value="<?php echo (isset($carbon_date) && !empty($carbon_date)) ? $carbon_date : '' ; ?>">
											   <span class="input-group-addon">
												<i class="font-icon font-icon-calend"></i>
												</span>
											  </div>
											</div>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
											   <div class='input-group'>
												 <label>Validity period</label>
												 <select class="form-control" name="carbon_expire">
													<option value="1 Month" <?php echo (isset($carbon_validity) && $carbon_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
													<option value="3 Months" <?php echo (isset($carbon_validity) && $carbon_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
													<option value="6 Months" <?php echo (isset($carbon_validity) && $carbon_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
													<option value="1 year" <?php echo (isset($carbon_validity) && $carbon_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
													<option value="3 years" <?php echo (isset($carbon_validity) && $carbon_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
													<option value="5 years" <?php echo (isset($carbon_validity) && $carbon_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
													<option value="10 years" <?php echo (isset($carbon_validity) && $carbon_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
												 </select>
											  </div>
											</div>
											<?php $required='required="required"';
												if(isset($carbon_certificate_file) && !empty($carbon_certificate_file)){
										 		$required = ''; }?>	
											 <div class="form-group" style="margin: 15px 0 15px 16px;">
												<div class='input-group date'>
													<label>Upload Certificate</label>
													 <input id="file_six" type="file" name="carbon_upload_file"  class="form-control" <?php echo $required; ?>>		
												</div>
											</div>
											
											<?php if(isset($carbon_certificate_file) && !empty($carbon_certificate_file)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
													<div class='input-group date'>
													  
											
														<div class="alert alert-success fade in">
															<a href="#" class="close close_cert" id="<?php echo $carbon_unique_id; ?>">&times;</a>
															<a href="<?php echo base_url() ?>uploads/cert/<?php echo $carbon_certificate_file; ?>" title="View file" download="<?php echo $carbon_certificate_file; ?>"><?php echo $carbon_certificate_file; ?></a>
														</div>
														
											</div></div>
											<?php } ?>
											
											
											<div class="form-group" style="margin: 30px 0 25px 16px;">
												<div class='input-group date'>
												   <label>Other Certificate File</label>
												  <input class="form-control" id="file_input" value=""  name="other_carbon_certificate_file[]" type="file" multiple="multiple"/> 
												</div>
											</div>
											  <?php  if(!empty($carboncount)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
													<div class='input-group date'>
													   
											
											  <?php
												foreach ($carbonarray as $other_cert) {?>
													<div class="alert alert-success fade in">
														<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?></a>
													</div>
												<?php }  ?>	
											
											 </div></div>
											 <?php }  ?>
											<input type="hidden" name="is_first_property_certificate_carbon" value="1" />
											<input type="hidden" name="carbon_certificate_unique_id" value="<?php echo $carbon_certificate_unique_id ?>">
											
											</div>
											 <!-- end date-img col-->
											
								</div>
							  </div>
							</div>
							<div class="panel panel-default">
							  <div class="panel-heading">
								<h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion7" href="#collapse7">
								  <h5 style="" class="accord-text">Gas safety - coming soon!</h5>
								  </a>
								</h4>
							  </div>
							  <div id="collapse7" class="panel-collapse collapse">
								<div class="panel-body">
									 <div class="row">
											<div class="col-md-12">
											
											   <div class="col-md-3">
											  
											 <div class="checkbox-detailed" id="check_yes7">
											  <input type="radio" name="gas_safety_test" id="check-det-13" value="yes" <?php if($property_data['gas_safety_test']=='yes'){ echo "checked";} ?>/>
											  <label for="check-det-13">
												<span class="checkbox-detailed-tbl">
												 <span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">Yes</span>
												</span>
												</span>
											  </label>
											 </div>

											 </div>
											 <div class="col-md-3">
											 <div class="checkbox-detailed" id="check_no7">
											   <input type="radio" name="gas_safety_test" id="check-det-14" value="no" <?php if($property_data['gas_safety_test']=='no'){ echo "checked";} ?>/>
											   <label for="check-det-14">
											   <span class="checkbox-detailed-tbl">
												<span class="checkbox-detailed-cell">
												<span class="checkbox-detailed-title">No</span>
											   </span>
											  </span>
											  </label>
											   </div>
											</div>
											
											<?php if($property_data['gas_safety_test']=='yes') { ?>
												<div class="col-md-3">
													<a href="<?php echo base_url('jobs/view_property_certificate/'.$this->uri->segment(3)).'/7' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
												</div>
											<?php } ?>
										   

											</div><!--close of md-12>-->
											</div><!--end of row-->
											<?php $style=($property_data['gas_safety_test']=='yes') ? "display:block" : "display:none;"; ?>
											<div class="prev_detail_hide7" style="<?php echo $style; ?>">
											<div class="" style="margin-left: 17px">

											 <div class="form-group">
											 
											  <label class="form-label" for="signup_v2-name">Number of devices</label>
											  <div class="form-control-wrapper">
												<input id="nr_gas_safety"
													   class="form-control"
													   name="nr_gas_safety"
													   type="text"
													   value="<?php echo $property_data['nr_gas_safety']; ?>"
													   data-validation="[OPTIONAL, NAME, L>=2, TRIM]">
											  </div>
											 </div>
											</div>
											<section class="card card-default" style="border:0px solid">
											<header class="card-header">Enter Test History Details Here
											  
											 </header>
											 </section>
											
										   <!--date-img col-->
											<div class="form-group" style="margin: 15px 0 15px 16px;">
											   <div class='input-group date'>
											  <input id="daterange7" name="gas_safety_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date" value="<?php echo (isset($gas_date) && !empty($gas_date)) ? $gas_date : '' ; ?>">
											   <span class="input-group-addon">
												<i class="font-icon font-icon-calend"></i>
												</span>
											  </div>
											</div>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
											   <div class='input-group'>
												 <label>Validity period</label>
												 <select class="form-control" name="gas_safety_expire">							
													<option value="1 Month" <?php echo (isset($gas_validity) && $gas_validity=='1 Month') ? 'selected=selected' : ''; ?>>1 Month</option>
													<option value="3 Months" <?php echo (isset($gas_validity) && $gas_validity=='3 Months') ? 'selected=selected' : ''; ?>>3 Months</option>
													<option value="6 Months" <?php echo (isset($gas_validity) && $gas_validity=='6 Months') ? 'selected=selected' : ''; ?>>6 Months</option>
													<option value="1 year" <?php echo (isset($gas_validity) && $gas_validity=='1 year') ? 'selected=selected' : ''; ?>>1 Year</option>
													<option value="3 years" <?php echo (isset($gas_validity) && $gas_validity=='3 years') ? 'selected=selected' : ''; ?>>3 Years</option>
													<option value="5 years" <?php echo (isset($gas_validity) && $gas_validity=='5 years') ? 'selected=selected' : ''; ?>>5 Years</option>
													<option value="10 years" <?php echo (isset($gas_validity) && $gas_validity=='10 years') ? 'selected=selected' : ''; ?>>10 Years</option>
												 </select>
											  </div>
											</div>
											<?php $required='required="required"';
												if(isset($gas_certificate_file) && !empty($gas_certificate_file)){
										 		$required = ''; }?>	
											 <div class="form-group" style="margin: 15px 0 15px 16px;">
												<div class='input-group date'>
													<label>Upload Certificate</label>
													 <input id="file_seven" type="file" name="gas_safety_upload"  class="form-control" <?php echo $required; ?>>					
												</div>
											</div>
											
											 <?php if(isset($gas_certificate_file) && !empty($gas_certificate_file)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
													<div class='input-group date'>
													  
											
												<div class="alert alert-success fade in">
													<a href="#" class="close close_cert" id="<?php echo $gas_unique_id; ?>">&times;</a>
													<a href="<?php echo base_url() ?>uploads/cert/<?php echo $gas_certificate_file; ?>" title="View file" download="<?php echo $gas_certificate_file; ?>"><?php echo $gas_certificate_file; ?></a>
												</div>
										
											</div></div>
												<?php } ?>
											
										
											<div class="form-group" style="margin: 30px 0 25px 16px;">
												<div class='input-group date'>
												   <label>Other Certificate File</label>
												  <input class="form-control" id="file_input" value=""  name="other_gassafety_certificate_file[]" type="file" multiple="multiple"/> 
												</div>
											</div>
											
											  <?php  if(!empty($gassafetycount)) { ?>
											<div class="form-group" style="margin: 30px 0 25px 16px;">
													<div class='input-group date'>
													   
											
											  <?php
												foreach ($gassafetyarray as $other_cert) {?>
													<div class="alert alert-success fade in">
														<a  class="close close_other_cert" id="<?php echo $other_cert['unique_id'] ?>">&times;</a>
														<a href="<?php echo base_url() ?>uploads/cert/<?php echo $other_cert['other_certificate_file'] ?>" title="View file" download="<?php echo $other_cert['other_certificate_file']; ?>"><?php echo $other_cert['other_certificate_file'] ?></a>
													</div>
												<?php }  ?>	
											 
											</div></div>
											<?php }  ?>
											
											<input type="hidden" name="is_first_property_certificate_gas" value="1" />
											<input type="hidden" name="gas_certificate_unique_id" value="<?php echo $gas_certificate_unique_id ?>">
											
											</div>
											 <!-- end date-img col-->
											
								</div>
							  </div>
							</div>

						  </div>
				 </div>
				  <div class="form-group">
					 <label class="form-label" for="signup_v2-name">Previous Test Note</label>
					  <div class="form-control-wrapper">
					  <textarea rows="5" id="prev_test_details"  name="prev_test_details" class="form-control" placeholder="Press Enter" data-autosize="" style="overflow: hidden; word-wrap: break-word; height: 145px;"><?php echo $property_data['prev_test_details'];?></textarea>
					  </div>
				   </div>
				   
				    <div class="form-group form-group-checkbox">
				      <div class="checkbox" style="margin: 25px 0;">
						  
							<input id="signup_v2-agree"
								   name="terms_and_conditions"
								   data-validation="[NOTEMPTY]"
								   data-validation-message="You must agree the terms and conditions"
								   type="checkbox" <?php if($property_data['terms_and_conditions']!=''){ echo "checked";} ?> required>
							<label for="signup_v2-agree">I agree the <a href="#">terms</a> and <a href="#">conditions</a></label>
						</div>
					
				    </div>
					<button type="submit" class="btn">Add</button>
			  </form>
			</div>
		  </div>
		</div>  
	  </section>
	</div>
</div>	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $("#check_yes1").click(function(){
        $(".prev_detail_hide1").show(); 
        $("#daterange1").attr('required',true); 
        
    });
    $("#check_yes2").click(function(){
        $(".prev_detail_hide2").show(); 
        $("#daterange2").attr('required',true); 
          
    });
    $("#check_yes3").click(function(){
        $(".prev_detail_hide3").show();
        $("#daterange3").attr('required',true); 
             
    });
    $("#check_yes4").click(function(){
        $(".prev_detail_hide4").show();
        $("#daterange4").attr('required',true); 
         
    });
    $("#check_yes5").click(function(){
        $(".prev_detail_hide5").show();
        $("#daterange5").attr('required',true);
            
    });
    $("#check_yes6").click(function(){
        $(".prev_detail_hide6").show(); 
        $("#daterange6").attr('required',true); 
        
    });
    $("#check_yes7").click(function(){
        $(".prev_detail_hide7").show();
        $("#daterange7").attr('required',true);  
            
    });
    $("#check_no1").click(function(){
        $(".prev_detail_hide1").hide(); 
        $("#daterange1").attr('required',false);
              
    });
   
    $("#check_no2").click(function(){
        $(".prev_detail_hide2").hide(); 
        $("#daterange2").attr('required',false); 
          
    });
    $("#check_no3").click(function(){
        $(".prev_detail_hide3").hide();
        $("#daterange3").attr('required',false);
            
    });
    $("#check_no4").click(function(){
        $(".prev_detail_hide4").hide(); 
        $("#daterange4").attr('required',false); 
          
    });
    $("#check_no5").click(function(){
        $(".prev_detail_hide5").hide();
        $("#daterange5").attr('required',false);  
                
    });
    $("#check_no6").click(function(){
        $(".prev_detail_hide6").hide(); 
        $("#daterange6").attr('required',false);
           
    });
    $("#check_no7").click(function(){
        $(".prev_detail_hide7").hide();
        $("#daterange7").attr('required',false); 
              
    });

});
</script>

<script type="text/javascript">
$('.close_cert').click(function(e){
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
           var path="<?php echo base_url() ?>user/delete_CertificateAjax"; 
		   
           $.ajax({
                type:"POST",
                url:path,
                data:{certificate_unique_id:certificate_unique_id},
                success:function(result){
                   if(result=='updated'){
                       window.location.href='<?php echo base_url() ?>user/property_edit/<?php echo $this->uri->segment(3); ?>/';

                   }
                }
             });
          
         

        });
  }); 
</script>

<script type="text/javascript">
$('.close_other_cert').click(function(e){
    e.preventDefault();
	
    var unique_id= $(this).attr('id');
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
           var path="<?php echo base_url() ?>user/delete_otherCertificateAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url() ?>user/property_edit/<?php echo $this->uri->segment(3); ?>/';

                   }
                }
             });
          
         

        });
  }); 
</script>
