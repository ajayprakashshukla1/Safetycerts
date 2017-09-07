<style type="text/css">
.alert-success {
    background-color: #dff0d8;
    border-color: #d6e9c6;
    color: #3c763d;
}

.alert-dismissable, .alert-dismissible {
    padding-right: 35px;
}

.alert {
    border: 1px solid transparent;
    border-radius: 4px;
    margin-bottom: 20px;
    padding: 15px;
}

.alert-danger {
    background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;
}    
</style>

 
  
  

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assest/css/loading.css"> 
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://use.fonticons.com/ffe176a3.js"></script>
 
    
     <div class="loading" style="display:none;">Loading&#8230;</div>

<?php // echo form_open('apply/create',array('id'=>'applyform')); ?>

<?php echo form_open_multipart('apply/create',array('id'=>'applyform'));?>
  
        <div class="inner_page_wrap">
            <div class="gray-header">
                <div class="container">
                    <p>
                        Your Details
                    </p>
                </div>
            </div>
            <div class="form-area container">
                <div class="form-group">
                    <div class="row">

                    <div id="notify"></div>

                  
                        <div class="col-sm-4">
                            <div class="select_wrap">
                                <div class="select_wrap_item">
                                    <label>Title <sup>*</sup></label>
                                    <div class="btn select_btn"></div>
                                    <select name="title" class="form-control">
                                        <option value="Mr" selected="selected">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Rev">Rev</option>
                                        <option value="Prof">Prof</option>
                                        <option value="Capt">Capt</option>
                                        <option value="Lady">Lady</option>
                                        <option value="Sir">Sir</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label> First Name <sup>*</sup></label>
                            <input type="text" name="first_name" id="apply_first_name" class="form-control">
                            <input type="hidden" name="token" id="token" value="<?php echo $token ?>">
                        </div>
                        <div class="col-sm-6">
                            <label> Surname <sup>*</sup></label>
                            <input type="text" name="last_name" id="apply_last_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Email Address <sup>*</sup></label>
                            <input type="email" name="email" id="email" class="form-control apply_email">
                        </div>
                        <div class="col-sm-6">
                            <label>Confirm Email <sup>*</sup></label>
                            <input type="email" name="confirm_email" id="apply_confirm_email" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Password <sup>*</sup></label>
                            <input type="password" name="password" id="apply_password" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label>Confirm Password <sup>*</sup></label>
                            <input type="password" name="confirm_password" id="apply_confirm_password" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Telephone Number</label>
                            <input type="tel" name="phone" id="apply_phone" class="form-control">
                        </div>
                    </div>
                </div>


               <!--  <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="button" name="sign_up" class="btn btn-default sign-up" value="Sign-up & add property later" onclick="let_signup()">
                            
                        </div>
                    </div>
                </div> -->



            </div>

            
        </div>

        <!-- ============step 1 end =============== -->

        <div class="inner_page_wrap">
    <div class="gray-header">
        <div class="container">
            <p>
                Property Details
            </p>
        </div>
    </div>

    <div class="form-area container">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6" style="display: none;">
                    <label>Search for an address</label>
                    <input type="text" class="form-control" placeholder="" name="form_6__previous_address">
                    <p class="field_desc">blablabla</p>
                </div>
                  <div class="col-md-5 col-sm-6" style="    margin-bottom: 15px;" >
                    <label>Property Name <sup>*</sup></label>
                    <input type="text" required class="form-control" placeholder="" name="name">
                </div>
                <br>
                <div class="col-sm-12">
                    <label>Property Address <sup>*</sup></label>
                    <textarea name="address"  required cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="col-sm-12" style="margin-top:20px;">
                    <label>PostCode<sup>*</sup></label>
                    <input type="text"  id="zip_code"  name="zip_code" class="form-control" placeholder="enter postcode" required/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Property Type</label>
            <div class="row">
                 <div class="col-md-5 col-sm-6">
                    <div class="btn_radio">
                        <label class="btn">
                            <input name="property_type" value="domestic" type="radio">
                            <p>Domestic</p>
                        </label>
                        <label class="btn">
                            <input name="property_type" value="commercial" type="radio">
                            <p>Commercial</p>
                        </label>
                        <label class="btn">
                            <input name="property_type" value="industrial" type="radio">
                            <p>Industrial</p>
                        </label>
                    </div>
                </div>
             </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label>Access Details</label>
                    <textarea name="access_details" cols="30" rows="10" class="form-control" placeholder="Please give details of access to the property and who will be there"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
        
