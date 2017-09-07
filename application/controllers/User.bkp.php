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

public function view_all_certificates(){
  $data['title']='View All Certificates';
  $data['login_user']=$this->loggedin_user;
  $login_user = $this->loggedin_user;
  $user_id = $login_user->user_id;
  
 // $data['job_lists'] = $this->assignjob_model->list_all_job($user_id);
   
  if($this->ion_auth->is_admin() || $login_user->role=='members'){
      $id=NULL;
      if(!$this->ion_auth->is_admin()){
         $id=$login_user->id;  
      } 

      $data['get_all_dates'] = $this->get_all_dates();
      $data['all_certificate'] = $this->assignjob_model->get_allcertificate_list($id);
     // $data['pending_test']= $this->assignjob_model->get_pending_list($id);
    //  $data['pending_status']=  $this->assignjob_model->status_count($id);
     // $data['admin_assigned_job']=  $this->assignjob_model->admin_assigned_job($id);
     // $data['admin_assigned_list']=  $this->assignjob_model->admin_assigned_list($id);
  }
  //echo "<pre>";print_r($data['admin_assigned_list']); exit();
  
  if($login_user->role=='contractor'){
     $id=$login_user->id;
     $data['get_all_dates'] = $this->get_all_dates();
    // $data['all_certificate'] = $this->assignjob_model->get_cont_certificate_list($id);

     $data['job_lists'] = $this->assignjob_model->list_all_job($id);

     // get all certificate of contractor

  }

 
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('user/view_all_certificates',$data);
  
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
  $data['admin_assigned_list']=  $this->assignjob_model->admin_assigned_list($id);

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
  $data['token'] = mt_rand(11111111,99999999);

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
      $certificate_data= $this->input->post();
     

    //--------test---------
      //echo "<pre>"; print_r($_SESSION['certdocfile']);
      //$files= $_SESSION['certdocfile'][$post['token']];
      //print_r($files);
      //print_r($files['electrical_upload_file']['other']);


    //----------------

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
      unset($post['token']);

      //echo "<pre>"; print_r($post); exit;
  
      $pro_id=$this->user_model->add_property_detail($post);
      if(!$pro_id){
          $this->session->set_flashdata('message', 'Eror! New property could not be added. Please try again');
          redirect('user/addproperty', 'refresh');
      } 

      // get token
      $token= $certificate_data['token'];
      $files=array();
      if(isset($_SESSION['certdocfile'][$token])){
         $files= $_SESSION['certdocfile'][$token];
         unset($_SESSION['certdocfile'][$token]);
      }
      
      
      // save electrical test data
      if($certificate_data['electrical_test']=='yes'){     
          $cert_data=array();
          if(!empty($files['electrical_upload_file']['name'])){
              $cert_data['certificate_file']=$files['electrical_upload_file']['name'];
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

              // save other file here

              foreach($files['electrical_upload_file']['other'] as $key=>$filename){
    
                    $other_files = array();

                    $other_files['certificate_property_id'] = $pro_id;
                    $other_files['unique_id'] = $this->ion_auth->generate_hash();
                    $other_files['certificate_unique_id'] = $cert_data['certificate_unique_id'];
                    $other_files['certificate_name'] = 'Other Electrical Test';
                    $other_files['certificate_type'] = '1';
                    $other_files['certificate_date'] = $cert_data['certificate_date'];
                    $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                    $other_files['certificate_uploadedby'] = $id;
                    $other_files['certificate_expire'] = $certificate_data['electrical_expire'];
                    $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_electrical'];

                    $other_files['other_certificate_file'] = $filename;
                    $pro= $this->db->insert('other_certificate_files', $other_files);
              }


          }           
      }

       // save emergency test data
      if($certificate_data['emergency_test']=='yes'){  
          $emmer_data=array();
          if(!empty($files['emergency_upload_file']['name'])){
              $emmer_data['certificate_file']=$files['emergency_upload_file']['name'];
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

              // save other file here

              foreach($files['emergency_upload_file']['other'] as $key=>$filename){
                    $other_files = array();

                    $other_files['certificate_property_id'] = $pro_id;
                    $other_files['unique_id'] = $this->ion_auth->generate_hash();
                    $other_files['certificate_unique_id'] = $emmer_data['certificate_unique_id'];
                    $other_files['certificate_name'] = 'Other Emergency Test';
                    $other_files['certificate_type'] = '2';
                    $other_files['certificate_date'] =$emmer_data['certificate_date'];
                    $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                    $other_files['certificate_uploadedby'] = $id;
                    $other_files['certificate_expire'] = $certificate_data['electrical_expire'];
                    $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_emergency'];

                    $other_files['other_certificate_file'] = $filename;
                    $pro= $this->db->insert('other_certificate_files', $other_files);
              }
          }           
      }

      //save portable test data
      if($certificate_data['portable_test']=='yes'){  
          $portable_data=array();
          if(!empty($files['portable_upload_file']['name'])){
              $portable_data['certificate_file']=$files['portable_upload_file']['name'];
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

              // save other file here
              foreach($files['portable_upload_file']['other'] as $key=>$filename){
                   $other_files = array();

                   $other_files['certificate_property_id'] = $pro_id;
                   $other_files['unique_id'] = $this->ion_auth->generate_hash();
                   $other_files['certificate_unique_id'] = $portable_data['certificate_unique_id'];
                   $other_files['certificate_name'] = 'Other Portable Test';
                   $other_files['certificate_type'] = '3';
                   $other_files['certificate_date'] = $portable_data['certificate_date'];
                   $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                   $other_files['certificate_uploadedby'] = $id;
                   $other_files['certificate_expire'] = $certificate_data['portable_expire'];
                   $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_portable'];

                   $other_files['other_certificate_file'] = $filename;
                   $pro= $this->db->insert('other_certificate_files', $other_files);
              }
          }           
      }
      
      //save Fire Alarm test data
      if($certificate_data['fire_test']=='yes'){  
          $fire_data=array();
          if(!empty($files['fire_upload_file']['name'])){
              $fire_data['certificate_file']=$files['fire_upload_file']['name'];
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

              // save other file here

              foreach($files['fire_upload_file']['other'] as $key=>$filename){
                  $other_files = array();

                  $other_files['certificate_property_id'] = $pro_id;
                  $other_files['unique_id'] = $this->ion_auth->generate_hash();
                  $other_files['certificate_unique_id'] = $fire_data['certificate_unique_id'];
                  $other_files['certificate_name'] = 'Other Electrical Test';
                  $other_files['certificate_type'] = '4';
                  $other_files['certificate_date'] = $fire_data['certificate_date'];
                  $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                  $other_files['certificate_uploadedby'] = $id;
                  $other_files['certificate_expire'] = $certificate_data['fire_expire'];
                  $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_fire'];

                  $other_files['other_certificate_file'] = $filename;
                  $pro= $this->db->insert('other_certificate_files', $other_files);
              }
          }           
      }

      //save Smoke Detector test data
      if($certificate_data['smoke_test']=='yes'){  
          $smoke_data=array();
          if(!empty($files['smoke_upload_file']['name'])){
              $smoke_data['certificate_file']=$files['smoke_upload_file']['name'];
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

              // save other file here

              foreach($files['smoke_upload_file']['other'] as $key=>$filename){
                  $other_files = array();

                  $other_files['certificate_property_id'] = $pro_id;
                  $other_files['unique_id'] = $this->ion_auth->generate_hash();
                  $other_files['certificate_unique_id'] = $smoke_data['certificate_unique_id'];
                  $other_files['certificate_name'] = 'Other Electrical Test';
                  $other_files['certificate_type'] = '5';
                  $other_files['certificate_date'] = $smoke_data['certificate_date'];
                  $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                  $other_files['certificate_uploadedby'] = $id;
                  $other_files['certificate_expire'] = $certificate_data['smoke_expire'];
                  $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_smoke'];

                  $other_files['other_certificate_file'] = $filename;
                  $pro= $this->db->insert('other_certificate_files', $other_files);

              }
          }           
      }
      
       //save carbon test data 
      if($certificate_data['carbon_test']=='yes'){ 
          $carbon_data=array();
          if(!empty($files['carbon_upload_file']['name'])){
              $carbon_data['certificate_file']=$files['carbon_upload_file']['name'];
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

              // save other file here

              foreach($files['carbon_upload_file']['other'] as $key=>$filename){
                  $other_files = array();

                  $other_files['certificate_property_id'] = $pro_id;
                  $other_files['unique_id'] = $this->ion_auth->generate_hash();
                  $other_files['certificate_unique_id'] = $carbon_data['certificate_unique_id'];
                  $other_files['certificate_name'] = 'Other Electrical Test';
                  $other_files['certificate_type'] = '6';
                  $other_files['certificate_date'] = $carbon_data['certificate_date'];
                  $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                  $other_files['certificate_uploadedby'] = $id;
                  $other_files['certificate_expire'] = $certificate_data['carbon_expire'];
                  $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_carbon'];

                  $other_files['other_certificate_file'] = $filename;
                  $pro= $this->db->insert('other_certificate_files', $other_files);
              }
          }           
      }
      
      //save gas safety test data 
      if($certificate_data['gas_safety_test']=='yes'){
          $carbon_data=array();
          if(!empty($files['gas_safety_upload']['name'])){
              $gas_safety_data['certificate_file']=$files['gas_safety_upload']['name'];
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

              // save other file here

              foreach($files['gas_safety_upload']['other'] as $key=>$filename){
                  $other_files = array();

                  $other_files['certificate_property_id'] = $pro_id;
                  $other_files['unique_id'] = $this->ion_auth->generate_hash();
                  $other_files['certificate_unique_id'] = $gas_safety_data['certificate_unique_id'];
                  $other_files['certificate_name'] = 'Other Electrical Test';
                  $other_files['certificate_type'] = '7';
                  $other_files['certificate_date'] = $gas_safety_data['certificate_date'];
                  $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                  $other_files['certificate_uploadedby'] = $id;
                  $other_files['certificate_expire'] = $certificate_data['gas_safety_expire'];
                  $other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_gas'];

                  $other_files['other_certificate_file'] = $filename;
                  $pro= $this->db->insert('other_certificate_files', $other_files);
              }
          }           
      }


      // unlink extra images

      foreach($_SESSION['certdocfile'] as $docfiles){
        
        // ======== unlink electrical_upload_file =======
          if(isset($docfiles['electrical_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['electrical_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                   
          } 

            // unlink other file
            $other_files= $docfiles['electrical_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                 
                } 
            }

          }
          // ======== unlink emergency_upload_file =======
          if(isset($docfiles['emergency_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['emergency_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['emergency_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
            }

          }
          // ======== unlink portable_upload_file =======
          if(isset($docfiles['portable_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['portable_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['portable_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
            }

          }
          // ======== unlink fire_upload_file =======
          if(isset($docfiles['fire_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['fire_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['fire_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                   
                } 
            }

          }
           // ======== unlink smoke_upload_file =======
           if(isset($docfiles['smoke_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['smoke_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                 
          } 

            // unlink other file
            $other_files= $docfiles['smoke_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                 
                } 
             }

           }
           // ======== unlink carbon_upload_file =======
           if(isset($docfiles['carbon_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['carbon_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['carbon_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
             }

           } 
            // ======== unlink gas_safety_upload =======
          if(isset($docfiles['gas_safety_upload'])){
             // unlink main file
            $main_doc= $docfiles['gas_safety_upload']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                 
          } 

            // unlink other file
            $other_files= $docfiles['gas_safety_upload']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
            }

          } 

        //===================unlink =========================

      }

      // unset leaddocfile session
      unset($_SESSION['certdocfile']);


//=================================================================================
     
      //insert in notification
      $notification_data=array(
         'user_id'=>$id,
         'url'=>'property_url'
      );
     
      $pro= $this->db->insert('property_notification', $notification_data);

      $this->load->library('email');
      $this->email->from('info@safetycerts.co.uk');
      $this->email->to('kevin@londonsparks.com'); 
      $this->email->cc('tim@ignitestudio.co.uk'); 
      $this->email->subject('A new property has been added');
      $message = 'A new property has been added<br/><br/>To view details please click here:<a href="'.base_url().'user/property_details/'.$post["unique_id"].'">Property Details</a>';                 
      $this->email->message($message);
      $this->email->send();



      $this->session->set_flashdata('message', 'Success! New property successfully added. You can view all registered properties <a href="'.base_url().'user/viewproperty">here</a>');
      redirect('user/addproperty', 'refresh');
  }


public function uploadCertAjax(){
  $cert_type= $_GET['cert_type'];
  $token= $_GET['token'];
  $file=$_FILES[$cert_type];

  if($file['name'] !=''){
     $filename= time()."_".$file['name'];
     $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
     if(move_uploaded_file($file['tmp_name'],$pathfilename)){
        $_SESSION['certdocfile'][$token][$cert_type]['name']= $filename;
        echo $filename;
     }
  }

  die();  
}

public function uploadOtherCertAjax(){
  $cert_type= $_GET['cert_type'];
  $cert_name= $_GET['cert_name'];
  $token= $_GET['token'];
  $files=$_FILES[$cert_name];

  //print_r($_SESSION['certdocfile'][$token]); exit;
  //$_SESSION['certdocfile'][$token][$cert_type]['other'][]= $files['name'][0];
  
  $docarr=array();
  if($files['name'][0] !=''){
     $i=0;
     foreach($files['name'] as $file){
        
        $filename= time()."_".$files['name'][$i];
        $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
        
        if(move_uploaded_file($files['tmp_name'][$i],$pathfilename)){
           $_SESSION['certdocfile'][$token][$cert_type]['other'][]= $filename;
           $docarr[]=$filename;
        }

        $i++;
     }
  }

  echo json_encode($docarr);
  die();  
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
  $prop_user_id =$this->assignjob_model->get_unique_pro_user_id($unique_id);
  if($loggedin_user->role=='admin' || $loggedin_user->role=='contractor'){
  $property_data['property_data']=$this->user_model->display_property_byuniqueid($unique_id);
  $property_data['client_data']=$this->user_model->get_user_by_id($property_data['property_data']['user_id']);
  }
  elseif($loggedin_user->role=='members'){
   if($id == $prop_user_id ){  
      $property_data['property_data']=$this->user_model->display_property_byuniqueid($unique_id);
      $property_data['client_data']=$this->user_model->get_user_by_id($property_data['property_data']['user_id']);
   }
   else{
      redirect('auth/error_404');
   }
  }
  //echo "<pre>"; print_r($property_data['client_data']); exit();
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/property_details',$property_data);
  $this->load->view('layout/addproperty_footer'); 

}



public function property_edit($unique_id){
	$data['title']='Edit Properties';
  $data['token'] = mt_rand(11111111,99999999);
	$loggedin_user=$this->loggedin_user;
	if($loggedin_user->role=='contractor'){
		redirect('auth/error_404'); 
	}
	
	$post = $this->input->post();
	
	$users = $this->ion_auth->users(2)->result();
	
	$data['list_of_clients'] = $users;
	
	$files = $_FILES;
	
	if(isset($post) && count($post) > 0){
		
		 $id=$loggedin_user->id;
		$post=$this->input->post();
		$certificate_data=$post;
		 $user_id=$this->input->post('user_id');
		  
		   if(!$this->ion_auth->is_admin()){
			   $post['user_id']=$id;
		   }else{
			   $post['user_id']=$user_id;
		   }
		//$propertydata=$post;
		$post['electrical_test']=!empty($certificate_data['electrical_prev_date']) ? 'yes' : 'no';
		$post['emergency_test']=!empty($certificate_data['emergency_prev_date']) ? 'yes' : 'no';
		$post['portable_test']=!empty($certificate_data['portable_prev_date']) ? 'yes' : 'no';
		$post['fire_test']=!empty($certificate_data['fire_prev_date']) ? 'yes' : 'no';
		$post['smoke_test']=!empty($certificate_data['smoke_prev_date']) ? 'yes' : 'no';
		$post['carbon_test']=!empty($certificate_data['carbon_prev_date']) ? 'yes' : 'no';
		$post['gas_safety_test']=!empty($certificate_data['gas_safety_prev_date']) ? 'yes' : 'no';
		
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
		unset($post['electrical_expire']);
		unset($post['emergency_expire']);
		unset($post['portable_expire']);
		unset($post['fire_expire']);
		unset($post['smoke_expire']);
		unset($post['carbon_expire']);
		unset($post['gas_safety_expire']);
    unset($post['electrical_certificate_unique_id']);
    unset($post['emergency_certificate_unique_id']);
    unset($post['portable_certificate_unique_id']);
    unset($post['fire_certificate_unique_id']);
    unset($post['smoke_certificate_unique_id']);
    unset($post['carbon_certificate_unique_id']);
    unset($post['gas_certificate_unique_id']);
    unset($post['token']);
   
	  
	  $pro_id=$this->user_model->add_property_detail($post);

    // get token
      $token= $certificate_data['token'];
      $files=array();
      if(isset($_SESSION['certdocfile'][$token])){
         $files= $_SESSION['certdocfile'][$token];
         unset($_SESSION['certdocfile'][$token]);
      }

     // echo "<pre>"; print_r($files); print_r($certificate_data); exit;
	  
	  if($certificate_data['electrical_test']=='yes'){ 		
  		  $cert_data=array();
  		  $certificateid=$this->user_model->find_certificate_for_property($pro_id,1);
  		  $cert_data['certificate_property_id']= $pro_id;		
  		  $cert_data['certificate_name']= 'electrical_test';
  		  $cert_data['certificate_type']= '1';
  		  $cert_data['certificate_date']= $certificate_data['electrical_prev_date'];		
  		  $cert_data['certificate_uploadedby']= $id;
  		  $cert_data['certificate_expire']= $certificate_data['electrical_expire'];
  		  $cert_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_electrical'];
		    if(!empty($files['electrical_upload_file']['name'])){
		       $cert_data['certificate_file']=$files['electrical_upload_file']['name']; 
			     $cert_data['uploaded_date']= date('Y-m-d H:i:s');
		    }
		
		    if(empty($certificateid)){
          $cert_data['certificate_unique_id']= $this->ion_auth->generate_hash();
			    $this->db->insert('certificate_files', $cert_data);
			    $cert_id = $this->db->insert_id();  	
		    }
		  else{
			     $this->db->where('certificate_id',$certificateid);
			     $this->db->update('certificate_files',$cert_data);
		    }
		  
		  //for ($j=0; $j <count($files['other_certificate_file']['name']) ; $j++) {
        // if(!empty($files['other_certificate_file']['name'])){
        if(isset($files['electrical_upload_file']['other'])){
        foreach($files['electrical_upload_file']['other'] as $key=>$filename){
          //if(!empty($files['electrical_upload_file']['name'])){
			 
				
  				$other_files = array();
          $cert_file_unique_id =($certificate_data['electrical_certificate_unique_id']) ? $certificate_data['electrical_certificate_unique_id'] : $cert_data['certificate_unique_id'];        
  				$other_files['certificate_property_id'] = $pro_id;
  				$other_files['unique_id'] = $this->ion_auth->generate_hash();
          $other_files['certificate_unique_id'] = $cert_file_unique_id;				
  				$other_files['certificate_name'] = 'Other Electrical Test';
  				$other_files['certificate_type'] = '1';				
          $other_files['certificate_date'] = $certificate_data['electrical_prev_date'];
  				#$other_files['certificate_date'] = $post['certificate_date'];				
  				$other_files['certificate_uploadedby'] = $id;
  				$other_files['certificate_expire'] = $certificate_data['electrical_expire'];
  				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_electrical'];   
          $data=array();
				  $other_files['other_certificate_file'] = $filename;
				  $other_files['uploaded_date'] = date('Y-m-d h:i:s');
				  $pro= $this->db->insert('other_certificate_files', $other_files);
				   
			  //}
          }
		   }
	  }
	  
	  //save emergency test data
      if($certificate_data['emergency_test']=='yes' && !empty($certificate_data['emergency_prev_date'])){
		   $certificateid=$this->user_model->find_certificate_for_property($pro_id,2); 		  
		    $emmer_data['certificate_property_id']= $pro_id;		  
		    $emmer_data['certificate_name']= 'emergency_test';
		    $emmer_data['certificate_type']= '2';
		    $emmer_data['certificate_date']= $certificate_data['emergency_prev_date'];		 
		    $emmer_data['certificate_uploadedby']= $id;
		    $emmer_data['certificate_expire']= $certificate_data['emergency_expire'];
		    $emmer_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_emergency'];
		  
		  if(!empty($files['emergency_upload_file']['name'])){			 
				 $emmer_data['certificate_file']=$files['emergency_upload_file']['name'];
				 $emmer_data['uploaded_date']= date('Y-m-d H:i:s');
						   
		   }
		  
  	      if(empty($certificateid)){
            $emmer_data['certificate_unique_id']= $this->ion_auth->generate_hash();
					$this->db->insert('certificate_files', $emmer_data);
					$cert_id = $this->db->insert_id();  	
			  }
		  else{
			  $this->db->where('certificate_id',$certificateid);
			  $this->db->update('certificate_files',$emmer_data);
		  }
		  
		  //for ($j=0; $j <count($files['other_emergency_certificate_file']['name']) ; $j++) {
       //if(!empty($files['emergency_upload_file']['name'])){
       if(isset($files['emergency_upload_file']['other'])){
       foreach($files['emergency_upload_file']['other'] as $key=>$filename){
			  //if(!empty($files['other_emergency_certificate_file']['name'])){
				
                $other_files = array();
                $cert_file_unique_id =($certificate_data['emergency_certificate_unique_id']) ? $certificate_data['emergency_certificate_unique_id'] : $emmer_data['certificate_unique_id'];

                $other_files['certificate_property_id'] = $pro_id;
                $other_files['unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_unique_id'] = $cert_file_unique_id;
              
                $other_files['certificate_name'] = 'Other Emergency Test';
                $other_files['certificate_type'] = '2';
                 $other_files['certificate_date'] = $certificate_data['emergency_prev_date'];
             
                
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $certificate_data['electrical_expire'];
				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_emergency'];

                                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
				   $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                   $pro= $this->db->insert('other_certificate_files', $other_files);
               

           //   }
		    }	
      }
	  }
	  
	  	    //save portable test data
      if($certificate_data['portable_test']=='yes' && !empty($certificate_data['portable_prev_date'])){
		  $certificateid=$this->user_model->find_certificate_for_property($pro_id,3); 
		  $portable_data['certificate_property_id']= $pro_id;
		  
		  $portable_data['certificate_name']= 'portable_test';
		  $portable_data['certificate_type']= '3';
		  $portable_data['certificate_date']=$certificate_data['portable_prev_date'];
		  $portable_data['certificate_uploadedby']= $id;
		  $portable_data['certificate_expire']= $certificate_data['portable_expire'];
		  $portable_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_portable'];
		  
		  if(!empty($files['portable_upload_file']['name'])){
		
				$portable_data['certificate_file']=$files['portable_upload_file']['name'];
				$portable_data['uploaded_date']= date('Y-m-d H:i:s');
			
		  }
		  
		  if(empty($certificateid)){
        $portable_data['certificate_unique_id']= $this->ion_auth->generate_hash();
			$this->db->insert('certificate_files', $portable_data);
			$cert_id = $this->db->insert_id();  	
		  }
		  else{
			  $this->db->where('certificate_id',$certificateid);
			  $this->db->update('certificate_files',$portable_data);
		  }
		  
		  //for ($j=0; $j <count($files['other_portable_certificate_file']['name']) ; $j++) {
      //if(!empty($files['portable_upload_file']['name'])){
         if(isset($files['portable_upload_file']['other'])){
      foreach($files['portable_upload_file']['other'] as $key=>$filename){
             // if(!empty($files['other_portable_certificate_file']['name'])){
				$certificateid=$this->user_model->find_otherfcertificates_for_property($pro_id,2);
                $other_files = array();
                $cert_file_unique_id =($certificate_data['portable_certificate_unique_id']) ? $certificate_data['portable_certificate_unique_id'] : $portable_data['certificate_unique_id'];

                

                $other_files['certificate_property_id'] = $pro_id;
                $other_files['unique_id'] = $this->ion_auth->generate_hash();
               $other_files['certificate_unique_id'] = $cert_file_unique_id;
              
                $other_files['certificate_name'] = 'Other Portable Test';
                $other_files['certificate_type'] = '3';
               
                 $other_files['certificate_date'] = $certificate_data['portable_prev_date'];
               
                
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $certificate_data['portable_expire'];
				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_portable'];
                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
				   $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                    $pro= $this->db->insert('other_certificate_files', $other_files);
                

              //}
           }
           }
	  }
	  
	   if($certificate_data['fire_test']=='yes' && !empty($certificate_data['fire_prev_date'])){
		   $certificateid=$this->user_model->find_certificate_for_property($pro_id,4);   
		  $fire_data['certificate_property_id']= $pro_id;
		  
		  $fire_data['certificate_name']= 'fire_test';
		  $fire_data['certificate_type']= '4';
		  $fire_data['certificate_date']= $certificate_data['fire_prev_date'];
		  
		  $fire_data['certificate_uploadedby']= $id;
		  $fire_data['certificate_expire']= $certificate_data['fire_expire'];
		  $fire_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_fire'];

		  if(!empty($files['fire_upload_file']['name'])){
			
              $fire_data['certificate_file']=$files['fire_upload_file']['name'];
			  $fire_data['uploaded_date']= date('Y-m-d H:i:s');
		
		  }
		  if(empty($certificateid)){
        $fire_data['certificate_unique_id']= $this->ion_auth->generate_hash();
			$this->db->insert('certificate_files', $fire_data);
			$cert_id = $this->db->insert_id();  	
		  }
		  else{
			  $this->db->where('certificate_id',$certificateid);
			  $this->db->update('certificate_files',$fire_data);
		  }
		  
		  //for ($j=0; $j <count($files['other_fire_certificate_file']['name']) ; $j++) {
       //if(!empty($files['fire_upload_file']['name'])){
      if(isset($files['fire_upload_file']['other'])){
      foreach($files['fire_upload_file']['other'] as $key=>$filename){
              //if(!empty($files['other_fire_certificate_file']['name'])){
				$certificateid=$this->user_model->find_otherfcertificates_for_property($pro_id,4);
                $other_files = array();
                $cert_file_unique_id =($certificate_data['fire_certificate_unique_id']) ? $certificate_data['fire_certificate_unique_id'] : $fire_data['certificate_unique_id'];

                

                $other_files['certificate_property_id'] = $pro_id;
                $other_files['unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_unique_id'] = $cert_file_unique_id;
                
                $other_files['certificate_name'] = 'Other Electrical Test';
                $other_files['certificate_type'] = '4';
                
                $other_files['certificate_date'] = $certificate_data['fire_prev_date'];
               
               
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $certificate_data['fire_expire'];
				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_fire'];
                           
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
				    $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                  $pro= $this->db->insert('other_certificate_files', $other_files);
               

              //}
           }
          }   
	   }
	   
	   if($certificate_data['smoke_test']=='yes' && !empty($certificate_data['smoke_prev_date'])){
			  $certificateid=$this->user_model->find_certificate_for_property($pro_id,5); 
			  $smoke_data['certificate_property_id']= $pro_id;
              
              $smoke_data['certificate_name']= 'smoke_test';
              $smoke_data['certificate_type']= '5';
              $smoke_data['certificate_date']= $certificate_data['smoke_prev_date'];
              
              $smoke_data['certificate_uploadedby']= $id;
              $smoke_data['certificate_expire']= $certificate_data['smoke_expire'];
			  $smoke_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_smoke'];
			  if(!empty($files['smoke_upload_file']['name'])){
				  
					  $smoke_data['certificate_file']=$files['smoke_upload_file']['name'];
					  $smoke_data['uploaded_date']= date('Y-m-d H:i:s');
				
			  }
              if(empty($certificateid)){
                $smoke_data['certificate_unique_id']= $this->ion_auth->generate_hash();
					$this->db->insert('certificate_files', $smoke_data);
					$cert_id = $this->db->insert_id();  	
			  }
			  else{
				  $this->db->where('certificate_id',$certificateid);
				  $this->db->update('certificate_files',$smoke_data);
			  }
			  
			  //for ($j=0; $j <count($files['other_smoke_certificate_file']['name']) ; $j++) {
       // if(!empty($files['smoke_upload_file']['name'])){
         if(isset($files['smoke_upload_file']['other'])){
         foreach($files['smoke_upload_file']['other'] as $key=>$filename){
              //if(!empty($files['other_smoke_certificate_file']['name'])){
				
                $other_files = array();
                $cert_file_unique_id =($certificate_data['smoke_certificate_unique_id']) ? $certificate_data['smoke_certificate_unique_id'] : $smoke_data['certificate_unique_id'];
                
               

                $other_files['certificate_property_id'] = $pro_id;
                $other_files['unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_unique_id'] =  $cert_file_unique_id;
                //$other_files['certificate_name'] = 'Other '.$post['certificate_name'];
                $other_files['certificate_name'] = 'Other Electrical Test';
                $other_files['certificate_type'] = '5';
               
                $other_files['certificate_date'] = $certificate_data['smoke_prev_date'];
              
               
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $certificate_data['smoke_expire'];
				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_smoke'];

                                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
				    $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                   $pro= $this->db->insert('other_certificate_files', $other_files);
                

             // }
           }
         }
	   }
	   
	   if($certificate_data['carbon_test']=='yes' && !empty($certificate_data['carbon_prev_date'])){
		   	  $certificateid=$this->user_model->find_certificate_for_property($pro_id,6);
			  $carbon_data['certificate_property_id']= $pro_id;
              
              $carbon_data['certificate_name']= 'carbon_test';
              $carbon_data['certificate_type']= '6';
              $carbon_data['certificate_date']= $certificate_data['carbon_prev_date'];
             
              $carbon_data['certificate_uploadedby']= $id;
              $carbon_data['certificate_expire']= $certificate_data['carbon_expire'];
			  $carbon_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_carbon'];
			  if(!empty($files['carbon_upload_file']['name'])){					
					  $carbon_data['certificate_file']=$files['carbon_upload_file']['name'];
					   $carbon_data['uploaded_date']= date('Y-m-d H:i:s');				
			  }
              if(empty($certificateid)){
                $carbon_data['certificate_unique_id']= $this->ion_auth->generate_hash();
					$this->db->insert('certificate_files', $carbon_data);
					$cert_id = $this->db->insert_id();  	
			  }
			  else{
				  $this->db->where('certificate_id',$certificateid);
				  $this->db->update('certificate_files',$carbon_data);
			  }
			  
			   //for ($j=0; $j <count($files['other_carbon_certificate_file']['name']) ; $j++) {
          if(isset($files['carbon_upload_file']['other'])){
        foreach($files['carbon_upload_file']['other'] as $key=>$filename){
              //if(!empty($files['other_carbon_certificate_file']['name'])){
				$certificateid=$this->user_model->find_otherfcertificates_for_property($pro_id,6);
                $other_files = array();
                $cert_file_unique_id =($certificate_data['carbon_certificate_unique_id']) ? $certificate_data['carbon_certificate_unique_id'] : $carbon_data['certificate_unique_id'];

               

                $other_files['certificate_property_id'] = $pro_id;
                $other_files['unique_id'] = $this->ion_auth->generate_hash();
                 $other_files['certificate_unique_id'] = $cert_file_unique_id;
               
                $other_files['certificate_name'] = 'Other Electrical Test';
                $other_files['certificate_type'] = '6';
                
                $other_files['certificate_date'] = $cert_date;
                $other_files['certificate_date'] = $certificate_data['carbon_prev_date'];
               
                
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $certificate_data['carbon_expire'];
				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_carbon'];

                                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
				   $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                   $pro= $this->db->insert('other_certificate_files', $other_files);
               

             // }
            }
           } 
	   }
	   
	   if($certificate_data['gas_safety_test']=='yes' && !empty($certificate_data['gas_safety_prev_date'])){
			  $certificateid=$this->user_model->find_certificate_for_property($pro_id,7);
			  $gas_safety_data['certificate_property_id']= $pro_id;
              
              $gas_safety_data['certificate_name']= 'gas_safety_test';
              $gas_safety_data['certificate_type']= '7';
              $gas_safety_data['certificate_date']= $certificate_data['gas_safety_prev_date'];
             
              $gas_safety_data['certificate_uploadedby']= $id;
              $gas_safety_data['certificate_expire']= $certificate_data['gas_safety_expire'];
			  $gas_safety_data['is_first_property_certificate']= $certificate_data['is_first_property_certificate_gas'];
			  if(!empty($files['gas_safety_upload']['name'])){
				   
					  $gas_safety_data['certificate_file']=$files['gas_safety_upload']['name'];
					   $gas_safety_data['uploaded_date']= date('Y-m-d H:i:s');
					
			  }
               if(empty($certificateid)){
                $gas_safety_data['certificate_unique_id']= $this->ion_auth->generate_hash();
					$this->db->insert('certificate_files', $gas_safety_data);
					$cert_id = $this->db->insert_id();  	
			  }
			  else{
				  $this->db->where('certificate_id',$certificateid);
				  $this->db->update('certificate_files',$gas_safety_data);
			  }
			  
			  ///for ($j=0; $j <count($files['other_gassafety_certificate_file']['name']) ; $j++) {
          if(isset($files['gas_safety_upload']['other'])){
         foreach($files['gas_safety_upload']['other'] as $key=>$filename){
            //  if(!empty($files['other_gassafety_certificate_file']['name'][$j])){
				$other_files = array();
                $cert_file_unique_id =($certificate_data['gas_certificate_unique_id']) ? $certificate_data['gas_certificate_unique_id'] : $gas_safety_data['certificate_unique_id'];

              

                $other_files['certificate_property_id'] = $pro_id;
                $other_files['unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_unique_id'] = $cert_file_unique_id;              
                $other_files['certificate_name'] = 'Other Electrical Test';
                $other_files['certificate_type'] = '7';              
                $other_files['certificate_date'] = $certificate_data['electrical_prev_date'];
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $certificate_data['gas_safety_expire'];
				$other_files['is_first_property_certificate']= $certificate_data['is_first_property_certificate_gas'];

                                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
				    $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                  $pro= $this->db->insert('other_certificate_files', $other_files);
              

             // }
           }
          } 
	   }

     foreach($_SESSION['certdocfile'] as $docfiles){
        
        // ======== unlink electrical_upload_file =======
          if(isset($docfiles['electrical_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['electrical_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                   
          } 

            // unlink other file
            $other_files= $docfiles['electrical_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                 
                } 
            }

          }
          // ======== unlink emergency_upload_file =======
          if(isset($docfiles['emergency_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['emergency_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['emergency_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
            }

          }
          // ======== unlink portable_upload_file =======
          if(isset($docfiles['portable_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['portable_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['portable_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
            }

          }
          // ======== unlink fire_upload_file =======
          if(isset($docfiles['fire_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['fire_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['fire_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                   
                } 
            }

          }
           // ======== unlink smoke_upload_file =======
           if(isset($docfiles['smoke_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['smoke_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                 
          } 

            // unlink other file
            $other_files= $docfiles['smoke_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                 
                } 
             }

           }
           // ======== unlink carbon_upload_file =======
           if(isset($docfiles['carbon_upload_file'])){
             // unlink main file
            $main_doc= $docfiles['carbon_upload_file']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                  
          } 

            // unlink other file
            $other_files= $docfiles['carbon_upload_file']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
             }

           } 
            // ======== unlink gas_safety_upload =======
          if(isset($docfiles['gas_safety_upload'])){
             // unlink main file
            $main_doc= $docfiles['gas_safety_upload']['name'];
            $dcfls=$_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$main_doc;
            if(file_exists($dcfls)){
                   unlink($dcfls);
                 
          } 

            // unlink other file
            $other_files= $docfiles['gas_safety_upload']['other'];
            foreach($other_files as $key=>$otherfl){
                $other_doc= $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$otherfl;

                if(file_exists($other_doc)){
                   unlink($other_doc);
                  
                } 
            }

          } 

        //===================unlink =========================

      }

      // unset leaddocfile session
      unset($_SESSION['certdocfile']);
	  
	  //insert in notification
      $notification_data=array(
            'user_id'=>$id,
            'url'=>'property_url'
      );

      $pro= $this->db->insert('property_notification', $notification_data);
      $this->session->set_flashdata('message', 'Property is Successfully Submitted.');
      redirect('user/property_edit/'.$unique_id, 'refresh');
	}
	
	 $data['login_user']=$this->loggedin_user;
	 
	 $loggedin_user=$this->loggedin_user;
	 $id=$loggedin_user->id;
	  
	 $property_data['property_data']=$this->user_model->display_property_byuniqueid($unique_id);

	 $prop_id= $this->user_model->get_property_id_by_unique_id($unique_id);
	 $property_data['property_files']=$this->user_model->get_property_files($prop_id);

	 //$property_data['certifiles'] = $this->user_model->get_property_certificates_files($prop_id);
	 $property_data['certifiles'] = $this->user_model->get_property_certificates_files_first($prop_id);
	  
	 $data['certificatedetails']=$this->user_model->get_property_certificates_files_first($prop_id);
	 $data['othercertificatedetails']=$this->user_model->other_certificate_files($prop_id);
  
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

public function delete_CertificateAjax(){
  $post=$this->input->post();
  $post['certificate_file']= NULL;
  $certificate_unique_id= $this->input->post('certificate_unique_id');
  $this->db->where('certificate_unique_id', $certificate_unique_id);
  $this->db->update('certificate_files',$post);
   echo "updated";
}

public function delete_otherCertificateAjax(){
   $unique_id= $this->input->post('unique_id');      
      $this->db->where('unique_id', $unique_id);
      $this->db->delete('other_certificate_files'); 
      echo "deleted";
      exit();
}

}
 