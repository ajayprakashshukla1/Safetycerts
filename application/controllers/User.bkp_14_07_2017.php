<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    // Declaration of the propery
    protected $loggedin_user; 
    
    public function __construct(){
        parent::__construct();

        ini_set('upload_max_filesize', '1000M');
		    ini_set('post_max_size', '1000M');
		    ini_set('max_execution_time', 0);
        $this->load->database();	
		
        $this->load->helper(array('url','language','form'));
        $this->load->library(array('ion_auth','form_validation','session'));
        $this->load->model('user_model');
		    $this->load->model('assignjob_model');
		    //$this->load->library('email');


        if(!$this->ion_auth->logged_in()){
           redirect('auth', 'refresh');
        }

        if($this->ion_auth->logged_in()){
           $user= $this->ion_auth->user()->row();
           $user->role=$this->ion_auth->get_users_groups($user->id)->row()->name;
           $this->loggedin_user=$user;
           
        }

		
    }

/**
 * Index Page for this controller.
 * @see https://codeigniter.com/user_guide/general/urls.html
 */

	

public function index(){
	$this->load->view('layout/header');
	$this->load->view('user/index');
	$this->load->view('layout/footer');
}


/*
Description:Function to check the user login information with the database table
Param: username,password

*/


public function signup(){
  
   $this->load->view('layout/header');
   $this->load->view('user/signup');
   $this->load->view('layout/footer');
}


public function dashboard(){
  $data['title']='Dashboard';
  $data['login_user']=$this->loggedin_user;
  $login_user = $this->loggedin_user;
  $user_id = $login_user->user_id;
  
  $data['job_lists'] = $this->assignjob_model->list_all_job($user_id);
   
  if($this->ion_auth->is_admin() || $login_user->role=='members'){
      $id=NULL;
      if(!$this->ion_auth->is_admin()){
    	   $id=$login_user->id;  
      } 

      $data['get_all_dates'] = $this->get_all_dates();
      $data['all_certificate'] = $this->assignjob_model->get_allcertificate_list($id);
      $data['pending_test']= $this->assignjob_model->get_pending_list($id);
      $data['pending_status']=  $this->assignjob_model->status_count($id);
      $data['admin_assigned_job']=  $this->assignjob_model->admin_assigned_job($id);
      $data['admin_assigned_list']=  $this->assignjob_model->admin_assigned_list($id);
  }
  //echo "<pre>";print_r($data['admin_assigned_list']); exit();
  
  if($login_user->role=='contractor'){
     $id=$login_user->id;
     $data['get_all_dates'] = $this->get_all_dates();
     $data['all_certificate'] = $this->assignjob_model->get_cont_certificate_list($id);

     $data['job_lists'] = $this->assignjob_model->list_all_job($id);

     // get all certificate of contractor

  }

 
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/dashboard',$data);
  
  $this->load->view('layout/dashboard_footer');
}



public function faq_search(){
  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404');
  }		

  $data['login_user']=$this->loggedin_user;
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/faq_search');
  $this->load->view('layout/dashboard_footer');
}


public function certificate(){
  $data['title']='Certificate';
  $data['login_user']=$this->loggedin_user;
  $login_user = $this->loggedin_user;
  
  if($this->ion_auth->is_admin() || $login_user->role=='members'){
  $id=NULL;
  if(!$this->ion_auth->is_admin()){
	 $id=$login_user->id;  
  }  
  $data['get_all_dates'] = $this->get_all_dates();
  $data['all_certificate'] = $this->assignjob_model->get_allcertificate_list($id);
  $data['pending_status_test']=  $this->assignjob_model->status_count($id);
  $data['admin_assigned_job']=  $this->assignjob_model->admin_assigned_job($id);

  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/certificate',$data);
  $this->load->view('layout/dashboard_footer');
  }else{
	 redirect('auth/error_404');
  }
}

public function all_certificate(){
  $data['title']='All Certificate';
  $data['login_user']=$this->loggedin_user;
  $login_user = $this->loggedin_user;
  
  if($this->ion_auth->is_admin() || $login_user->role=='members'){
  $id=NULL;
  if(!$this->ion_auth->is_admin()){
   $id=$login_user->id;  
  }  
  $data['get_all_dates'] = $this->get_all_dates();
  $data['all_certificate'] = $this->assignjob_model->get_allcertificate_list($id);
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/all_certificate',$data);
  $this->load->view('layout/dashboard_footer');
  }else{
   redirect('auth/error_404');
  }
}