<!-- ============step 2 end =============== -->

<div class="inner_page_wrap">
    <div class="gray-header">
        <div class="container">
            <p>
                Certificates Required
            </p>
        </div>
    </div>
    <div class="form-area container">
        <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                 <label>Electrical Test</label>
                 <div class="row">
                    <div class="col-md-6 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn ">
                            <input name="electrical_test" value="yes" type="radio" class="test_checkbox" id="electrical_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="electrical_test" value="no" type="radio" class="test_checkbox" id="electrical_test_no" checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-sm-5 left_label_wrap" id="electrical_qty" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of circuits</label>
                    <input name="nr_circuits" type="number" class="form-control" placeholder="Qty.">
                </div>
                     
                 </div>
              </div>
              <div class="col-md-2" id="electrical_prev_date" style="display:none">
                 <label>Previous Test Date</label>
                 <div class="row">
                 <div class="col-md-12 col-sm-12 left_label_wrap">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange1" name="electrical_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
                </div>
                </div>
              </div>
              <div class="col-md-2" id="electrical_validity" style="display:none">
                 <label>Validity period</label>
                 <div class="row">
                 <div class="col-md-12 col-sm-12 left_label_wrap" >
                    <select class="form-control" style="display: block;" name="electrical_expire">
                        <option value="1 Month">Select Validity</option>
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
              </div>
              <div class="col-md-2" id="electrical_upload" style="display:none">
                 <label>Current Certificate</label>
                 <div class="row">          
                    <div class="col-md-12 col-sm-12 left_label_wrap">
                      <label class="upload btn one" style="width: 189px; margin-top:0;">
                            Upload Certificate
                            <input type="file" id="upload1" name="electrical_upload_file"  value=""
                           onchange="uploadcertfile('electrical_upload_file','upload1')"/>
                        </label>
                        <span id="elect_uploaded_file"></span>
                    </div>
                </div>
              </div>
               <input type="hidden" name="is_first_property_certificate_electrical" value="1" />
            </div>
            
        </div>
         <div class="form-group">
            <label>Emergency Lighting Test</label>
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn ">
                            <input name="emergency_test" value="yes" type="radio" class="test_checkbox" id="emergency_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="emergency_test" value="no" type="radio" class="test_checkbox" id="emergency_test_no" checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 left_label_wrap" id="emergency_qty" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of fittings</label>
                    <input name="nr_fittings" type="number" class="form-control" placeholder="Qty.">
                </div>
                <div class="col-md-2 left_label_wrap" id="emergency_prev_date" style="display:none">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange2" name="emergency_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
              </div>
              <div class="col-md-2 left_label_wrap" id="emergency_validity" style="display:none">
                    <select class="form-control" style="display: block;" name="emergency_expire">
                        <option value="1 Month">Select Validity</option>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="1 year">1 Year</option>
                        <option value="3 years">3 Years</option>
                        <option value="5 years">5 Years</option>
                        <option value="10 years">10 Years</option>
                    </select>
                
              </div>
              <div class="col-md-2 left_label_wrap" id="emergency_upload" style="display:none">                 
                  <label class="upload btn two" style="width: 189px; margin-top:0;">
                        Upload Certificate
                        <input type="file" id="upload2" name="emergency_upload_file"
                        onchange="uploadcertfile('emergency_upload_file','upload2')" >
                    </label>
                    <span id="emerg_uploaded_file"></span>
                </div>  
                 <input type="hidden" name="is_first_property_certificate_emergency" value="1" />  
            </div>
                        
        </div>
         <div class="form-group">
            <label>Portable Appliance Test</label>
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn ">
                            <input name="portable_test" value="yes" type="radio" class="test_checkbox" id="portable_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="portable_test" value="no" type="radio" class="test_checkbox" id="portable_test_no" checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 left_label_wrap" id="portable_qty" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of items</label>
                    <input name="nr_items" type="number" class="form-control" placeholder="Qty.">
                </div>
                <div class="col-md-2 left_label_wrap" id="portable_prev_date" style="display:none">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange3" name="portable_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
              </div>
              <div class="col-md-2 left_label_wrap" id="portable_validity" style="display:none">
                    <select class="form-control" style="display: block;" name="portable_expire">
                        <option value="1 Month">Select Validity</option>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="1 year">1 Year</option>
                        <option value="3 years">3 Years</option>
                        <option value="5 years">5 Years</option>
                        <option value="10 years">10 Years</option>
                    </select>
                
              </div>
              <div class="col-md-2 left_label_wrap" id="portable_upload" style="display:none">                 
                  <label class="upload btn three" style="width: 189px; margin-top:0;">
                        Upload Certificate
                        <input type="file" id="upload3" name="portable_upload_file" value="" 
                         onchange="uploadcertfile('portable_upload_file','upload3')">
                    </label>
                    <span id="port_upload_file"></span>
                </div> 
                <input type="hidden" name="is_first_property_certificate_portable" value="1" />  
            </div>
        </div>
         <div class="form-group">
            <label>Fire Alarm Test</label>
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn">
                            <input name="fire_test" value="yes" type="radio"  class="test_checkbox" id="fire_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="fire_test" value="no" type="radio" class="test_checkbox" id="fire_test_no"checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 left_label_wrap" id="fire_prev_date" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of devices</label>
                    <input type="number" name="nr_devices" class="form-control" placeholder="Qty.">
                </div>
                <div class="col-md-2 left_label_wrap" id="fire_qty" style="display:none">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange4" name="fire_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
              </div>
              <div class="col-md-2 left_label_wrap" id="fire_validity" style="display:none">
                    <select class="form-control" style="display: block;" name="fire_expire">
                        <option value="1 Month">Select Validity</option>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="1 year">1 Year</option>
                        <option value="3 years">3 Years</option>
                        <option value="5 years">5 Years</option>
                        <option value="10 years">10 Years</option>
                    </select>
                
              </div>
              <div class="col-md-2 left_label_wrap" id="fire_upload" style="display:none">                 
                  <label class="upload btn four" style="width: 189px; margin-top:0;">
                        Upload Certificate
                        <input type="file" id="upload4" name="fire_upload_file"  onchange="uploadcertfile('fire_upload_file','upload4')">
                    </label>
                    <span id="fire_uploaded_file"></span>
                </div> 
                 <input type="hidden" name="is_first_property_certificate_fire" value="1" />  
            </div>
        </div>

         <div class="form-group">
            <label>Smoke Detector Test</label>
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn">
                            <input name="smoke_test" value="yes" type="radio"  class="test_checkbox" id="smoke_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="smoke_test" value="no" type="radio" class="test_checkbox" id="smoke_test_no" checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 left_label_wrap" id="smoke_qty" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of sensors</label>
                    <input type="number" name="nr_sensors" class="form-control" placeholder="Qty.">
                </div>
                <div class="col-md-2 left_label_wrap" id="smoke_prev_date" style="display:none">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange5" name="smoke_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
              </div>
              <div class="col-md-2 left_label_wrap" id="smoke_validity" style="display:none">
                    <select class="form-control" style="display: block;" name="smoke_expire">
                        <option value="1 Month">Select Validity</option>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="1 year">1 Year</option>
                        <option value="3 years">3 Years</option>
                        <option value="5 years">5 Years</option>
                        <option value="10 years">10 Years</option>
                    </select>
                
              </div>
              <div class="col-md-2 left_label_wrap" id="smoke_upload" style="display:none">                 
                  <label class="upload btn five" style="width: 189px; margin-top:0;">
                        Upload Certificate
                        <input type="file" id="upload5" name="smoke_upload_file" onchange="uploadcertfile('smoke_upload_file','upload5')" >
                    </label>
                    <span id="smoke_uploaded_file"></span>
                </div> 
                 <input type="hidden" name="is_first_property_certificate_smoke" value="1" />  
            </div>
        </div>

        <div class="form-group">
            <label>Carbon monoxide detector</label>
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn">
                            <input name="carbon_test" value="yes" type="radio"  class="test_checkbox" id="carbon_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="carbon_test" value="no" type="radio" class="test_checkbox" id="carbon_test_no" checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 left_label_wrap" id="carbon_qty" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of devices</label>
                    <input type="number" name="nr_carbon" class="form-control" placeholder="Qty.">
                </div>
                <div class="col-md-2 left_label_wrap" id="carbon_prev_date" style="display:none">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange6" name="carbon_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
              </div>
              <div class="col-md-2 left_label_wrap" id="carbon_validity" style="display:none">
                    <select class="form-control" style="display: block;" name="carbon_expire">
                        <option value="">Select Validity</option>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="1 year">1 Year</option>
                        <option value="3 years">3 Years</option>
                        <option value="5 years">5 Years</option>
                        <option value="10 years">10 Years</option>
                    </select>
                
              </div>
              <div class="col-md-2 left_label_wrap" id="carbon_upload" style="display:none">                 
                  <label class="upload btn six" style="width: 189px; margin-top:0;">
                        Upload Certificate
                        <input type="file" id="upload6" name="carbon_upload_file" onchange="uploadcertfile('carbon_upload_file','upload6')" >
                    </label>
                    <span id="carbon_uploaded_file"></span>
                </div>
                 <input type="hidden" name="is_first_property_certificate_carbon" value="1" />   
            </div>
        </div>

        <div class="form-group">
            <label>Gas safety - coming soon!</label>
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="btn_radio">
                        <label class="btn">
                            <input name="gas_safety_test" value="yes" type="radio"  class="test_checkbox" id="gas_test_yes">
                            <p>Yes</p>
                        </label>
                        <label class="btn active">
                            <input name="gas_safety_test" value="no" type="radio" class="test_checkbox" id="gas_test_no" checked>
                            <p>No</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 left_label_wrap" id="gas_qty" style="display:none">
                    <label class="left_label" style=" text-align: left;font-size: 13px;">Number of devices</label>
                    <input type="number" name="nr_gas_safety" class="form-control" placeholder="Qty.">
                </div>
                <div class="col-md-2 left_label_wrap" id="gas_prev_date" style="display:none">
                  <div class="form-group" style="">
                       <div class='input-group date'>
                        <input id="daterange7" name="gas_prev_date" type="text"  class="form-control datepicker" style="width: 100%;">
                       <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                        </span>
                      </div>
                    </div>
              </div>
              <div class="col-md-2 left_label_wrap" id="gas_validity" style="display:none">
                    <select class="form-control" style="display: block;" name="gas_expire">
                        <option value="">Select Validity</option>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="1 year">1 Year</option>
                        <option value="3 years">3 Years</option>
                        <option value="5 years">5 Years</option>
                        <option value="10 years">10 Years</option>
                    </select>
                
              </div>
              <div class="col-md-2 left_label_wrap" id="gas_upload" style="display:none">                 
                  <label class="upload btn seven" style="width: 189px; margin-top:0;">
                        Upload Certificate
                        <input type="file" id="upload7" name="gas_safety_upload" onchange="uploadcertfile('gas_safety_upload','upload7')">
                    </label>
                    <span id="gas_uploaded_file"></span>
                </div> 
                <input type="hidden" name="is_first_property_certificate_gas" value="1" />  
            </div>
        </div>

    </div>
    <div class="gray-header">
        <div class="container">
            <p>
                Test History
            </p>
        </div>
    </div>
    <div class="form-area container">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label>Previous Test Note</label>
                    <textarea name="prev_test_details" cols="30" rows="10" class="form-control" placeholder="Please give details of previous tests"></textarea>
                </div>
            </div>
        </div>
        <!--
        <div class="form-group">
            <label>Previous Test Date <span>if known/available (if unknown leave blank)</span></label>
            <div class="row dates-here">
                <div class="col-md-4 col-sm-5">
                    <div class="select_wrap sel_3">
                        <div class="select_wrap_item">
                            <div class="btn select_btn"></div>
                            <select name="prev_test_day"  class="form-control">
                                <option value="">Day</option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>
                        <div class="select_wrap_item">
                            <div class="btn select_btn"></div>
                            <select name="prev_test_month" class="form-control">
                                <option value="">Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="select_wrap_item">
                            <div class="btn select_btn"></div>
                            <select name="prev_test_year" class="form-control">
                                <option value="">Year</option>
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
        <!-- <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <span class="label">Photo Upload</span>
                    <label class="upload btn">
                        Choose file to upload
                        <input type="file" id="upload" name="userfile[]" multiple="multiple" accept=".png,.pdf,.jpg,.jpeg,.tiff,.bmp">
                    </label>
                    <span id="uploaded_file"></span>
                </div>
            </div>
        </div> -->
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="checkbox">
                        <div class="label">Terms & conditions <sup>*</sup></div>
                        <input type="checkbox" id="terms_and_conditions" name="terms_and_conditions">
                        <label for="terms_and_conditions" class="right_label">I have read and agreed to the <a href="#">terms and conditions</a>.</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        
        
        <!-- ============step 3 end =============== -->

        <div class="action-buttons">
            <div class="container">
                <ul>
                    <input type="hidden" name="url_path" id="url_path" value="<?php echo base_url() ?>apply/createPropertyAjax">
                    <input type="hidden" name="redirect_path" id="redirect_path" value="<?php echo base_url() ?>auth/login" disabled>
                    <li class="btn btn-default sign-up" onclick="let_signup()" style=" width: 362px;">Sign-up & add property later</li>
                    <li class="btn previous">previous</li>
                    <li class="btn next">Next</li>
                </ul>
            </div>
        </div>
    </form>


