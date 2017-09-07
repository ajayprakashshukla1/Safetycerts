<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assest/apply/css/style.css">-->
<style>
.checkbox input[type=checkbox]:checked+label:after, .radio input[type=checkbox]:checked+label:after {
    content: "\22";
}
.accord-text{
	color: #333;background-color: #f5f5f5;border-color: #ddd;padding: 10px;
	border: 1px solid #ddd;
    margin-bottom: 0;
}
</style>

<div class="loading" style="display:none;">Loading&#8230;</div>
<div class="page-content">
   <div class="container-fluid">	
	  <section class="card">
		<div class="card-block">
		  <div class="row">
			<div class="col-md-12">
			  <h3 class="m-t-lg with-border">Property Details </h3>
	            <?php if($this->session->flashdata('message')) {?>
		           <div class="alert alert-success fade in">
		              <a href="#" class="close" data-dismiss="alert">&times;</a>
		              <strong>Success!</strong> <?php echo $this->session->flashdata('message');?>
		           </div>
	            <?php } ?>
				
		        <form id="form-signup_v2" action="<?=base_url()?>user/createproperty" name="form-signup_v2" method="POST" enctype="multipart/form-data">

		          <input type="hidden" name="token" id="token" value="<?php echo $token ?>">
			
			       <div class="form-group">
					  <label class="form-label" for="signup_v2-name">Name</label>
					  <div class="form-control-wrapper">
					     <input type="text"  id="name"  name="name" class="form-control" placeholder="enter name" required/>
					  </div>
				   </div>

				   <div class="form-group">
					  <label class="form-label" for="signup_v2-name">Address</label>
					  <div class="form-control-wrapper">
						 <textarea rows="4" id="address"  name="address" class="form-control" placeholder="" data-autosize="" style="overflow: hidden; word-wrap: break-word; height: 98px;" required></textarea>		
					  </div>
				   </div>
				   <div class="form-group">
					  <label class="form-label" for="signup_v2-name">PostCode</label>
					  <div class="form-control-wrapper">
						  <input type="text"  id="zip_code"  name="zip_code" class="form-control" placeholder="enter postcode" required/>		
					  </div>
				   </div>

				   <div class="form-group form-group-radios">
					  <label class="form-label" id="property_type">
						Property Type <span class="color-red">*</span>
					  </label>
					  <div class="radio">
				         <input type="radio" name="property_type" id="radio-1" value="domestic" checked>
				         <label for="radio-1">Domestic</label>
			          </div>
				
					  <div class="radio">
				        <input type="radio" name="property_type" id="radio-2" value="commercial">
				        <label for="radio-2">Commercial</label>
			          </div>

			          <div class="radio">
				        <input type="radio" name="property_type" id="radio-3" value="industrial">
				        <label for="radio-3">Industrial</label>
			          </div>
				  </div>
				
				
				  <div class="form-group form-group-radios">
					 <label class="form-label" id="signup_v2-gender"></label>
					 <div class="form-control-wrapper"></div>
				  </div>
                
                 <?php if($login_user->role=='admin'){ ?>
                 <?php if(isset($property_user_id)){ ?>
                 <div class="row">
                	<div class="form-group">
					   <div class="col-md-6">
					     <label>Client Name <span class="color-red">*</span></label>
					   	 <select class="form-control" id='user_id' name="user_id" required/>
					   	     <option value="">Select Client</option>
						     <?php foreach($list_of_clients as $list_of_client) { ?>
							    <option value="<?php echo $list_of_client->id ?>"<?php if($property_user_id==$list_of_client->id){echo 'selected="selected"';} ?>><?php echo $list_of_client->first_name?> <?php echo $list_of_client->last_name ?></option>
							 <?php } ?>
					     </select>
					   </div>
					</div>
                 </div>
                 <br>
                <?php }else{ ?>
                <div class="row">
                	<div class="form-group">
					   <div class="col-md-6">
					     <label>Client Name <span class="color-red">*</span></label>
					   	 <select class="form-control" id='user_id' name="user_id" required/>
					   	     <option value="">Select Client</option>
						     <?php foreach($list_of_clients as $list_of_client) { ?>
							    <option value="<?php echo $list_of_client->id ?>"><?php echo $list_of_client->first_name?> <?php echo $list_of_client->last_name ?></option>
							 <?php } ?>
					     </select>
					   </div>
					</div>
                </div>
                <br>
				
				<?php } } ?>
				 
				
				<div class="form-group">
				   <label class="form-label" for="signup_v2-name">Access Details</label>
				   <div class="form-control-wrapper">
					 <input id="access_detail" class="form-control" name="access_details" type="text" data-validation="[OPTIONAL, NAME, L>=2, TRIM]">
				  </div>
			    </div>

                    <!-- accondian start-->
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
							      <input type="radio" name="electrical_test" id="check-det-1" value="yes" class="test_checkbox" />
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
							       <input type="radio" name="electrical_test" id="check-det-2" value="no" class="test_checkbox"  checked/>
							       <label for="check-det-2">
							       <span class="checkbox-detailed-tbl">
								    <span class="checkbox-detailed-cell">
									<span class="checkbox-detailed-title">No</span>
								   </span>
							      </span>
							      </label>
						           </div>
			                    </div>
			                   
			                
						        </div><!--close of md-12>-->
						        </div><!--end of row-->
						      <div class="prev_detail_hide1"  style="display: none;">
						        <div class="" style="margin-left: 17px">

						         <div class="form-group">
							     
							      <label class="form-label" for="signup_v2-name">Number of circuits</label>
								  <div class="form-control-wrapper">
									<input id="nr_circuits"
										   class="form-control"
										   name="nr_circuits"
										   type="text"
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
			                     </section>
						        
							   <!--date-img col-->
							   	<div class="form-group" style="margin: 30px 0 25px 16px;">
							       <div class='input-group date'>
								  <input id="daterange1" name="electrical_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date">
								   <span class="input-group-addon">
									<i class="font-icon font-icon-calend"></i>
								    </span>
							      </div>
						        </div>

						        <div class="form-group" style="margin: 30px 0 25px 16px;">
							       <div class='input-group'>
							         <label>Validity period</label>
								     <select class="form-control" name="electrical_expire">
								        
				                        <option value="1 Month">1 Month</option>
				                        <option value="3 Months">3 Months</option>
				                        <option value="6 Months">6 Months</option>
				                        <option value="1 year">1 Year</option>
				                        <option value="3 years">3 Years</option>
				                        <option value="5 years">5 Years</option>
				                        <option value="10 years">10 Years</option>
								     </select>
							      </div>
						        </div>

			                     <div class="form-group" style="margin: 30px 0 25px 16px;">
							        <div class='input-group date'>
							           <label>Upload Certificate</label>
									   <input id="file_one" type="file" name="electrical_upload_file" class="form-control" onchange="uploadcertfile(this.files[0],'electrical_upload_file','file_one')">
							        </div>
							        <div id="uploaded-electrical_upload_file"></div>
						        </div>
								
								<div class="form-group" style="margin: 30px 0 25px 16px;">
							        <div class='input-group date'>
							           <label>Other Certificate File</label>
									  <input class="form-control" id="other_certificate_file" value=""  name="other_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'electrical_upload_file','other_certificate_file')"/> 
							        </div>
							        <div id="uploaded-other_certificate_file"></div>
						        </div>
								
									
                                <input type="hidden" name="is_first_property_certificate_electrical" value="1" />
						     </div>
						         <!-- end date-img col-->  
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
						       <input type="radio" name="emergency_test" id="check-det-3" value="yes" class="test_checkbox"/>
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
						       <input type="radio" name="emergency_test" id="check-det-4" value="no" class="test_checkbox" checked/>
						       <label for="check-det-4">
						       <span class="checkbox-detailed-tbl">
							    <span class="checkbox-detailed-cell">
								<span class="checkbox-detailed-title">No</span>
							   </span>
						      </span>
						      </label>
					        </div>
					         
		                    </div>
		                   
					        </div><!--close of md-12>-->
					        </div><!--end of row-->
					        <div class="prev_detail_hide2" style="display: none;">
					        <div class="" style="margin-left: 17px">
		                    <div class="form-group">
						      <label class="form-label" for="signup_v2-name">Number of fittings</label>
							  <div class="form-control-wrapper">
								<input id="nr_fittings"
									   class="form-control"
									   name="nr_fittings"
									   type="text"
									   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width: 50%">
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
							  <input id="daterange2" name="emergency_prev_date" type="text"  class="form-control datepicker" placeholder="Previous Test Date">
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>

					        <div class="form-group" style="margin: 30px 0 25px 16px;">
						       <div class='input-group'>
						         <label>Validity period</label>
							     <select class="form-control" name="emergency_expire">
							       
			                        <option value="1 Month">1 Month</option>
			                        <option value="3 Months">3 Months</option>
			                        <option value="6 Months">6 Months</option>
			                        <option value="1 year">1 Year</option>
			                        <option value="3 years">3 Years</option>
			                        <option value="5 years">5 Years</option>
			                        <option value="10 years">10 Years</option>
							     </select>
						      </div>
					        </div>

		                    <div class="form-group" style="margin: 15px 0 15px 16px;">
						       <div class='input-group date'>
								 <label>Upload Certificate</label>
								 <input id="file_two" type="file" name="emergency_upload_file"  class="form-control" onchange="uploadcertfile(this.files[0],'emergency_upload_file','file_two')">
						       </div>
						       <div id="uploaded-emergency_upload_file"></div>
					        </div>
							
							<div class="form-group" style="margin: 30px 0 25px 16px;">
								<div class='input-group date'>
								   <label>Other Certificate File</label>
								  <input class="form-control" id="other_emergency_certificate_file" value=""  name="other_emergency_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'emergency_upload_file','other_emergency_certificate_file')"/> 
								</div>
								<div id="uploaded-other_emergency_certificate_file"></div>
							</div>
								
                            <input type="hidden" name="is_first_property_certificate_emergency" value="1" />

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
						       <input type="radio" name="portable_test" id="check-det-5" value="yes"/>
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
						       <input type="radio" name="portable_test" id="check-det-6" value="no" checked/>
						       <label for="check-det-6">
						       <span class="checkbox-detailed-tbl">
							    <span class="checkbox-detailed-cell">
								<span class="checkbox-detailed-title">No</span>
							   </span>
						      </span>
						      </label>
					        </div>

		                    </div>
		                    
					        </div><!--close of md-12>-->
					        </div><!--end of row-->
					       <div class="prev_detail_hide3" style="display: none;">
					        <div class="" style="margin-left: 17px">
		                     <div class="form-group">
						      <label class="form-label" for="signup_v2-name">Number of items</label>
							  <div class="form-control-wrapper">
								<input id="nr_items"
									   class="form-control"
									   name="nr_items"
									   type="text"
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
		                     </section>
					        
						   <!--date-img col-->
						   	<div class="form-group" style="margin: 15px 0 15px 16px;">
						       <div class='input-group date'>
							  <input id="daterange3" name="portable_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date">
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>

					        <div class="form-group" style="margin: 30px 0 25px 16px;">
						       <div class='input-group'>
						         <label>Validity period</label>
							     <select class="form-control" name="portable_expire">
							       
			                        <option value="1 Month">1 Month</option>
			                        <option value="3 Months">3 Months</option>
			                        <option value="6 Months">6 Months</option>
			                        <option value="1 year">1 Year</option>
			                        <option value="3 years">3 Years</option>
			                        <option value="5 years">5 Years</option>
			                        <option value="10 years">10 Years</option>
							     </select>
						      </div>
					        </div>

		                     <div class="form-group" style="margin: 15px 0 15px 16px;">
						       <div class='input-group date'>
								 <label>Upload Certificate</label>
								 <input id="file_three" type="file" name="portable_upload_file"  class="form-control" onchange="uploadcertfile(this.files[0],'portable_upload_file','file_three')">
						       </div>
						       <div id="uploaded-portable_upload_file"></div>
					        </div>
							
							<div class="form-group" style="margin: 30px 0 25px 16px;">
								<div class='input-group date'>
								   <label>Other Certificate File</label>
								  <input class="form-control" id="other_portable_certificate_file" value=""  name="other_portable_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'portable_upload_file','other_portable_certificate_file')"/> 
								</div>
								<div id="uploaded-other_portable_certificate_file"></div>
							</div>
							
                            <input type="hidden" name="is_first_property_certificate_portable" value="1" />

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
						       <input type="radio" name="fire_test" id="check-det-7" value="yes"/>
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
						       <input type="radio" name="fire_test" id="check-det-8" value="no" checked/>
						       <label for="check-det-8">
						       <span class="checkbox-detailed-tbl">
							    <span class="checkbox-detailed-cell">
								<span class="checkbox-detailed-title">No</span>
							   </span>
						      </span>
						      </label>
					        </div>
					         

		                    </div>
		                    
					        </div><!--close of md-12>-->
					        </div><!--end of row-->
					       <div class="prev_detail_hide4" style="display: none;">
					        <div class="" style="margin-left: 17px">
		                    <div class="form-group">
						      <label class="form-label" for="signup_v2-name">Number of devices</label>
							  <div class="form-control-wrapper">
								<input id="nr_devices"
									   class="form-control"
									   name="nr_devices"
									   type="text"
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
		                     </section>
					        
						   <!--date-img col-->
						   	<div class="form-group" style="margin: 15px 0 15px 16px;">
						       <div class='input-group date'>
							  <input id="daterange4" name="fire_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date">
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>

					        <div class="form-group" style="margin: 30px 0 25px 16px;">
						       <div class='input-group'>
						         <label>Validity period</label>
							     <select class="form-control" name="fire_expire">							        
			                        <option value="1 Month">1 Month</option>
			                        <option value="3 Months">3 Months</option>
			                        <option value="6 Months">6 Months</option>
			                        <option value="1 year">1 Year</option>
			                        <option value="3 years">3 Years</option>
			                        <option value="5 years">5 Years</option>
			                        <option value="10 years">10 Years</option>
							     </select>
						      </div>
					        </div>

		                     <div class="form-group" style="margin: 15px 0 15px 16px;">
						       <div class='input-group date'>
									<label>Upload Certificate</label>
								   <input id="file_four" type="file" name="fire_upload_file"  class="form-control" onchange="uploadcertfile(this.files[0],'fire_upload_file','file_four')">
						       </div>
						       <div id="uploaded-fire_upload_file"></div>
					        </div>
							
							<div class="form-group" style="margin: 30px 0 25px 16px;">
								<div class='input-group date'>
								   <label>Other Certificate File</label>
								  <input class="form-control" id="other_fire_certificate_file" value=""  name="other_fire_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'fire_upload_file','other_fire_certificate_file')"/> 
								</div>
								<div id="uploaded-other_fire_certificate_file"></div>
							</div>
							
                            <input type="hidden" name="is_first_property_certificate_fire" value="1" />
					    </div>
		        </div>
		      </div>
		    </div>
		    <div class="panel panel-default">
		      <div class="panel-heading">
		        <h4 class="panel-title">
		          <a data-toggle="collapse" data-parent="#accordion5" href="#collapse5">
		           <h5  class="accord-text">Smoke Detector Test</h5></a></a>
		        </h4>
		      </div>
		      <div id="collapse5" class="panel-collapse collapse">
		        <div class="panel-body">
		        	 <div class="row">
						    <div class="col-md-12">
						    
						    <div class="col-md-3">

						     <div class="checkbox-detailed" id="check_yes5">
						       <input type="radio" name="smoke_test" id="check-det-9" value="yes" />
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
						       <input type="radio" name="smoke_test" id="check-det-10" value="no" checked/>
						       <label for="check-det-10">
						       <span class="checkbox-detailed-tbl">
							    <span class="checkbox-detailed-cell">
								<span class="checkbox-detailed-title">No</span>
							   </span>
						      </span>
						      </label>
					        </div>
					         
		                    </div>
		                    
					        </div><!--close of md-12>-->
					        </div><!--end of row-->
					       <div class="prev_detail_hide5" style="display: none;">
					       <div class=" " style="margin-left: 17px">
		                    <div class="form-group">
						      <label class="form-label" for="signup_v2-name">Number of sensors</label>
							  <div class="form-control-wrapper">
								<input id="nr_sensors"
									   class="form-control"
									   name="nr_sensors"
									   type="text"
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
							  <input id="daterange5" name="smoke_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date">
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>

					        <div class="form-group" style="margin: 30px 0 25px 0px;">
						       <div class='input-group'>
						         <label>Validity period</label>
							     <select class="form-control" name="smoke_expire">
							        
			                        <option value="1 Month">1 Month</option>
			                        <option value="3 Months">3 Months</option>
			                        <option value="6 Months">6 Months</option>
			                        <option value="1 year">1 Year</option>
			                        <option value="3 years">3 Years</option>
			                        <option value="5 years">5 Years</option>
			                        <option value="10 years">10 Years</option>
							     </select>
						      </div>
					        </div>

		                     <div class="form-group">
						        <div class='input-group date'>
									<label>Upload Certificate</label>
							       <input id="file" type="file" name="smoke_upload_file"  class="form-control" onchange="uploadcertfile(this.files[0],'smoke_upload_file','file')">
						        </div>
						        <div id="uploaded-smoke_upload_file"></div>
					        </div>
							
							<div class="form-group" style="margin: 30px 0 25px 0;">
								<div class='input-group date'>
								   <label>Other Certificate File</label>
								  <input class="form-control" id="other_smoke_certificate_file" name="other_smoke_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'smoke_upload_file','other_smoke_certificate_file')"/> 
								</div>
								<div id="uploaded-other_smoke_certificate_file"></div>
							</div>
							
                            <input type="hidden" name="is_first_property_certificate_smoke" value="1" />
		             </div>
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
						      <input type="radio" name="carbon_test" id="check-det-11" value="yes" />
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
						       <input type="radio" name="carbon_test" id="check-det-12" value="no" checked/>
						       <label for="check-det-12">
						       <span class="checkbox-detailed-tbl">
							    <span class="checkbox-detailed-cell">
								<span class="checkbox-detailed-title">No</span>
							   </span>
						      </span>
						      </label>
					           </div>
		                    </div>
		                   

					        </div><!--close of md-12>-->
					        </div><!--end of row-->
					        <div class="prev_detail_hide6" style="display: none;">
					        <div class="" style="margin-left: 17px">

					         <div class="form-group">
						     
						      <label class="form-label" for="signup_v2-name">Number of devices</label>
							  <div class="form-control-wrapper">
								<input id="nr_carbon"
									   class="form-control"
									   name="nr_carbon"
									   type="text"
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
							  <input id="daterange6" name="carbon_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date">
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
					        <div class="form-group" style="margin: 30px 0 25px 16px;">
						       <div class='input-group'>
						         <label>Validity period</label>
							     <select class="form-control" name="carbon_expire">
			                        <option value="1 Month">1 Month</option>
			                        <option value="3 Months">3 Months</option>
			                        <option value="6 Months">6 Months</option>
			                        <option value="1 year">1 Year</option>
			                        <option value="3 years">3 Years</option>
			                        <option value="5 years">5 Years</option>
			                        <option value="10 years">10 Years</option>
							     </select>
						      </div>
					        </div>
		                     <div class="form-group" style="margin: 15px 0 15px 16px;">
						        <div class='input-group date'>
									<label>Upload Certificate</label>
									 <input id="file_six" type="file" name="carbon_upload_file"  class="form-control" onchange="uploadcertfile(this.files[0],'carbon_upload_file','file_six')">	
						        </div>
						        <div id="uploaded-carbon_upload_file"></div>
					        </div>
							
							<div class="form-group" style="margin: 30px 0 25px 16px;">
								<div class='input-group date'>
								   <label>Other Certificate File</label>
								  <input class="form-control" id="other_carbon_certificate_file" value=""  name="other_carbon_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'carbon_upload_file','other_carbon_certificate_file')"/> 
								</div>
								<div id="uploaded-other_carbon_certificate_file"></div>
							</div>
							
                            <input type="hidden" name="is_first_property_certificate_carbon" value="1" />
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
						      <input type="radio" name="gas_safety_test" id="check-det-13" value="yes" />
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
						       <input type="radio" name="gas_safety_test" id="check-det-14" value="no" checked/>
						       <label for="check-det-14">
						       <span class="checkbox-detailed-tbl">
							    <span class="checkbox-detailed-cell">
								<span class="checkbox-detailed-title">No</span>
							   </span>
						      </span>
						      </label>
					           </div>
		                    </div>
		                   

					        </div><!--close of md-12>-->
					        </div><!--end of row-->
					        <div class="prev_detail_hide7" style="display: none">
					        <div class="" style="margin-left: 17px">

					         <div class="form-group">
						     
						      <label class="form-label" for="signup_v2-name">Number of devices</label>
							  <div class="form-control-wrapper">
								<input id="nr_gas_safety"
									   class="form-control"
									   name="nr_gas_safety"
									   type="text"
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
							  <input id="daterange7" name="gas_safety_prev_date" type="text"  class="form-control datepicker" placeholder="Previous test date">
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
					        <div class="form-group" style="margin: 30px 0 25px 16px;">
						       <div class='input-group'>
						         <label>Validity period</label>
							     <select class="form-control" name="gas_safety_expire">							
			                        <option value="1 Month">1 Month</option>
			                        <option value="3 Months">3 Months</option>
			                        <option value="6 Months">6 Months</option>
			                        <option value="1 year">1 Year</option>
			                        <option value="3 years">3 Years</option>
			                        <option value="5 years">5 Years</option>
			                        <option value="10 years">10 Years</option>
							     </select>
						      </div>
					        </div>
		                     <div class="form-group" style="margin: 15px 0 15px 16px;">
						        <div class='input-group date'>
									<label>Upload Certificate</label>
									 <input id="file_seven" type="file" name="gas_safety_upload"  class="form-control" onchange="uploadcertfile(this.files[0],'gas_safety_upload','file_seven')">
						        </div>
						        <div id="uploaded-gas_safety_upload"></div>
					        </div>
							
							<div class="form-group" style="margin: 30px 0 25px 16px;">
								<div class='input-group date'>
								   <label>Other Certificate File</label>
								  <input class="form-control" id="other_gassafety_certificate_file" value=""  name="other_gassafety_certificate_file[]" type="file" multiple="multiple" onchange="uploadothercertfile(this.files[0],'gas_safety_upload','other_gassafety_certificate_file')"/> 
								</div>
								<div id="uploaded-other_gassafety_certificate_file"></div>
							</div>
							
                            <input type="hidden" name="is_first_property_certificate_gas" value="1" />
					        </div>
					         <!-- end date-img col-->
					        
		        </div>
		      </div>
		    </div>

          </div>




                    <!-- accordian end -->



				   
			         <!-- end date-img col-->

			       
			         <!-- end date-img col-->
			      
			         <!-- end date-img col-->
			         <div class="form-group">
							 <label class="form-label" for="signup_v2-name">Previous Test Note</label>
							  <div class="form-control-wrapper">
							  <textarea rows="5" id="prev_test_details"  name="prev_test_details" class="form-control" placeholder="Press Enter" data-autosize="" style="overflow: hidden; word-wrap: break-word; height: 145px;"></textarea>
							  </div>
						   </div>
			       
			        <div class="form-group form-group-checkbox">
				      <div class="checkbox" style="margin: 25px 0;">
				      
						<input id="signup_v2-agree"
							   name="terms_and_conditions"
							   data-validation="[NOTEMPTY]"
							   data-validation-message="You must agree the terms and conditions"
							   type="checkbox" required>
						<label for="signup_v2-agree">I agree the <a href="#">terms</a> and <a href="#">conditions</a></label>
					</div>
					
				    </div>

                  </div>
                  <button type="submit" class="btn">Add</button>
                 </section>
		
				
			</form>
		</div>
			</div>
		</div>
