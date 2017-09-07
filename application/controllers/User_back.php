<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    // Declaration of the propery
    protected $loggedin_user; 
    
    public function __construct(){
        parent::__construct();
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
  
  $data['login_user']=$this->loggedin_user;
   $login_user = $this->loggedin_user;
   
  if($this->ion_auth->is_admin() || $login_user->role=='members'){
      $id=NULL;
      if(!$this->ion_auth->is_admin()){
    	   $id=$login_user->id;  
      } 

      $data['get_all_dates'] = $this->get_all_dates();
      $data['all_certificate'] = $this->assignjob_model->get_allcertificate_list($id);
  }

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
  $this->load->view('user/certificate',$data);
  $this->load->view('layout/dashboard_footer');
  }else{
	 redirect('auth/error_404');
  }
}

public function profile(){
  
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


public function deleteContratorAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id
   $post_data= array('active'=>'0');
   $this->ion_auth->update($id, $post_data);
      echo "deleted";

}

public function deletePropertyAjax(){
      $unique_id= $this->input->post('unique_id');
      $this->db->where('unique_id', $unique_id);
      $this->db->delete('properties'); 
      echo "deleted";

}







public function deleteMemberAjax(){
   $unique_id= $this->input->post('unique_id');
   $id= $this->user_model->get_id($unique_id);
   // get user by id
   $post_data= array('active'=>'0');
   $this->ion_auth->update($id, $post_data);
   
   //$this->user_model->delete_user_by_id($id);
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

public function addproperty(){

  $data['login_user']=$this->loggedin_user;
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/addproperty');
  $this->load->view('layout/addproperty_footer'); 

}

/*Function to create the property for the login in user*/
public function createproperty(){

   $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   //store all post data
   $post=$this->input->post();
   $test_date=$this->input->post('prev_test_date');
   $test_date=date('Y-m-d',strtotime($test_date));
   $post['unique_id']= $this->ion_auth->generate_hash();
   $post['prev_test_date']=$test_date;
   $post['user_id']=$id;
   $post['created']=date('Y-m-d h:i:s');

   $pro_id=$this->user_model->add_property_detail($post);

   if(!$pro_id){
      $this->session->set_flashdata('message', 'Eror! New property could not be added. Please try again');
      redirect('user/addproperty', 'refresh');
   }

   $files= $_FILES;
   if($files['userfile']['name']){
   	  $config['upload_path'] = './uploads/';
	  $config['allowed_types'] = 'gif|jpg|png|pdf';
	  $config['max_size']	= '';
	  $config['max_width']  = '';
	  $config['max_height']  = ''; 

	  $this->load->library('upload', $config);

	  if($this->upload->do_upload()){
		 $upload_data = $this->upload->data();
		 $data=array();
         $data['property_id']=$pro_id;
         $data['doc']=$upload_data['file_name'];
         $pro= $this->db->insert('property_documents', $data);
		
	 }

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

  $data['login_user']=$this->loggedin_user;
  $loggedin_user=$this->loggedin_user;
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
  $data['login_user']=$this->loggedin_user;
  $loggedin_user=$this->loggedin_user;
  $id=$loggedin_user->id;
  $property_data['property_data']=$this->user_model->display_property_byuniqueid($unique_id);
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/property_details',$property_data);
  $this->load->view('layout/addproperty_footer'); 

}



public function property_edit($unique_id){

   $loggedin_user=$this->loggedin_user;
   $post=$this->input->post();
   if(isset($post) && count($post) > 0){ 
      $id=$loggedin_user->id;
      //store all post data
      $post=$this->input->post();
      $test_date=$this->input->post('prev_test_date');
      $test_date=date('Y-m-d',strtotime($test_date));
   
      $post['prev_test_date']=$test_date;
      $post['user_id']=$id;
      $post['created']=date('Y-m-d h:i:s');
      $post['unique_id']=$unique_id;

      unset($post['userfile']);
      // update property
      $pro_id=$this->user_model->add_property_detail($post);

      $files= $_FILES;

      if($files['userfile']['name']){
	   	  $config['upload_path'] = './uploads/';
		  $config['allowed_types'] = 'gif|jpg|png|pdf';
		  $config['max_size']	= '';
		  $config['max_width']  = '';
		  $config['max_height']  = ''; 

		  $this->load->library('upload', $config);

		  if($this->upload->do_upload()){
			 $upload_data = $this->upload->data();
			 $data=array();
	         $data['property_id']=$pro_id;
	         $data['doc']=$upload_data['file_name'];
	         $pro= $this->db->insert('property_documents', $data);
		 }
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

  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('apply/editproperty',$property_data);
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
   $list[] = date('m/d/Y', $i);
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

}
 