<script type="text/javascript">
    $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
</script>
<script type="text/javascript">
  $('.test_checkbox').click(function(){
    var id= $(this).attr('id');
    var id_split = id.split("_");
    var group_id= id_split[0];
    var value= $('#'+id).val();
    
    if(value=='yes'){
       $('#'+group_id+'_qty').css('display','block');
       $('#'+group_id+'_prev_date').css('display','block');
       $('#'+group_id+'_validity').css('display','block');
       $('#'+group_id+'_upload').css('display','block');
       // make prev_date required
       $("input[name="+group_id+"_prev_date]").attr('required',true);
    }else if(value=='no'){
        $('#'+group_id+'_qty').css('display','none');
       $('#'+group_id+'_prev_date').css('display','none');
       $('#'+group_id+'_validity').css('display','none');
       $('#'+group_id+'_upload').css('display','none');
       // remove required from prev_date
       $("input[name="+group_id+"_prev_date]").attr('required',false);
    }

  })   
</script>
<script type="text/javascript">
    function makeFileList() {
        var input = document.getElementById("upload1");
        var ul = document.getElementById("elect_uploaded_file");
        while (ul.hasChildNodes()) {
            ul.removeChild(ul.firstChild);
        }
        for (var i = 0; i < input.files.length; i++) {
            var li = document.createElement("li");
            li.innerHTML = input.files[i].name;
            ul.appendChild(li);
        }
        if(!ul.hasChildNodes()) {
            var li = document.createElement("li");
            li.innerHTML = 'No Files Selected';
            ul.appendChild(li);
        }
    }
</script>
<script type="text/javascript">
    
function uploadcertfile(cert_type,file_id){
     
    var token= $('#token').val();
   var path="<?php echo base_url() ?>apply/uploadCertAjax?cert_type="+cert_type+"&token="+token+"";

    $('.loading').css('display','block');
    //alert(path); 
      $.ajax({
       type: 'POST', 
       url: path,
       //enctype: 'multipart/form-data',
       data:new FormData($('#applyform')[0]),
       contentType: false,
       processData: false,
       cache: false,
       success: function(response){
         
         $('.loading').css('display','none');

          var $el = $('#'+file_id);
          $el.wrap('<form>').closest('form').get(0).reset();
          $el.unwrap();

       }
     });
}
</script>