</div>
	</section>

	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $("#check_yes1").click(function(){
        $(".prev_detail_hide1").show(); 
        $("#daterange1").attr('required',true);  
        $("#file_one").attr('required',true);   
    });
    $("#check_yes2").click(function(){
        $(".prev_detail_hide2").show(); 
        $("#daterange2").attr('required',true);
        $("#file_two").attr('required',true);     
    });
    $("#check_yes3").click(function(){
        $(".prev_detail_hide3").show();
        $("#daterange3").attr('required',true);  
        $("#file_three").attr('required',true);      
    });
    $("#check_yes4").click(function(){
        $(".prev_detail_hide4").show();
        $("#daterange4").attr('required',true); 
        $("#file_four").attr('required',true);      
    });
    $("#check_yes5").click(function(){
        $(".prev_detail_hide5").show();
        $("#daterange5").attr('required',true);
        $("#file").attr('required',true);       
    });
    $("#check_yes6").click(function(){
        $(".prev_detail_hide6").show(); 
        $("#daterange6").attr('required',true);
        $("#file_six").attr('required',true);      
    });
    $("#check_yes7").click(function(){
        $(".prev_detail_hide7").show();
        $("#daterange7").attr('required',true); 
        $("#file_seven").attr('required',true);      
    });
    $("#check_no1").click(function(){
        $(".prev_detail_hide1").hide(); 
        $("#daterange1").attr('required',false); 
        $("#file_one").attr('required',true);       
    });
   
    $("#check_no2").click(function(){
        $(".prev_detail_hide2").hide(); 
        $("#daterange2").attr('required',false);
        $("#file_two").attr('required',true);         
    });
    $("#check_no3").click(function(){
        $(".prev_detail_hide3").hide();
        $("#daterange3").attr('required',false);
        $("#file_three").attr('required',true);           
    });
    $("#check_no4").click(function(){
        $(".prev_detail_hide4").hide(); 
        $("#daterange4").attr('required',false); 
        $("#file_four").attr('required',true);        
    });
    $("#check_no5").click(function(){
        $(".prev_detail_hide5").hide();
        $("#daterange5").attr('required',false);
        $("#file").attr('required',true);         
    });
    $("#check_no6").click(function(){
        $(".prev_detail_hide6").hide(); 
        $("#daterange6").attr('required',false);
        $("#file_six").attr('required',true);        
    });
    $("#check_no7").click(function(){
        $(".prev_detail_hide7").hide();
        $("#daterange7").attr('required',false); 
        $("#file_seven").attr('required',true);        
    });

});
</script>

