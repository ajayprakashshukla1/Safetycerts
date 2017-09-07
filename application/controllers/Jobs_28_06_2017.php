<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {
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
	 $data['title']='All Jobs';   
   $data['login_user']=$this->loggedin_user;   
   $loggedin_user=$this->loggedin_user;
   if($loggedin_user->role=='members'){
     redirect('auth/error_404'); 
   }
   $id=$loggedin_user->id;	
   $data['job_lists'] = $this->assignjob_model->list_all_job($id);
   $this->load->view('layout/dashboard_header',$data);
   $this->load->view('job/job',$data);
   $this->load->view('layout/dashboard_footer');
}

public function upload_certificate($unique_id=NULL){
  $data['title']='Upload Certificate';
  $loggedin_user=$this->loggedin_user;  
   //$unique_id is property unique id
   if($unique_id){

      $data['unique_id']=$unique_id;	   
      if($_POST){
          $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
          $this->form_validation->set_rules('certificate_name', 'certificate name', 'required');
          $this->form_validation->set_rules('certificate_type', 'certificate type', 'required');
          $this->form_validation->set_rules('certificate_date', 'certificate date', 'required');

          if (empty($_FILES['certificate_file']['name'])){
             $this->form_validation->set_rules('certificate_file', 'certificate file', 'required');
          }

         if ($this->form_validation->run() == FALSE){

         }else{

           $loggedin_user=$this->loggedin_user;
           $id=$loggedin_user->id;
           //store all post data
           $post=$this->input->post();
           //$post['certificate_unique_id']= $this->ion_auth->generate_hash();
           $post['certificate_uploadedby']=$id;
           $post['uploaded_date']=date('Y-m-d h:i:s');
           $files= $_FILES;
           
           if(!empty($files['certificate_file']['name'])){

              $filename= time()."_".$files['certificate_file']['name'];
              $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
              if(move_uploaded_file($files['certificate_file']['tmp_name'],$pathfilename)){
                 // insert in db
                 $data=array();
                 $prop_id =$this->assignjob_model->get_prop_by_uniqueid($unique_id);
                 $post['certificate_property_id']=$prop_id;
                 $post['certificate_unique_id']=$this->ion_auth->generate_hash();
                 $post['certificate_file']=$filename;
                 $pro= $this->db->insert('certificate_files', $post);

                 // change status of property
                 $status_arr=array();
                 $status_arr['status']=1;
                 $this->db->where('id', $prop_id);
                 $pro= $this->db->update('properties', $status_arr);

              }

           }

          //insert in notification
          $notification_data=array(
                 'user_id'=>$id,
                 'url'=>'property_url',
        		     'message'=>"certificate uploaded"
            );

            $pro= $this->db->insert('property_notification', $notification_data);
            $this->session->set_flashdata('message', 'Certificate uploaded Sucessfully !!');
            redirect('jobs/upload_certificate/'.$unique_id, 'refresh');
        }
      }


     $data['login_user']=$this->loggedin_user;	
     $loggedin_user=$this->loggedin_user;
     $id=$loggedin_user->id;	
     $data['certificate_list'] = $this->assignjob_model->get_certificate_list();
     $this->load->view('layout/dashboard_header',$data);
     $this->load->view('job/upload_certificate',$data);
     $this->load->view('layout/dashboard_footer');
   }else{
	    redirect('auth/error_404'); 
   }
}

public function view_certificate($unique_id=NULL,$cert_type=NULL){
  $data['title']='View Certificate';
   // $unique_id is property unique id
   $loggedin_user=$this->loggedin_user;
  
   if($unique_id){  
       $data['login_user']=$this->loggedin_user;  
       $loggedin_user=$this->loggedin_user;
       $id=$loggedin_user->id; 
       $prop_id =$this->assignjob_model->get_prop_by_uniqueid($unique_id); 
       $data['prop_details'] = $this->assignjob_model->get_prop_details_by_id($prop_id);
       //print_r($data['prop_details']); exit;
       $data['unique_id']=$unique_id;
       $data['all_certificates'] = $this->assignjob_model->get_certificate_by_prop_id($prop_id,$cert_type);
       //$data['property_unique_id'] =$this->user_model->get_property_unique_id($id);
       $this->load->view('layout/dashboard_header',$data);
       $this->load->view('job/view_certificate',$data);
       $this->load->view('layout/dashboard_footer');
   }else{
      redirect('auth/error_404'); 
   }
}

public function certificate_download($unique_id=NULL){
  
   if($unique_id){  
     $this->load->helper('download');
     $data['login_user']=$this->loggedin_user;  
     $loggedin_user=$this->loggedin_user;
     $id=$loggedin_user->id; 
     $certificate_file =$this->assignjob_model->get_certificatefile_by_cerunique($unique_id);  
     force_download(FCPATH.'uploads/cert/'.$certificate_file, NULL);
  
   }else{
      redirect('auth/error_404'); 
   }
}

public function edit_certificate($certificate_unique_id = NULL){
  
   $data = $this->input->post();
   $data['title']='Edit Certificate';
   $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   $data['login_user']=$this->loggedin_user; 
  
   if($_POST){
          $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
          $this->form_validation->set_rules('certificate_name', 'certificate name', 'required');
          $this->form_validation->set_rules('certificate_type', 'certificate type', 'required');
          $this->form_validation->set_rules('certificate_date', 'certificate date', 'required');

          if (empty($_FILES['certificate_file']['name'])){
             //$this->form_validation->set_rules('certificate_file', 'certificate file', 'required');
          }

         if ($this->form_validation->run() == FALSE){

         }else{

           $loggedin_user=$this->loggedin_user;
           $id=$loggedin_user->id;
           $post=$this->input->post();

           $post['certificate_uploadedby']=$id;
           $post['uploaded_date']=date('Y-m-d h:i:s');
           $files= $_FILES;
           
           if(!empty($files['certificate_file']['name'])){

              $filename= time()."_".$files['certificate_file']['name'];
              $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
              if(move_uploaded_file($files['certificate_file']['tmp_name'],$pathfilename)){                
                 $data=array();
                 $post['certificate_file']=$filename;
		       }

           }
           
            $this->db->where('certificate_unique_id', $certificate_unique_id);
            $pro= $this->db->update('certificate_files', $post);               
            $this->session->set_flashdata('message', 'Certificate updated Sucessfully !!');
            redirect(base_url().'jobs/edit_certificate/'.$certificate_unique_id, 'refresh');
        }
      }
   
   //$cert_data['all_certificate'] = $all_certificate;
   $data['all_certificate'] = $this->assignjob_model->get_certificate_row($certificate_unique_id); 
   $data['cert_types'] = $this->assignjob_model->get_certificate_type();
   $data['property_unique_id'] =$this->user_model->get_property_unique_id($data['all_certificate']['certificate_property_id']);
   
   $this->load->view('layout/dashboard_header',$data);
   $this->load->view('job/edit_certificate',$data);
   $this->load->view('layout/dashboard_footer');

}

public function deleteCertificateAjax(){
      $certificate_unique_id= $this->input->post('certificate_unique_id');
      $this->db->where('certificate_unique_id', $certificate_unique_id);
      //unlink(base_url("safetycerts/uploads/cert/".$group_picture));
      $this->db->delete('certificate_files'); 
      echo "deleted";

}

}
 