public function profile(){
  $data['title']='Profile';
  
  $data['login_user']=$this->loggedin_user;

  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/profile',$data);
  $this->load->view('layout/dashboard_footer');

}


public function update_profile(){
   $post_data=$this->input->post();

   if($post_data){
      $loggedin_user=$this->loggedin_user;
      $id=$loggedin_user->id;
      $this->ion_auth->update($id, $post_data);
      redirect('user/profile', 'refresh');
 
   }

}

public function update_password(){
   $data['login_user']=$this->loggedin_user;
   $data['route_method']=array('method'=>'update_password');
   $post_data=$this->input->post();
   if(!empty($post_data)){
      

      $this->form_validation->set_rules('password', 'password', 'required');
      $this->form_validation->set_rules('re_password', 'Confirm Password', 'required|matches[password]');
      if(!$this->form_validation->run() == false){
         
         $loggedin_user=$this->loggedin_user;
         $id=$loggedin_user->id;

         $passdata= array('password'=>$post_data['password']);
         $this->ion_auth->update($id, $passdata);
         $this->session->set_flashdata('message', 'Password has been changed');
         
         $this->load->view('layout/dashboard_header',$data);
         $this->load->view('user/profile',$data);
         $this->load->view('layout/dashboard_footer');
      }else{

         $this->load->view('layout/dashboard_header',$data);
         $this->load->view('user/profile',$data);
         $this->load->view('layout/dashboard_footer');
      }

     
   }
}


public function contractor_list(){

  $data['title']='Controller List';

  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404'); 
  }

  
  $role=3; // contrator
  $data['user_lists'] = $this->ion_auth->users($role)->result();
  //echo "<pre>"; print_r($data); exit; 
  $data['login_user']=$this->loggedin_user;
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/contractor_list',$data);
  $this->load->view('layout/dashboard_footer');
}

public function client_list(){
  $data['title']='Client List';
  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404'); 
  }

  
  $role=2; // Member
  $data['user_lists'] = $this->ion_auth->users($role)->result();
  //echo "<pre>"; print_r($data); exit; 
  $data['login_user']=$this->loggedin_user;
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/client_list',$data);
  $this->load->view('layout/dashboard_footer');
}


public function edit_contrator($unique_id=NULL){
  $data['title']='Edit Contractor';
  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404'); 
  }

  $id= $this->user_model->get_id($unique_id);
  // get user by id
  $user= $this->user_model->get_user_by_id($id);
  
  //==============================================
  
  // pass the user to the view
    //$data['user'] = $user;
    $data['id'] = array(
      'name'  => 'id',
      'type'  => 'hidden',
      'value' => $user->id,
    );
    $data['first_name'] = array(
      'name'  => 'first_name',
      'id'    => 'first_name',
      'type'  => 'text',
      'value' => $user->first_name,
    );
    $data['last_name'] = array(
      'name'  => 'last_name',
      'id'    => 'last_name',
      'type'  => 'text',
      'value' => $user->last_name,
    );
    $data['email'] = array(
      'name'  => 'email',
      'id'    => 'email',
      'type'  => 'text',
      'value' => $user->email,
      
    );
    $data['company'] = array(
      'name'  => 'company',
      'id'    => 'company',
      'type'  => 'text',
      'value' => $user->company,
    );
    $data['phone'] = array(
      'name'  => 'phone',
      'id'    => 'phone',
      'type'  => 'text',
      'value' => $user->phone,
    );
    

  //==============================================
  
  $data['login_user']=$this->loggedin_user;

  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/edit_contractor',$data);
  $this->load->view('layout/dashboard_footer');

}