<script type="text/javascript">

function uploadcertfile(file,cert_type,file_id){
    
	var token= $('#token').val();
    var path="<?php echo base_url() ?>/user/uploadCertAjax?cert_type="+cert_type+"&token="+token+"";
    $('.loading').css('display','block');
	  $.ajax({
	   type: 'POST', 
	   url: path,
	   //enctype: 'multipart/form-data',
	   data:new FormData($('#form-signup_v2')[0]),
	   contentType: false,
	   processData: false,
	   cache: false,
	   success: function(response){
	      if(response){
	      	 $('#uploaded-'+cert_type).empty();
	      	 $('#uploaded-'+cert_type).append('<div class="alert alert-success fade in">'+
	                      	   '<a href="javascript:void(0)" class="close close_cert_delete" onclick="deleted_cert_files('+token+','+"'"+cert_type+"'"+','+"'"+response+"'"+')">×</a>'+
	                   		   '<a href="http://www.safetycerts.co.uk/safetycerts/uploads/cert/'+response+'" title="View file" id="single_file">'+response+'</a>'+
                     	       '</div>');
	      }

	      $('.loading').css('display','none');

	      var $el = $('#'+file_id);
          $el.wrap('<form>').closest('form').get(0).reset();
          $el.unwrap();

          $('#'+file_id).attr('required',false);

	   }
	 });
}



