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


<?php #print_r($certifiles);?>
<div class="page-content">
   <div class="container-fluid">
	  <section class="card">
		<div class="card-block">
		   <div class="row">
			  <div class="col-md-12"><?php if($property_data['unique_id']=="eac22aeb77c9063b52446cb61feb2891"){?>
<div class="col-md-3" style="float:right;top:15px;">
<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> Upload Certificate</button></a>
</div>
<?php }?>
			     <h3 class="m-t-lg with-border">Property Details </h3> 
                             
				  <?php if($this->session->flashdata('message')) {?>
		            <div class="alert alert-success fade in">
		              <a href="#" class="close" data-dismiss="alert">&times;</a>
		              <strong>Success!</strong> <?php echo $this->session->flashdata('message');?>
		            </div>
	               <?php } ?>
			
							
				<?php echo form_open('', array('class'=>'email','id' =>'form-signup_v2','name'=>'form-signup_v2','enctype' => 'multipart/form-data'));?>
                <input type="hidden" name="id" value="<?php echo $property_data['id'] ; ?>">
                
                <div class="form-group">
				   <label class="form-label" for="signup_v2-name">Name</label>
				   <div class="form-control-wrapper">
					  <input type="text"  id="name"  name="name" value="<?php echo $property_data['name'] ; ?>" class="form-control" placeholder="enter name" />				
				   </div>
				</div>

				<div class="form-group">
				   <label class="form-label" for="signup_v2-name">Address</label>
				   <div class="form-control-wrapper">
					  <textarea rows="4" id="address"  name="address" class="form-control" placeholder="" data-autosize="" style="overflow: hidden; word-wrap: break-word; height: 98px;" required><?php echo $property_data['address'] ; ?></textarea>		
					</div>
				</div>

				<div class="form-group form-group-radios">
					<label class="form-label" id="signup_v2-gender">
						Property Type <span class="color-red">*</span>
					</label>
					<div class="radio">
				     <input type="radio" name="property_type" <?php if($property_data['property_type']=='domestic'){ echo "checked";  } ?>   id="radio-1" value="domestic">
				     <label for="radio-1">Domestic</label>
			        </div>
				
					<div class="radio">
				     <input type="radio" name="property_type" id="radio-2" <?php if($property_data['property_type']=='commercial'){ echo "checked";  } ?>  value="commercial">
				     <label for="radio-2">Commercial</label>
			        </div>

			        <div class="radio">
				     <input type="radio" name="property_type" id="radio-3" <?php if($property_data['property_type']=='industrial'){ echo "checked";  } ?>  value="industrial">
				     <label for="radio-3">Industrial</label>
			        </div>
				</div>
				
				


				<?php if($login_user->role=='admin'){ ?>
                <div class="row">
                	<div class="form-group">
					   <div class="col-md-6">
					     <label>Client Name <span class="color-red">*</span></label>
					   	 <select class="form-control" id='user_id' name="user_id" required>
					   	     <option value="">Select Client</option>
						     <?php foreach($list_of_clients as $list_of_client) { ?>
							    <option value="<?php echo $list_of_client->id ?>" <?php if($property_data['user_id']==$list_of_client->id){echo 'selected="selected"';} ?>><?php echo $list_of_client->first_name?> <?php echo $list_of_client->last_name ?></option>
							 <?php } ?>
					     </select>
					   </div>
					</div>
                </div>
                <br>
				
				<?php } ?>
				
				
				
				<div class="form-group">
				   <label class="form-label" for="signup_v2-name">Access Details</label>
				   <div class="form-control-wrapper">
					<input id="access_detail" class="form-control" name="access_details" type="text" value="<?php echo $property_data['access_details'] ; ?>" data-validation="[OPTIONAL, NAME, L>=2, TRIM]">
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
                         <div class="checkbox-detailed" id="check_yes1">
					        <input type="radio" name="electrical_test"  <?php if($property_data['electrical_test']=='yes'){ echo "checked";} ?> id="check-det-1" value="yes" />
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
				         <div class="checkbox-detailed" id="check_no1">
					       <input type="radio" name="electrical_test"  <?php if($property_data['electrical_test']=='no'){ echo "checked";} ?> id="check-det-2" value="no"/>
					       <label for="check-det-2">
					       <span class="checkbox-detailed-tbl">
						    <span class="checkbox-detailed-cell">
							<span class="checkbox-detailed-title">No</span>
						   </span>
					      </span>
					      </label>
				        </div>				        
                     </div>
                       <?php 
			  $electrical_test_style='';
			  if($property_data['electrical_test']=='no'){ $electrical_test_style="display: none;";} 
			  ?>
			   <?php /*
			   <div class="prev_detail_hide1" style="<?php echo $electrical_test_style; ?>">
			   */ ?>
			   <div class="prev_detail_hide1" style="<?php echo (!(isset($certifiles[0])) || $property_data['electrical_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/1' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a></div>
 
                     	
                     </div>
					
				<?php if(!(isset($certifiles[0]))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/1' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>

							        </div><!--close of md-12>-->
							        </div><!--end of row-->

									 <?php 
			  $electrical_test_style='';
			  if($property_data['electrical_test']=='no'){ $electrical_test_style="display: none;";} 
			  
			  ?>
							     <div class="prev_detail_hide1" style="<?php echo $electrical_test_style; ?>">

							        <div class="" style="margin-left: 17px">

							         <div class="form-group">
								     
								      <label class="form-label" for="signup_v2-name">Number of circuits</label>
									  <div class="form-control-wrapper">
										<input id="nr_circuits"
											   class="form-control"
											   name="nr_circuits"
											   type="text"
											   value="<?php echo $property_data['nr_circuits'] ; ?>"
											   data-validation="[OPTIONAL, NAME, L>=2, TRIM]"style="width:50%">
									  </div>
                                      <div class="form-group" style="margin: 15px 0 15px 0;">
                                           <div class="input-group date">
                                           <?php if(isset($certifiles[0]['certificate_date'])){?>
                                          <input id="daterange2" name="electrical_prev_date" type="text" class="form-control datepicker " placeholder="Previous Test Date" required="required" value="<?php echo $certifiles[0]['certificate_date'] ; ?>">
                                          <input type="hidden" name="electrical_prev_date_id" value="<?php echo $certifiles[0]['certificate_id'] ; ?>">
                                          <?php } else {?>
                                          <input id="daterange2" name="electrical_prev_date" type="text" class="form-control datepicker " placeholder="Previous Test Date" required="required" value="">
                                          <input type="hidden" name="is_first_property_certificate_electrical" value="1" />
										  <input type="hidden" name="electrical_prev_date_id" value="">
                                          <?php }?>
                                           <span class="input-group-addon">
                                            <i class="font-icon font-icon-calend"></i>
                                            </span>
                                          </div>
                                        </div>
							         </div>
							        </div>
							      

        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2">
            <h5 style="" class="accord-text">Emergency Lighting Test</h5>
          </a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
          
							        <div class="row">
								    <div class="col-md-12">
								   
								    <div class="col-md-3">
								    <div class="checkbox-detailed" id="check_yes2">
								       <input <?php if($property_data['emergency_test']=='yes'){ echo "checked";} ?>  type="radio" name="emergency_test" id="check-det-3" value="yes"/>
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
							          <div class="checkbox-detailed" id="check_no2">
								       <input type="radio"  <?php if($property_data['emergency_test']=='no'){ echo "checked";} ?> name="emergency_test" id="check-det-4" value="no"/>
								       <label for="check-det-4">
								       <span class="checkbox-detailed-tbl">
									    <span class="checkbox-detailed-cell">
										<span class="checkbox-detailed-title">No</span>
									   </span>
								      </span>
								      </label>
							        </div>
							         
                                    </div>
                                     <?php 
			  $emergency_test_style='';
			  if($property_data['emergency_test']=='no'){ $emergency_test_style="display: none;";} 
			  ?>
			   <?php /*
			   <div class="prev_detail_hide2" style="<?php echo $emergency_test_style; ?>">
			   */ ?>
			   <div class="prev_detail_hide2" style="<?php echo (!(isset($certifiles[1])) || $property_data['emergency_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/2' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
                     	</div>
                     </div>
					 
			<?php if(!(isset($certifiles[1]))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/2' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>

							        </div><!--close of md-12>-->
							        </div><!--end of row-->
									<?php 
			 $emergency_test_style='';
			  if($property_data['emergency_test']=='no'){ $emergency_test_style="display: none;";} 
			  ?>
							       <div class="prev_detail_hide2" style="<?php echo $emergency_test_style; ?>">
							        <div class="" style="margin-left: 17px">
                                    <div class="form-group">
								      <label class="form-label" for="signup_v2-name">Number of fittings</label>
									  <div class="form-control-wrapper">
										<input id="nr_fittings"
											   class="form-control"
											   name="nr_fittings"
											   type="text"
											      value="<?php echo $property_data['nr_fittings'] ; ?>"
											   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width: 50%;">
									  </div>
                                      <div class="form-group" style="margin: 15px 0 15px 0">
						       <div class="input-group date">
                               <?php if(isset($certifiles[1]['certificate_date'])){?>
							  <input id="daterange1" name="emergency_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="<?php echo $certifiles[1]['certificate_date'] ; ?>">
                              <input type="hidden" name="emergency_prev_date_id" value="<?php echo $certifiles[1]['certificate_id'] ; ?>">
                              <?php } else {?>
                              <input id="daterange1" name="emergency_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="">
                              <input type="hidden" name="is_first_property_certificate_emergency" value="1" />
							   <input type="hidden" name="emergency_prev_date_id" value="">
                              <?php }?>
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
							         </div>
							        </div>
							              

        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3">
            <h5 style="" class="accord-text"> Portable Appliance Test </h5>
          </a>
        </h4>
      </div>
	  
      <div id="collapse3" class="panel-collapse collapse">
	  
        <div class="panel-body">
          
							        <div class="row">
								    <div class="col-md-12">
								   
								    <div class="col-md-3">
								    <div class="checkbox-detailed" id="check_yes3">
								       <input type="radio"  <?php if($property_data['portable_test']=='yes'){ echo "checked";} ?> name="portable_test" id="check-det-5" value="yes"/>
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
								       <input type="radio" name="portable_test" <?php if($property_data['portable_test']=='no'){ echo "checked";} ?>   id="check-det-6" value="no"/>
								       <label for="check-det-6">
								       <span class="checkbox-detailed-tbl">
									    <span class="checkbox-detailed-cell">
										<span class="checkbox-detailed-title">No</span>
									   </span>
								      </span>
								      </label>
							        </div>

                                    </div>
                                     <?php 
			  $portable_test_test_style='';
			  if($property_data['portable_test']=='no'){ $portable_test_test_style="display: none;";} 
			  ?>
			  <?php /*
			   <div class="prev_detail_hide3" style="<?php echo $portable_test_test_style; ?>">
			   */?>
			   
			   <div class="prev_detail_hide1" style="<?php echo (!(isset($certifiles[2])) || $property_data['portable_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/3' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
                     	</div>
                     </div>
					 
					 <?php if((!(isset($certifiles[2])) || (isset($certifiles[2]) && empty($certifiles[2])))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/3' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>

							        </div><!--close of md-12>-->
							        </div><!--end of row-->
									<?php 
			 $portable_test_test_style='';
			  if($property_data['portable_test']=='no'){ $portable_test_test_style="display: none;";} 
			  ?>
							        <div class="prev_detail_hide3" style="<?php echo $portable_test_test_style ?>">
							        <div class="" style="margin-left: 17px">
                                     <div class="form-group">
								      <label class="form-label" for="signup_v2-name">Number of items</label>
									  <div class="form-control-wrapper">
										<input id="nr_items"
											   class="form-control"
											   name="nr_items"
											   value="<?php echo $property_data['nr_items'] ; ?>" 
											   type="text"
											   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
									  </div>
                                      <div class="form-group" style="margin: 15px 0 15px 0;">
						       <div class="input-group date">
                               <?php if(isset($certifiles[2]['certificate_date'])){?>
							  <input id="daterange3" name="portable_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="<?php echo $certifiles[2]['certificate_date'] ; ?>">
                              <input type="hidden" name="portable_prev_date_id" value="<?php echo $certifiles[2]['certificate_id'] ; ?>">
                              <?php } else {?>
                              <input id="daterange3" name="portable_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="">
                              <input type="hidden" name="is_first_property_certificate_portable" value="1" />
							  <input type="hidden" name="portable_prev_date_id" value="">
                              <?php }?>
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
                            
							         </div>
							        </div>
									           
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion4" href="#collapse4">
             <h5 style="" class="accord-text">Fire Alarm Test</h5>
          </a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">
              <div class="row">
								    <div class="col-md-12">
								   
								    <div class="col-md-3">

								    <div class="checkbox-detailed" id="check_yes4">
								       <input type="radio" <?php if($property_data['fire_test']=='yes'){ echo "checked";} ?> name="fire_test" id="check-det-7" value="yes"/>
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
								       <input <?php if($property_data['fire_test']=='no'){ echo "checked";} ?> type="radio" name="fire_test" id="check-det-8" value="no"/>
								       <label for="check-det-8">
								       <span class="checkbox-detailed-tbl">
									    <span class="checkbox-detailed-cell">
										<span class="checkbox-detailed-title">No</span>
									   </span>
								      </span>
								      </label>
							        </div>
							         

                                    </div>
                                     <?php 
			  $fire_test_style='';
			  if($property_data['fire_test']=='no'){ $fire_test_style="display: none;";} 
			  ?>
			   <?php /*
			   <div class="prev_detail_hide4" style="<?php echo $fire_test_style; ?>">
			   */?>
			     <div class="prev_detail_hide1" style="<?php echo (!(isset($certifiles[3])) || $property_data['fire_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/4' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
                     	</div>
                     </div>
					 
					 <?php if(!(isset($certifiles[3]))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/4' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>

							        </div><!--close of md-12>-->
							        </div><!--end of row-->
									<?php 
			 $fire_test_style='';
			  if($property_data['fire_test']=='no'){ $fire_test_style="display: none;";} 
			  ?>
							       <div class="prev_detail_hide4" style="<?php echo $fire_test_style; ?>">
							        <div class="" style="margin-left: 17px">
                                    <div class="form-group">
								      <label class="form-label" for="signup_v2-name">Number of devices</label>
									  <div class="form-control-wrapper">
										<input id="nr_devices"
											   class="form-control"
											   name="nr_devices"
											   type="text"
											   value="<?php echo $property_data['nr_devices'];?>" 
											   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
									  </div>
                                      <div class="form-group" style="margin: 15px 0 15px 0;">
						       <div class="input-group date">
                               <?php if(isset($certifiles[3]['certificate_date'])){?>
							  <input id="daterange4" name="fire_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="<?php echo $certifiles[3]['certificate_date'] ; ?>">
                              <input type="hidden" name="fire_prev_date_id" value="<?php echo $certifiles[3]['certificate_id'] ; ?>">
                              <?php } else {?>                          
                              
                              <input id="daterange4" name="fire_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="">
                              <input type="hidden" name="is_first_property_certificate_fire" value="1" />
							   <input type="hidden" name="fire_prev_date_id" value="">
                              <?php }?>
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
							         </div>
							        </div>
							              
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion5" href="#collapse5">
           <h5 style="" class="accord-text">Smoke Detector Test</h5>
          </a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
        <div class="panel-body">
           <div class="row">
								    <div class="col-md-12">
								   
								    <div class="col-md-3">

								     <div class="checkbox-detailed" id="check_yes5">
								       <input <?php if($property_data['smoke_test']=='yes'){ echo "checked";} ?>  type="radio" name="smoke_test" id="check-det-9" value="yes"/>
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
								       <input type="radio" <?php if($property_data['smoke_test']=='no'){ echo "checked";} ?>  name="smoke_test" id="check-det-10" value="no"/>
								       <label for="check-det-10">
								       <span class="checkbox-detailed-tbl">
									    <span class="checkbox-detailed-cell">
										<span class="checkbox-detailed-title">No</span>
									   </span>
								      </span>
								      </label>
							        </div>
							         
                                    </div>
                                    <?php 
			  $smoke_test_style='';
			  if($property_data['smoke_test']=='no'){ $smoke_test_style="display: none;";} 
			  ?>
			   <?php /*
			   <div class="prev_detail_hide5" style="<?php echo $smoke_test_style; ?>">
			   */ ?>
			   <div class="prev_detail_hide5" style="<?php echo (!(isset($certifiles[4])) || $property_data['smoke_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/5' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
                     	</div>
                     </div>
					 
					 <?php if(!(isset($certifiles[4]))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/5' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>
							        </div><!--close of md-12>-->
							        </div><!--end of row-->
									<?php 
			 $smoke_test_style='';
			  if($property_data['smoke_test']=='no'){ $smoke_test_style="display: none;";} 
			  ?>
							       <div class="prev_detail_hide5" style="<?php echo $smoke_test_style; ?>">
							        <div class="" style="margin-left: 17px">
                                    <div class="form-group">
								      <label class="form-label" for="signup_v2-name">Number of sensors</label>
									  <div class="form-control-wrapper">
										<input id="nr_sensors"
											   class="form-control"
											   name="nr_sensors"
											   type="text"
											   value="<?php echo $property_data['nr_sensors'];?>" 
											   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
									  </div>
                                      <div class="form-group" style="margin: 15px 0 15px 0;">
						               <div class="input-group date">
                                       <?php  if(isset($certifiles[4]['certificate_date'])){?>
							  <input id="daterange5" name="smoke_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="<?php echo $certifiles[4]['certificate_date'] ; ?>">
                              <input type="hidden" name="smoke_prev_date_id" value="<?php echo $certifiles[4]['certificate_id'] ; ?>">
                              <?php } else {?>
                              <input id="daterange5" name="smoke_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="">
                              <input type="hidden" name="is_first_property_certificate_smoke" value="1" />
							  <input type="hidden" name="smoke_prev_date_id" value="">
                              <?php }?>
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
							         </div>
							        </div>
							       </div>
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
			<input type="radio" name="carbon_test"  <?php if($property_data['carbon_test']=='yes'){ echo "checked";} ?> id="check-det-11" value="yes" />
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
			<input type="radio" name="carbon_test"  <?php if($property_data['carbon_test']=='no'){ echo "checked";} ?> id="check-det-12" value="no"/>
			<label for="check-det-12">
			<span class="checkbox-detailed-tbl">
			<span class="checkbox-detailed-cell">
			<span class="checkbox-detailed-title">No</span>
			</span>
			</span>
			</label>
			</div>


            </div>
           <?php 
			  $corbon_style='';
			  if($property_data['carbon_test']=='no'){ $corbon_style="display: none;";} 
			  ?>
			  <?php /*
			   <div class="prev_detail_hide6" style="<?php echo $corbon_style; ?>">
			   */ ?>
			   <div class="prev_detail_hide6" style="<?php echo (!(isset($certifiles[5])) || $property_data['carbon_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/6' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
                     	</div>
                     </div>
					 
					 <?php if(!(isset($certifiles[5]))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/6' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>

	        </div><!--close of md-12>-->
	        </div><!--end of row-->
			
              <?php 
			  $corbon_style='';
			  if($property_data['carbon_test']=='no'){ $corbon_style="display: none;";} 
			  ?>
			
	        <div class="prev_detail_hide6" style="<?php echo $corbon_style; ?>">
	         <div class="" style="margin-left: 17px">

	         <div class="form-group">
		     
		      <label class="form-label" for="signup_v2-name">Number of devices</label>
			  <div class="form-control-wrapper">
				<input id="nr_carbon"
					   class="form-control"
					   name="nr_carbon"
					   type="text"
					   value="<?php echo $property_data['nr_carbon'] ; ?>"
					   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
			  </div>
              <div class="form-group" style="margin: 15px 0 15px 0">
						       <div class="input-group date">
                               <?php if(isset($certifiles[5]['certificate_date'])){?>
							  <input id="daterange6" name="carbon_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="<?php echo $certifiles[5]['certificate_date'] ; ?>">
                              <input type="hidden" name="carbon_prev_date_id" value="<?php echo $certifiles[5]['certificate_id'] ; ?>">
                              <?php } else {?>
                              <input id="daterange6" name="carbon_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="">
                              <input type="hidden" name="is_first_property_certificate_carbon" value="1" />
                              <input type="hidden" name="carbon_prev_date_id" value="">
                              <?php }?>
							   <span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							    </span>
						      </div>
					        </div>
	         </div>
	        </div>
	        <!--section-->
	              
			 
			 <!--section end -->
			</div> 	
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
			<input type="radio" name="gas_safety_test"  <?php if($property_data['gas_safety_test']=='yes'){ echo "checked";} ?> id="check-det-13" value="yes" />
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
			<input type="radio" name="gas_safety_test"  <?php if($property_data['gas_safety_test']=='no'){ echo "checked";} ?> id="check-det-14" value="no"/>
			<label for="check-det-14">
			<span class="checkbox-detailed-tbl">
			<span class="checkbox-detailed-cell">
			<span class="checkbox-detailed-title">No</span>
			</span>
			</span>
			</label>
			</div>


            </div>
           <?php 
			  $gas_safety_test_style='';
			  if($property_data['gas_safety_test']=='no'){ $gas_safety_test_style="display: none;";} 
			  ?>
			  <?php /*
			   <div class="prev_detail_hide7" style="<?php echo $gas_safety_test_style; ?>">
			   */ ?>
			   <div class="prev_detail_hide7" style="<?php echo (!(isset($certifiles[6])) || $property_data['gas_safety_test']=='no') ? 'display:none' : '';?>">
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/view_property_certificate/'.$property_data['unique_id']).'/7' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View Certificates</button></a>
                     	</div>
                     </div>
					 
					 <?php if(!(isset($certifiles[6]))){ ?>					
				    <div class="prev_detail_hide2" >
                      <div class="col-md-3">
                     	<a href="<?php echo base_url('jobs/upload_certificate/'.$property_data['unique_id']).'/1/7' ?>" ><button type="button" class="btn"><span class="font-icon font-icon-plus"></span> Add Certificate</button></a>
                     	</div>
                     </div>
				<?php } ?>

	        </div><!--close of md-12>-->
	        </div><!--end of row-->
            <?php 
			  $gas_safety_test_style='';
			  if($property_data['gas_safety_test']=='no'){ $gas_safety_test_style="display: none;";} 
			  ?>
	       <div class="prev_detail_hide7" style="<?php echo $gas_safety_test_style; ?>">
	        <div class="" style="margin-left: 17px">

	         <div class="form-group">
		     
		      <label class="form-label" for="signup_v2-name">Number of devices</label>
			  <div class="form-control-wrapper">
				<input id="nr_gas_safety"
					   class="form-control"
					   name="nr_gas_safety"
					   type="text"
					   value="<?php echo $property_data['nr_gas_safety'] ; ?>"
					   data-validation="[OPTIONAL, NAME, L>=2, TRIM]" style="width:50%">
			  </div>
              <div class="form-group" style="margin: 15px 0 15px 0">
                   <div class="input-group date">
                   <?php if(isset($certifiles[6]['certificate_date'])){?>
                  <input id="daterange7" name="gas_safety_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="<?php echo $certifiles[6]['certificate_date'] ; ?>">
                  <input type="hidden" name="gas_prev_date_id" value="<?php echo $certifiles[6]['certificate_id'] ; ?>">
                  <?php } else {?>
                  <input id="daterange7" name="gas_safety_prev_date" type="text" class="form-control datepicker " placeholder="Previous test date" required="required" value="">
                  <input type="hidden" name="is_first_property_certificate_gas" value="1" />
				  <input type="hidden" name="gas_prev_date_id" value="">
                  <?php }?>
                   <span class="input-group-addon">
                    <i class="font-icon font-icon-calend"></i>
                    </span>
                  </div>
                </div>
	         </div>
	        </div>
	        <!--section-->
	              
			 <!--section end -->
			</div>
        </div>
      </div>
    </div>
</div>

						<div class="form-group">
									 <label class="form-label" for="signup_v2-name">Previous Test Notes</label>
									  <div class="form-control-wrapper">
									  <textarea rows="4" id="prev_test_details"  name="prev_test_details" class="form-control" placeholder="Press Enter" data-autosize="" style="overflow: hidden; word-wrap: break-word; height: 145px;" required> <?php echo $property_data['prev_test_details'];?> </textarea>
									  </div>
								   </div>



							        <div class="form-group form-group-checkbox">
								      <div class="checkbox" style="margin: 25px 0;">
								      
										<input id="signup_v2-agree"
											   name="terms_and_conditions"
											   data-validation="[NOTEMPTY]"
											   data-validation-message="You must agree the terms and conditions"
											   <?php if($property_data['terms_and_conditions']!=''){ echo "checked";} ?>
											   type="checkbox" required>
										<label for="signup_v2-agree">I agree the <a href="#">terms</a> and <a href="#">conditions</a></label>
									</div>
									
								    </div>

				                  </div> 
				                  	<button type="submit" class="btn" >Update</button>
								   <a href="<?php echo base_url('user/viewproperty') ?>"><button type="button" class="btn">Cancel</button></a>
								   <a href="<?php echo base_url('jobs/view_certificate/'.$property_data['unique_id']) ?>" ><button type="button" class="btn"><span class="font-icon font-icon-eye"></span> View all certificates</button></a>
			                       </section>
                                 
                                
                               
           							
							</form>
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