public function edit_member($unique_id=NULL){
  $data['title']='Edit Client';
  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404'); 
  }

  $id= $this->user_model->get_id($unique_id);
  // get user by id
  $user= $this->user_model->get_user_by_id($id);
  
  //==============================================
  
  // pass the user to the view
    //$data['user'] = $user;
    $data['id'] = array(
      'name'  => 'id',
      'type'  => 'hidden',
      'value' => $user->id,
    );
    $data['first_name'] = array(
      'name'  => 'first_name',
      'id'    => 'first_name',
      'type'  => 'text',
      'value' => $user->first_name,
    );
    $data['last_name'] = array(
      'name'  => 'last_name',
      'id'    => 'last_name',
      'type'  => 'text',
      'value' => $user->last_name,
    );
    $data['email'] = array(
      'name'  => 'email',
      'id'    => 'email',
      'type'  => 'text',
      'value' => $user->email,
      
    );
    $data['company'] = array(
      'name'  => 'company',
      'id'    => 'company',
      'type'  => 'text',
      'value' => $user->company,
    );
    $data['phone'] = array(
      'name'  => 'phone',
      'id'    => 'phone',
      'type'  => 'text',
      'value' => $user->phone,
    );
    

  //==============================================
  
  $data['login_user']=$this->loggedin_user;

  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/edit_member',$data);
  $this->load->view('layout/dashboard_footer');

}


public function update_contractor(){
   $post_data=$this->input->post();
   if(!empty($post_data)){
      //echo "<pre>"; print_r($post_data); exit;
      $this->ion_auth->update($post_data['id'], $post_data);
      redirect('user/contractor_list', 'refresh');

   }else{
      redirect('user/contractor_list', 'refresh');
   }
}
public function update_client(){
   $post_data=$this->input->post();
   if(!empty($post_data)){
      //echo "<pre>"; print_r($post_data); exit;
      $this->ion_auth->update($post_data['id'], $post_data);
      redirect('user/client_list', 'refresh');

   }else{
      redirect('user/client_list', 'refresh');
   }
}

public function deactivateContratorAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id
   $post_data= array('active'=>'0');
   $this->ion_auth->update($id, $post_data);
      echo "Deactivate";

}

public function deletePropertyAjax(){
      $unique_id= $this->input->post('unique_id');      
      $this->db->where('unique_id', $unique_id);
      $this->db->delete('properties'); 
      echo "deleted";
      exit();
}

public function deleteContratorAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id

   if($this->db->delete('users', array('id' => $id))){
      // get all property id
      $properties= $this->user_model->display_all_properties($id);
      $this->db->delete('properties', array('user_id' => $id));
      foreach($properties as $pro){
         $this->db->delete('property_documents', array('property_id' => $pro['id']));
         $this->db->delete('assign_jobs', array('job_prop_id' => $pro['id']));
      } 
   }

   echo "deleted";
}

public function deactivateClientAjax(){
      $unique_id= $this->input->post('unique_id');
      $id= $this->user_model->get_id($unique_id);
      $result = $this->ion_auth->deactivate($id);  
      echo "Deactivate";
    }

public function deleteMemberAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id

   if($this->db->delete('users', array('id' => $id))){
      // get all property id
      $properties= $this->user_model->display_all_properties($id);
      $this->db->delete('properties', array('user_id' => $id));
      foreach($properties as $pro){
         $this->db->delete('property_documents', array('property_id' => $pro['id']));
         $this->db->delete('assign_jobs', array('job_prop_id' => $pro['id']));
      } 
   }

   echo "deleted";

}







public function ActivateContratorAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id
   $post_data= array('active'=>'1');
   $this->ion_auth->update($id, $post_data);
   
   echo "activated";
}

public function ActivateMemberAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id
   $post_data= array('active'=>'1');
   $this->ion_auth->update($id, $post_data);
   
   echo "activated";
}

public function uploadProfileImage(){
  $login_user=$this->loggedin_user;
  
  $config['upload_path']      = './uploads/';
  $config['allowed_types']    = 'gif|jpg|png';
  $config['max_size']         = 9120;
  //$config['max_width']        = 1024;
  //$config['max_height']       = 768;

  $this->load->library('upload', $config);

  if($this->upload->do_upload('userfile')){
      $img_data = array('upload_data' => $this->upload->data());
      $post_data= array('profile_pic'=>$img_data['upload_data']['file_name']);
      $this->ion_auth->update($login_user->id, $post_data);
      
      echo "uploaded";
  }else{
     //$error = array('error' => $this->upload->display_errors());
      echo "failed"; 
  }


  die();
}


public function deleteAcAjax(){
  $form_email= $this->input->post('email');
  $form_password= $this->input->post('password');
  $remember=0;
  $login_user=$this->loggedin_user;
  if($login_user->email==$form_email){
     if($this->ion_auth->login($form_email, $form_password, $remember)){
        // update user status
        $post_data= array('active'=>'0');
        $this->ion_auth->update($login_user->id, $post_data);
        echo "Your Ac has been deleted successfully";
     }else{
        echo "Email or Password incorrect";
     }
  }else{
     echo "Email does not match with this account";
  }

  die();
}

