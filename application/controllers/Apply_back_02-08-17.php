<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apply extends CI_Controller{
     
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		    
        $this->load->helper(array('url','language','form'));
        $this->load->library(array('ion_auth','form_validation','session'));

        ini_set('upload_max_filesize', '1000M');
        ini_set('post_max_size', '1000M');
        ini_set('max_execution_time', 0);

		   
    }

/**
 * Index Page for this controller.
 * @see https://codeigniter.com/user_guide/general/urls.html
 */

	

public function index(){
	$this->load->view('layout/apply_header');
	$this->load->view('apply/index');
	$this->load->view('layout/apply_footer');

}



public function createAjax(){
  $error=false;
  
  $email    = strtolower($this->input->post('email'));
  $identity_column = $this->config->item('identity','ion_auth');
  $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
  $password = $this->input->post('password');

  $additional_data = array(
      'first_name' => $this->input->post('first_name'),
      'last_name'  => $this->input->post('last_name'),
      'phone'      => $this->input->post('phone'),
      'unique_id'  => $this->ion_auth->generate_hash()
  );

  $is_exist = $this->ion_auth->email_check($this->input->post('email'));
  $error='';
  if($is_exist>0){
     $error= 'Email already exist';
  }

  if($this->input->post('email') != $this->input->post('confirm_email')){
     $error= 'Confirm email does not match';
  }

  if($this->input->post('password') != $this->input->post('confirm_password')){
     $error= 'Confirm password does not match';
  }

  if($error==''){

     if($this->ion_auth->register($identity, $password, $email, $additional_data)){
         $error='saved';
     }else{
        $error='Error! please try again';
     }

  }

  echo $error;

  die();
}