function uploadothercertfile(file,cert_type,file_id){

	var token= $('#token').val();
    var path="<?php echo base_url() ?>/user/uploadOtherCertAjax?cert_type="+cert_type+"&token="+token+"&cert_name="+file_id+"";
    $('.loading').css('display','block');
	  $.ajax({
	   type: 'POST', 
	   url: path,
	   //enctype: 'multipart/form-data',
	   data:new FormData($('#form-signup_v2')[0]),
	   contentType: false,
	   processData: false,
	   cache: false,
	   success: function(response){
	      if(response){
	      	var obj = $.parseJSON(response);
	      	$.each(obj, function( index, value ) {
			  
			   $('#uploaded-'+file_id).append('<div class="alert alert-success fade in" id="other_'+index+'">'+
	                      	   '<a  href="javascript:void(0)" class="close close_muttiple_cert" onclick="deleted_Othercert_files('+token+','+"'"+cert_type+"'"+','+"'"+file_id+"'"+','+"'"+value+"'"+','+index+')">×</a>'+
	                   		   '<a class="multiple_files" href="http://www.safetycerts.co.uk/safetycerts/uploads/cert/'+value+'" title="View file">'+value+'</a>'+
                     	       '</div>');
			});
	      	 
	      }

	      var $el = $('#'+file_id);
          $el.wrap('<form>').closest('form').get(0).reset();
          $el.unwrap();

	      $('.loading').css('display','none');

	   }
	 });
}

</script>


<script type="text/javascript">

function deleted_cert_files(token,cert_type,file_name){
	
    var path="<?php echo base_url() ?>user/removecertificatesfiles";
    //alert(path);
    $.ajax({
	    type: 'POST',
        url: path,
        data: {token:token,cert_type:cert_type,file_name:file_name},                         
        success: function(response){
        	if(response=="deleted"){
        		$("#uploaded-"+cert_type).html('');	
        	}
			
			
        }
	});
}


</script>

<script type="text/javascript">

function deleted_Othercert_files(token,cert_type,other_cert_type,file_name,index){
    var path="<?php echo base_url() ?>user/removeOthercertificatesfiles";

    //alert(path);
    $.ajax({
	    type: 'POST',
        url: path,
        data: {token:token,cert_type:cert_type,other_cert_type:other_cert_type,file_name:file_name},                         
        success: function(response){
			if(response=="deleted"){
				$("#other_"+index).remove();
			}	
        }
	});
		
}


</script>