/*Function to add the property from the member dashboard after user login*/

public function addproperty($user_id = NULL){
  $data['title']='Add Property';
  if($user_id){
    $data['property_user_id']=$user_id;
  }
  $data['login_user']=$this->loggedin_user;
  $login_user = $this->loggedin_user;
  if($login_user->role=='contractor'){
     redirect('auth/error_404'); 
   }
  $users = $this->ion_auth->users(2)->result();
  $data['list_of_clients'] = $users;
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/addproperty');
  $this->load->view('layout/addproperty_footer'); 

}

/*Function to create the property for the login in user*/
  public function createproperty(){   
      $loggedin_user=$this->loggedin_user;
      $id=$loggedin_user->id;
      //store all post data
      $files = $_FILES;
      $post=$this->input->post();
      /*echo "<pre>";
      print_r($files); exit();*/
      $certificate_data= $this->input->post();
  
      $post['unique_id']= $this->ion_auth->generate_hash();
      if($loggedin_user->role=='admin'){
        $post['user_id']= $this->input->post('user_id');
      }else{
        $post['user_id']=$id;
      }
  
      $post['created']=date('Y-m-d h:i:s');
      //$post['user_id']= $user_id;
      unset($post['electrical_expire']);
      unset($post['emergency_expire']);
      unset($post['portable_expire']);
      unset($post['fire_expire']);
      unset($post['smoke_expire']);
      unset($post['carbon_expire']);
      unset($post['gas_safety_expire']);
      unset($post['electrical_prev_date']);
      unset($post['emergency_prev_date']);
      unset($post['portable_prev_date']);
      unset($post['fire_prev_date']);
      unset($post['smoke_prev_date']);
      unset($post['carbon_prev_date']);
      unset($post['gas_safety_prev_date']);
	  unset($post['is_first_property_certificate_electrical']);
	  unset($post['is_first_property_certificate_emergency']);
	  unset($post['is_first_property_certificate_portable']);
	  unset($post['is_first_property_certificate_fire']);
	  unset($post['is_first_property_certificate_smoke']);
      unset($post['is_first_property_certificate_carbon']);
	  unset($post['is_first_property_certificate_gas']);

      //echo "<pre>"; print_r($post); exit;
  
      $pro_id=$this->user_model->add_property_detail($post);
      if(!$pro_id){
          $this->session->set_flashdata('message', 'Eror! New property could not be added. Please try again');
          redirect('user/addproperty', 'refresh');
      } 
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
              $cert_data['certificate_uploadedby']= $id;
              $cert_data['certificate_expire']= $certificate_data['electrical_expire'];
			  $cert_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_electrical'];
              $this->db->insert('certificate_files', $cert_data);
              $cert_id = $this->db->insert_id();  
            }
          }           
        //}
      }
      //save emergency test data
      if($certificate_data['emergency_test']=='yes'){
       // for ($j=0; $j <count($files['emergency_upload_file']['name']) ; $j++) { 
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
              $emmer_data['certificate_uploadedby']= $id;
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
        //for ($k=0; $k < count($files['portable_upload_file']['name']); $k++) { 
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
              $portable_data['certificate_uploadedby']= $id;
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
              $fire_data['certificate_uploadedby']= $id;
              $fire_data['certificate_expire']= $certificate_data['fire_expire'];
			  $fire_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_fire'];
              $this->db->insert('certificate_files', $fire_data);
              $cert_id = $this->db->insert_id();
            }
          }          
        //}         
      }
      //save Smoke Detector test data
      if($certificate_data['smoke_test']=='yes'){
        //for ($m=0; $m < count($files['smoke_upload_file']['name']); $m++) { 
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
              $smoke_data['certificate_uploadedby']= $id;
              $smoke_data['certificate_expire']= $certificate_data['smoke_expire'];
			  $smoke_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_smoke'];
              $this->db->insert('certificate_files', $smoke_data);
              $cert_id = $this->db->insert_id();   
            }
          }          
       // }         
      }
      //save carbon test data 
      if($certificate_data['carbon_test']=='yes'){
        //for ($n=0; $n < count($files['carbon_upload_file']['name']); $n++) { 
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
              $carbon_data['certificate_uploadedby']= $id;
              $carbon_data['certificate_expire']= $certificate_data['carbon_expire'];
			  $carbon_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_carbon'];
              $this->db->insert('certificate_files', $carbon_data);
              $cert_id = $this->db->insert_id(); 
            }
          }          
       // }          
      }
      //save gas safety test data 
      if($certificate_data['gas_safety_test']=='yes'){
       // for ($o=0; $o <count($files['gas_safety_upload']['name']) ; $o++) { 
          $gas_safety_data=array();
          if(!empty($files['gas_safety_upload']['name'])){
            $filename= time()."_".$files['gas_safety_upload']['name'];
            $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
            if(move_uploaded_file($files['gas_safety_upload']['tmp_name'],$pathfilename)){
              $gas_safety_data['certificate_file']=$filename;
              $gas_safety_data['certificate_property_id']= $pro_id;
              $gas_safety_data['certificate_unique_id']= $this->ion_auth->generate_hash();
              $gas_safety_data['certificate_name']= 'gas_safety_test';
              $gas_safety_data['certificate_type']= '7';
              $gas_safety_data['certificate_date']= $certificate_data['gas_safety_prev_date'];
              $gas_safety_data['uploaded_date']= date('Y-m-d H:i:s');
              $gas_safety_data['certificate_uploadedby']= $id;
              $gas_safety_data['certificate_expire']= $certificate_data['gas_safety_expire'];
			  $gas_safety_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_gas'];
              $this->db->insert('certificate_files', $gas_safety_data);
              $cert_id = $this->db->insert_id();
            }
          }          
       // }           
      }
      //insert in notification
      $notification_data=array(
         'user_id'=>$id,
         'url'=>'property_url'
      );
      $pro= $this->db->insert('property_notification', $notification_data);
      $this->session->set_flashdata('message', 'Success! New property successfully added. You can view all registered properties <a href="'.base_url().'user/viewproperty">here</a>');
      redirect('user/addproperty', 'refresh');
  }