public function createPropertyAjax(){
  // check if user already signd-up
  $data= $this->input->post();
  $certificate_data= $this->input->post();

  //print_r($certificate_data); 
  //print_r($_FILES);
  //exit;
//================================================
  
//================================================
  
  $is_exist = $this->ion_auth->email_check($data['email']);
  $noti=array();
  if($is_exist>0){
     $noti['status']='fail';
     $noti['message']= 'You have already registered. please login <a href="'.base_url().'auth/login">here</a> and create property';
     echo json_encode($noti);
     die();
  }
  
  // check confirm email
  if($data['email'] != $data['confirm_email']){
     $noti['status']='fail';
     $noti['message']= 'Confirm email does not match';
     echo json_encode($noti);
     die();
  }
  // check confirm password
  if($data['password'] != $data['confirm_password']){
     $noti['status']='fail';
     $noti['message']= 'Confirm password does not match';
     echo json_encode($noti);
     die();
  }

  // lets register user
  $email    = strtolower($data['email']);
  $identity_column = $this->config->item('identity','ion_auth');
  $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
  $password = $data['password'];

  $additional_data = array(
      'first_name' => $data['first_name'],
      'last_name'  => $data['last_name'],
      'phone'      => $data['phone'],
      'unique_id'  => $this->ion_auth->generate_hash()
  );

  if($user_id=$this->ion_auth->register($identity, $password, $email, $additional_data)){
     // if user registered add property
     $unset_arr= array('title','first_name','last_name','email','confirm_email','password','confirm_password','phone','form_6__previous_address','url_path');
     
     foreach($data as $key=>$val){
         if(in_array($key, $unset_arr)){
            unset($data[$key]);
         }
     }

      //$data['prev_test_date']= $data['prev_test_year']."-".$data['prev_test_month']."-".$data['prev_test_day'];
      $data['created']= date('Y-m-d H:i:s');
      $data['unique_id']= $this->ion_auth->generate_hash();
      $data['user_id']= $user_id;
      
      unset($data['prev_test_year']);
      unset($data['prev_test_month']);
      unset($data['prev_test_day']);
      unset($data['electrical_expire']);
      unset($data['emergency_expire']);
      unset($data['portable_expire']);
      unset($data['fire_expire']);
      unset($data['smoke_expire']);
      unset($data['electrical_prev_date']);
      unset($data['emergency_prev_date']);
      unset($data['portable_prev_date']);
      unset($data['fire_prev_date']);
      unset($data['smoke_prev_date']);

      unset($data['carbon_expire']);
      unset($data['gas_expire']);
      unset($data['carbon_prev_date']);
      unset($data['gas_prev_date']);
      unset($data['is_first_property_certificate_electrical']);
      unset($data['is_first_property_certificate_emergency']);
      unset($data['is_first_property_certificate_portable']);
      unset($data['is_first_property_certificate_fire']);
      unset($data['is_first_property_certificate_smoke']);
      unset($data['is_first_property_certificate_carbon']);
      unset($data['is_first_property_certificate_gas']);

     $this->db->insert('properties', $data);
     $pro_id = $this->db->insert_id();

     $files= $_FILES;

     /*if(!empty($files[0]['name'])){
         foreach($files as $file){
            $filename= time()."_".$file['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/".$filename;
            if(move_uploaded_file($file['tmp_name'],$pathfilename)){
               // insert in db
                $data=array();
                $data['property_id']=$pro_id;
                $data['doc']=$filename;
                $pro= $this->db->insert('property_documents', $data);
            }
         }
      }*/
      
      // save electrical test data
      if($certificate_data['electrical_test']=='yes'){
        //for ($i=0; $i < count($files['electrical_upload_file']['name']); $i++) { 
          $cert_data=array();
          if(!empty($files['electrical_upload_file']['name'])){
            $filename= time()."_".$files['electrical_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['electrical_upload_file']['tmp_name'],$pathfilename)){
              $cert_data['certificate_file']=$filename;
              $cert_data['certificate_property_id']= $pro_id;
              $cert_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $cert_data['certificate_name']= 'electrical_test';
              $cert_data['certificate_type']= '1';
              $cert_data['certificate_date']= $certificate_data['electrical_prev_date'];
              $cert_data['uploaded_date']= date('Y-m-d H:i:s');
              $cert_data['certificate_uploadedby']= $user_id;
              $cert_data['certificate_expire']= $certificate_data['electrical_expire'];
              $cert_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_electrical'];
              $this->db->insert('certificate_files', $cert_data);
              $cert_id = $this->db->insert_id();  
            }
          }           
       // }
      }
      
      //save emergency test data
      if($certificate_data['emergency_test']=='yes'){
      //  for ($j=0; $j <count($files['emergency_upload_file']['name']) ; $j++) { 
          $emmer_data=array();
          if(!empty($files['emergency_upload_file']['name'])){
            $filename= time()."_".$files['emergency_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['emergency_upload_file']['tmp_name'],$pathfilename)){
              $emmer_data['certificate_file']=$filename;
              $emmer_data['certificate_property_id']= $pro_id;
              $emmer_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $emmer_data['certificate_name']= 'emergency_test';
              $emmer_data['certificate_type']= '2';
              $emmer_data['certificate_date']= $certificate_data['emergency_prev_date'];
              $emmer_data['uploaded_date']= date('Y-m-d H:i:s');
              $emmer_data['certificate_uploadedby']= $user_id;
              $emmer_data['certificate_expire']= $certificate_data['emergency_expire'];
              $emmer_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_emergency'];
              $this->db->insert('certificate_files', $emmer_data);
              $cert_id = $this->db->insert_id();
            }
          }          
       // }  
      }

      //save portable test data
      if($certificate_data['portable_test']=='yes'){
       // for ($k=0; $k < count($files['portable_upload_file']['name']); $k++) { 
          $portable_data=array();
          if(!empty($files['portable_upload_file']['name'])){
            $filename= time()."_".$files['portable_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['portable_upload_file']['tmp_name'],$pathfilename)){
              $portable_data['certificate_file']=$filename;
              $portable_data['certificate_property_id']= $pro_id;
              $portable_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $portable_data['certificate_name']= 'portable_test';
              $portable_data['certificate_type']= '3';
              $portable_data['certificate_date']= $certificate_data['portable_prev_date'];
              $portable_data['uploaded_date']= date('Y-m-d H:i:s');
              $portable_data['certificate_uploadedby']= $user_id;
              $portable_data['certificate_expire']= $certificate_data['portable_expire'];
              $portable_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_portable'];
              $this->db->insert('certificate_files', $portable_data);
              $cert_id = $this->db->insert_id();
            }
          }          
       // }
      }

      //save Fire Alarm test data
      if($certificate_data['fire_test']=='yes'){
        //for ($l=0; $l < count($files['fire_upload_file']['name']); $l++) { 
          $fire_data=array();
          if(!empty($files['fire_upload_file']['name'])){
            $filename= time()."_".$files['fire_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['fire_upload_file']['tmp_name'],$pathfilename)){
              $fire_data['certificate_file']=$filename;
              $fire_data['certificate_property_id']= $pro_id;
              $fire_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $fire_data['certificate_name']= 'fire_test';
              $fire_data['certificate_type']= '4';
              $fire_data['certificate_date']= $certificate_data['fire_prev_date'];
              $fire_data['uploaded_date']= date('Y-m-d H:i:s');
              $fire_data['certificate_uploadedby']= $user_id;
              $fire_data['certificate_expire']= $certificate_data['fire_expire'];
               $fire_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_fire'];
              $this->db->insert('certificate_files', $fire_data);
              $cert_id = $this->db->insert_id();
            }
          }          
       // }
      }

      //save Smoke Detector test data
      if($certificate_data['smoke_test']=='yes'){
       // for ($m=0; $m < count($files['smoke_upload_file']['name']); $m++) { 
          $smoke_data=array();
          if(!empty($files['smoke_upload_file']['name'])){
            $filename= time()."_".$files['smoke_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['smoke_upload_file']['tmp_name'],$pathfilename)){
              $smoke_data['certificate_file']=$filename;
              $smoke_data['certificate_property_id']= $pro_id;
              $smoke_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $smoke_data['certificate_name']= 'smoke_test';
              $smoke_data['certificate_type']= '5';
              $smoke_data['certificate_date']= $certificate_data['smoke_prev_date'];
              $smoke_data['uploaded_date']= date('Y-m-d H:i:s');
              $smoke_data['certificate_uploadedby']= $user_id;
              $smoke_data['certificate_expire']= $certificate_data['smoke_expire'];
              $smoke_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_smoke'];
              $this->db->insert('certificate_files', $smoke_data);
              $cert_id = $this->db->insert_id();   
            }
          }          
        //}
      }

      //save Carbon monoxide detector test data
      if($certificate_data['carbon_test']=='yes'){
       // for ($n=0; $n < count($files['carbon_upload_file']['name']); $n++) { 
          $carbon_data=array();
          if(!empty($files['carbon_upload_file']['name'])){
            $filename= time()."_".$files['carbon_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['carbon_upload_file']['tmp_name'],$pathfilename)){
              $carbon_data['certificate_file']=$filename;
              $carbon_data['certificate_property_id']= $pro_id;
              $carbon_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $carbon_data['certificate_name']= 'carbon_test';
              $carbon_data['certificate_type']= '6';
              $carbon_data['certificate_date']= $certificate_data['carbon_prev_date'];
              $carbon_data['uploaded_date']= date('Y-m-d H:i:s');
              $carbon_data['certificate_uploadedby']= $user_id;
              $carbon_data['certificate_expire']= $certificate_data['carbon_expire'];
              $carbon_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_carbon'];
              $this->db->insert('certificate_files', $carbon_data);
              $cert_id = $this->db->insert_id(); 
            }
          }          
        //} 
      }

      //save Gas safety - coming soon! test data
      if($certificate_data['gas_safety_test']=='yes'){
        // for ($o=0; $o <count($files['gas_upload_file']['name']) ; $o++) { 
          $gas_data=array();
          if(!empty($files['gas_safety_upload']['name'])){
            $filename= time()."_".$files['gas_upload_file']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['gas_upload_file']['tmp_name'],$pathfilename)){
              $gas_data['certificate_file']=$filename;
              $gas_data['certificate_property_id']= $pro_id;
              $gas_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $gas_data['certificate_name']= 'gas_safety_test';
              $gas_data['certificate_type']= '7';
              $gas_data['certificate_date']= $certificate_data['gas_prev_date'];
              $gas_data['uploaded_date']= date('Y-m-d H:i:s');
              $gas_data['certificate_uploadedby']= $user_id;
              $gas_data['certificate_expire']= $certificate_data['gas_expire'];
              $gas_safety_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_gas'];
              $this->db->insert('certificate_files', $gas_data);
              $cert_id = $this->db->insert_id();
            }
          }          
       // } 
      }
      $certificate_data['email'] = $email;
     if($certificate_data){
     	$this->load->library('email');
      $this->email->from('info@safetycerts.co.uk');
		  $this->email->to('kevin@londonsparks.com');	
		  $this->email->cc('tim@ignitestudio.co.uk');	
		  $this->email->subject('A new user and property has been added');
		  $message = 'A new user and property has been added<br/><br/>To view details please click here:<a href="'.base_url().'user/property_details/'.$data["unique_id"].'">Property Details</a>';	                
		  $this->email->message($message);
		  $this->email->send();
		  //echo $this->email->print_debugger();
      }

     $noti['status']='success';
     $noti['message']= 'Property has been created successfully. please click <a href="'.base_url().'auth/login">here</a> to login & manage your property';
     echo json_encode($noti);

	

     die();

  }else{
     $noti['status']='fail';
     $noti['message']= 'User could not be registered. please try again';
     echo json_encode($noti);
     die();
  }

  
  
  die();
}


/*public function mail_test(){
	$this->load->library('email');
	$this->email->from('shagufta.rahat786@gmail.com');
	$this->email->to('shagufta@jamtechtechnologies.com');
	$this->email->subject('Email Test');
	$this->email->message('Testing the email class.');

	$this->email->send();
	echo $this->email->print_debugger();

}*/


}
 