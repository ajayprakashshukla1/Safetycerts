<?php

/* The function that creates the HTML on the front-end, based on the parameters
 * supplied in the product-catalog shortcode */

function Create_Qupte_Form($atts) {
    // Include the required global variables, and create a few new ones
    global $wpdb, $user_message, $feup_success;
    global $ewd_feup_fields_table_name, $ewd_feup_user_table_name, $ewd_feup_user_fields_table_name, $ewd_product_categories, $ewd_product_list, $wp_ewd_quotation;
    define('DOING_AJAX', true);
    $Custom_CSS = get_option("EWD_FEUP_Custom_CSS");
    $Salt = get_option("EWD_FEUP_Hash_Salt");
    $Time = time();
    $additionalAmount1 = 0;
    $CheckCookie = CheckLoginCookie();
    //Check User Return Messages
    if ($user_message == "move_step2") {
        FEUPRedirect('create-quote/?step=2');
    }
    if ($user_message == "move_step3") {
        FEUPRedirect('create-quote/?step=3');
    }
    if ($user_message == "move_step4") {
        FEUPRedirect('create-quote/?step=4');
    }
    if ($user_message == "move_step5") {
        FEUPRedirect('create-quote/?step=5');
    }
    //if($user_message=="move_step6"){FEUPRedirect('create-quote/?msg=success&step=6#quotesavedmsg');}
    if ($user_message == "move_step6") {
        FEUPRedirect('create-quote/?msg=success&step=7#quotesavedmsg');
    }
    if ($user_message == "move_skip_step6") {
        FEUPRedirect('create-quote/?step=6');
    }
    if ($user_message == "Quotation") {
        FEUPRedirect('create-quote/?print=Quotation');
    } else if ($user_message == "MethodStatement") {
        FEUPRedirect('create-quote/?print=method_statement');
    } else if ($user_message == "LocationMap") {
        FEUPRedirect('create-quote/?print=LocationMap');
    } else if ($user_message == "Quotation,MethodStatement") {
        FEUPRedirect('create-quote/?print=QuotationMethodStatement');
    } else if ($user_message == "MethodStatement,LocationMap") {
        FEUPRedirect('create-quote/?print=MethodStatementLocationMap');
    } else if ($user_message == "Quotation,LocationMap") {
        FEUPRedirect('create-quote/?print=QuotationLocationMap');
    } else if ($user_message == "Quotation,MethodStatement,LocationMap") {
        FEUPRedirect('create-quote/?print=QuotationMethodStatementLocationMap');
    } else if ($user_message == "Quotation,MethodStatement,LocationMap,Materials") {
        FEUPRedirect('create-quote/?print=QuotationMethodStatementLocationMapMaterials');
    } else if ($user_message == "Materials") {
        FEUPRedirect('create-quote/?print=Materials');
    } else if ($user_message == "Quotation,Materials") {
        FEUPRedirect('create-quote/?print=QuotationMaterials');
    } else if ($user_message == "Quotation,MethodStatement,Materials") {
        FEUPRedirect('create-quote/?print=QuotationMethodStatementMaterials');
    } else if ($user_message == "MethodStatement,LocationMap,Materials") {
        FEUPRedirect('create-quote/?print=MethodStatementLocationMapMaterials');
    } else if ($user_message == "LocationMap,Materials") {
        FEUPRedirect('create-quote/?print=LocationMapMaterials');
    } else if ($user_message == "MethodStatement,Materials") {
        FEUPRedirect('create-quote/?print=MethodStatementMaterials');
    } else if ($user_message == "Quotation,LocationMap,Materials") {
        FEUPRedirect('create-quote/?print=QuotationLocationMapMaterials');
    }


    if ($CheckCookie['Username'] == '') {
        FEUPRedirect('user-login');
    }
    $Sql = "SELECT * FROM $ewd_feup_fields_table_name WHERE Field_Show_In_Front_End='Yes' ORDER BY Field_Order";
    $Fields = $wpdb->get_results($Sql);
    $User = $wpdb->get_row($wpdb->prepare("SELECT ID as User_ID  FROM " . $wpdb->prefix . "users WHERE id='%s'", $CheckCookie['User_ID']));
    $UserData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $ewd_feup_user_fields_table_name WHERE User_ID='%d'", $User->User_ID));

    $ReturnString = "";
    // Get the attributes passed by the shortcode, and store them in new variables for processing
    extract(shortcode_atts(array(
        'redirect_page' => '#',
        'login_page' => '',
        'omit_fields' => '',
        'submit_text' => __('Edit Profile', 'EWD_FEUP')), $atts
            )
    );



    $ReturnString .= "<style type='text/css'>";
    $ReturnString .= $Custom_CSS;
    $ReturnString .='.error{ color: red;}';
    $ReturnString .= '.modal-backdrop.in{ display:none;}';
    $ReturnString .= '.gates{ height:30px;}';
    $ReturnString .= '.filter_select{ margin-right:10px;}';
    $ReturnString .='.stopall{pointer-events:none !important;cursor:progress !important;}';
    $ReturnString .='#gate_type_2,#gate_type_1,#gate_type_3{width:130px !important;}';
    $ReturnString .='#gate_type_4{width:500px !important;}';
    $ReturnString .='#oranz{color:#FC6 !important;}';
    $ReturnString .='#para1{padding-bottom:8px !important;}';
    $ReturnString .='#addressdetails{ font-size: 20px;margin-top: 12px;margin-bottom: -17px;}';
    $ReturnString .='.posts_select{margin-bottom:5px;width:73%}';
    $ReturnString .= '#waittextwrap{text-align:center;margin-top:5px;font-size:14px;color:green}';
    $ReturnString .= '.grid_layout{margin-top:35px;}';
    $ReturnString .= '.numericinput{width:50%;}';
    $ReturnString .= '#tabledata_cms td {height:71px; border:none;}';
    $ReturnString .= '.numericinput_summary{width:70%;}';
    $ReturnString .= '.lowopacity{opacity : 0.5; pointer-events: none;}';
    $ReturnString .= '.form_field_wrap{margin-bottom: 15px;}';
    $ReturnString .='.page1text{width:100px;}';
    $ReturnString .='#sm_cost .form_field_wrap{margin-bottom: 25px !important;}';
    $ReturnString .='#sm_markup .form_field_wrap{margin-bottom: 8px !important;}';
    $ReturnString .='#sm_profit .form_field_wrap{margin-bottom: 26px !important;}';
    $ReturnString .= "</style>";
    $ReturnString .='<script>';
    $ReturnString .='var ajaxurl="' . admin_url('admin-ajax.php') . '"';
    $ReturnString .='</script>';
    if ($CheckCookie['Username'] == "") {
        $ReturnString .= __('You must be logged in to access this page.', 'EWD_FEUP');
        if ($login_page != "") {
            $ReturnString .= "<br />" . __('Please', 'EWD_FEUP') . " <a href='" . $login_page . "'>" . __('login', 'EWD_FEUP') . "</a> " . __('to continue.', 'EWD_FEUP');
        }
        return $ReturnString;
    }


    if (isset($_REQUEST['step']) && $_REQUEST['step'] == '1') {
		

        session_regenerate_id();
        $ReturnString .="<link rel='stylesheet' id='ls-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900%7COpen+Sans:300%7CIndie+Flower:regular%7COswald:300,regular,700&#038;subset=latin%2Clatin-ext' type='text/css' media='all' />";
	
        $ReturnString .='<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6O6hImWyPBCGI8RkA1sdNvzbQD3Lgle0#;v=3.exp&#038;ver=4.1.3" type="text/javascript"></script>';     echo 'pluginurl'.plugin_dir_path( __FILE__ );
        $ReturnString .='<script src="' . plugins_url("quotation-google-map/js/quotation-map.js") . '" type="text/javascript"></script>';
	
    }
    $ReturnString .='<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>';
    $ReturnString .='<script src="' . plugins_url("quotation-google-map/js/jquery.validate.js") . '"></script>';
    $ReturnString .='<script src="' . plugins_url("quotation-google-map/js/bootstrap.min.js") . '"></script>';

    $ReturnString .='<script src="' . plugins_url("quotation-google-map/js/product_google_quote.js") . '" type="text/javascript"></script>';
    $ReturnString .='<script src="' . plugins_url("quotation-google-map/js/numeric.js") . '" type="text/javascript"></script>';
    $ReturnString .='<script>';
    $ReturnString .="jQuery(document).ready(function(){jQuery('input.numeric').numeric();});";
    $ReturnString .='</script>';

    if ($feup_success and $redirect_page != '#') {
        FEUPRedirect($redirect_page);
    }

    $ReturnString .='<link rel="stylesheet" href="' . plugins_url("TorCo/css/bootstrap.min.css?ver=4.2.2") . '">';
    /* $ReturnString .='<link rel="stylesheet" href="'.plugins_url("quotation-google-map/css/bootstrap.min.css").'">'; */

    /* $ReturnString .='<link rel="stylesheet" href="'.plugins_url("quotation-google-map/css/bootstrap.min.css").'">'; */

    /* help popup */
    if ($_REQUEST['step'] < 7) {
        $ReturnString .='<div id="myModal" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Help</h4>
                </div>
                <div class="modal-body">
                    <p>';
        /* Display page content on help popup */
        $step_no = $_REQUEST['step'];

        if ($step_no == '1') {
            $page_name = 'Quote Builder Help 1';
        } elseif ($step_no == '2') {
            $page_name = 'Quote Builder Help 2';
        } elseif ($step_no == '3') {
            $page_name = 'Quote Builder Help 3';
        } elseif ($step_no == '4') {
            $page_name = 'Quote Builder Help 4';
        } elseif ($step_no == '5') {
            $page_name = 'Quote Builder Help 5';
        } elseif ($step_no == '6') {
            $page_name = 'Quote Builder Help 6';
        }

        if (isset($page_name)) {
            $page = get_page_by_title($page_name);
            $content = apply_filters('the_content', $page->post_content);
            $ReturnString .=$content;
        }
        $ReturnString .='</p>                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
                </div>
            </div>
       </div>    
    </div>';
    }


    if (isset($step_no) && $step_no == 1) {
        $ReturnString .='<div id="myModalLoadFence" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Project</h4>
                </div>
                <div class="modal-body">
                    <label for="cmsms_name_required">Select Your Project</label>
					<select name="loadFenceSelect" id="loadFenceSelect">
					<option value="">Select Project</option>
					';
        $GetLoadFenceByID = GetLoadFenceByID($User->User_ID);
        if (count($GetLoadFenceByID) > 0) {
            foreach ($GetLoadFenceByID as $GLFI) {
                $ReturnString .='<option value="' . $GLFI->ID . '">' . $GLFI->Name . '</option>';
            }
        }
        $ReturnString .='</select>
				</div>
                <div class="modal-footer">
				    <button type="button" class="btn btn-default" id="delete_fence_button" value="Delete Fence">Delete Fence</button>  
					<button type="button" class="btn btn-default" id="load_fence_button" value="Load Fence" >Load Fence</button>  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
                </div>
            </div>
       </div>    
    </div>';
    }
    if (isset($step_no) && $step_no == 2) {
        $ReturnString .='<div id="myModalLoadFavouriteQuote" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Favourite Quote</h4>
                </div>
                <div class="modal-body"><input type="hidden" id="siteurl" value="' . site_url() . '">
                    <label for="cmsms_name_required">Select Your Favourite Quote</label>
					<select name="loadFavouriteQuoteSelect" id="loadFavouriteQuoteeSelect">
					<option value="">Select Favourite Spec.</option>
					';
        $GetLoadFavouriteQuoteByID = GetLoadFavouriteQuoteByID($User->User_ID);
        if (count($GetLoadFavouriteQuoteByID) > 0) {
            foreach ($GetLoadFavouriteQuoteByID as $GLFI) {
                $ReturnString .='<option value="' . $GLFI->quotation_id . '">' . (($GLFI->favourite_spec_title == "") ? GetStep1Data('contract_title', $GLFI->quotation_id) : $GLFI->favourite_spec_title ) . '</option>';
            }
        }
        $ReturnString .='</select>
				</div>
                <div class="modal-footer">
				     <button type="button" class="btn btn-default" id="delete_favourite_quote_button" value="Delete favourite spec." >Delete favourite spec.</button> 
					<button type="button" class="btn btn-default" id="load_favourite_quote_button" value="Load favourite spec." >Load favourite spec.</button>  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
                </div>
            </div>
       </div>    
    </div>';
    }

    if (isset($step_no) && $step_no == 4) {
        $ReturnString .='<div id="myModalLoadFavouriteQuoteWithPrice" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Favourite Price</h4>
                </div>
                <div class="modal-body"><input type="hidden" id="siteurl" value="' . site_url() . '">
                    <label for="cmsms_name_required">Select Your Favourite Price</label>
					<select name="loadFavouriteQuoteWithPriceSelect" id="loadFavouriteQuoteWithPriceSelect">
					<option value="">Select Favourite  price</option>';
        $GetLoadFavouriteQuoteWithPriceByID = GetLoadFavouriteQuoteWithPriceByID($User->User_ID);
        if (count($GetLoadFavouriteQuoteWithPriceByID) > 0) {
            foreach ($GetLoadFavouriteQuoteWithPriceByID as $GLFIP) {
                if ($_REQUEST['quotation_id'] == $GLFIP->quotation_id) {
                    $ReturnString .='<option value="' . $GLFIP->quotation_id . '" selected="selected">' . (($GLFIP->favourite_spec_title == "") ? GetStep1Data('contract_title', $GLFIP->quotation_id) : $GLFIP->favourite_spec_title ) . '</option>';
                } else {
                    $ReturnString .='<option value="' . $GLFIP->quotation_id . '">' . (($GLFIP->favourite_spec_title == "") ? GetStep1Data('contract_title', $GLFIP->quotation_id) : $GLFIP->favourite_spec_title ) . '</option>';
                }
            }
        }
        $ReturnString .='</select>
				</div>
                <div class="modal-footer">
				   <button type="button" class="btn btn-default" id="delete_favourite_quote_price_button" value="Delete favourite price." >Delete favourite price.</button>
					<button type="button" class="btn btn-default" id="load_favourite_quote_price_button" value="Load favourite price." >Load favourite price.</button>  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
                </div>
            </div>
       </div>    
    </div>';
    }

    if (isset($step_no) && $step_no == 5) {
        $ReturnString .='<div id="myModalLoadFavouriteQuoteWithMethod" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Favourite method statment</h4>
                </div>
                <div class="modal-body"><input type="hidden" id="siteurl" value="' . site_url() . '">
                    <label for="cmsms_name_required">Favourite Method Statment</label>
					<select name="loadFavouriteQuoteWithMethodSelect" id="loadFavouriteQuoteWithMethodSelect">
					<option value="">Select Favourite  Method Statment</option>';
        $GetLoadFavouriteQuoteWithMethodByID = GetLoadFavouriteQuoteWithMethodByID($User->User_ID);
        if (count($GetLoadFavouriteQuoteWithMethodByID) > 0) {
            foreach ($GetLoadFavouriteQuoteWithMethodByID as $GLMIP) {
                if ($_REQUEST['quotation_id'] == $GLMIP->quotation_id) {
                    $ReturnString .='<option value="' . $GLMIP->quotation_id . '" selected="selected">' . (($GLMIP->favourite_spec_title == "") ? GetStep1Data('contract_title', $GLMIP->quotation_id) : $GLMIP->favourite_spec_title ) . '</option>';
                } else {
                    $ReturnString .='<option value="' . $GLMIP->quotation_id . '">' . (($GLMIP->favourite_spec_title == "") ? GetStep1Data('contract_title', $GLMIP->quotation_id) : $GLMIP->favourite_spec_title ) . '</option>';
                }
            }
        }
        $ReturnString .='</select>
				</div>
                <div class="modal-footer">
				   <button type="button" class="btn btn-default" id="delete_favourite_quote_method_button" value="Delete favourite Method Statment." >Delete favourite Method Statment.</button>
					<button type="button" class="btn btn-default" id="load_favourite_quote_method_button" value="Load favourite Method Statment." >Load favourite Method Statment.</button>  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
                </div>
            </div>
       </div>    
    </div>';
    }


    $ReturnString .= "<div id='ewd-feup-edit-profile-form-div'>";
    $site_url = site_url();
    $ReturnString .='<div style="width:100%; text-align:right;margin-top: 10px;padding-right: 30px;">';
    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 6) {
        $ReturnString .='<a href="' . $site_url . '/create-quote/?step=1" style="padding-right:10px;"><input type="button" value="Create another quote" ></a>';
        $ReturnString .='<a href="' . $site_url . '/edit-user-personal-info/" style="padding-right:10px;"><input type="button" value="Return to My Account page" ></a>';
    }

    $site_url = $site_url . '/user-login/';
    if (is_user_logged_in()) {
        $ReturnString .='<a href="' . wp_logout_url($site_url) . '"><input type="button" value="Logout" ></a>';
    }
    $ReturnString .='</div>';
    if (isset($user_message['Message'])) {
        $ReturnString .= $user_message['Message'];
    }



    // Step 1
    if (isset($_REQUEST['step']) && $_REQUEST['step'] == '1') {
        //echo "session_id". session_id();
        $ReturnString .='<script> 
	jQuery(document).ready(function() {		
 
    jQuery("#ewd-feup-edit-profile-form").validate({
  rules: {
    customer_name: { lettersonly: true }
  }
});	
		

	}); </script>';
        $ReturnString .= "<form action='#' onsubmit=' return checkvalidation();' method='post' id='ewd-feup-edit-profile-form' class='pure-form pure-form-aligned' enctype='multipart/form-data'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-check' value='" . sha1(md5($Time . $Salt)) . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-time' value='" . $Time . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-action' value='process-step-1'>";
        $ReturnString .= "<input type='hidden' name='Omit_Fields' value='" . $omit_fields . "'>";
        $ReturnString .= "<input type='hidden' name='Omit_user_id' id='Omit_user_id' value='" . $User->User_ID . "'>";

        $ReturnString .='<p><h2>Plan fence line</h2><hr></p>';
        $ReturnString .='<div class="cmsms_row">';
        $ReturnString .= '<div class="cmsms_column one_first">';

        $ReturnString .='<div class="form_info cmsms_input one_fourth"><label for="cmsms_name_required">Contract Title</label><div class="form_field_wrap"><input type="text" class="required" name="contract_title" id="contract_title"  placeholder="Contract Title" value=""/></div></div>';

        $ReturnString .='<div class="form_info cmsms_input one_fourth"><label for="cmsms_name_required">Customer Name</label><div class="form_field_wrap"><input type="text" name="customer_name" class="required" id="customer_name"  placeholder="Customer Name" value=""/></div></div>';

        $ReturnString .='<div class="cmsms_input one_fourth form_info"><label for="cmsms_name_required">Customer Address</label><br/><textarea placeholder="Customer Address" name="customer_address" class="required"  id="customer_address" style="height:36px;"></textarea></div>';

        $ReturnString .='<div class="form_info cmsms_input"><label for="cmsms_name_required" class="reference_number_custom">Reference Number</label><div class="form_field_wrap"><input type="text" class="required" name="reference_number" id="reference_number"  placeholder="Reference number" value="' . mt_rand(100000, 999999) . '"/></div></div>';
        $ReturnString .='<div class="form_info cmsms_input one_fourth"><label for="cmsms_name_required">Customer Town</label><div class="form_field_wrap"><input type="text" value="" placeholder="Customer Town" id="customer_town" class="required" name="customer_town" aria-required="true"></div></div>';
        $ReturnString .='<div class="form_info cmsms_input one_fourth"><label for="cmsms_name_required">Customer County</label><div class="form_field_wrap"><input type="text" value="" placeholder="Customer County" id="customer_county" class="required" name="customer_county" aria-required="true"></div></div>';
        $ReturnString .='<div class="cmsms_column one_second" style="margin-top: 29px;margin-left: 17px;"><input type="text" name="postcode" id="postcode"  placeholder="Post Code" value=""/>&nbsp;&nbsp;&nbsp;';
        $ReturnString .='<input type="button" name="getlocationpostcode"  value="Locate" onclick="addMarkerByButtonPostcode()"/>';
        $ReturnString .='<p id="addressdetails"></p></div>';


        $ReturnString .='<p></p>';

        $ReturnString .='<div style="height:50px;clear:both;float: right;"><input type="button" class="my_fence_stop" value="Add another Fence" style=" float: left;" /></a><a href="#myModal" class="" data-toggle="modal"><a href="#myModalLoadFence" class="" data-toggle="modal"><input type="button" id="load_fence" value="Load Fence" style=" float: left;" /></a><a href="#myModal" class="" data-toggle="modal"><input type="button" id="help" value="Help" style="margin-right:10px; float:right;"></a><input type="button" id="resetroute" value="Reset Route" style="margin-right:10px; float:left;margin-left: 10px;" onclick="removeAll();"></div>';

        $ReturnString .= ' <table class="cmsms_table">
                      <tbody>';

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<th>Map</th>
	
	</tr>';
        $ReturnString .= '<tr>	
	<td class="map"><div id="map-canvas" style="height: 400px; margin-bottom: 15px;"></div></td>
	</tr>';
        $ReturnString .= ' </tbody>
                      </table>';

        $ReturnString .= '</div>';





        $ReturnString .= '<div class="cmsms_column one_first">';

        $ReturnString .= ' <table class="cmsms_table" id="cmsms_table">
                      <tbody>';
        $ReturnString .= '<tr class="cmsms_table_row_header">
	<th>Fence Details</th>
	<th id="fence_details_head" style="width: 50%;"></th>
	</tr>';

        $ReturnString .= '<tr id="fence_type">
	<td >Fence type – open or closed (tick box to connect final post to first post)</td>
	<td align="right" class="align-right firstFence" id="original_fence_type"><input type="checkbox" class="align-right" id="closedFence" style="margin:0">&nbsp;<span id="closedFence_text">Open Fence 1</span></td>
	
	</tr>';

        $ReturnString .= '<tr id="fence_line">
	<td >Length of fence line</td>
	<td align="right" class="align-right firstFence" id="length_of_fence_line"><input type ="text" class="page1text required number" id="routeLength" class="page1text" name="routeLength" readonly="true"/>&nbsp;Metre	<input type ="hidden" class="page1text" id="markerlength" class="page1text" name="markerlength" />	</td>
	</tr>';

        $ReturnString .= '<tr id="intermediate_posts">
	<td >Distance between intermediate posts</td>
	<td align="right" class="align-right firstFence"><input type="number" min="1" max="10" step="0.1" class="align-right" style="width: 59px;height:32px;" value="5" name="subPostsGap" id="subPostsGap">&nbsp;Metre</td>
	</tr>';

        $ReturnString .= '<tr id="strainer_posts">
	<td >Number of strainer posts</td>
    <td align="right" class="align-right firstFence"><input type ="text" class="page1text strainerposts required number" id="amount_mainPosts" name="amount_mainPosts" readonly="true"/>&nbsp;Post</td>
	</tr>';
        $ReturnString .= '<tr id="intermediate_posts_num">
	<td >Number of intermediate posts</td>
	<td align="right" class="align-right firstFence"><input type ="text" class="page1text  required number" id="amount_subPosts" name="amount_subPosts" readonly="true"/>&nbsp;Post</td>
	</tr>';


        /* $ReturnString .= '<tr>
          <td>Number of staples</td>
          <td align="right" class="align-right"><span id="amount_staples">0</span></td>
          </tr>'; */


        $ReturnString .= '<tr>
	<td id="gates">Gates</td>
	<td align="right" class="align-right" colspan="2">
	<table class="cmsms_table">
	<tr>
	<td>';
        $Product_List = Quote_Process_List('gates');
        //$Product_List = Quote_Process_List('gates');
        $Other_ProductGate_List = Quote_Process_ListByOtherGate();
        //print_r($Other_ProductGate_List);

        $ReturnString .= '<select id="gate_type_1" name="gate_type_1">';

        $ReturnString .= '<option value="">Gate Type 1</option>';

        foreach ($Product_List as $PLR) {
            $ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
        }

        if (count($Other_ProductGate_List) > 0) {
            foreach ($Other_ProductGate_List as $OPLG) {
                $ReturnString .='<option value="' . $OPLG->product_id . '">' . $OPLG->otherproductname . '</option>';
            }
        }


        $ReturnString .='</select>';

        $ReturnString .= '</td><td align="right"><input type="number" min="0" max="100" step="1" class="align-right gate_count" style="width: 59px;height:32px;" value="0" id="gate_type_1_number" name="gate_type_1_number" onchange="check_gate_type1();">&nbsp;Gates</td>
	</tr>
    <tbody>
	<tr>
	<td>';
        $Product_List = Quote_Process_List('gates');
        $ReturnString .= '<select id="gate_type_2" name="gate_type_2">';

        $ReturnString .= '<option value="">Gate Type 2</option>';

        foreach ($Product_List as $PLR) {
            $ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
        }
        if (count($Other_ProductGate_List) > 0) {
            foreach ($Other_ProductGate_List as $OPLG) {
                $ReturnString .='<option value="' . $OPLG->product_id . '">' . $OPLG->otherproductname . '</option>';
            }
        }

        $ReturnString .='</select>';
        $ReturnString .='</td>
	<td align="right"><input type="number" min="0" max="100" step="1" class="align-right gate_count" style="width: 59px;height:32px;" value="0" id="gate_type_2_number" name="gate_type_2_number" onchange="check_gate_type2();">&nbsp;Gates</td>
	</tr>
	<tr>
	<td>';
        $Product_List = Quote_Process_List('gates');
        $ReturnString .= '<select id="gate_type_3" name="gate_type_3">';

        $ReturnString .= '<option value="">Gate Type 3</option>';

        foreach ($Product_List as $PLR) {
            $ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
        }
        if (count($Other_ProductGate_List) > 0) {
            foreach ($Other_ProductGate_List as $OPLG) {
                $ReturnString .='<option value="' . $OPLG->product_id . '">' . $OPLG->otherproductname . '</option>';
            }
        }

        $ReturnString .='</select>';
        $ReturnString .='</td>
	<td align="right"><input type="number" min="0" max="100" step="1" class="align-right gate_count" style="width: 59px;height:32px;" value="0" id="gate_type_3_number" name="gate_type_3_number" onchange="check_gate_type3();">&nbsp;Gates</td>



	</tr>
	</tbody>
	</table>
	</td>
	</tr>';


        $ReturnString .= '<tr>
	<td></td>
	<td align="right" class="align-right complete"><input type="submit" id="next" name="next" value="Fence line complete – next step"/></td>
	
	</tr>';
        $ReturnString .= ' </tbody>
                      </table>';

        $ReturnString .='</div>';


        $ReturnString .='</div>';

        $ReturnString .='<input type="hidden" name="step" id="step" value="step1"/>';
        $ReturnString .='<input type="hidden" name="post_types_map" id="post_types_map" value=""/>';
        $ReturnString .='<input type="hidden" name="post_map_potitions" id="post_map_potitions" value=""/>';
        $ReturnString .='<input type="hidden" name="is_corner_post" id="is_corner_post" value=""/>';
        $ReturnString .='<input type="hidden" name="post_types_map_count_value" id="post_types_map_count_value" value=""/>';
		$ReturnString .='<input type="hidden" id="fence_length" value="">';
		$ReturnString .='<input type="hidden" name ="array_fence_length[]" id="array_fence_length" value="">';
        $ReturnString .= "</form>";
        $ReturnString .= "</div>";

        return $ReturnString;
    }
    /* #####################################
      ############## STEP 2##################
      /*Step @2 */
    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 2) {
        /* this code is used for step 2 validation */

        $ReturnString .='
      <script> 
	jQuery(document).ready(function() {		
     	
		jQuery("#ewd-feup-edit-profile-form").validate({
			errorElement: "div",
			rules: {
				net_wire: "required",				
				staples: { required:{
                                             depends: function(element) {
                                             return jQuery("#net_wire option:selected").val() != "0";
                                             }
                                         }} ,
				joiner: { 
                                        required:{
                                             depends: function(element) {
                                             return jQuery("#net_wire option:selected").val() != "0";
                                             }
                                         }  
                                        },
				terminations: { required:{
                                             depends: function(element) {
                                             return jQuery("#net_wire option:selected").val() != "0";
                                             }
                                         }}
				
			},
			messages: {
				net_wire: "Please select net wire",				
				staples: "Please select staples",
				joiner: "Please select joiner",
				terminations: "Please select terminations"
			}
			
			
		});	
		

	}); </script>';
        /* end here */

        $ReturnString .= "<form action='#' method='post' id='ewd-feup-edit-profile-form' class='pure-form pure-form-aligned step_2_form' enctype='multipart/form-data'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-check' value='" . sha1(md5($Time . $Salt)) . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-time' value='" . $Time . "'>";
        $ReturnString .= "<input type='hidden' id='ewd-feup-action' name='ewd-feup-action' value='process-step-2'>";
        $ReturnString .= "<input type='hidden' name='Omit_Fields' value='" . $omit_fields . "'>";
        $ReturnString .= "<input type='hidden' name='Omit_user_id' id='Omit_user_id' value='" . $User->User_ID . "'>";


        $ReturnString .='<p></p>';
        $ReturnString .='<div class="cmsms_row">';

        $ReturnString .= '<div class="cmsms_column one_first">';
        $ReturnString .='<div class="headline_text"><h1 class="entry-title">Configure your fence</h1></div>';
        $ReturnString .='<div style="height:50px;"><a href="#myModalLoadFavouriteQuote" class="" data-toggle="modal"><input type="button" id="load_favourite_quote" value="Load favourite spec." style=" float: left;margin-left: 71%;" /></a> <a href="#myModal" class="" data-toggle="modal"><input type="button" id="help" value="Help" style="margin-right:10px; float:right;"></a></div>';
        $ReturnString .= ' <table class="cmsms_table">
                      <tbody>';

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Net</td>
	</tr>';

        $ReturnString .= '<tr>
	<td colspan="2">
	 <div class="cmsms_column one_first" style="margin-bottom:5px;">';

        $ReturnString .= '<select id ="knot_type" name="knot_type" class="filter_select">';
        $ReturnString .= '<option value="">Knot type</option>';
        $select_knot = Quote_Process_ListByType('Knot type'); //mysql_query("Select * from $ewd_product_categories where type='Knot type'");
        foreach ($select_knot as $SK) {
            $ReturnString.= '<option value="' . $SK->category_id . '">' . $SK->name . '</option>';
        }
        $ReturnString .= '</select>';

        $ReturnString .= '<select id ="wire_specification" name="wire_specification" class="filter_select">';
        $ReturnString .= '<option value="">Wire specification</option>';
        $wire_spec = Quote_Process_ListByType('Wire specification'); //mysql_query("Select * from $ewd_product_categories where type='Knot type'");
        foreach ($wire_spec as $WS) {
            $ReturnString.= '<option value="' . $WS->category_id . '">' . $WS->name . '</option>';
        }
        $ReturnString .= '</select>';


        $ReturnString .= '<select name="application_1" id="application_1" style="width:133px" class="filter_select">';
        $ReturnString .= '<option value="">Application</option>';
        $ap1 = Quote_Process_ListByType('Application 1');
        foreach ($ap1 as $AP1) {
            $ReturnString.= '<option title="application1" value="' . $AP1->category_id . '">' . $AP1->name . '</option>';
        }
        $ap2 = Quote_Process_ListByType('Application 2');
        foreach ($ap2 as $AP2) {
            $ReturnString.= '<option title="application2" value="' . $AP2->category_id . '">' . $AP2->name . '</option>';
        }
        $ReturnString .= '</select>';
		
		$j=1;
		$count=0;
		
		while(1){
			$val=GetStep1Data('routeLength_'.$j++);
			if(trim($val)=='')
				break; 
			else{
				$count++;
			}
		}
		
		if($count > 0){
			$j=1;
			$ReturnString .= '<select id="fence" style="width:133px">';
			$ReturnString .= '<option value="0">All</option>';
			while(1){
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break; 
				else{
					
					$ReturnString .= '<option value='.$j.'>Fence '.$j++.'</option>';
					
				}
					
			}
			$ReturnString .= '</select>&nbsp;';
		}


        $ReturnString .= '<a href="javascript:;" id="reset_filter" name="reset_filter">Reset Filters</a>';

        $ReturnString .='<p id="waittextwrap"></p>';

        $ReturnString .='</div>';

        $ReturnString .='</td>
   </td>
	</tr>';

        $ReturnString .='<tr>';
        $ReturnString .='<td>';
        $ReturnString .= 'Fence Net';
        $ReturnString .='</td>';
		$j=1;
		$colcount=0;
		while(1){
			$val=GetStep1Data('routeLength_'.$j++);
			if(trim($val)=='')
				break; 
			else
				$colcount++;	
		}
	
		if($colcount==0) {
			$ReturnString .='<td>';
			$ReturnString .= '<div class="cmsms_column one_first">';

			$Product_List = Quote_Process_List('fence_wire');
			$ReturnString .= '<select id="net_wire" name="net_wire">';

			$ReturnString .= '<option value="">Select Net Wire</option>';
			$ReturnString .='<option value="0">no net required</option>';
			foreach ($Product_List as $PLR) {
				$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
			}

			$ReturnString .='</select>&nbsp;&nbsp;<p id="fence_wait"></p>';

			$ReturnString .='</div>';
			$ReturnString .='</td>';
		}
		
		else{
			$j=1;
			$ReturnString .='<td>';
			$ReturnString .='<table>';
			$ReturnString .='<tr>';
			while(1){
				$val='';
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break;
				else{
					
					
					$ReturnString .='<td style="border:none">';
					//$ReturnString .='<div class="cmsms_column">';
					
					$Product_List = Quote_Process_List('fence_wire');
					
					$ReturnString .= '<select id="net_wire_'.$j.'" name="net_wire_'.$j.'" class="net_wire" style="width:100%" required>';
					$ReturnString .= '<option value="">Select Net Wire</option>';
					$ReturnString .='<option value="0">no net required</option>';
					foreach ($Product_List as $PLR) {
						$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
					}
					
					$ReturnString .='</select>&nbsp;&nbsp;<p id="fence_wait_'.$j++.'"></p>';
					
					//$ReturnString .='</div>';
					$ReturnString .='</td>';
					
					
				}
			}
			
			$ReturnString .='</tr>';
			$ReturnString .='</table>';
			
			$ReturnString .='</td>';
		}
        $ReturnString .='</tr>';

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Additional Wires</td>
	</tr>';

		$j=1;
		$colcount=0;
		while(1){
			$val=GetStep1Data('routeLength_'.$j++);
			if(trim($val)=='')
				break; 
			else
				$colcount++;	
		}
			
			$ReturnString .= '<tr>';
			
			if($colcount > 1)
				$ReturnString .='<td style="width:15%"> Top Line Wire 1';
			else
				$ReturnString .='<td> Top Line Wire 1';
			
			$ReturnString .='</td>';
			$ReturnString .='<td>';
			
			if($colcount==0){
				$ReturnString .='<select name="top_line_wire_1" id="top_line_wire_1">';
				$ReturnString .='<option value="">Top Line Wire 1</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="top_line_wire_1_'.$j.'" id="top_line_wire_1_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Top Line Wire 1</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			}
			
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';

			$ReturnString .= '<tr>';
			$ReturnString .='<td> Top line Wire 2';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
				if($colcount==0){
				$ReturnString .='<select name="top_line_wire_2" id="top_line_wire_2">';
				$ReturnString .='<option value="">Top Line Wire 2</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="top_line_wire_2_'.$j.'" id="top_line_wire_2_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Top Line Wire 2</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			}
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';



			$ReturnString .= '<tr>';
			$ReturnString .='<td>Top Line Wire 3';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
				if($colcount==0){
				$ReturnString .='<select name="top_line_wire_3" id="top_line_wire_3">';
				$ReturnString .='<option value="">Top Line Wire 3</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="top_line_wire_3_'.$j.'" id="top_line_wire_3_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Top Line Wire 3</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			}
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';



			$ReturnString .= '<tr>';
			$ReturnString .='<td>Top Line Wire 4';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
				if($colcount==0){
				$ReturnString .='<select name="top_line_wire_4" id="top_line_wire_4">';
				$ReturnString .='<option value="">Top Line Wire 4</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="top_line_wire_4_'.$j.'" id="top_line_wire_4_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Top Line Wire 4</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			}
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';


			$ReturnString .= '<tr>';
			$ReturnString .='<td> Top Line Wire 5';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
				if($colcount==0){
				$ReturnString .='<select name="top_line_wire_5" id="top_line_wire_5">';
				$ReturnString .='<option value="">Top Line Wire 5</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="top_line_wire_5_'.$j.'" id="top_line_wire_5_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Top Line Wire 5</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			};
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';


			$ReturnString .= '<tr>';
			$ReturnString .='<td> Top Line Wire 6';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
				if($colcount==0){
				$ReturnString .='<select name="top_line_wire_6" id="top_line_wire_6">';
				$ReturnString .='<option value="">Top Line Wire 6</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="top_line_wire_6_'.$j.'" id="top_line_wire_6_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Top Line Wire 6</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			}
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';


			$ReturnString .= '<tr>';
			$ReturnString .='<td>Bottom Line Wire';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
			if($colcount==0){
				$ReturnString .='<select name="bottom_line_wire" id="bottom_line_wire">';
				$ReturnString .='<option value="">Bottom Line Wire</option>';

				$Product_List = Quote_Process_List('plain_wire');
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}

				$ReturnString .='</select>';
				
			}
			else{
				$j=1;
				$ReturnString.="<table>";
				$ReturnString.="<tbody>";
				$ReturnString.="<tr>";
				while(1){
					$val='';
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
							if($j>1)
								$style="margin-left:5px;";
							else
								$style='';
							
							$ReturnString .='<select name="bottom_line_wire_'.$j.'" id="bottom_line_wire_'.$j++.'" style="'.$style.'" >';
							$ReturnString .='<option value="">Bottom Line Wire</option>';

							$Product_List = Quote_Process_List('plain_wire');
							foreach ($Product_List as $PLR) {
								$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
							}

							$ReturnString .='</select>';
					}
				}
				
				$ReturnString.="</tr>";
				$ReturnString.="</tbody>";
				$ReturnString.="</table>";
			}
			$ReturnString .='</td>';
			$ReturnString .= '</tr>';
		
	
        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Staples</td>
	</tr>';
        $ReturnString .= '<tr>
	<td>Select Staples</td>
	<td>';
        $ReturnString .='<select name="staples" id="staples">';
        $ReturnString .='<option value="">Select Staples</option>';
        $Product_List = Quote_Process_List('fixing');
        foreach ($Product_List as $PLR) {
            $ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
        }

        $ReturnString .='</select>';
        $ReturnString .='</td></tr>';
	

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Joiners</td>
	</tr>';
	
	  
	  	$j=1;
	 $ReturnString .= '<tr >
	<td>Fence Length</td>
	';
	
	$ReturnString .='<td><table class="cmsms_table">';
	$ReturnString .='<tr>';
	if($colcount > 1){
		while(1){
			$val='';
			$val=GetStep1Data('routeLength_'.$j++);
			if(trim($val)=='')
				break;
			else{
					$ReturnString.="<td style='border:none'>".$val.' Meters'."</td>";
			}
		}
	}
	$fence_line_length = round(GetStep1Data('FenceLine'));
	$ReturnString .='<td style="border:none">'.$fence_line_length.' Meters</td>';
	$ReturnString .='</tr></td>';	
	$ReturnString .='</table>';
	
	$ReturnString.='</tr>';
	
	$ReturnString .= '<tr>';
	$ReturnString .= '<td>Select roll Length</td>';
	$ReturnString .= '<td><table class="cmsms_table">';
	$ReturnString .='<tr>';
	
	if($colcount > 1){
		$j=1;
		while(1){
			$val='';
			$val=GetStep1Data('routeLength_'.$j);
			if(trim($val)=='')
				break; 
			else{
				$width=(int)(100/($colcount+1))-1;
				
				if($j==1)
					$ReturnString .= '<td style="border:none;width:'.$width.'%"><select id="rollength_'.$j.'" class="rolllength rolllengthdynamic" data-length="'.GetStep1Data('routeLength_'.$j++).'"><option value="0">Select Rolls</option><option value="50">50m rolls</option><option value="100" selected="selected">100m rolls</option><option value="250">250m rolls</option><option value="500">500m rolls</option></select></td>';
				else{
					$k=$j+1;
					$val=GetStep1Data('routeLength_'.$k);
					
					if(trim($val)!='')
						$ReturnString .= '<td style="border:none;width:'.$width.'%""><select id="rollength_'.$j.'" class="rolllength rolllengthdynamic" data-length="'.GetStep1Data('routeLength_'.$j++).'"><option value="0">Select Rolls</option><option value="50">50m rolls</option><option value="100" selected="selected">100m rolls</option><option value="250">250m rolls</option><option value="500">500m rolls</option></select></td>';
					else
						$ReturnString .= '<td style="border:none;"><select id="rollength_'.$j.'" class="rolllength rolllengthdynamic" data-length="'.GetStep1Data('routeLength_'.$j++).'"><option value="0">Select Rolls</option><option value="50">50m rolls</option><option value="100" selected="selected">100m rolls</option><option value="250">250m rolls</option><option value="500">500m rolls</option></select></td>';
				}
				
				//$ReturnString .='<p>Not all products are available in all roll lengths above – please select an appropriate roll length for your chosen Tornado net</p></td>';
			}
		}
	}
	else{
		$ReturnString .= '<td style="border:none;"><select id="rollength" class="rolllength" data-length="'.GetStep1Data('routeLength').'"><option value="0">Select Rolls</option><option value="50">50m rolls</option><option value="100" selected="selected">100m rolls</option><option value="250">250m rolls</option><option value="500">500m rolls</option></select></td>';
	}
				
	$ReturnString .='</tr>';
	$ReturnString .='<tr><td style="border:none" colspan="'.($j).'">Not all products are available in all roll lengths above – please select an appropriate roll length for your chosen Tornado net</td></tr>';
	$ReturnString .= '</table></td>';
	$ReturnString .= '</tr>';
	 
	$ReturnString .= '<tr>';
	$ReturnString .= '<td>Select number of Joins</td>';
	$ReturnString .= '<td>';
	$ReturnString .='<table class="cmsms_table">';
	$ReturnString .='<tr>';
	
	$j=1;
	$colcount=0;
	while(1){
		$val=GetStep1Data('routeLength_'.$j++);
		if(trim($val)=='')
			break; 
		else
			$colcount++;	
	}
	
	if($colcount > 0){
	$j=1;
	while(1){
			$val='';
			$val=GetStep1Data('routeLength_'.$j);
			
			if(trim($val)=='')
				break;
			else{
				$ReturnString .= '<td style="border:none"><input type="text" value="" class="no_of_joiners" id="no_of_joiners_'.$j.'" name="no_of_joiners_'.$j.'" placeholder="No of Joiners" readonly/>
				&nbsp;&nbsp;&nbsp;
				<input type="number" value="1" min="1" max="100" step="1" class="align-right" style="width: 80px;height:32px;display:none;" value="0" id="joiners_amount_'.$j.'">
				<br/><br/>
				<select id="joiners_'.$j.'" name="joiner_'.$j++.'">
					<option value="">Select Joiner</option>
				';
				
				$Product_List = Quote_Process_List('joiners');
				$Product_listJoiners = Quote_Process_ListByOtherJoiners();
				
				foreach ($Product_List as $PLR) {
					$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
				}
				
				foreach ($Product_listJoiners as $PLRO) {
					$ReturnString .='<option value="' . $PLRO->product_id . '">' . $PLRO->otherproductname . '</option>';
				}
				
				
				$ReturnString .="</select></td>";
				
			}
		}
		
		
	}
	$ReturnString .= '<td style="border:none"><input type="text" value="" name="no_of_joiners" id="no_of_joiners" placeholder="No of Joiners" readonly/>&nbsp;&nbsp;&nbsp;
			<input type="number" value="1" min="1" max="100" step="1" class="align-right" style="width: 80px;height:32px;display:none;" value="0" name="joiners_amount" id="joiners_amount">
			<br/><br/>
			';
	
	if($colcount == 0){	
		$ReturnString .='<select id="joiners" name="joiner">
					<option value="">Select Joiner</option>';	
		$Product_List = Quote_Process_List('joiners');
		$Product_listJoiners = Quote_Process_ListByOtherJoiners();
				
		foreach ($Product_List as $PLR) {
			$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
		}

		foreach ($Product_listJoiners as $PLRO) {
			$ReturnString .='<option value="' . $PLRO->product_id . '">' . $PLRO->otherproductname . '</option>';
		}
		$ReturnString .='</select>';
	}
	
	$ReturnString .="</td>";
	
	$ReturnString .='</tr>';
	$ReturnString .='</table>';
	$ReturnString .= '</td>';
	$ReturnString .= '</tr>';

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Terminations</td>
	</tr>';

        $ReturnString .= '<tr >
	<td>Select Terminations</td>';
		
		$j=1;
		$colcount=0;
		while(1){
			$val=GetStep1Data('routeLength_'.$j++);
			if(trim($val)=='')
				break; 
			else
				$colcount++;	
		}
		
		if($colcount==0){
			$ReturnString .='<td>';
			$ReturnString .='<select name="terminations" id="terminations">';
			$ReturnString .='<option value="">Select Terminations</option>';
			$ReturnString .='<option value="Tie-off">Tie-off</option>';
			$ReturnString .='<option value="T-Clips">T-Clips</option>';
			$ReturnString .='<option value="Staple">Staple</option>';
			$ReturnString .='</select>&nbsp;&nbsp;<p id="term_wait"></p>';
			$ReturnString .='</td>';
		}
		else{
			$ReturnString .='<td>';
			$ReturnString .='<table class="cmsms_table">';
			$ReturnString .='<tr>';
			$j=1;
			while(1){
				$val='';
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break;
				else{
					$ReturnString .='<td style="border:none;">';
					$ReturnString .='<select name="terminations_'.$j.'" class="terminations" id="terminations_'.$j.'" style="width:100%" required>';
					$ReturnString .='<option value="">Select Terminations</option>';
					$ReturnString .='<option value="Tie-off">Tie-off</option>';
					$ReturnString .='<option value="T-Clips">T-Clips</option>';
					$ReturnString .='<option value="Staple">Staple</option>';
					$ReturnString .='</select>&nbsp;&nbsp;<p id="term_wait_'.$j++.'"></p>';
					$ReturnString .='</td>';
				}
			}
			$ReturnString .='</tr>';
			$ReturnString .='</table>';
			$ReturnString .='</td>';
		}
		
        $ReturnString .='</tr>';
		$j=1;
		$colcount=0;
		while(1){
			$val=GetStep1Data('routeLength_'.$j++);
			if(trim($val)=='')
				break; 
			else
				$colcount++;	
		}
		
		if($colcount==0){
			$ReturnString .= '<tr>
			<td></td>
			<td align="right" class="align-right">
			<input type="hidden" name="no_of_joiner_in_product" id="no_of_joiner_in_product" value="0"/>
			<input type="hidden" name="terminations_calculation" id="terminations_calculation" value=""/>
			<input type="submit" id="next" name="next" value="Next Step"/></td>
			</tr>';
		}
		
		else{
			$ReturnString .= '<tr>';
			$ReturnString .= '<td></td>';
			$ReturnString .= '<td align="right" class="align-right">';
			$j=1;
			while(1){
				$val='';
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break;
				else{
						$ReturnString.='<input type="hidden" name="no_of_joiner_in_product_'.$j.'" id="no_of_joiner_in_product_'.$j.'" value="0"/>';
						
						$ReturnString .= '<input type="hidden" name="terminations_calculation_'.$j.'" id="terminations_calculation_'.$j++.'" value=""/>';
				}
			}
			
			$ReturnString .= '<input type="submit" id="next" name="next" value="Next Step"/>';
			$ReturnString .= '</td>';
			
			$ReturnString .= '</tr>';
			
			
		}
		$ReturnString .= '<input type="hidden" name="terminations_calculation" id="terminations_calculation" value=""/>
			<input type="submit" id="next" name="next" value="Next Step"/></td>
			</tr>';
        $ReturnString .= ' </tbody>
                      </table>';

        $ReturnString .='</div>';


        $ReturnString .='</div>';

        $ReturnString .='<input type="hidden" name="step" id="step" value="step2"/>';

        $ReturnString .= "</form>";
        $ReturnString .= "</div>";

        return $ReturnString;
    }

    /* #####################################
      ############## STEP 3##################
      /*Step @3 */
    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 3) {

        /* this code is used for step 2 validation */

        $ReturnString .='<style>.posts_select {display:block !important}</style><script> 
	jQuery(document).ready(function() {		
     	
		jQuery("#ewd-feup-edit-profile-form").validate({
			errorElement: "div",
			rules: {
				intermediate_fence_post: "required",
				end_post_st_strainerposts: "required",
				end_post_st_struts: "required",
				corner_post_st_strainerposts: "required",
				corner_post_st_struts: "required",
				standard_gateway_st_strainerposts: "required",
				standard_gateway_st_struts: "required",
				free_standing_gateway_st_strainerposts: "required",
				free_standing_gateway_st_struts: "required",
				end_post_box_strainerposts: "required",
				end_post_box_crossrails: "required",
				end_post_box_Gpaks: "required",
				corner_post_box_strainerposts: "required",
				corner_post_box_crossrails: "required",
				corner_post_box_Gpaks: "required",
				standard_gateway_box_strainerposts: "required",
				standard_gateway_box_crossrails: "required",
				standard_gateway_box_Gpaks: "required",
				free_standing_gateway_box_strainerposts: "required",
				free_standing_gateway_box_crossrails: "required",
				free_standing_gateway_box_Gpaks: "required",
				turning_post_unstrutted_strainerposts: "required"
				
			}
		});	
		

	}); </script>';
        /* end here */
        $quotation_key = NULL;
        $quotation_id = NULL;
        /* if(isset($_REQUEST['quotation_id']) && $_REQUEST['quotation_id']!='')
          {
          $quotation_id = $_REQUEST['quotation_id'];
          $quotation_key = GetQuoteKeyByID($quotation_id);
          }else
          {
          $quotation_id = NULL;

          } */
        global $wpdb;

        $quotationdata = $wpdb->get_row("SELECT quotation_step3 FROM wp_ewd_quotation WHERE quotation_id = '" . $_REQUEST['quotation_id'] . "'");
        $quotation_step3 = unserialize($quotationdata->quotation_step3);



        $ReturnString .='<style type="text/css">';
        $ReturnString .='.one_third{ height:245px; }';
        $ReturnString .='.grid_layout{ margin-top:12px; }';
        $ReturnString .='</style>';
        $ReturnString .= "<form action='#' method='post' id='ewd-feup-edit-profile-form' class='pure-form pure-form-aligned' enctype='multipart/form-data'>";
        $ReturnString .='<input type="hidden" name="quotation_id" value="' . $quotation_id . '">';
        $ReturnString .= "<input type='hidden' name='ewd-feup-check' value='" . sha1(md5($Time . $Salt)) . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-time' value='" . $Time . "'>";
        $ReturnString .= "<input type='hidden' id='ewd-feup-action' name='ewd-feup-action' value='process-step-3'>";
        $ReturnString .= "<input type='hidden' name='Omit_Fields' value='" . $omit_fields . "'>";
        $ReturnString .= "<input type='hidden' name='Omit_user_id' id='Omit_user_id' value='" . $User->User_ID . "'>";


        $ReturnString .='<p></p>';
        $ReturnString .='<div class="cmsms_row">';

        $ReturnString .= '<div class="cmsms_column one_first">';
        $ReturnString .='<div class="headline_text"><h1 class="entry-title">Select Posts</h1></div>';
        $ReturnString .='<div style="height:50px;"> <span id="wait" style="color:rgba(255, 204, 102, 1); display:none;">saving..</span><span id="element" style="color:green; display:none;">Saved</span>	
	<a href="#myModal" class="" data-toggle="modal"><input type="button" id="help" value="Help" style="margin-right:10px; float:right;"></a>&nbsp;&nbsp;</div>';
        $ReturnString .= ' <table class="cmsms_table">
                      <tbody>';

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Intermediate Posts</td>
	</tr>';

		//start code here
		$j=1;
		$count=0;
		while(1){
			$val=GetStep1Data('routeLength_'.$j++);
			
			if(trim($val)=='')
				break; 
			else
				$count++;
		}
		
		if($count > 0){
			$ReturnString .='<tr>';
			$ReturnString .='<td>';
			$ReturnString .= 'Select Intermediate Post';
			$ReturnString .='</td>';
			$ReturnString .='<td>';
			$ReturnString.="<table>";
			$ReturnString.="<tr>";
			$j=1;
			while(1){
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break; 
				else{
					$ReturnString.="<td style='border:none'>";
					$ReturnString .= '<div class="cmsms_column one_first">';
					
					$Product_List = Quote_Process_ListByPostType('intermediate_post');
					$Other_Product_List = Quote_Process_ListByOtherPostType('intermediate_post');
					$selected_intermediate_fence_post = $quotation_step3['intermediate_fence_post'];
					
					 $ReturnString .= '<select id="intermediate_fence_post_'.$j.'" name="intermediate_fence_post_'.$j++.'">';
					 
					 $ReturnString .= '<option value="">Select intermediate post</option>';
					 foreach ($Product_List as $PLR) {
						if ($selected_intermediate_fence_post == $PLR->product_id) {
							$ReturnString .='<option value="' . $PLR->product_id . '" selected="selected">' . $PLR->product_name . '</option>';
						} else {
							$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
						}
					}
					if (count($Other_Product_List) > 0) {
						foreach ($Other_Product_List as $OPLR) {
							if ($selected_intermediate_fence_post == $OPLR->product_id) {
								$ReturnString .='<option value="' . $OPLR->product_id . '" selected="selected">' . $OPLR->otherproductname . '</option>';
							} else {
								$ReturnString .='<option value="' . $OPLR->product_id . '">' . $OPLR->otherproductname . '</option>';
							}
						}
					}
					 
					 $ReturnString .= '</select>';
					
					$ReturnString .= '</div>';
					$ReturnString.="</td>";
				}
			}
			
			$ReturnString.="</tr>";
			$ReturnString.="</table>";
			$ReturnString .='</td>';
			$ReturnString .='</tr>';
		}
		else{
			    $ReturnString .='<tr>';
				$ReturnString .='<td>';
				$ReturnString .= 'Select Intermediate Post';
				$ReturnString .='</td>';
				$ReturnString .='<td>';
				$ReturnString .= '<div class="cmsms_column one_first">';

				$Product_List = Quote_Process_ListByPostType('intermediate_post');
				$Other_Product_List = Quote_Process_ListByOtherPostType('intermediate_post');

				$selected_intermediate_fence_post = $quotation_step3['intermediate_fence_post'];

				$ReturnString .= '<select id="intermediate_fence_post" name="intermediate_fence_post">';

				$ReturnString .= '<option value="">Select intermediate post</option>';
				foreach ($Product_List as $PLR) {
					if ($selected_intermediate_fence_post == $PLR->product_id) {
						$ReturnString .='<option value="' . $PLR->product_id . '" selected="selected">' . $PLR->product_name . '</option>';
					} else {
						$ReturnString .='<option value="' . $PLR->product_id . '">' . $PLR->product_name . '</option>';
					}
				}
				if (count($Other_Product_List) > 0) {
					foreach ($Other_Product_List as $OPLR) {
						if ($selected_intermediate_fence_post == $OPLR->product_id) {
							$ReturnString .='<option value="' . $OPLR->product_id . '" selected="selected">' . $OPLR->otherproductname . '</option>';
						} else {
							$ReturnString .='<option value="' . $OPLR->product_id . '">' . $OPLR->otherproductname . '</option>';
						}
					}
				}
				$ReturnString .='</select>';

				$ReturnString .='</div>';
				$ReturnString .='</td>';
				$ReturnString .='</tr>';
		}
		//end code here

        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td colspan="2">Straining Posts</td>
	</tr>';

        $ReturnString .= '<tr>';
        $ReturnString .='<td colspan="2">';
        $EndPostType = array();
        $EndPostType = GetEndPostTypes($quotation_key);
		if($_SERVER['REMOTE_ADDR']=='')
		{
			
		}
        $sp = 0;
        $st = 0;
        $cr = 0;
        $gp = 0;
        $EndPostTypeArray = array('end_post_st', 'corner_post_st', 'standard_gateway_st', 'free_standing_gateway_st', 'end_post_box', 'corner_post_box', 'standard_gateway_box', 'free_standing_gateway_box', 'turning_post_unstrutted');
        $EndPostTypeUnique = array_unique($EndPostType);
        $ArrayDiff = array_diff($EndPostTypeArray, $EndPostTypeUnique);


        $newArray = array_merge($EndPostType, $ArrayDiff);


        if (count($EndPostTypeArray) > 0) {
            $endpostflag = 1;
            foreach ($EndPostTypeArray as $EPT) {

                if ($EPT == 'end_post_st') {
                    $EndPostTypeName = 'End Post - Strutted';

                    $sp = 1;
                    $st = 1;
                    $cr = 0;
                    $gp = 0;
                }

                if ($EPT == 'turning_post_unstrutted') {
                    $EndPostTypeName = 'Turning Post – Unstrutted';

                    $sp = 1;
                    $st = 0;
                    $cr = 0;
                    $gp = 0;
                }
                if ($EPT == 'corner_post_st') {
                    $EndPostTypeName = 'Corner Post - Strutted';

                    $sp = 1;
                    $st = 2;
                    $cr = 0;
                    $gp = 0;
                }

                if ($EPT == 'standard_gateway_st') {
                    $EndPostTypeName = 'Standard Gateway - Strutted';

                    $sp = 2;
                    $st = 2;
                    $cr = 0;
                    $gp = 0;
                }

                if ($EPT == 'free_standing_gateway_st') {
                    $EndPostTypeName = 'Free-standing Gateway - Strutted';

                    $sp = 4;
                    $st = 2;
                    $cr = 0;
                    $gp = 0;
                }

                if ($EPT == 'end_post_box') {
                    $EndPostTypeName = 'End Post - Box Assembly';

                    $sp = 2;
                    $cr = 1;
                    $gp = 1;
                    $st = 0;
                }

                if ($EPT == 'corner_post_box') {
                    $EndPostTypeName = 'Corner Post - Box Assembly';


                    $sp = 3;
                    $cr = 2;
                    $gp = 1;
                    $st = 0;
                }

                if ($EPT == 'standard_gateway_box') {
                    $EndPostTypeName = 'Standard Gateway - Box Assembly';


                    $sp = 4;
                    $cr = 2;
                    $gp = 1;
                    $st = 0;
                }

                if ($EPT == 'free_standing_gateway_box') {
                    $EndPostTypeName = 'Free-standing Gateway - Box Assembly';


                    $sp = 6;
                    $cr = 2;
                    $gp = 1;
                    $st = 0;
                }
                if (in_array($EPT, $EndPostType)) {
                    if ($endpostflag <= 3) {
                        $ReturnString .='<div class="cmsms_column one_third grid_layout" style="height:180px;">';
                    } else {
                        $ReturnString .= '<div class="cmsms_column one_third grid_layout">';
                    }
                    $ReturnString .= '<input type="radio" checked="checked" name="' . $EPT . '_radio" value="1"/>&nbsp;' . $EndPostTypeName;
                    $ReturnString .= '<br><br>';

                    if ($sp > 0) {


                        $Product_List_Sp = Quote_Process_ListByPostType('strainer_posts');
                        $Other_Product_List = Quote_Process_ListByOtherPostType('strainer_posts');
                        $ReturnString .= '<select class="posts_select" id="' . $EPT . '_strainerposts" name="' . $EPT . '_strainerposts">';

                        $ReturnString .= '<option value="">Select Strainer Post</option>';

                        foreach ($Product_List_Sp as $PLR_SP) {
                            if ($quotation_step3[$EPT . '_strainerposts'] == $PLR_SP->product_id) {
                                $ReturnString .='<option value="' . $PLR_SP->product_id . '" selected="selected">' . $PLR_SP->product_name . '</option>';
                            } else {
                                $ReturnString .='<option value="' . $PLR_SP->product_id . '">' . $PLR_SP->product_name . '</option>';
                            }
                        }
                        if (count($Other_Product_List) > 0) {
                            foreach ($Other_Product_List as $OPLR) {
                                if ($quotation_step3[$EPT . '_strainerposts'] == $OPLR->product_id) {
                                    $ReturnString .='<option value="' . $OPLR->product_id . '" selected="selected">' . $OPLR->otherproductname . '</option>';
                                } else {
                                    $ReturnString .='<option value="' . $OPLR->product_id . '">' . $OPLR->otherproductname . '</option>';
                                }
                            }
                        }
                        $ReturnString .='</select>';
                    }

                    if ($st > 0) {


                        $Product_List_St = Quote_Process_ListByPostType('struts');
                        $Other_Product_List = Quote_Process_ListByOtherPostType('struts');
                        $ReturnString .= '<select class="posts_select" id="' . $EPT . '_struts" name="' . $EPT . '_struts">';

                        $ReturnString .= '<option value="">Select Struts</option>';

                        foreach ($Product_List_St as $PLR_ST) {
                            if ($quotation_step3[$EPT . '_struts'] == $PLR_ST->product_id) {
                                $ReturnString .='<option value="' . $PLR_ST->product_id . '" selected="selected">' . $PLR_ST->product_name . '</option>';
                            } else {
                                $ReturnString .='<option value="' . $PLR_ST->product_id . '">' . $PLR_ST->product_name . '</option>';
                            }
                        }
                        if (count($Other_Product_List) > 0) {
                            foreach ($Other_Product_List as $OPLR) {
                                if ($quotation_step3[$EPT . '_struts'] == $OPLR->product_id) {
                                    $ReturnString .='<option value="' . $OPLR->product_id . '" selected="selected">' . $OPLR->otherproductname . '</option>';
                                } else {
                                    $ReturnString .='<option value="' . $OPLR->product_id . '">' . $OPLR->otherproductname . '</option>';
                                }
                            }
                        }
                        $ReturnString .='</select><br>';
                    }

                    if ($cr > 0) {


                        $Product_List_CR = Quote_Process_ListByPostType('cross_rails');
                        $Other_Product_List = Quote_Process_ListByOtherPostType('cross_rails');
                        $ReturnString .= '<select class="posts_select" id="' . $EPT . '_crossrails" name="' . $EPT . '_crossrails">';

                        $ReturnString .= '<option value="">Select Cross Rails </option>';

                        foreach ($Product_List_CR as $PLR_CR) {
                            if ($quotation_step3[$EPT . '_crossrails'] == $PLR_CR->product_id) {
                                $ReturnString .='<option value="' . $PLR_CR->product_id . '" selected="selected">' . $PLR_CR->product_name . '</option>';
                            } else {
                                $ReturnString .='<option value="' . $PLR_CR->product_id . '">' . $PLR_CR->product_name . '</option>';
                            }
                        }
                        if (count($Other_Product_List) > 0) {
                            foreach ($Other_Product_List as $OPLR) {
                                if ($quotation_step3[$EPT . '_crossrails'] == $OPLR->product_id) {
                                    $ReturnString .='<option value="' . $OPLR->product_id . '" selected="selected">' . $OPLR->otherproductname . '</option>';
                                } else {
                                    $ReturnString .='<option value="' . $OPLR->product_id . '">' . $OPLR->otherproductname . '</option>';
                                }
                            }
                        }
                        $ReturnString .='</select>';
                    }


                    if ($gp > 0) {

                        $ReturnString .= '<select class="posts_select" id="' . $EPT . '_Gpaks" name="' . $EPT . '_Gpaks">';
                        $ReturnString .='<option value="">Select Gpaks</option>';
                        if ($quotation_step3[$EPT . '_Gpaks'] == "Gpaks") {
                            $ReturnString .='<option value="Gpaks" selected="selected">Gpaks</option>';
                        } else {
                            $ReturnString .='<option value="Gpaks">Gpaks</option>';
                        }
                        $ReturnString .='</select><br>';
                    }



                    $ReturnString .= '</div>';
                } else {
                    if ($endpostflag <= 3) {
                        $ReturnString .= '<div class="cmsms_column one_third grid_layout lowopacity" style="height:180px;">';
                    } else {
                        $ReturnString .= '<div class="cmsms_column one_third grid_layout lowopacity">';
                    }
                    $ReturnString .= '<input type="radio" />&nbsp;' . $EndPostTypeName;
                    $ReturnString .= '<br><br>';

                    if ($sp > 0) {


                        $Product_List_Sp = Quote_Process_ListByPostType('strainer_posts');
                        $ReturnString .= '<select class="posts_select">';
                        $ReturnString .= '<option value="">Select Strainer Post</option>';
                        $ReturnString .='</select>';
                    }

                    if ($st > 0) {


                        $Product_List_St = Quote_Process_ListByPostType('struts');
                        $ReturnString .= '<select class="posts_select">';

                        $ReturnString .= '<option value="">Select Struts</option>';
                        $ReturnString .='</select><br>';
                    }

                    if ($cr > 0) {


                        $Product_List_cr = Quote_Process_ListByPostType('cross_rails');
                        $ReturnString .= '<select class="posts_select">';
                        $ReturnString .= '<option value="">Select Cross Rails </option>';
                        $ReturnString .='</select>';
                    }


                    if ($gp > 0) {

                        $ReturnString .= '<select class="posts_select">';
                        $ReturnString .='<option value="">Select Gpaks</option>';
                        $ReturnString .='</select><br>';
                    }



                    $ReturnString .= '</div>';
                }

                $endpostflag ++;
            }
        }

        $ReturnString .='</td>';
        $ReturnString .= '</tr>';

        $ReturnString .= '<tr>
	<td></td>
	<td align="right" class="align-right">
	 <a href="#myModal_fav_spec" class="" data-toggle="modal"><input type="button" id="favourite_spec" name="favourite_spec" value="Save & Next Step" /></a>&nbsp;&nbsp;&nbsp;<input type="submit" id="next" name="next" class="nextafterspec" value="Next Step"/></td>
	</tr>';

        $ReturnString .='<div id="myModal_fav_spec" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Save spec favourite</h4>
                </div>
                <div class="modal-body">
				    <div class="form-group">
                        <label for="email">Favourite spec title : </label>
                             <input type="text" name="favouritetitle" id="favouritetitle" placeholder="favourite spec title" class="form-control">
                    </div>
				              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="savebtnspec">Save & Next Step</button>                    
                </div>
            </div>
       </div>    
    </div>
	<script type="text/javascript">
	jQuery("#savebtnspec").click(function(){
	  if(jQuery("#favouritetitle").val().trim()!=""){	
	   //jQuery(".nextafterprice").trigger("click");	
	  jQuery("#myModal_fav_spec").modal("hide");
	  jQuery("#ewd-feup-edit-profile-form").submit();
	  }else{
		  alert("Please provide favourite title.")
		  
	  }
		
	})
	
	jQuery("#favourite_spec").click(function(){
	   jQuery("#myModal_fav_spec").modal("show");	
	   jQuery("#favouritetitle").val("");
	})
	
	jQuery(".nextafterspec").click(function(){
	   jQuery("#favouritetitle").val("");
	
	})
	
	
	
	</script>
	
	';


        $ReturnString .= ' </tbody>
                      </table>';

        $ReturnString .='</div>';


        $ReturnString .='</div>';

        $ReturnString .='<input type="hidden" name="step" id="step" value="step3"/>';

        $ReturnString .= "</form>";
        $ReturnString .= "</div>";

        return $ReturnString;
    }

    /* #####################################
      ############## STEP 4##################
      /*Step @4 */
    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 4) {


        $ReturnString .= "<form action='#' method='post' id='ewd-feup-edit-profile-form' class='pure-form pure-form-aligned ewd-feup-edit-profile-form-price' enctype='multipart/form-data'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-check' value='" . sha1(md5($Time . $Salt)) . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-time' value='" . $Time . "'>";
        $ReturnString .= "<input type='hidden' id='ewd-feup-action' name='ewd-feup-action' value='process-step-4'>";
        $ReturnString .= "<input type='hidden' name='Omit_Fields' value='" . $omit_fields . "'>";
        $ReturnString .= "<input type='hidden' name='Omit_user_id' id='Omit_user_id' value='" . $User->User_ID . "'>";



        $ReturnString .='<p></p>';
        $ReturnString .='<div class="cmsms_row">';

        global $wpdb;

        $quotationdata = $wpdb->get_row("SELECT quotation_step4 FROM wp_ewd_quotation WHERE quotation_id = '" . $_REQUEST['quotation_id'] . "'");
        $quotation_step4 = unserialize($quotationdata->quotation_step4);


        $ReturnString .= '<div class="cmsms_column one_first">';
        $ReturnString .='<div class="headline_text"><h1 class="entry-title">Bill of materials</h1></div>';

        $ReturnString .='<div style="height:50px;"><a href="#myModalLoadFavouriteQuoteWithPrice" class="" data-toggle="modal"><input type="button" id="load_favourite_quote_withprice" value="Load favourite price" style=" float: left;margin-left: 77%;" /></a> <a href="#myModal" class="" data-toggle="modal"><input type="button" id="help" value="Help" style="margin-right:10px; float:right;"></a></div>';
        $ReturnString .= ' <table class="cmsms_table">
                      <tbody>';
        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td>Item Description</td>
	<td>Quantity</td>
	<td>Cost Price/Unit</td>
	<td>Line Value</td>
	<td>Markup</td>
	<td>Selling Price</td>
	<td>Show Item</td>
	</tr>';
        //$Mrkup = 50;
        $Mrkup = get_user_meta($User->User_ID, "default_markup", true);
        if (trim($Mrkup) == '') {
            $Mrkup = 50;
        }
        $FlagInc = 1;
        $TotalLineValue = 0;
        $TotalSellingValue = 0;

		$NetWire = GetStep2Data('net_wire');
		
		if(trim($NetWire)=='' || $NetWire==0){
			$TotalFenceWireAdditional=0;
			$j=1;
			while(1){
				$val=GetStep1Data('routeLength_'.$j);
				
				$TotalFenceWireAdditional+=$val;
								
				if(trim($val)=='')
					break; 
				else{
					$TotalFenceWire = round(GetStep1Data('routeLength_'.$j));
					$NetWire = GetStep2Data('net_wire_'.$j++);
					if (isset($quotation_step4['Projects'][$NetWire])) {
						$ProductPriceNet = $quotation_step4['Projects'][$NetWire]['perprice'];
					}
					else{
						$ProductPriceNet = GetProductPriceByUserRow($NetWire, $User->User_ID);
					}
					$NetWireLineValue = $ProductPriceNet * $TotalFenceWire;
					$TotalLineValue +=$NetWireLineValue;
					$selling_NetPrice = (($NetWireLineValue * $Mrkup) / 100) + $NetWireLineValue;
					$TotalSellingValue +=$selling_NetPrice;
					if ($NetWire != 0) {
						$ReturnString .= '<tr>';
						
						$ReturnString .= '<td>'.GetProductNameByID($NetWire).'</td>';
						$ReturnString .= '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc .'" value="' . $NetWire . '" id="product_id_' . $FlagInc .'"/>';
						$ReturnString .= '</td>';
						
						$ReturnString .= '<td>';
						$ReturnString .= '<input type="hidden" class="numericinput" name="product_length_' . $FlagInc .'" value="' . $TotalFenceWire . '" id="product_length_' . $FlagInc .'"/><span id="product_length_label_' . $FlagInc .'">' . $TotalFenceWire . '</span>';
						$ReturnString .= '</td>';
						
						$ReturnString .= '<td>';
						$ReturnString .= '£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc .'" value="' . $ProductPriceNet . '" id="product_perprice_' . $FlagInc .'"/>';
						$ReturnString .= '</td>';
						
						$ReturnString .= '<td>';
						$ReturnString .= '£<span id="product_total_label_' . $FlagInc .'">' . round($NetWireLineValue) . '</span><input type="hidden" name="product_total_' . $FlagInc .'" id="product_total_' . $FlagInc .'" value="' . $NetWireLineValue .'"/>';
						$ReturnString .= '</td>';
						
						$ReturnString .= '<td>';
						$ReturnString .= '<input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc .'" id="product_markup_' . $FlagInc .'" value="' . $Mrkup . '"/>%';
						$ReturnString .= '</td>';
						
						$ReturnString .= '<td>';
						$ReturnString .= '<input type="hidden" id="product_selling_' . $FlagInc .'" name="product_selling_' . $FlagInc .'" value="' . $selling_NetPrice . '"/>£<span id="product_selling_label_' . $FlagInc .'">' . $selling_NetPrice . '<span>';
						$ReturnString .= '</td>';
						
						$ReturnString .= '<td>';
						$ReturnString .= '<input type="checkbox" id="product_check_' . $FlagInc .'" class="itemizedcheck" name="product_check_' . $FlagInc .'" value="1" />';
						$ReturnString .= '</td></tr>';
					}
				}
					
			}
		}
		else{
			// Fence Net
        //$NetWire =GetStep2Data('net_wire');
        $NetWire = GetStep2Data('net_wire');

        $TotalFenceWire = round(GetStep1Data('FenceLine'));
        $ProductPriceNet = GetProductPriceByUserRow($NetWire, $User->User_ID);

        /* Product price from faviorate */
        if (isset($quotation_step4['Projects'][$NetWire])) {
            $ProductPriceNet = $quotation_step4['Projects'][$NetWire]['perprice'];
        }

        $NetWireLineValue = $ProductPriceNet * $TotalFenceWire;

        $TotalLineValue +=$NetWireLineValue;

        $selling_NetPrice = (($NetWireLineValue * $Mrkup) / 100) + $NetWireLineValue;

        $TotalSellingValue +=$selling_NetPrice;
        if ($NetWire != 0) {
            $ReturnString .= '<tr>
	<td>' . GetProductNameByID($NetWire) . '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $NetWire . '" id="product_id_' . $FlagInc . '"/></td>
	<td><input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $TotalFenceWire . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $TotalFenceWire . '</span></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $ProductPriceNet . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . round($NetWireLineValue) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $NetWireLineValue . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_NetPrice . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $selling_NetPrice . '<span></td>
	<td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';
        } else {
            // It work when no net wire selected
            $ReturnString .= '<input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $TotalFenceWire . '" id="product_length_' . $FlagInc . '"/>';
        }

        // Intermediate Posts 

        $SelectedIntermediatePost = GetStep3Data('intermediate_fence_post');
        $total_number_of_Intermediate = GetStep1Data('amount_subPosts');
        $IntermediateProductPrice = GetProductPriceByUserRow($SelectedIntermediatePost, $User->User_ID);

        /* Product price from faviorate */
        if (isset($quotation_step4['Projects'][$SelectedIntermediatePost])) {
            $IntermediateProductPrice = $quotation_step4['Projects'][$SelectedIntermediatePost]['perprice'];
        }


        $TotalPriceOfInterMediate = round($total_number_of_Intermediate * $IntermediateProductPrice, 2);
        $selling_IntermediatePrice = (($TotalPriceOfInterMediate * $Mrkup) / 100) + $TotalPriceOfInterMediate;
        $selling_IntermediatePrice = round($selling_IntermediatePrice);

        $TotalLineValue +=$TotalPriceOfInterMediate;
        $TotalSellingValue +=$selling_IntermediatePrice;
        $FlagInc++;

        $ReturnString .= '<tr><td>';
        $User_Id = get_current_user_id();
        $other_desc = GetOtherProductDescByUser($SelectedIntermediatePost, $User_Id);
        @$other_desc_val = $other_desc[0]->descr;
        if (empty($other_desc_val)) {
            $other_desc_val1 = GetProductNameByID($SelectedIntermediatePost);
        } else {
            $other_desc_val1 = $other_desc_val;
        }

		$ReturnString .= $other_desc_val1 . '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $SelectedIntermediatePost . '" id="product_id_' . $FlagInc . '"/></td>
		<td><input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $total_number_of_Intermediate . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $total_number_of_Intermediate . '</span></td>
		<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $IntermediateProductPrice . '" id="product_perprice_' . $FlagInc . '"/></td>
		<td>£<span id="product_total_label_' . $FlagInc . '">' . round($TotalPriceOfInterMediate) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $TotalPriceOfInterMediate . '"/></td>
		<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
		<td><input type="hidden"  name="product_selling_' . $FlagInc . '" id="product_selling_' . $FlagInc . '" value="' . $selling_IntermediatePrice . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_IntermediatePrice . '</span></td>
		<td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
		</tr>';
		}



        //Top Line Wires
		
			$TopLineWire = array();
			$TopLineWire[] = GetStep2Data('top_line_wire_1');
			if(empty($TopLineWire[0])){
				$j=1;
				$i=0;
				while(1){
					$val=GetStep1Data('routeLength_'.$j);
					if(trim($val)=='')
						break;
					else{
						$TopLineWire[$i++] = GetStep2Data('top_line_wire_1_'.$j);
						$TopLineWire[$i++] = GetStep2Data('top_line_wire_2_'.$j);
						$TopLineWire[$i++] = GetStep2Data('top_line_wire_3_'.$j);
						$TopLineWire[$i++] = GetStep2Data('top_line_wire_5_'.$j);
						$TopLineWire[$i++] = GetStep2Data('top_line_wire_6_'.$j);
						$TopLineWire[$i++] = GetStep2Data('top_line_wire_4_'.$j);
						$TopLineWire[$i++] = GetStep2Data('bottom_line_wire_'.$j++);
					}
				}
				
				$TopLineWireFilter = array_filter($TopLineWire);
				$TopLineWireFilterUnique = array_unique($TopLineWireFilter);
				$newArrayAfterDiff = array_diff_key($TopLineWireFilter, $TopLineWireFilterUnique);
				foreach ($TopLineWireFilterUnique as $TLWFU) {
					 $FlagInc++;
					 $TotalFenceWireAdditional=round($TotalFenceWireAdditional);
					 $TotalFenceWireAdditionalLength=round($TotalFenceWireAdditional);
					 
					 foreach ($newArrayAfterDiff as $NAAD) {
						if ($NAAD == $TLWFU) {

							$TotalFenceWireAdditionalLength +=$TotalFenceWireAdditional;
						}
					}
					$WirePrice = GetProductPriceByUserRow($TLWFU, $User->User_ID);

					/* Product price from faviorate */
					if (isset($quotation_step4['Projects'][$TLWFU])) {
						$WirePrice = $quotation_step4['Projects'][$TLWFU]['perprice'];
					}


					$TotalWirePrice = round($WirePrice * $TotalFenceWireAdditionalLength);
					$selling_WirePrice = (($TotalWirePrice * $Mrkup) / 100) + $TotalWirePrice;

					$TotalLineValue +=$TotalWirePrice;
					$TotalSellingValue +=$selling_WirePrice;
					
					$ReturnString .= '<tr>';
					
					$ReturnString .= '<td>';
					$ReturnString .= GetProductNameByID($TLWFU);
					$ReturnString .= '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' .$TLWFU . '" id="product_id_' . $FlagInc . '"/>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $TotalFenceWireAdditionalLength . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $TotalFenceWireAdditionalLength . '</span>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $WirePrice . '" id="product_perprice_' . $FlagInc . '"/>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '£<span id="product_total_label_' . $FlagInc . '">' . round($TotalWirePrice) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $TotalWirePrice . '"/>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_WirePrice . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_WirePrice . '</span>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" />';
					$ReturnString .= '</td></tr>';
				}
				
			}
			
			else{
				$TopLineWire = array();
				$TopLineWire[] = GetStep2Data('top_line_wire_1');
				$TopLineWire[] = GetStep2Data('top_line_wire_2');
				$TopLineWire[] = GetStep2Data('top_line_wire_3');
				$TopLineWire[] = GetStep2Data('top_line_wire_5');
				$TopLineWire[] = GetStep2Data('top_line_wire_6');
				$TopLineWire[] = GetStep2Data('top_line_wire_4');
				$TopLineWire[] = GetStep2Data('bottom_line_wire');

				$TopLineWireFilter = array_filter($TopLineWire);
				$TopLineWireFilterUnique = array_unique($TopLineWireFilter);
				$newArrayAfterDiff = array_diff_key($TopLineWireFilter, $TopLineWireFilterUnique);

				foreach ($TopLineWireFilterUnique as $TLWFU) {
					$FlagInc++;
					//Check if Key Already Exists
					$TotalFenceWireAdditional = round(GetStep1Data('FenceLine'));
					$TotalFenceWireAdditionalLength = round(GetStep1Data('FenceLine'));
				
					foreach ($newArrayAfterDiff as $NAAD) {
						if ($NAAD == $TLWFU) {

							$TotalFenceWireAdditionalLength +=$TotalFenceWireAdditional;
						}
					}

					$WirePrice = GetProductPriceByUserRow($TLWFU, $User->User_ID);

					/* Product price from faviorate */
					if (isset($quotation_step4['Projects'][$TLWFU])) {
						$WirePrice = $quotation_step4['Projects'][$TLWFU]['perprice'];
					}


					$TotalWirePrice = round($WirePrice * $TotalFenceWireAdditionalLength);
					$selling_WirePrice = (($TotalWirePrice * $Mrkup) / 100) + $TotalWirePrice;

					$TotalLineValue +=$TotalWirePrice;
					$TotalSellingValue +=$selling_WirePrice;

					$ReturnString .= '<tr>
			<td>' . GetProductNameByID($TLWFU) . '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $TLWFU . '" id="product_id_' . $FlagInc . '"/></td>
			<td><input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $TotalFenceWireAdditionalLength . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $TotalFenceWireAdditionalLength . '</span></td>
			<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $WirePrice . '" id="product_perprice_' . $FlagInc . '"/></td>
			<td>£<span id="product_total_label_' . $FlagInc . '">' . round($TotalWirePrice) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $TotalWirePrice . '"/></td>
			<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
			<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_WirePrice . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_WirePrice . '</span></td>
			<td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
			</tr>';
				}
			}
		
		


        /* Gates */

        $SelectedGates = array();
        $GateTypeNumber = array();

        $GateTypeNumber[1] = GetStep1Data('gate_type_1_number');
        $GateTypeNumber[2] = GetStep1Data('gate_type_2_number');
        $GateTypeNumber[3] = GetStep1Data('gate_type_3_number');

        $GateTypeNumberValue = array_unique($GateTypeNumber);

        $SelectedGates[1] = GetStep1Data('gate_type_1');
        $SelectedGates[2] = GetStep1Data('gate_type_2');
        $SelectedGates[3] = GetStep1Data('gate_type_3');



        $FilterGateArray = array_filter($SelectedGates);
        $ArrayGatesUnique = array_unique($FilterGateArray);
        $ArrayGatesDiff = array_diff_key($FilterGateArray, $ArrayGatesUnique);

        foreach ($ArrayGatesUnique as $key => $value) {
            $FlagInc++;

            $gate_quantity = $GateTypeNumber[$key];

            if (in_array($value, $ArrayGatesDiff)) {
                foreach ($ArrayGatesDiff as $gate_key => $gate_value) {
                    if ($value == $gate_value) {
                        $gt_q = $GateTypeNumber[$gate_key];
                        $gate_quantity = $gt_q + $gate_quantity;
                    }
                }
            }

            $GatePrice = GetProductPriceByUserRow($value, $User->User_ID);

            /* Product price from faviorate */
            if (isset($quotation_step4['Projects'][$value])) {
                $GatePrice = $quotation_step4['Projects'][$value]['perprice'];
            }


            $TotalGatePrice = round($GatePrice * $gate_quantity, 2);
            $selling_GatePrice = (($TotalGatePrice * $Mrkup) / 100) + $TotalGatePrice;

            $TotalLineValue +=$TotalGatePrice;
            $TotalSellingValue +=$selling_GatePrice;

            $other_desc_gate = GetOtherProductDescByUser($value, $User_Id);
            @$other_desc_val_gate = $other_desc_gate[0]->descr;
            if (empty($other_desc_val_gate)) {
                $other_desc_val1_gate = GetProductNameByID($value);
            } else {
                $other_desc_val1_gate = $other_desc_val_gate;
            }



            $ReturnString .= '<tr>
		  <td>' . $other_desc_val1_gate . '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $value . '" id="product_id_' . $FlagInc . '"/></td>
		  <td><input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $gate_quantity . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $gate_quantity . '</span></td>
		  <td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $GatePrice . '" id="product_perprice_' . $FlagInc . '"/></td>
		  <td>£<span id="product_total_label_' . $FlagInc . '">' . round($TotalGatePrice) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $TotalGatePrice . '"/></td>
		  <td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
		  <td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_GatePrice . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_GatePrice . '</span></td>
		  <td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
		  </tr>';
        }
        /*
          $ReturnString .= '<tr class="cmsms_table_row_header">
          <td>Starning Posts</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>'; */

        $EndPostType = GetEndPostTypes();
        $starning_posts = GetStep3Data('starning_posts');
        //echo "<pre>";
        //print_r($starning_posts);

        $UniqueStarningPosts = array_unique($starning_posts);
        $ArrayStarningDiff = array_diff_key($starning_posts, $UniqueStarningPosts);
        //print_r($ArrayStarningDiff);
        //print_r($UniqueStarningPosts);
        foreach ($UniqueStarningPosts as $EPTKEY => $value) {


            $FlagInc++;

            $qty_array = explode('-', $EPTKEY);
            $qty = $qty_array[1];
            //$qty=0;
            if (in_array($value, $ArrayStarningDiff)) {
                foreach ($ArrayStarningDiff as $ASDKEY => $ASDVALUE) {
                    $qty_ASD_array = array();
                    if ($value == $ASDVALUE) {   // echo "==================".$value."==================";
                        // echo $ASDKEY;
                        //  echo "<br>";
                        $qty_ASD_array = explode('-', $ASDKEY);
                        //echo $ASDKEY."==".$qty_ASD_array[1];
                        //echo "<br>";
                        $qty +=$qty_ASD_array[1];
                    }
                }
            }

            if ($value == "Gpaks") {
                $ProductName = "Gpaks";
            } else {
                $ProductName = GetProductNameByID($value);
            }

            $starning_posts_price = GetProductPriceByUserRow($value, $User->User_ID);

            /* Product price from faviorate */
            if (isset($quotation_step4['Projects'][$value])) {
                $starning_posts_price = $quotation_step4['Projects'][$value]['perprice'];
            }


            $lineValueStarning_Posts = $qty * $starning_posts_price;
            $selling_ValueStarning_Posts = (($lineValueStarning_Posts * $Mrkup) / 100) + $lineValueStarning_Posts;

            $TotalLineValue +=$lineValueStarning_Posts;
            $TotalSellingValue +=$selling_ValueStarning_Posts;

            $ReturnString .= '<tr><td>';
            $User_Id = get_current_user_id();
            $other_desc = GetOtherProductDescByUser($value, $User_Id);
            @$other_desc_val = $other_desc[0]->descr;
            if (empty($other_desc_val)) {
                $other_desc_val1 = $ProductName;
            } else {
                $other_desc_val1 = $other_desc_val;
            }
            $ReturnString .= $other_desc_val1 . '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $value . '" id="product_id_' . $FlagInc . '"/></td>
	<td><input type="hidden" class="numericinput" name="product_length_' . $FlagInc . '" value="' . $qty . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $qty . '</span></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $starning_posts_price . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . round($lineValueStarning_Posts) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $lineValueStarning_Posts . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_ValueStarning_Posts . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_ValueStarning_Posts . '</span></td>
	<td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';
        }

        /* Staples */

        $selected_total_staple = GetStep2Data('total_no_staples');
        if ($selected_total_staple > 0) {
            $selected_staples = GetStep2Data('staples');
            $SelectedStapleName = GetProductNameByID($selected_staples);

            $selected_staples_price = GetProductPriceByUserRow($selected_staples, $User->User_ID);

            /* Product price from faviorate */
            if (isset($quotation_step4['Projects'][$selected_staples])) {
                $selected_staples_price = $quotation_step4['Projects'][$selected_staples]['perprice'];
            }

            $lineValueSelectedStaples = $selected_total_staple * $selected_staples_price;
            $selling_SelectedStaples = (($lineValueSelectedStaples * $Mrkup) / 100) + $lineValueSelectedStaples;

            $TotalLineValue +=$lineValueSelectedStaples;
            $TotalSellingValue +=$selling_SelectedStaples;

            $FlagInc++;

            $ReturnString .= '<tr>
	<td>' . $SelectedStapleName . '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $selected_staples . '" id="product_id_' . $FlagInc . '"/></td>
	<td><input type="hidden" name="product_length_' . $FlagInc . '" value="' . $selected_total_staple . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $selected_total_staple . '</span></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $selected_staples_price . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . round($lineValueSelectedStaples) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $lineValueSelectedStaples . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_SelectedStaples . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_SelectedStaples . '</span></td>
	<td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';
        }


        /* joiner */


        $selected_total_joiner = GetStep2Data('no_of_joiners');
		 if ($selected_total_joiner > 0) {
			$j=1; 
			while(1){
				$val='';
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break;
				else{
					$selected_total_joiner_new=GetStep2Data('no_of_joiners_'.$j);
					$selected_joiner = GetStep2Data('joiner_'.$j++);
										
					 $SelectedjoinerName = GetProductNameByID($selected_joiner);
					 
					 $other_desc_joiner = GetOtherProductDescByUser($selected_joiner, $User_Id);
					 @$other_desc_val_joiner = $other_desc_joiner[0]->descr;
					 if (empty($other_desc_val_joiner)) {
						$SelectedjoinerName = GetProductNameByID($selected_joiner);
					 }
					 else{
						 $SelectedjoinerName = $other_desc_val_joiner;
					 }
					 $selected_joiner_price = GetProductPriceByUserRow($selected_joiner, $User->User_ID);
									
					 /* Product price from faviorate */
					if (isset($quotation_step4['Projects'][$selected_joiner])) {
						$selected_joiner_price = $quotation_step4['Projects'][$selected_joiner]['perprice'];
					}
					
					$lineValueSelectedJoiner = $selected_total_joiner_new * $selected_joiner_price;
					$selling_SelectedJoiner = (($lineValueSelectedJoiner * $Mrkup) / 100) + $lineValueSelectedJoiner;
					$FlagInc++;
			
					$TotalSellingValue +=$selling_SelectedJoiner;
					$TotalLineValue +=$lineValueSelectedJoiner;
					
					$ReturnString .= '<tr>';
					
					$ReturnString .= '<td>';
					$ReturnString .= $SelectedjoinerName;
					$ReturnString .= '<input type="hidden" class="numericinput" name="product_id_' . $FlagInc . '" value="' . $selected_joiner . '" id="product_id_' . $FlagInc . '"/>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input type="hidden" name="product_length_' . $FlagInc . '" value="' . $selected_total_joiner_new . '" id="product_length_' . $FlagInc . '"/><span id="product_length_label_' . $FlagInc . '">' . $selected_total_joiner_new . '</span>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $selected_joiner_price . '" id="product_perprice_' . $FlagInc . '"/>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '£<span id="product_total_label_' . $FlagInc . '">' . round($lineValueSelectedJoiner) . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $lineValueSelectedJoiner . '"/>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_SelectedJoiner . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_SelectedJoiner . '</span>';
					$ReturnString .= '</td>';
					
					$ReturnString .= '<td>';
					$ReturnString .= '<input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" />';
					$ReturnString .= '</td>';
					
					$ReturnString .= '</tr>';
				}
			}
        }

        /*         * ** Terminations  ** */

        $terminations = GetStep2Data('terminations');
		
		if(trim($terminations)==''){
			
			$j=1;
			while(1){
				$val=GetStep1Data('routeLength_'.$j);
				if(trim($val)=='')
					break; 
				else{
					$terminations = GetStep2Data('terminations_'.$j);
					
					 if ($terminations == "T-Clips") {
						 $terminations_calculation = GetStep2Data('terminations_calculation_'.$j++);
						 
						 $Terminations_List = Quote_Terminations_List();
						 
						 $FlagInc++;
						 
						 if (isset($quotation_step4['Projects'][112]['perprice'])) {
							$selected_termination_price = $quotation_step4['Projects'][112]['perprice'];
						} elseif (isset($quotation_step4['Projects'][111]['perprice'])) {
							$selected_termination_price = $quotation_step4['Projects'][111]['perprice'];
						} else {
							$selected_termination_price = 0.00;
						}
						
						 $lineValueSelectedtclips = $terminations_calculation * $selected_termination_price;
						 
						  $selling_Selectedtclips = (($lineValueSelectedtclips * $Mrkup) / 100) + $lineValueSelectedtclips;
						  
						  $ReturnString .= '<tr>';
						  $ReturnString .= '<td>';
						  $ReturnString .= '<select class="tclips"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Select T-clip</option>';
						  
						  foreach ($Terminations_List as $TL) {
							  if (isset($quotation_step4['Projects'][$TL->product_id])) {
								  $ReturnString .='<option value="' . $TL->product_id . '" selected="selected">' . $TL->product_name . '</option>';
							  }
							  else{
								   $ReturnString .='<option value="' . $TL->product_id . '">' . $TL->product_name . '</option>';
							  }
						  }
						  
						  $ReturnString .= '</select>';
						  $ReturnString .='<p id="term_wait_' . $FlagInc . '"></p>';
						  
						  
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '<td>';
						  $ReturnString .= '<input type="text" class="numericinput product_length numeric" name="product_length_' . $FlagInc . '" value="' . $terminations_calculation . '" id="product_length_' . $FlagInc . '"/>';
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '<td>';
						  $ReturnString .= '£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $selected_termination_price . '" id="product_perprice_' . $FlagInc . '"/>';
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '<td>';
						  $ReturnString .= '£<span id="product_total_label_' . $FlagInc . '">' . $lineValueSelectedtclips . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $lineValueSelectedtclips . '"/>';
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '<td>';
						  $ReturnString .= '<input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%';
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '<td>';
						  $ReturnString .= '<input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_Selectedtclips . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_Selectedtclips . '</span>';
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '<td>';
						  $ReturnString .= '<input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" />';
						  $ReturnString .= '</td>';
						  
						  $ReturnString .= '</tr>';

						  
					 }
					 else{
						 $j++;
					 }
				}
			}
		}
		else{
			
			 if ($terminations == "T-Clips") {

				$terminations_calculation = GetStep2Data('terminations_calculation');
				$Terminations_List = Quote_Terminations_List();
				$FlagInc++;
				if (isset($quotation_step4['Projects'][112]['perprice'])) {
					$selected_termination_price = $quotation_step4['Projects'][112]['perprice'];
				} elseif (isset($quotation_step4['Projects'][111]['perprice'])) {
					$selected_termination_price = $quotation_step4['Projects'][111]['perprice'];
				} else {
					$selected_termination_price = 0.00;
				}

				$lineValueSelectedtclips = $terminations_calculation * $selected_termination_price;
				$selling_Selectedtclips = (($lineValueSelectedtclips * $Mrkup) / 100) + $lineValueSelectedtclips;



				$ReturnString .= '<tr>
						<td>
						<select class="tclips"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Select T-clip</option>';
								foreach ($Terminations_List as $TL) {
									if (isset($quotation_step4['Projects'][$TL->product_id])) {

										$ReturnString .='<option value="' . $TL->product_id . '" selected="selected">' . $TL->product_name . '</option>';
									} else {
										$ReturnString .='<option value="' . $TL->product_id . '">' . $TL->product_name . '</option>';
									}
								}





								$ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
						<td><input type="text" class="numericinput product_length numeric" name="product_length_' . $FlagInc . '" value="' . $terminations_calculation . '" id="product_length_' . $FlagInc . '"/></td>
						<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $selected_termination_price . '" id="product_perprice_' . $FlagInc . '"/></td>
						<td>£<span id="product_total_label_' . $FlagInc . '">' . $lineValueSelectedtclips . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $lineValueSelectedtclips . '"/></td>
						<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $Mrkup . '"/>%</td>
						<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $selling_Selectedtclips . '">£<span id="product_selling_label_' . $FlagInc . '">' . $selling_Selectedtclips . '</span></td>
						<td><input type="checkbox" id="product_check_' . $FlagInc . '" class="itemizedcheck" name="product_check_' . $FlagInc . '" value="1" /></td>
						</tr>';
			}
		}



        $ReturnString .= '<tr>
	
	<td align="right" colspan="7" class="align-right"></td>
	</tr>';
        $ReturnString .= ' </tbody>
                      </table>';

        /* Other Works Calculations */


        $ReturnString .= ' <table class="cmsms_table">
                      <tbody>';
        $ReturnString .= '<tr class="cmsms_table_row_header">
	<td>Item Description</td>
	<td>Quantity</td>
	<td>Cost Price/Unit</td>
	<td>Line Value</td>
	<td>Markup</td>
	<td>Selling Price</td>
	<td>Show Item</td>
	</tr>';

        $OtherWorkArray = array('10008', '10009', '10010', '10011');
        //$Mrkup = 50;
        $Mrkup = get_user_meta($User->User_ID, "default_markup", true);
        if (trim($Mrkup) == '') {
            $Mrkup = 50;
        }
        $FlagInc++;
        if (isset($quotation_step4['Projects'])) {
            $Works_List = Quote_OtherWorkPrice_List_SEL();
        } else {
            $Works_List = Quote_OtherWorkPrice_List();
        }
        $OtherLoadWorkFlag = false;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }
                if (isset($quotation_step4['Projects'][$WKL->work_id])) {
                    $selectedPr = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id])) {

                    $selectedPr = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }
        if (isset($quotation_step4['Projects'][$selectedPr])) {

            $OtherWorkPerPrice1 = $quotation_step4['Projects'][$selectedPr]['perprice'];
            $OtherWorkLength1 = $quotation_step4['Projects'][$selectedPr]['length'];
            $OtherWorktotal1 = $quotation_step4['Projects'][$selectedPr]['total'];
            $OtherWorkMarkup1 = $quotation_step4['Projects'][$selectedPr]['markup'];
            $OtherWorkselling1 = $quotation_step4['Projects'][$selectedPr]['selling'];
        } else {
            $OtherWorkPerPrice1 = 0.00;
            $OtherWorkLength1 = 0;
            $OtherWorktotal1 = 0.00;
            $OtherWorkMarkup1 = $Mrkup;
            $OtherWorkselling1 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength1 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice1 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal1 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal1 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup1 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling1 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling1 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork" name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }

                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr) {
                    $selectedPr1 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr) {

                    $selectedPr1 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr1])) {

            $OtherWorkPerPrice2 = $quotation_step4['Projects'][$selectedPr1]['perprice'];
            $OtherWorkLength2 = $quotation_step4['Projects'][$selectedPr1]['length'];
            $OtherWorktotal2 = $quotation_step4['Projects'][$selectedPr1]['total'];
            $OtherWorkMarkup2 = $quotation_step4['Projects'][$selectedPr1]['markup'];
            $OtherWorkselling2 = $quotation_step4['Projects'][$selectedPr1]['selling'];
        } else {
            $OtherWorkPerPrice2 = 0.00;
            $OtherWorkLength2 = 0;
            $OtherWorktotal2 = 0.00;
            $OtherWorkMarkup2 = $Mrkup;
            $OtherWorkselling2 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength2 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice2 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal2 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal2 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup2 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling2 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling2 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1) {
                    $selectedPr2 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1) {

                    $selectedPr2 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr2])) {

            $OtherWorkPerPrice3 = $quotation_step4['Projects'][$selectedPr2]['perprice'];
            $OtherWorkLength3 = $quotation_step4['Projects'][$selectedPr2]['length'];
            $OtherWorktotal3 = $quotation_step4['Projects'][$selectedPr2]['total'];
            $OtherWorkMarkup3 = $quotation_step4['Projects'][$selectedPr2]['markup'];
            $OtherWorkselling3 = $quotation_step4['Projects'][$selectedPr2]['selling'];
        } else {
            $OtherWorkPerPrice3 = 0.00;
            $OtherWorkLength3 = 0;
            $OtherWorktotal3 = 0.00;
            $OtherWorkMarkup3 = $Mrkup;
            $OtherWorkselling3 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength3 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice3 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal3 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal3 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup3 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling3 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling3 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }

                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2) {
                    $selectedPr3 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2) {

                    $selectedPr3 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr3])) {

            $OtherWorkPerPrice4 = $quotation_step4['Projects'][$selectedPr3]['perprice'];
            $OtherWorkLength4 = $quotation_step4['Projects'][$selectedPr3]['length'];
            $OtherWorktotal4 = $quotation_step4['Projects'][$selectedPr3]['total'];
            $OtherWorkMarkup4 = $quotation_step4['Projects'][$selectedPr3]['markup'];
            $OtherWorkselling4 = $quotation_step4['Projects'][$selectedPr3]['selling'];
        } else {
            $OtherWorkPerPrice4 = 0.00;
            $OtherWorkLength4 = 0;
            $OtherWorktotal4 = 0.00;
            $OtherWorkMarkup4 = $Mrkup;
            $OtherWorkselling4 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength4 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice4 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal4 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal4 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup4 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling4 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling4 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }

                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3) {
                    $selectedPr4 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3) {

                    $selectedPr4 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr4])) {

            $OtherWorkPerPrice5 = $quotation_step4['Projects'][$selectedPr4]['perprice'];
            $OtherWorkLength5 = $quotation_step4['Projects'][$selectedPr4]['length'];
            $OtherWorktotal5 = $quotation_step4['Projects'][$selectedPr4]['total'];
            $OtherWorkMarkup5 = $quotation_step4['Projects'][$selectedPr4]['markup'];
            $OtherWorkselling5 = $quotation_step4['Projects'][$selectedPr4]['selling'];
        } else {
            $OtherWorkPerPrice5 = 0.00;
            $OtherWorkLength5 = 0;
            $OtherWorktotal5 = 0.00;
            $OtherWorkMarkup5 = $Mrkup;
            $OtherWorkselling5 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength5 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice5 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal5 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal5 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup5 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling5 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling5 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }

                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3 && $WKL->work_id != $selectedPr4) {
                    $selectedPr5 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3 && $WKL->work_id != $selectedPr4) {

                    $selectedPr5 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr5])) {

            $OtherWorkPerPrice6 = $quotation_step4['Projects'][$selectedPr5]['perprice'];
            $OtherWorkLength6 = $quotation_step4['Projects'][$selectedPr5]['length'];
            $OtherWorktotal6 = $quotation_step4['Projects'][$selectedPr5]['total'];
            $OtherWorkMarkup6 = $quotation_step4['Projects'][$selectedPr5]['markup'];
            $OtherWorkselling6 = $quotation_step4['Projects'][$selectedPr5]['selling'];
        } else {
            $OtherWorkPerPrice6 = 0.00;
            $OtherWorkLength6 = 0;
            $OtherWorktotal6 = 0.00;
            $OtherWorkMarkup6 = $Mrkup;
            $OtherWorkselling6 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength6 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice6 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal6 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal6 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup6 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling6 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling6 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }

                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3 && $WKL->work_id != $selectedPr4 && $WKL->work_id != $selectedPr5) {
                    $selectedPr6 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3 && $WKL->work_id != $selectedPr4 && $WKL->work_id != $selectedPr5) {

                    $selectedPr6 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr6])) {

            $OtherWorkPerPrice7 = $quotation_step4['Projects'][$selectedPr6]['perprice'];
            $OtherWorkLength7 = $quotation_step4['Projects'][$selectedPr6]['length'];
            $OtherWorktotal7 = $quotation_step4['Projects'][$selectedPr6]['total'];
            $OtherWorkMarkup7 = $quotation_step4['Projects'][$selectedPr6]['markup'];
            $OtherWorkselling7 = $quotation_step4['Projects'][$selectedPr6]['selling'];
        } else {
            $OtherWorkPerPrice7 = 0.00;
            $OtherWorkLength7 = 0;
            $OtherWorktotal7 = 0.00;
            $OtherWorkMarkup7 = $Mrkup;
            $OtherWorkselling7 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength7 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice7 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal7 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal7 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup7 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling7 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling7 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';

        $FlagInc++;
        $ReturnString .= '<tr>
	<td>
	<select class="otherwork"  name="product_id_' . $FlagInc . '" id="product_id_' . $FlagInc . '"><option value="">Other Work</option>';
        foreach ($Works_List as $WKL) {
            if (in_array($WKL->work_id, $OtherWorkArray)) {

                $other_desc = GetOtherDescByUser($WKL->work_id, $User->User_ID);
                @$other_desc_val = $other_desc[0]->descr;
                if (empty($other_desc_val)) {
                    $other_desc_val1 = $WKL->work_name;
                } else {
                    $other_desc_val1 = $other_desc_val;
                }

                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3 && $WKL->work_id != $selectedPr4 && $WKL->work_id != $selectedPr5 && $WKL->work_id != $selectedPr6) {
                    $selectedPr7 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $other_desc_val1 . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $other_desc_val1 . '</option>';
                }
            } else {
                if (isset($quotation_step4['Projects'][$WKL->work_id]) && $WKL->work_id != $selectedPr && $WKL->work_id != $selectedPr1 && $WKL->work_id != $selectedPr2 && $WKL->work_id != $selectedPr3 && $WKL->work_id != $selectedPr4 && $WKL->work_id != $selectedPr5 && $WKL->work_id != $selectedPr6) {

                    $selectedPr7 = $WKL->work_id;
                    $ReturnString .='<option value="' . $WKL->work_id . '" selected="selected">' . $WKL->work_name . '</option>';
                } else {
                    $ReturnString .='<option value="' . $WKL->work_id . '">' . $WKL->work_name . '</option>';
                }
            }
        }

        if (isset($quotation_step4['Projects'][$selectedPr7])) {

            $OtherWorkPerPrice8 = $quotation_step4['Projects'][$selectedPr7]['perprice'];
            $OtherWorkLength8 = $quotation_step4['Projects'][$selectedPr7]['length'];
            $OtherWorktotal8 = $quotation_step4['Projects'][$selectedPr7]['total'];
            $OtherWorkMarkup8 = $quotation_step4['Projects'][$selectedPr7]['markup'];
            $OtherWorkselling8 = $quotation_step4['Projects'][$selectedPr7]['selling'];
        } else {
            $OtherWorkPerPrice8 = 0.00;
            $OtherWorkLength8 = 0;
            $OtherWorktotal8 = 0.00;
            $OtherWorkMarkup8 = $Mrkup;
            $OtherWorkselling8 = 0.00;
        }




        $ReturnString .='</select><p id="term_wait_' . $FlagInc . '"></p></td>
	<td><input type="text" class="numericinput numeric product_length" name="product_length_' . $FlagInc . '" value="' . $OtherWorkLength8 . '" id="product_length_' . $FlagInc . '"/></td>
	<td>£<input type="text" class="numericinput perprice numeric" name="product_perprice_' . $FlagInc . '" value="' . $OtherWorkPerPrice8 . '" id="product_perprice_' . $FlagInc . '"/></td>
	<td>£<span id="product_total_label_' . $FlagInc . '">' . $OtherWorktotal8 . '</span><input type="hidden" name="product_total_' . $FlagInc . '" id="product_total_' . $FlagInc . '" value="' . $OtherWorktotal8 . '"/></td>
	<td><input class="numericinput product_markup numeric" type="text" name="product_markup_' . $FlagInc . '" id="product_markup_' . $FlagInc . '" value="' . $OtherWorkMarkup8 . '"/>%</td>
	<td><input type="hidden" id="product_selling_' . $FlagInc . '" name="product_selling_' . $FlagInc . '" value="' . $OtherWorkselling8 . '"/>£<span id="product_selling_label_' . $FlagInc . '">' . $OtherWorkselling8 . '<span></td>
	<td><input type="checkbox" class="itemizedcheck" id="product_check_' . $FlagInc . '" name="product_check_' . $FlagInc . '" value="1" /></td>
	</tr>';



        $ReturnString .= '<tr class="cmsms_table_row_header">
     <td align="left" colspan="7" class="align-right">Summary </td>
	</tr>';
        $ReturnString .= '<tr>
	<td align="right" class="align-right" colspan="7">
	<input type="button" id="calculate_sumarry" name="calculate_sumarry" style="float:right"  value="Calculate Summary"/>
	</tr>';

        $costperMeter = $TotalLineValue / $TotalFenceWire;
        $sellingperMeter = (($costperMeter * $Mrkup) / 100) + $costperMeter;

        $ReturnString .= '<tr>
     <td align="right" colspan="7" class="align-right">
	 <div class="cmsms_column one_fourth" id="sm_cost">
	 <h2>Cost Price</h2>
	 <label for="cmsms_name_required">Total Metre</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_cost_totalmeter" id="summary_cost_totalmeter" value="' . $TotalFenceWire . '" size="15">
		<span id="summary_cost_totalmeter_label">' . $TotalFenceWire . '</span>
	</div>
	 <label for="cmsms_name_required">Total Cost (un-itemised)</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_cost_totalcost" id="summary_cost_totalcost" value="0" size="15">
		<span id="summary_cost_totalcost_label"></span>
	</div>
	
	 <label for="cmsms_name_required">Cost Per Metre</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_cost_permeter" id="summary_cost_permeter" value="0" size="15">
		<span id="summary_cost_permeter_label"></span>
	</div>
	
	 <label for="cmsms_name_required">Total Itemised items</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_cost_itemiseditem" id="summary_cost_itemiseditem" size="15" value=""/>
		<span id="summary_cost_itemiseditem_label"></span>
	</div>
	 </div>
	 
	 
	 
	 
	 <div class="cmsms_column one_fourth" id="sm_markup">
	  <h2>Markup</h2>
	 <label for="cmsms_name_required" style="visibility:hidden">Name (Required)</label>
	<div class="form_field_wrap">
		<input type="text" style="visibility:hidden" size="15">
	</div>
	
	 <label style="visibility:hidden" for="cmsms_name_required">Name (Required)</label>
	<div class="form_field_wrap">
		<input type="text" style="visibility:hidden" size="15">
	</div>
	
	 <label style="visibility:hidden" for="cmsms_name_required">Name (Required)</label>
	<div class="form_field_wrap">
		<input type="text" name="summary_markup" id="summary_markup" value="' . $Mrkup . '" size="15">%
		<input type="hidden" name="summary_markup_pre" id="summary_markup_pre" value="' . $Mrkup . '" size="15">
	</div>
	
	 <label style="visibility:hidden" for="cmsms_name_required">Name (Required)</label>
	<div class="form_field_wrap">
		<input style="visibility:hidden" type="text"  size="15">
	</div>
	 </div>
	 
	 
	 
	<div class="cmsms_column one_fourth" id="sm_selling">
	 <h2>Selling Price</h2>
	 <label for="cmsms_name_required">Total Metre</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_selling_totalmeter" id="summary_selling_totalmeter" value="' . $TotalFenceWire . '" size="15">
		<span id="summary_selling_totalmeter_label">' . $TotalFenceWire . '</span>
	</div>
	
	 <label for="cmsms_name_required">Total £/mtr (unitemised)</label>
	<div class="form_field_wrap">
		<input type="text" name="summary_selling_sellingprice" id="summary_selling_sellingprice" value="' . $TotalSellingValue . '" size="15">
		
		<input type="hidden" name="summary_selling_sellingprice_pre" id="summary_selling_sellingprice_pre" value="' . $TotalSellingValue . '" size="15">
		
	</div>
	
	 <label for="cmsms_name_required">Selling Price Per Metre</label>
	<div class="form_field_wrap">
		<input type="text" name="summary_selling_permeter" id="summary_selling_permeter" value="' . round($sellingperMeter, 2) . '" size="15">
		<input type="hidden" name="summary_selling_permeter_pre" id="summary_selling_permeter_pre" value="' . round($sellingperMeter, 2) . '" size="15">
	</div>
	
	 <label for="cmsms_name_required">Total Itemised items</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_selling_itemiseditem" id="summary_selling_itemiseditem" value="" size="15">
		<span id="summary_selling_itemiseditem_label"></span>
	</div>
	 </div>
	 
	 
	 
	 
	<div class="cmsms_column one_fourth" id="sm_profit">
	<h2>Profit</h2>
	 <label for="cmsms_name_required">Total Cost</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_profit_totalcost" id="summary_profit_totalcost" value="" size="15">
		<span id="summary_profit_totalcost_label"></span>
	</div>
	
	 <label for="cmsms_name_required">Total Selling Price</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_profit_sellingprice" id="summary_profit_sellingprice" value="" size="15">
		<span id="summary_profit_sellingprice_label"></span>
	</div>
	
	 <label for="cmsms_name_required">Total Profit</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_profit_totalprofit" id="summary_profit_totalprofit" value="" size="15">
		<span id="summary_profit_totalprofit_label"></span>
	</div>
	
	 <label for="cmsms_name_required">Total Profit Margin</label>
	<div class="form_field_wrap">
		<input type="hidden" name="summary_profit_totalmargin" id="summary_profit_totalmargin" value="" size="15">
		<span id="summary_profit_totalmargin_label"></span> %
	</div>
	 </div>
	 
	 </td>
	</tr>';
        $ReturnString .= '<tr>
	<td align="right" class="align-right" colspan="7">
	<input type="button" id="calculate_sumarry_total" name="calculate_sumarry_total" style="float:right"  value="Calculate Total Again"/>
	</tr>';

        $ReturnString .= '<tr>
	<td align="right" class="align-right" colspan="7">
	 <a href="#myModal_fav_amount" class="" data-toggle="modal"><input type="button" id="favourite_price" name="favourite_price" value="Save & Create Quote" /></a>&nbsp;&nbsp;&nbsp;<input type="submit" id="next" class="nextafterprice" name="next" value="Create Quote"/></td>
	</tr>';

        $ReturnString .='<div id="myModal_fav_amount" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Save Prices favourite</h4>
                </div>
                <div class="modal-body">
				    <div class="form-group">
                        <label for="email">Favourite price title : </label>
                             <input type="text" name="favouritepricetitle" id="favouritepricetitle" placeholder="Favourite price title" class="form-control">
                    </div>
				              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="savebtnprice">Save & Create Quote</button>                    
                </div>
            </div>
       </div>    
    </div>
	<script type="text/javascript">
	jQuery("#savebtnprice").click(function(){
	  if(jQuery("#favouritepricetitle").val().trim()!=""){	
	   //jQuery(".nextafterprice").trigger("click");	
	  jQuery("#myModal_fav_amount").modal("hide");
	  jQuery(".ewd-feup-edit-profile-form-price").submit();
	  }else{
		  alert("please provide favourite price title.")
		  
	  }
		
	})
	
	jQuery("#favourite_price").click(function(){
	   jQuery("#myModal_fav_amount").modal("show");	
	   jQuery("#favouritepricetitle").val("");
	})
	
	jQuery(".nextafterprice").click(function(){
	   jQuery("#favouritepricetitle").val("");
	
	})
	
	
	
	</script>
	
	';

        $ReturnString .= ' </tbody>
                      </table>';
        $ReturnString .='</div>';


        $ReturnString .='</div>';

        $ReturnString .='<input type="hidden" name="step" id="step" value="step4"/>';
        $ReturnString .='<input type="hidden" name="total_pr" id="total_pr" value="' . $FlagInc . '"/>';

        $ReturnString .= "</form>";
        $ReturnString .= "</div>";

        return $ReturnString;
    }

    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 5) {
        global $wpdb;
        $user_id = get_current_user_id();

        $companyName = GetUserFieldNameByID($user_id, 'Companyname');

        $ReturnString .= "<form action='#' method='post' id='ewd-feup-edit-profile-form' class='pure-form pure-form-aligned' enctype='multipart/form-data'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-check' value='" . sha1(md5($Time . $Salt)) . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-time' value='" . $Time . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-action' value='process-step-5-skip'>";
        $ReturnString .= "<input type='hidden' name='Omit_Fields' value='" . $omit_fields . "'>";
        $ReturnString .= "<input type='hidden' name='Omit_user_id' id='Omit_user_id' value='" . $User->User_ID . "'>";

        $ReturnString .='<p></p>';
        $ReturnString .='<div class="cmsms_row">';

        $ReturnString .= '<div class="cmsms_column one_first">';
        $ReturnString .='<div class="headline_text"><h1 class="entry-title">Method Statement</h1></div>';
        $ReturnString .='<div style="height: 50px; width: 378px; float: right;"><a href="#myModalLoadFavouriteQuoteWithMethod" class="" data-toggle="modal"><input type="button" id="load_favourite_quote_withprice" value="Load favourite method st" style="" /></a>&nbsp;&nbsp;<a href="' . site_url() . '/create-quote/?step=6"><input type="button"  name="skip" value="Skip Step"/></a>&nbsp;&nbsp;<a href="#myModal" class="" data-toggle="modal"><input type="button" id="help" value="Help" style="margin-right:10px; float:right;"></a></div>';
        $ReturnString .= ' <table class="cmsms_table">
                      <tbody>';
        $ReturnString .= '<tr>
	<td align="center" colspan="2">
	
	<div class="cmsms_column one_first">
  <h3 id="oranz">General requirements</h3>
    <h4><em>Tornado products:</em></h4>
      <p id="para1">Will be installed in accordance with the Installation Guidelines on the manufacturer&#39;s product data sheets (where applicable).</p>
    <h4><em>Installation of Tornado products:</em></h4>
       <p id="para1">Will be carried out by professional and trained fencing contractors only.</p>
       <p id="para1">Safe working methods will be adhered to and, where required, suitable protective clothing and equipment will be used.</p>
    <h4><em>Selection of the most suitable Tornado fencing products:</em></h4>
       <p id="para1">Will be undertaken by  ' . $companyName . '  unless otherwise specified by the customer and agreed with  ' . $companyName . ' prior to work commencing.</p>
    <h3 id="oranz">Fencing site preparation</h3>
    <h4><em>Removing old fence prior to new fence installation:</em></h4>
           <select id="gate_type_4" name="fence_prior_to_new">
               <option value="">Select</option>';

        $Settingoutthefencelines = GetMethodOptions('36');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select>
     <h4><em>Clearing the site of vegetation prior to new fence installation:</em></h4>
           <select id="gate_type_4" name="vegetation_prior_to_new">
               <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('38');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select>
    <h4><em>Clearing over-hanging trees prior to new fence installation:</em></h4>
                <p id="para1"><input type="radio" name="Overhanging" value="Overhanging1" id="r1">
               Overhanging trees are to be cleared by the customer – to a height of approximately <input  type="text" placeholder="Enter Height" name="Overhanging_by_customer_height" /> <label>metres</label>   – prior to the fence being installed</p></input>
                 
                 <p id="para1"><input type="radio" value="Overhanging2" name="Overhanging" id="r2">
               Quotation includes overhanging trees being cleared by  ' . $companyName . '  – to a height of approximately <input  type="text" placeholder="Enter Height" name="Quotation_by_contractor_height"/> <label> metres</label>  – prior to the fence being installed.</input></p> 
			   <a href="javascript:void(0)" id="cl">Click to clear</a>
			   
      <h4><em>Setting out the fence line:</em></h4>
           <select id="gate_type_4" name="Setting_out_the_fenceline">
           <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('21');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select>';

        $subPostsGap = GetStep1Data('subPostsGap');
        $ReturnString .='<h4><em>Underground services:</em></h4>
       <p id="para1">The customer should make  ' . $companyName . '  aware of and physically mark out any underground services prior to work commencing.</p>  
       <p id="para1"> ' . $companyName . '  cannot accept responsibility for any interruption or damage to underground services which have not been explicitly detailed prior to work commencing.</p>
     <h3 id="oranz">Intermediate posts</h3>
     <h4><em>Spacing of intermediate posts:</em></h4>
               <p id="para1"><input type="radio" name="intermediate_posts" value="imp1" id="r3"> Intermediate posts will be spaced at approximately <input name="Spacing_intermediate_posts_distance" type="text" value="' . $subPostsGap . '" placeholder="Enter Distance" /> <label>metres</label>  apart.</input></p>
 <p id="para1"><input type="radio" name="intermediate_posts" value="imp2" id="r4"> Intermediate posts will be up to approximately <input name="up_intermediate_posts_distance" type="text" placeholder="Enter Distance" value="' . $subPostsGap . '" /> <label>metres</label>  apart.</input></p> 
			   <a href="javascript:void(0)" id="c2">Click to clear</a>
     <h3><em>Depth of intermediate posts below ground level:</em></h3>
              <p id="para1"><input type="radio" name="Intermediate_posts_driven" value="Intermediate posts will be driven approximately millimetres %height% into the ground." id="r5"> Intermediate posts will be driven approximately <input name="Intermediate_posts_driven_distance" type="text" placeholder="Enter Distance" /> <label>millimetres</label> into the ground.</input></p> 
			  <a href="javascript:void(0)" id="c3">Click to clear</a>
       <p id="para1">Appropriate work will be undertaken to ensure stability of intermediate posts depending on ground conditions specific to post location.</p> 
    <h3 id="oranz">Straining / Turning posts</h3>
    <h4><em>Purpose and positioning of end posts, turning posts and strainer posts:</em></h4>
      <p id="para1">Straining / Turning posts will be set at every change in direction and every termination.</p>
    <h4><em>Construction of end strainer posts:</em></h4>
           <select id="gate_type_4" name="end_strainer_posts">
               <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('39');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select> 
       <p id="para1">Appropriate work will be undertaken to ensure stability of end strainer posts depending on ground conditions specific to post location.</p>
    <h4><em>Construction of turning posts:</em></h4>
           <select id="gate_type_4" name="turning_posts">
               <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('40');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select> 
       <p id="para1">Appropriate work will be undertaken to ensure stability of turning posts depending on ground conditions specific to post location.</p>
     <h3 id="oranz">Joining the fencing net</h3>        
     <h4><em>Method / finish:</em></h4>
           <select id="gate_type_4" name="Method_finish">
               <option value="">Select</option>';
        /* $Settingoutthefencelines =  GetMethodOptions('29');
          foreach($Settingoutthefencelines as $Settingoutthefenceline)
          {
          $ReturnString .='<option value="'.str_replace("'"," ",str_replace("%cmp%",$companyName,$Settingoutthefenceline->option_value)).'">'.str_replace("%cmp%",$companyName,$Settingoutthefenceline->option_value).'</option>';
          } */
        $joiner_step5 = GetStep2Data('joiner');
        $joiner_productname = GetProductNameByID($joiner_step5);
        $Product_List = Quote_Process_List('joiners');
        foreach ($Product_List as $PLR) {
            if ($joiner_productname == $PLR->product_name) {
                $ReturnString .='<option value="' . $PLR->product_name . '" selected="selected">' . $PLR->product_name . '</option>';
            } else {
                $ReturnString .='<option value="' . $PLR->product_name . '">' . $PLR->product_name . '</option>';
            }
        }

        $ReturnString .='</select>
     <h3 id="oranz">Tensioning Net</h3> 
     <h4><em>Method:</em></h4>
           <select id="gate_type_4" name="Method">
               <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('30');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }
        $staplesId = GetStep2Data('staples');
        $ReturnString .='</select>         
     <h3 id="oranz">Staples and stapling method</h3> 
     <h4><em>Number of staples and stapling method:</em></h4>
        <p id="para1">Tornado ' . GetProductNameByID($staplesId) . ' will be used to staple the appropriate intermediate line wires, as well as any top or bottom line wires.</p>
        <p id="para1">The fencing net will be stapled on the most appropriate line wires and posts for the product specification being used.</p>
        <p id="para1">Staples will not be driven home against line wires.</p>
     <h3 id="oranz">Gateways</h3> 
     <h4><em>Hanging gates:</em></h4>
           <select id="gate_type_4" name="Hanging_gates">
               <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('28');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select>       
     <h3 id="oranz">Terminations</h3> 
     <h4><em>Type / method:</em></h4>
           <select id="gate_type_4" name="Type_method">
               <option value="">Select</option>';
        $stapleType = 'Tornado ' . GetProductNameByID($staplesId);
        $Settingoutthefencelines = GetMethodOptions('42');
        $termination_step5 = GetStep2Data('terminations');



        /* foreach($Settingoutthefencelines as $Settingoutthefenceline)
          {
          $ReturnString .='<option value="'.str_replace("'"," ",str_replace("%stpl%",$stapleType,$Settingoutthefenceline->option_value)).'">'.str_replace("%stpl%",$stapleType,$Settingoutthefenceline->option_value).'</option>';
          } */
        if ($termination_step5 == "Tie-off") {
            $ReturnString .='<option value="Tie-off" selected="selected">Tie-off</option>';
        } else {
            $ReturnString .='<option value="Tie-off">Tie-off</option>';
        }

        if ($termination_step5 == "T-Clips") {
            $ReturnString .='<option value="T-Clips" selected="selected">T-Clips</option>';
        } else {
            $ReturnString .='<option value="T-Clips">T-Clips</option>';
        }

        if ($termination_step5 == "Staple") {
            $ReturnString .='<option value="Staple" selected="selected">Staple</option>';
        } else {
            $ReturnString .='<option value="Staple">Staple</option>';
        }




        $ReturnString .='</select>
     <h3 id="oranz">Finishing off</h3> 
     <h4><em>After the fence has been installed:</em></h4>
        <p id="para1">Upon completion, the project site will be left tidy with no wire off-cuts or debris left behind.</p>
        <p id="para1">The completed fence will be checked for slack line wires and loose posts.</p>
        <p id="para1">The customer will be invited to inspect the completed fence with  ' . $companyName . '  to ensure satisfaction.</p>             
        <p id="para1"> </p> 
     <h3 id="oranz">Maintenance</h3> 
     <h4><em>Recommendations for fence maintenance:</em></h4>
           <select id="gate_type_4" name="fence_maintenance">
               <option value="">Select</option>';
        $Settingoutthefencelines = GetMethodOptions('44');
        foreach ($Settingoutthefencelines as $Settingoutthefenceline) {
            $ReturnString .='<option value="' . str_replace("'", " ", str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value)) . '">' . str_replace("%cmp%", $companyName, $Settingoutthefenceline->option_value) . '</option>';
        }

        $ReturnString .='</select>
           
          
 </div>
	
	
	
	</td>
	
	</tr>';

        $ReturnString .= '<tr>
	<td></td>
	<td align="right" class="align-right"><a href="' . site_url() . '/create-quote/?step=6"><input type="button"  name="skip" value="Skip Step"/></a>&nbsp;<input type="button" id="nextsaveStep" name="nextsaveStep" value="Save & Next Step"/>&nbsp;<input type="submit" id="SkipStep" name="next" value="Next Step"/></td>
	
	</tr>';
        $ReturnString .= ' </tbody>
                      </table>';

        $ReturnString .='<div id="myModal_fav_method" class="modal fade" style="top: 67px; z-index: 9999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Save method statement favourite</h4>
                </div>
                <div class="modal-body">
				    <div class="form-group">
                        <label for="email">Favourite method statement title : </label>
                             <input type="text" name="favouritemethodtitle" id="favouritemethodtitle" placeholder="Favourite method statement" class="form-control">
                    </div>
				              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="savebtnmethod">Save & Create Quote</button>                    
                </div>
            </div>
       </div>    
    </div>
	<script type="text/javascript">
	jQuery("#savebtnmethod").click(function(){
	  if(jQuery("#favouritemethodtitle").val().trim()!=""){	
	   //jQuery(".nextafterprice").trigger("click");	
	  jQuery("#myModal_fav_method").modal("hide");
	  jQuery("#ewd-feup-edit-profile-form").submit();
	  }else{
		  alert("Please provide Favourite method statement title.")
		  
	  }
		
	})
	
	jQuery("#nextsaveStep").click(function(){
	   jQuery("#myModal_fav_method").modal("show");	
	   jQuery("#favouritemethodtitle").val("");
	})
	
	jQuery(".nextafterprice").click(function(){
	   jQuery("#favouritemethodtitle").val("");
	
	})
	</script>';

        $ReturnString .='</div>';


        $ReturnString .='</div>';

        $ReturnString .='<input type="hidden" name="step" id="step" value="step5"/>';
        //$ReturnString .='<input type="hidden" name="post_types_map" id="post_types_map" value=""/>';
        $ReturnString .='<input type="hidden" name="post_map_potitions" id="post_map_potitions" value=""/>';
        $ReturnString .= "</form>";
        $ReturnString .= "</div>";

        return $ReturnString;
    }


    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 6) {


        $ReturnString.='<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
<script type="text/javascript">


tinymce.init({
	 menubar : false,
	selector: "textarea",
	toolbar: " bold italic | bullist numlist",
});
</script>';


        $ReturnString .= "<form action='#' method='post' id='ewd-feup-edit-profile-form' class='pure-form pure-form-aligned' enctype='multipart/form-data'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-check' value='" . sha1(md5($Time . $Salt)) . "'>";
        $ReturnString .= "<input type='hidden' name='ewd-feup-time' value='" . $Time . "'>";
        $ReturnString .= "<input type='hidden' id='ewd-feup-action' name='ewd-feup-action' value='process-step-6'>";
        $ReturnString .= "<input type='hidden' name='Omit_Fields' value='" . $omit_fields . "'>";
        $ReturnString .= "<input type='hidden' name='Omit_user_id' id='Omit_user_id' value='" . $User->User_ID . "'>";


        $ReturnString .='<p></p>';
        $ReturnString .='<div class="cmsms_row" align="center">';
        $logo = GetUserFieldNameByID($User->User_ID, 'logo');
        $Companyname = GetUserFieldNameByID($User->User_ID, 'Companyname');
        $Address = GetUserFieldNameByID($User->User_ID, 'CompanyAddress');
        $Address2 = GetUserFieldNameByID($User->User_ID, 'Address2');
        $Town = GetUserFieldNameByID($User->User_ID, 'Town');
        $County = GetUserFieldNameByID($User->User_ID, 'County');
        $Postcode = GetUserFieldNameByID($User->User_ID, 'Postcode');
        $Tel = GetUserFieldNameByID($User->User_ID, 'Telephonenumber');
        $Email = GetUserFieldNameByID($User->User_ID, 'Email');
        $VatNumber = GetUserFieldNameByID($User->User_ID, 'VATregistrationnumber');
        $CompanyRegistrationNumber = GetUserFieldNameByID($User->User_ID, 'Companyregistrationnumber');
        $upload_dir = wp_upload_dir();
        $customer_name = GetStep1Data('customer_name');
        $post_code = GetStep1Data('postcode');
        if (!empty($post_code)) {
            $prcode = ", " . $post_code;
        } else {
            $prcode = '';
        }
        $customer_address = GetStep1Data('customer_address') . $prcode;
        $contract_title = GetStep1Data('contract_title');
        $Referencenumber = GetStep1Data('reference_number');
        $FenceType = GetStep2Data('net_wire');
        $intermediate_fence_post = GetStep3Data('intermediate_fence_post');
        $GetStep4Data = GetStep4Data('Projects');
        $post_map_potitions = GetStep1Data('post_map_potitions');
        $post_types_map = GetStep1Data('post_types_map');
        /* step6 data */
        $quotation_type = GetStep6Data('quote_type');
        $additional_notes = GetStep6Data('additional_notes');
        if (empty($additional_notes)) {
            $additional_notes = get_user_meta($User->User_ID, "quote_term_condition", true);
        }
        $save_type = GetPdfSaveType($quote_id = NULL, 'arr');
        $additionalnotesvalues = GetStep6Data('additional_notes_values');
        /* endhere */
        $post_map_potitions = str_replace('(', '', $post_map_potitions);
        $post_map_potitions = str_replace(')', '', $post_map_potitions);
        $post_map_potitions = rtrim($post_map_potitions, '|');

        $post_types_map = rtrim($post_types_map, '|');
        $PostTypeMap = explode('|', $post_types_map);
        $PostMapPotitions = explode('|', $post_map_potitions);

        if ($VatNumber != '') {
            $vt_no = "| VAT Number : " . $VatNumber;
        } else {
            $vt_no = '';
        }

        $Product_List_SpArray = Quote_Process_ListByPostTypeArray('strainer_posts');

        $ReturnString .='<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="12"></td>
  </tr>
  <tr>
    <td height="12" align="center"><h1>Quotation</h1><hr/></td>
  </tr>
  <tr>
    <td height="12"></td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" font-family:arial; font-size:18px; color:#000; font-weight:bold; text-align:center;">
      <tr>
        <td height="60">';
        $ReturnString .= '<div class="cmsms_column one_first">';
        $ReturnString .= '<div class="cmsms_column one_third"></div>';



        $ReturnString .= '<div class="cmsms_column one_third"><img src="' . $upload_dir['baseurl'] . '/ewd-feup-user-uploads/' . $logo . '"/><br><br></div>';
        $ReturnString .= '<div class="cmsms_column one_third"></div>';
        $ReturnString .='</div>';
        $ReturnString .= '<div class="cmsms_column one_first"><p style="text-align:center">';
        $ReturnString .='Tel : ' . $Tel . ' | Email : ' . $Email . ' ' . $vt_no . '</p></div>';

        $ReturnString .='</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25"></td>
  </tr>
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" font-family:arial; font-size:14px; color:#000;">
      <tr>
        <td width="153" height="10" align="left"><strong>Company Address</strong></td>
        <td width="22"></td>
        <td width="475"><span style="font-family:arial; font-size:14px; color:#000;">';
        $str_address = '';
        if ($Companyname != "") {
            $str_address .=$Companyname . ' | ';
        }
        if ($Address != "") {
            $str_address .=$Address . ' | ';
        }
        if ($Address2 != "") {
            $str_address .=$Address2 . ' | ';
        }
        if ($Town != "") {
            $str_address .=$Town . ' | ';
        }
        if ($County != "") {
            $str_address .=$County . ' | ';
        }
        if ($Postcode != "") {
            $str_address .=$Postcode . ' | ';
        }
        $Rtrim_address = rtrim($str_address, ' | ');
        $ReturnString .=$Rtrim_address;
        $ReturnString .='</span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" font-family:arial; font-size:14px; color:#000;">
      <tr>';
        if ($VatNumber != "") {
            $ReturnString .='<td width="152" height="10" align="left"><strong>VAT Registration</strong></td>
        <td width="22"></td>
        <td width="143">' . $VatNumber . '</td>';
        } else {
            $ReturnString .='<td width="152" height="10" align="left"></td>
        <td width="22"></td>
        <td width="143"></td>';
        }

        $ReturnString .='<td width="188" align="center"><strong>Date</strong></td>
        <td width="20"></td>
        <td width="125">' . date('jS F Y', strtotime(date('Y-m-d'))) . '</td>
      </tr>
      <tr>
        <td height="10" align="right"></td>
        <td colspan="5"></td>
      </tr>
      <tr>';
        if ($CompanyRegistrationNumber != "") {
            $ReturnString .='<td height="10" align="left"><strong>Company Registration</strong></td>
        <td></td>
        <td>' . $CompanyRegistrationNumber . '</td>';
        } else {
            $ReturnString .='<td height="10" align="left"></td>
        <td></td>
        <td></td>';
        }
        $ReturnString .='<td align="center"><strong>Reference Number</strong></td>
        <td></td>
        <td>(' . $Referencenumber . ')</td>
      </tr>
      <tr>
        <td height="10" align="right"></td>
        <td colspan="5"></td>
      </tr>
      <tr>
        <td height="10" align="left"><strong>Email</strong></td>
        <td></td>
        <td colspan="4">' . $Email . '</td>
        </tr>
      <tr>
        <td height="10" align="right"></td>
        <td colspan="5"></td>
      </tr>
      <tr>
        <td height="10" align="left"><strong>Telephone</strong></td>
        <td></td>
        <td colspan="4">' . $Tel . '</td>
        </tr>
      <tr>
        <td height="10" align="right"></td>
        <td colspan="5"></td>
      </tr>
      <tr>
        <td height="12" colspan="6" align="left"></td>
        </tr>
      <tr>
        <td height="10" colspan="6" align="left"> <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:2px solid #000; font-size:12px;">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td height="12" colspan="6" align="left"></td>
        </tr>
      <tr>
        <td height="10" align="left"><strong>Customer Name</strong></td>
        <td></td>
        <td colspan="4">' . $customer_name . '</td>
        </tr>
      <tr>
        <td height="10" align="right"></td>
        <td colspan="5"></td>
      </tr>
      <tr>
        <td height="10" align="left"><strong>Project Name</strong></td>
        <td></td>
        <td colspan="4">' . $contract_title . '</td>
        </tr>
      <tr>
        <td height="10" align="right"></td>
        <td colspan="5"></td>
      </tr>
      <tr>
        <td height="10" align="left"><strong>Project Address</strong></td>
        <td></td>
        <td colspan="4">' . $customer_address . '</td>
        </tr>
      <tr>
        <td height="12" colspan="6" align="left"></td>
      </tr>
      <tr>
        <td height="12" colspan="6" align="left"><table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:2px solid #000; font-size:12px;">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25"></td>
  </tr>  
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="143" style="font-family:arial; font-size:22px; color:#000;">Select Type</td>
        <td width="507" style="font-family:arial; font-size:22px; color:#253f8e;"><select name="quote_type" id="quote_type"><option value="Quotation" ' . (($quotation_type == "Quotation") ? 'selected="selected"' : '') . '>QUOTATION</option><option value="Estimate" ' . (($quotation_type == "Estimate") ? 'selected="selected"' : '') . '>ESTIMATE</option></select></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" font-family:arial; font-size:14px; color:#000;">
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td height="10">To supply and install ' . round(GetStep1Data('FenceLine')) . ' metres of Tornado ' . GetProductNameByID($FenceType) . '</td>
      </tr>
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td height="10">With';


        //Top Line Wires
        $TopLineWire = array();
        $TopLineWire[] = GetStep2Data('top_line_wire_1');
        $TopLineWire[] = GetStep2Data('top_line_wire_2');
        $TopLineWire[] = GetStep2Data('top_line_wire_3');
        $TopLineWire[] = GetStep2Data('top_line_wire_5');
        $TopLineWire[] = GetStep2Data('top_line_wire_6');
        $TopLineWire[] = GetStep2Data('top_line_wire_4');
        $BottomLineWire = GetStep2Data('bottom_line_wire');

        $TopLineWireFilter = array_filter($TopLineWire);
        $TopLineWireFilterUnique = array_unique($TopLineWireFilter);
        $newArrayAfterDiff = array_diff_key($TopLineWireFilter, $TopLineWireFilterUnique);
        $ReturnString1 = '';
        foreach ($TopLineWireFilterUnique as $TLWFU) {
            //Check if Key Already Exists
            $TotalFenceWireAdditional = round(GetStep1Data('FenceLine'));
            $TotalFenceWireAdditionalLength = round(GetStep1Data('FenceLine'));
            $i = 1;
            foreach ($newArrayAfterDiff as $NAAD) {
                if ($NAAD == $TLWFU) {

                    // $TotalFenceWireAdditionalLength +=$TotalFenceWireAdditional;
                    $i++;
                }
            }

            $ReturnString1 .= ' ' . $i . ' x  Tornado ' . GetProductNameByID($TLWFU) . ' top lines,';
        }

        $Rtrim_ReturnString1 = rtrim($ReturnString1, ',');
        $ReturnString .=$Rtrim_ReturnString1;
        if ($BottomLineWire != "" || $BottomLineWire != 0) {
            $ReturnString .=' and Tornado ' . GetProductNameByID($BottomLineWire) . " bottom line";
        }

        $ReturnString .='</td>
      </tr>
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td height="16"><span style="font-family:arial; font-size:14px; color:#000;">On ' . GetProductNameByID($intermediate_fence_post) . '  with ';
        $ProductNameArray = array();
        foreach ($GetStep4Data as $Key => $values) {

            if (in_array($Key, $Product_List_SpArray)) {
                $ProductNameArray[] = " " . GetProductNameByID($Key);
            }
        }

        if (count($ProductNameArray) > 0) {
            $ReturnString.= join(',', $ProductNameArray);
        }

        $ReturnString .= ' posts </span> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  align="left"><strong>Price / mtr</strong></td>
        <td  align="center"><strong>£ ' . GetStep4Data('summary_selling_permeter') . '</strong></td>
        <td  align="right"><strong>£ ' . GetStep4Data('summary_selling_sellingprice') . '</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25"></td>
  </tr>';
        $totalCheckedPrice = 0;
        if (GetStep4DataItemIsed('Projects') == true) {

            $ReturnString .='
  <tr>
   <td height="10">';



            $ReturnString .='<table width="100%">';
            $ReturnString .='<tr>';
            $ReturnString .='<th>Items not included in £/Mtr Price</th>';
            $ReturnString .='<th>Qty</th>';
            $ReturnString .='<th>£/each</th>';
            $ReturnString .='<td align="right">Line Total</td>';
            $ReturnString .='</tr>';
            $totalCheckedPrice = 0;
            $ReturnString .='<tr>
        <td height="15" colspan="4"></td>
       
      </tr>';
            $OtherWorkArray = array('10008', '10009', '10010', '10011');
            $OtherProductList = Quote_OtherWorkPrice_List_ID();
            foreach ($GetStep4Data as $PrKey => $PrValue) {
                if ($PrValue['product_check'] == 1) {

                    if ($PrValue['product_id'] == 'Gpaks') {
                        $ProductName = 'Gpaks';
                    } else {
                        if (in_array($PrKey, $OtherProductList)) {

                            $ProductName = GetOtherProductNameByID($PrKey);
                            if (in_array($PrKey, $OtherWorkArray)) {

                                $other_desc = GetOtherDescByUser($PrKey, $User->User_ID);
                                @$other_desc_val = $other_desc[0]->descr;
                                if (empty($other_desc_val)) {
                                    $ProductName = GetOtherProductNameByID($PrKey);
                                } else {
                                    $ProductName = $other_desc_val;
                                }
                            }
                        } else {
                            $ProductName = GetProductNameByID($PrKey);
                        }
                    }
                    $User_Id = get_current_user_id();
                    $other_desc = GetOtherProductDescByUser($PrKey, $User_Id);
                    @$other_desc_val = $other_desc[0]->descr;
                    if (empty($other_desc_val)) {
                        $other_desc_val1 = $ProductName;
                    } else {
                        $other_desc_val1 = $other_desc_val;
                    }
                    $PricePerMeterValue = $PrValue['selling'] / $PrValue['length'];
                    $ReturnString .='<tr>
        <td height="30"><span style="font-family:arial; font-size:14px; color:#000;">' . $other_desc_val1 . '</span></td>
        <td height="30"> <strong>' . $PrValue['length'] . '</strong></td>
	   <td height="30"> <strong>£ ' . number_format($PricePerMeterValue, 2) . '</strong></td>
		  <td height="30" align="right"> <strong>£ ' . number_format($PrValue['selling'], 2) . '</strong></td>
      </tr>';


                    $totalCheckedPrice +=$PrValue['selling'];
                }
            }
            $ReturnString .='<tr>
        <td height="15" colspan="4"></td>
       
      </tr>';
            $ReturnString .='<tr>
          <td  align="left"></td>
         
	      <td  align="right" colspan="2" height="30"><strong>Additional items Total</strong></td>
		  <td  align="right"  width="120" height="30"> <strong>£ ' . number_format($totalCheckedPrice, 2) . '</strong></td>
      </tr>';

            $ReturnString .='
    </table>';

            $ReturnString .='</td>
  </tr>
 </table>';

            $ReturnString .='</td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>';
        }
        $ReturnString .='
  <tr>
    <td>';

        $ReturnString .='<table width="100%">';
        $sub_total = $totalCheckedPrice + GetStep4Data('summary_selling_sellingprice');
        $ReturnString .='<tr>
          <td   align="left"></td>
         
	      <td  align="right" colspan="2">Sub Total</td>
		  <td   align="right" width="120">£ ' . number_format($sub_total, 2) . '<input type="hidden" name="subtotal" value="' . $sub_total . '"/></td>
      </tr>';
        $vatvalue = 0;
        if ($VatNumber != "") {
            $vatvalue = $sub_total * 0.2;



            $ReturnString .='<tr>
          <td height="30"  align="left"></td>
         
	      <td height="30" align="right" colspan="2">Vat (20%)</td>
		  <td height="30" align="right" width="120">£ ' . number_format($vatvalue, 2) . '<input type="hidden" name="vatvalue" value="' . $vatvalue . '"/></td>
      </tr>';
        }

        $total = $vatvalue + $sub_total;

        $ReturnString .='<tr>
          <td height="30"  align="left"></td>
         
	      <td height="30"  align="right" colspan="2"><strong>Total Project Price</strong></td>
		  <td height="30"  align="right" width="120"> <strong>£ ' . number_format($total, 2) . '</strong><input type="hidden" name="subtotal" value="' . $total . '"/></td>
      </tr>';


        $ReturnString .='
    </table>';

        $ReturnString .='</td>
  </tr>
   <tr>
    <td height="70">&nbsp;</td>
  </tr>
  <tr>
    <td height="70">&nbsp;</td>
  </tr>
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  style="font-family:arial; font-size:22px; color:#000;width:90% "><strong id="additionaltext">' . (($additionalnotesvalues != "") ? strtoupper($additionalnotesvalues) : 'Terms and Conditions') . '</strong><input type="text"  id="additional_notes_values" name="additional_notes_values" value="' . (($additionalnotesvalues != "") ? strtoupper($additionalnotesvalues) : 'Terms and Conditions') . '" style="display: none;"/><input type="hidden"  id="additionalnotesvalues" name="additionalnotesvalues" value="Terms and Conditions" /></td>
        <td width="408" style="font-family:arial; font-size:22px; color:#253f8e;"><a href="javascript:;" name="additional_notes_title" id="additional_notes_title">Edit title</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" align="left"></td>
  </tr>
  <tr>
    <td height="10"><textarea name="additional_notes" id="additional_notes" cols="77" style="width:99%; font-size:14px;" rows="10">' . $additional_notes . '</textarea></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
   <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="font-family:arial; font-size:22px; color:#000;"><strong>PROJECT LOCATION</strong> </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td height="10"><table border="0" cellspacing="0" cellpadding="0" style="border:0px solid #ccc; width:100%; height:600px; text-align:center; font-size:30px;">
      <tr>
        <td height="10">';
        $marker = '';
        if (count($PostTypeMap) > 0) {
            $j = 0;

            //print_r($PostTypeMap);
            foreach ($PostTypeMap as $post_type) {

                $iconurl = "http://google.com/mapfiles/ms/micons/";

                if ($post_type == "") {
                    $icon = 'red-dot.png';
                    $title = '';
					$color='red';
                }

                if ($post_type == "end_post_st") {
                    $icon = 'green-dot.png';
                    $title = 'End post (strutted)';
					$color='green';
                }

                if ($post_type == "corner_post_st") {
                    $icon = 'blue-dot.png';
                    $title = 'Corner post (strutted)';
					$color='blue';
                }

                if ($post_type == "standard_gateway_st") {
                    $icon = 'yellow-dot.png';
                    $title = 'Standard gateway (strutted)';
					$color='yello';
                }

                if ($post_type == "free_standing_gateway_st") {
                    $icon = 'ltblue-dot.png';
                    $title = 'Free-standing gateway (strutted)';
					$color='ltblue';
                }

                if ($post_type == "end_post_box") {
                    $icon = 'orange-dot.png';
                    $title = 'End post (box assembly)';
					$color='ornage';
                }

                if ($post_type == "corner_post_box") {
                    $icon = 'pink-dot.png';
                    $title = 'Corner post (box assembly)';
					$color='pink';
                }

                if ($post_type == "standard_gateway_box") {
                    $icon = 'purple-dot.png';
                    $title = 'Standard gateway (box assembly)';
					$color='purple';
                }

                if ($post_type == "free_standing_gateway_box") {
                    $icon = 'red-dot.png';
                    $title = 'Free-standing gateway (box assembly)';
					$color='red';
                }

                if ($post_type == "turning_post_unstrutted") {
                    $icon = 'green-dot.png';
                    $title = 'Turning post unstrutted';
					$color='green';
                }
                //$marker .="&markers=label:" . $title . "|icon:http://google.com/mapfiles/ms/micons/" . $icon . "|" . $PostMapPotitions[$j] . "";
				
				$marker .="&markers=label:".$title."|color:".$color."|".$PostMapPotitions[$j]."";
                $j++;
            }
        }

        $msg = '';
        if (isset($_REQUEST['msg'])) {
            $msg = 'success';
        }

		
			$markerlength=json_decode(GetStep1Data('markerlength'));
			//echo "Quotation Id=".$_REQUEST['quotationid']; exit;
			//echo "<pre>";
			if(!empty($markerlength))	{
				$postmappositions=explode('|',$post_map_potitions);
				$path='path=color:0xffff00|weight:2|';
		
		
			$i=0;
			
			if(sizeof($markerlength)){
				foreach($markerlength as $key=>$val){
					foreach($postmappositions as $key1=>$val1){
						$testarray[$i][$key1]=$val1;
						if($key1==$val){
						  break;
						}	
					}
					$i++;
				}
				
				if(!array_key_exists($key+1,$markerlength)){
					$i++;
					for($j=$val+1;$j<sizeof($postmappositions);$j++){
						$testarray[$i][$j]=$postmappositions[$j];
					}
				}
			}
			
			foreach($testarray as $key=>$val){
				$newarray[]=$val;
			}
			$testarray=$newarray;
			
			foreach($testarray as $key=>$val){
				
				if($key > 0){
					foreach($testarray[$key-1] as $key1=>$val1){
						if(array_key_exists($key1+1,$testarray[$key-1])){
							$intendedkey=$key1+1;
							//$intendedkey=$intendedkey+1;
							for($i=0;$i<=$intendedkey;$i++){
								unset($testarray[$key][$i]);
							}
							
						}
					}
					
				}
			}
			
			foreach($testarray as $key=>$val){
				if($key > 0){
					if (substr($path, -1, 1) == '|')
						{
						  $path = substr($path, 0, -1);
						}
					$path.="&path=color:0xffff00|weight:2|";
				}
				
				foreach($val as $key1=>$val1){
					$path.=$val1;
					
					if(array_key_exists($key1,$val))
						$path.="|";
				}
				
			}
		
			if(substr($path, -1, 1) == '|')
				{
				  $path = substr($path, 0, -1);
				}
				
			$ReturnString .='<img src="http://maps.googleapis.com/maps/api/staticmap?'.$path.'&size=640x640&maptype=satellite'.$marker.' &sensor=false&key=AIzaSyBYa2HSDHt9W-RAOd3PzRHmFV_R-Z8ac2k"/>';
			}
			else{
				$ReturnString .='<img src="http://maps.googleapis.com/maps/api/staticmap?path=color:0xffff00|weight:2|' . $post_map_potitions . '&size=640x640&maptype=satellite' . $marker . ' &sensor=false&key=AIzaSyBYa2HSDHt9W-RAOd3PzRHmFV_R-Z8ac2k"/>';
			}
			
		
        //$ReturnString .='<img src="//maps.googleapis.com/maps/api/staticmap?path=color:0xffff00|weight:2|' . $post_map_potitions . '&size=640x640&zoom=16&maptype=satellite' . $marker . '"/>';
        $save_type_arr = array('MethodStatement', 'Quoation', 'LocationMap', 'Materials');
        $ReturnString .='</td>
		<td><table id="quotesavedmsg"> 
		<tr><td colspan="2" style="font-size:15px; color:#3F9021;"><span>' . (($msg == 'success') ? 'Your quotation has been saved successfully.' : '') . '</span></td></tr>
		<tr><td colspan="2"><h3>Print & Save Options</h3></td></tr>
		<tr>
		<td width="50px" align="right"><input type="checkbox" name="save_type[]" id="quotation" ' . (in_array('Quoation', $save_type) ? 'checked' : (empty($save_type) ? 'checked' : '') ) . '  value="Quotation"></td>
		<td style="font-size:15px; padding-left:5px;" align="left"> Quotation</td>
		</tr>
		<tr>
		<td width="50px" align="right"><input type="checkbox" name="save_type[]" id="methodstatement" ' . (in_array('MethodStatement', $save_type) ? 'checked' : '' ) . ' value="MethodStatement"></td>
		<td style="font-size:15px;padding-left:5px;" align="left"> Method Statement</td>
		</tr>
		<tr>
		<td width="50px" align="right"><input type="checkbox" name="save_type[]" id="locationmap" ' . (in_array('LocationMap', $save_type) ? 'checked' : '' ) . ' value="LocationMap"></td>
		<td style="font-size:15px;padding-left:5px;" align="left"> Location Map</td>
		</tr>
		
		<tr>
		<td width="50px" align="right"><input type="checkbox" name="save_type[]" id="materials" ' . (in_array('Materials', $save_type) ? 'checked' : '' ) . ' value="Materials"></td>
		<td style="font-size:15px;padding-left:5px;" align="left"> Materials</td>
		</tr>
		<tr>
		<td colspan="2"><input type="submit" name="saveaccount" id="saveaccount" value="Save to my account"> <input type="submit" name="printpdf" id="printpdf" value="Print PDF"></td>		
		</tr>
		<tr>
		<td colspan="2" align="center" style="font-size:13px;"></td>		
		</tr>
		</table></td>		
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
   <tr>
    <td height="20">&nbsp;</td>
  </tr>
   <tr>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td height="10"><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="344" align="left"><!----<span style=" float:left"><img src="' . $upload_dir['baseurl'] . '/ewd-feup-user-uploads/' . $logo . '" /></span>----></td>
        <td width="306" align="right"><!-----<span style="font-family:arial; font-size:16px; color:#253f8e; font-weight:bold;">' . $Companyname . ' <span id="typeproject">Quotation</span></span>---></td>
      </tr>
    </table>
	
	
	</td>
  </tr>
</table>';



        $ReturnString .='</div>';

        $ReturnString .='<input type="hidden" name="step" id="step" value="step5"/>';

        $ReturnString .= "</form>";
        $ReturnString .= "</div>";

        return $ReturnString;
    }

    if (isset($_REQUEST['step']) && $_REQUEST['step'] == 7) {



        //Create the client object
       
        //Use the functions of the client, the params of the function are in 
        //the associative array
        global $wpdb, $user_message, $feup_success;
        global $ewd_feup_fields_table_name, $ewd_feup_user_table_name, $ewd_feup_user_fields_table_name;

        $Custom_CSS = get_option("EWD_FEUP_Custom_CSS");
        $Salt = get_option("EWD_FEUP_Hash_Salt");
        $Time = time();

        $CheckCookie = CheckLoginCookie();

        if ($CheckCookie['Username'] == '') {
            FEUPRedirect('user-login');
        }

        $Sql = "SELECT * FROM $ewd_feup_fields_table_name WHERE Field_Show_In_Front_End='Yes' ORDER BY Field_Order";
        $Fields = $wpdb->get_results($Sql);
        $User = $wpdb->get_row($wpdb->prepare("SELECT ID as User_ID  FROM " . $wpdb->prefix . "users WHERE id='%s'", $CheckCookie['User_ID']));
        $UserData = $wpdb->get_results($wpdb->prepare("SELECT * FROM $ewd_feup_user_fields_table_name WHERE User_ID='%d'", $User->User_ID));
        $UserDataAccount = $wpdb->get_results("SELECT * FROM $ewd_feup_user_fields_table_name WHERE User_ID='" . $User->User_ID . "' and Field_ID='17'");
        $UserQuotation = $wpdb->get_results("SELECT * FROM $wp_ewd_quotation WHERE quotation_key='" . session_id() . "'");
        // echo  "SELECT * FROM $wp_ewd_quotation WHERE quotation_key='".session_id()."'";
        $quote_id = $UserQuotation[0]->quotation_id;
        $FieldArray = array();
        $FielNameArray = array(
            'companyname' => 'CompanyName',
            'companyaddress' => 'Address1',
            'address2' => 'Address2',
            'address3' => 'Address3',
            'town' => 'Town',
            'county' => 'County',
            'postcode' => 'PostCode',
            'companyregistrationnumber' => 'CoRegNumber',
            'vatregistrationnumber' => 'VatRegNumber',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'EmailAddress');



        foreach ($UserData as $UserDatas) {

            foreach ($UserDatas as $key => $value) {
                if ($key == 'Field_Name')
                    $FieldKey = $FielNameArray[strtolower(preg_replace('/\s+/', '', $value))];

                if ($key == 'Field_Value')
                    $FieldValue = $value;
            }
            if ($FieldKey != '')
                $FieldArray[$FieldKey] = $FieldValue;
        }

        $xmlCompanyContact = '<?xml version="1.0" standalone="yes"?>
                                          <AjayLead><Contractor>';

        foreach ($FieldArray as $key1 => $value1) {
            $xmlCompanyContact .='<' . $key1 . '>' . $value1 . '</' . $key1 . '>';
        }
        $xmlCompanyContact .='<AccountNo>' . $UserDataAccount[0]->Field_Value . '</AccountNo>';

        $xmlCompanyContact .='</Contractor></AjayLead>';




        $post_map_potitions = GetStep1Data('post_map_potitions', $quote_id);
        $post_types_map = GetStep1Data('post_types_map', $quote_id);
        $post_map_potitions = str_replace('(', '', $post_map_potitions);
        $post_map_potitions = str_replace(')', '', $post_map_potitions);
        $post_map_potitions = rtrim($post_map_potitions, '|');
        $post_types_map = rtrim($post_types_map, '|');
        $PostTypeMap = explode('|', $post_types_map);
        $PostMapPotitions = explode('|', $post_map_potitions);
        $marker = '';
        if (count($PostTypeMap) > 0) {
            $j = 0;

            //print_r($PostTypeMap);
            foreach ($PostTypeMap as $post_type) {

                $iconurl = "http://google.com/mapfiles/ms/micons/";

                if ($post_type == "") {
                    $icon = 'red-dot.png';
                    $title = '';
                }

                if ($post_type == "end_post_st") {
                    $icon = 'green-dot.png';
                    $title = 'End post (strutted)';
                }

                if ($post_type == "corner_post_st") {
                    $icon = 'blue-dot.png';
                    $title = 'Corner post (strutted)';
                }

                if ($post_type == "standard_gateway_st") {
                    $icon = 'yellow-dot.png';
                    $title = 'Standard gateway (strutted)';
                }

                if ($post_type == "free_standing_gateway_st") {
                    $icon = 'ltblue-dot.png';
                    $title = 'Free-standing gateway (strutted)';
                }

                if ($post_type == "end_post_box") {
                    $icon = 'orange-dot.png';
                    $title = 'End post (box assembly)';
                }

                if ($post_type == "corner_post_box") {
                    $icon = 'pink-dot.png';
                    $title = 'Corner post (box assembly)';
                }

                if ($post_type == "standard_gateway_box") {
                    $icon = 'purple-dot.png';
                    $title = 'Standard gateway (box assembly)';
                }

                if ($post_type == "free_standing_gateway_box") {
                    $icon = 'red-dot.png';
                    $title = 'Free-standing gateway (box assembly)';
                }

                if ($post_type == "turning_post_unstrutted") {
                    $icon = 'green-dot.png';
                    $title = 'Turning post unstrutted';
                }
                $marker .="&markers=label:" . $title . "|icon:http://google.com/mapfiles/ms/micons/" . $icon . "|" . $PostMapPotitions[$j] . "";
                $j++;
            }
        }
        $URLFenceRoute = "maps.googleapis.com/maps/api/staticmap?path=color:0xffff00|weight:2|" . $post_map_potitions . "&size=640x640&zoom=16&maptype=satellite" . $marker;

        $xmlProjectDetails = '<?xml version="1.0" standalone="yes"?>
                                           <AjayLead><Project>';

        $xmlProjectDetails .='<AccountNo>' . $UserDataAccount[0]->Field_Value . '</AccountNo>
						  <ProjectName>' . GetStep1Data('contract_title', $quote_id) . '</ProjectName>
						  <Name>' . GetStep1Data('customer_name', $quote_id) . '</Name>
						  <Address1>' . GetStep1Data('customer_address', $quote_id) . '</Address1>
						  <Address2>Address2</Address2>
						  <Address3>Address3</Address3>
						  <Town>' . GetStep1Data('customer_town', $quote_id) . '</Town>
						  <County>' . GetStep1Data('customer_county', $quote_id) . '</County>
						  <PostCode>' . GetStep1Data('postcode', $quote_id) . '</PostCode>
						  <URLFenceRoute></URLFenceRoute>
						  <LengthofFence>' . GetStep1Data('routeLength', $quote_id) . '</LengthofFence>
						  <PostDistance>' . GetStep1Data('subPostsGap', $quote_id) . '</PostDistance>';
        $xmlProjectDetails .='</Project></AjayLead>';


        $ProjectProducts = GetStep4Data('Projects', $quote_id);
        $xmlProjectProducts = '<?xml version="1.0" standalone="yes"?><AjayLead>';
        foreach ($ProjectProducts as $ProjectProduct) {
            if ($ProjectProduct['length'] != '') {
                $prcode = GetProductCodeByID($ProjectProduct['product_id']);
                if ($prcode != '--') {
                    if ($prcode != '') {
                        $xmlProjectProducts .='<Products><ProductID>' . GetProductCodeByID($ProjectProduct['product_id']) . '</ProductID><Qty>' . $ProjectProduct['length'] . '</Qty></Products>';
                    }
                }
            }
        }

        $xmlProjectProducts .='</AjayLead>';


        /* $xmlCompanyContact ='<AjayLead>
          <Contractor>
          <CompanyName>CompanyName</CompanyName>
          <Address1>Address1</Address1>
          <Address2>Address2</Address2>
          <Address3>Address3</Address3>
          <Town>Town</Town>
          <County>County</County>
          <PostCode>PostCode</PostCode>
          <CoRegNumber>CoRegNumber</CoRegNumber>
          <VatRegNumber>VatRegNumber</VatRegNumber>
          <AccountNo>AccountNo</AccountNo>
          <Firstname>Firstname</Firstname>
          <Lastname>Lastname</Lastname>
          <EmailAddress>EmailAddress</EmailAddress>
          </Contractor>
          </AjayLead>';
          $xmlProjectDetails = '<AjayLead>
          <Project>
          <AccountNo>AccountNo</AccountNo>
          <ProjectName>ProjectName</ProjectName>
          <Name>Name</Name>
          <Address1>Address1</Address1>
          <Address2>Address2</Address2>
          <Address3>Address3</Address3>
          <Town>Town</Town>
          <County>County</County>
          <PostCode>PostCode</PostCode>
          <URLFenceRoute>URLFenceRoute</URLFenceRoute>
          <LengthofFence>200</LengthofFence>
          <PostDistance>100</PostDistance>
          </Project>
          </AjayLead>';
          $xmlProjectProducts = '<AjayLead>
          <Products>
          <ProductID>PRDNO123</ProductID>
          <Qty>200</Qty>
          </Products>
          <Products>
          <ProductID>PRDNO456</ProductID>
          <Qty>500</Qty>
          </Products>
          <Products>
          <ProductID>PRDNO789</ProductID>
          <Qty>10</Qty>
          </Products>
          </AjayLead>'; */


        $Reference = $quote_id;

        $errorMessage = 'Ok';
        $sendCRM = 0;
        if ($sendCRM == 1) {
			 $soapclient = new SoapClient('http://195.54.249.139:81/integration.svc?wsdl', array('trace' => 1));

            $params = array('Reference' => $Reference, 'xmlCompanyContact' => $xmlCompanyContact, 'xmlProjectDetails' => $xmlProjectDetails, 'xmlProjectProducts' => $xmlProjectProducts, 'errorMessage' => $errorMessage);
            $response = $soapclient->ajay_Project($params);
            //echo "Response:\n" . $soapclient->__getLastResponse() . "\n";
            // print_r($params);
           // print_r($response );


            if ($response->ajay_ProjectResult == 0) {
                echo '<div style="  min-height:300px;"><div style="padding-top:50px;text-align:center;">Your project details saved successfully.</div><div style="text-align:center;padding-top:20px;"><a href="' . site_url() . '/edit-user-personal-info/"><input type="button" value="Back to profile" ></a></div> </div>';
				echo '<script>window.location.href="'.site_url().'/edit-user-personal-info/?tab=quotation"</script>';
            } else if ($response->ajay_ProjectResult == 1) {
                echo '<div style=" text-align:center; min-height:300px;">Problem with ajayContractor xml – check errorMessage for more information</div>';
            } else if ($response->ajay_ProjectResult == 2) {
                echo '<div style=" text-align:center; min-height:300px;">Problem with ajayProject xml – check errorMessage for more information</div>';
            } else if ($response->ajay_ProjectResult == 3) {
                echo '<div style=" text-align:center; min-height:300px;">Problem with ajayProduct xml – check errorMessage for more information</div>';
            }
        } else {
            echo '<div style="  min-height:300px;"><div style="padding-top:50px;text-align:center;">Your project details saved successfully.</div><div style="text-align:center;padding-top:20px;"><a href="' . site_url() . '/edit-user-personal-info/"><input type="button" value="Back to profile" ></a></div> </div>';
			echo '<script>window.location.href="'.site_url().'/edit-user-personal-info/?tab=quotation"</script>';
        }
    }
}

add_shortcode("create-quote", "Create_Qupte_Form");