//this function is used for view properties list
public function viewproperty(){
  $data['title']='Properties';

  $data['login_user']=$this->loggedin_user;
  $loggedin_user=$this->loggedin_user;
  if($loggedin_user->role=='contractor'){
     redirect('auth/error_404'); 
   }
  $id=$loggedin_user->id;
  if($this->ion_auth->is_admin()){
	  $id=NULL;
  }

  $property_data['property_data']=$this->user_model->display_all_properties($id);
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/viewproperty',$property_data);
  $this->load->view('layout/addproperty_footer'); 

}


public function client_property($unique_id=NULL){
  $data['title']='Client Properties';
  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404');
   }

   if(!$unique_id){
      redirect('auth/error_404');
   }

   $data['login_user']=$this->loggedin_user;
   
   $id= $this->user_model->get_id($unique_id);

   $data['property_data']=$this->user_model->display_all_properties($id);
   $data['client']=$this->user_model->get_user_by_id($id);

   $this->load->view('layout/dashboard_header',$data);
   $this->load->view('apply/client_property',$data);
   $this->load->view('layout/addproperty_footer'); 


}


//this function is used for view properties list
public function property_details($unique_id){
  $data['title']='Property Details';
  $data['login_user']=$this->loggedin_user;
  $loggedin_user=$this->loggedin_user;
  $id=$loggedin_user->id;
  $property_data['property_data']=$this->user_model->display_property_byuniqueid($unique_id);
  $property_data['client_data']=$this->user_model->get_user_by_id($property_data['property_data']['user_id']);
  //echo "<pre>"; print_r($property_data['client_data']); exit();
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/property_details',$property_data);
  $this->load->view('layout/addproperty_footer'); 

}



