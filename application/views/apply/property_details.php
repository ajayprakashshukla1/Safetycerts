<style type="text/css">
	.sweet-alert .btn{
	  min-width: 0px;
	}
	.error { color:red; }  

	h1.with-border, h2.with-border, h3.with-border, h4.with-border, h5.with-border, h6.with-border {
	    padding-bottom: 1.8rem;
	}
	.form-control-static {
	    
	     padding-top: 0 !important; 
	}
	.row.client-details {
	    float: right;
	    padding: 0 45px;
	}
	.row.property-details {
	    margin-top: 120px!important;
	    padding: 0 25px;
	}
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
		<div class="row client-details">
			<h5>Client Details</h5>
			<span><b>Name</b> : <a href="<?php echo base_url('user/edit_member/'.$client_data->unique_id) ?>"><?php echo $client_data->first_name.' '.$client_data->last_name ?></a></span><br>
			<span><b>Email</b> : <?php echo $client_data->email;?></span><br>
			<span><b>Number</b> : <?php echo $client_data->phone;?></span>			
		</div>
		<div class="row property-details">
			<h5 class="m-t-lg with-border">Property Details 
         
	        <div style="float: right">
	         	<?php if($login_user->role=='admin' || $login_user->role=='members'){ ?>
		         <a class="tabledit-edit-button btn btn-sm btn-success" href="<?php echo base_url() ?>user/property_edit/<?php echo $property_data['unique_id']; ?>">
		            <!-- <span class="glyphicon glyphicon-pencil"></span> -->
		            <span>Edit Property</span>
		         </a> 
	             <?php } ?>
	             <?php if($login_user->role=='admin'){ ?>
	             <a href="<?php echo base_url() ?>jobs/upload_certificate/<?php echo $property_data['unique_id']; ?>" class="tabledit-edit-button btn btn-sm btn-primary">
	                <!-- <span class="font-icon font-icon-upload"></span> -->
	                <span>Upload Certificates</span>
	             </a>
	             <?php } ?>

	             <a href="<?php echo base_url() ?>jobs/view_certificate/<?php echo $property_data['unique_id']; ?>" class="tabledit-edit-button btn btn-sm btn-default">
	                <!-- <span class="font-icon font-icon-eye"></span> -->
	                <span>View Certificates</span>
	             </a>


	         </div>

	         <?php if($login_user->role=='contractor'){ ?>
	            <div style="float: right">
	              <a href="<?php echo base_url() ?>jobs/upload_certificate/<?php echo $property_data['unique_id'] ?>" class="btn btn-inline">Upload Certificate</a>
	            </div>

	         <?php } ?>
	        </h5>
		</div>
        
        <div class="row">
					<div class="col-lg-12">		
		            
		
			<div class="card-block row">
			<form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1">
			<div class="row">
			 <?php //echo "<pre>";
                //print_r($property_data);
			 ?>
					<div class="col-lg-12">
		                 <div class="card-block row">
			               <div class="form-group row">
						<label class="col-sm-3 form-control-label">Name</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php echo ucfirst($property_data['name']) ?></p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Address</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php echo ucfirst($property_data['address']) ?></p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">PostCode</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php echo ucfirst($property_data['zip_code']) ?></p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Property type</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php echo ucfirst($property_data['property_type']) ?></p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Access Details</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php echo ucfirst($property_data['access_details']) ?></p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Electrical Test</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['electrical_test']==''){echo "No";}else{echo ucfirst($property_data['electrical_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of circuits : <?php echo ucfirst($property_data['nr_circuits']) ?></p>
						</div>
					</div>
					
					
					
						<div class="form-group row">
						<label class="col-sm-3 form-control-label">Emergency Lighting Test</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['emergency_test']==''){echo "No";}else{echo ucfirst($property_data['emergency_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of fittings : <?php echo ucfirst($property_data['nr_fittings']) ?></p>
						</div>
					</div>
					
					
					
						<div class="form-group row">
						<label class="col-sm-3 form-control-label">Portable Appliance Test</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['portable_test']==''){echo "No";}else{echo ucfirst($property_data['portable_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of items : <?php echo ucfirst($property_data['nr_items']) ?></p>
						</div>
					</div>
					
					
						<div class="form-group row">
						<label class="col-sm-3 form-control-label">Fire Alarm Test</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['fire_test']==''){echo "No";}else{echo ucfirst($property_data['fire_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of devices : <?php echo ucfirst($property_data['nr_devices']) ?></p>
						</div>
					</div>
					
					
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Smoke Detector Test</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['smoke_test']==''){echo "No";}else{echo ucfirst($property_data['smoke_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of sensors : <?php echo ucfirst($property_data['nr_sensors']) ?></p>
						</div>
					</div>
					<div class="form-group row">
					<label class="col-sm-3 form-control-label">Carbon monoxide detector</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['carbon_test']==''){echo "No";}else{echo ucfirst($property_data['carbon_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of devices : <?php echo ucfirst($property_data['nr_carbon']) ?></p>
						</div>
					</div>
					<div class="form-group row">
					<label class="col-sm-3 form-control-label">Gas safety</label>
						<div class="col-sm-4">
							<p class="form-control-static"><?php if($property_data['gas_safety_test']==''){echo "No";}else{echo ucfirst($property_data['gas_safety_test']);} ?></p>
						</div>
						<div class="col-sm-5">
							<p class="form-control-static">Number of devices : <?php echo ucfirst($property_data['nr_gas_safety']) ?></p>
						</div>
					</div>

					
					  <h5 class="m-t-lg with-border">Test History</h5>
					  
					  <div class="form-group row">
						<label class="col-sm-3 form-control-label">Previous Test Notes</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php if($property_data['prev_test_details']==''){echo "--";}else{echo ucfirst($property_data['prev_test_details']);} ?></p>
						</div>
						
					</div>
					
					<?php /* <div class="form-group row">
						<label class="col-sm-3 form-control-label">Previous Test Date</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php if($property_data['prev_test_date']==''){echo "--";}else{echo date('m/d/Y',strtotime($property_data['prev_test_date']));} ?></p>
						</div>
						
					</div>*/ ?>
					<?php /*if($property_data['doc']!=''){ ?>
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Document</label>
						<div class="col-sm-9">
							<p class="form-control-static"><?php if($property_data['doc']==''){echo "--";}else{echo '<a href="">Download</a>';} ?></p>
						</div>
						
					</div>
					<?php } */ ?>
					  
					  
					
	                     </div>
					</div>
				
				</div>
				
				
				</form>
				
				
	</div>

        
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>