public function property_edit($unique_id){
  $data['title']='Edit Properties';

   $loggedin_user=$this->loggedin_user;
   if($loggedin_user->role=='contractor'){
     redirect('auth/error_404'); 
   }
   $post = $this->input->post();

   $users = $this->ion_auth->users(2)->result();
  // print_r($users);
   $data['list_of_clients'] = $users;

   if(isset($post) && count($post) > 0){ 
      $id=$loggedin_user->id;
      //store all post data
      $post=$this->input->post();
     $user_id=$this->input->post('user_id');
      
	   if(!$this->ion_auth->is_admin()){
		   $post['user_id']=$id;
	   }else{
		   $post['user_id']=$user_id;
	   }
      
     $post['created']=date('Y-m-d h:i:s');
   
    $post['unique_id']=$unique_id;
	
	  unset($post['electrical_prev_date']);
      unset($post['emergency_prev_date']);
      unset($post['portable_prev_date']);
      unset($post['fire_prev_date']);
      unset($post['smoke_prev_date']);
      unset($post['carbon_prev_date']);	  
      unset($post['gas_safety_prev_date']);
	  
	  unset($post['electrical_prev_date_id']);
      unset($post['emergency_prev_date_id']);
      unset($post['portable_prev_date_id']);
      unset($post['fire_prev_date_id']);
      unset($post['smoke_prev_date_id']);
      unset($post['carbon_prev_date_id']);	  
      unset($post['gas_prev_date_id']);
	  
	  unset($post['is_first_property_certificate_electrical']);
	  unset($post['is_first_property_certificate_emergency']);
	  unset($post['is_first_property_certificate_portable']);
	  unset($post['is_first_property_certificate_fire']);
	  unset($post['is_first_property_certificate_smoke']);
      unset($post['is_first_property_certificate_carbon']);
	  unset($post['is_first_property_certificate_gas']);

   // echo '<pre>'; print_r($post); exit;

 

      
      // update property
      $pro_id=$this->user_model->add_property_detail($post);
	   $files= $_FILES;
	   
	   
	@$electrical_id = $this->input->post('electrical_prev_date_id');
	  if(isset($electrical_id) && $electrical_id!="")  {                  
	       $electrical = array();	   
	       $electrical['certificate_date'] = $this->input->post('electrical_prev_date');
#print_r($electrical); exit;
	       $this->user_model->update_property_certificate_date($electrical,$electrical_id);
	   }
     
     
  

      //insert in notification
      $notification_data=array(
            'user_id'=>$id,
            'url'=>'property_url'
      );

      $pro= $this->db->insert('property_notification', $notification_data);
      $this->session->set_flashdata('message', 'Property is Successfully Submitted');
      redirect('user/property_edit/'.$unique_id, 'refresh');
  }


  /*===================================================*/
  $data['login_user']=$this->loggedin_user;
  $loggedin_user=$this->loggedin_user;
  $id=$loggedin_user->id;
  
  $property_data['property_data']=$this->user_model->display_property_byuniqueid($unique_id);

  $prop_id= $this->user_model->get_property_id_by_unique_id($unique_id);
  $property_data['property_files']=$this->user_model->get_property_files($prop_id);

  $property_data['certifiles'] = $this->user_model->get_property_certificates_files($prop_id);
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/editproperty',$property_data,$data);
  $this->load->view('layout/addproperty_footer'); 

}

public function get_all_dates(){
	
$month = date('m');
$day = date('d');
$year = date('Y');
$start_date = $day."-".$month."-".$year;
$start_time = strtotime($start_date);
$end_time = strtotime("+1 month", $start_time);
for($i=$start_time; $i<$end_time; $i+=86400)
{
   $list[] = date('d/m/Y', $i);
}
return $list;
}


public function file_download($id=NULL){
  
   if($unique_id){  
   $this->load->helper('download');
   $data['login_user']=$this->loggedin_user;  
   $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id; 
   $certificate_file =$this->assignjob_model->getfile($id);  
   force_download(FCPATH.'uploads/'.$certificate_file, NULL);
   //$data['unique_id']=$unique_id;
   //$this->load->view('layout/dashboard_header',$data);
   //$this->load->view('job/view_certificate',$data);
   //$this->load->view('layout/dashboard_footer');
   }else{
      redirect('auth/error_404'); 
   }
}
public function invoice(){
  $paid = $this->input->post('myVal');
  $pro_id= $this->input->post('pro_id');
  $data= array();
  $data['invoice']=$paid;
  $this->db->where('id',$pro_id);
  $this->db->update('properties',$data);
  echo "saved";
}

public function email_logs(){
  
  $data = array();
  $data['title']='Email Logs';
  if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404'); 
   }
  $data['email_lists'] = $this->assignjob_model->get_email_detail_list();
  $data['login_user']=$this->loggedin_user;
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/email_detail',$data);
  $this->load->view('layout/dashboard_footer');
}

}
 