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
        $this->load->library('zip');
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
           $prop_id =$this->assignjob_model->get_prop_by_uniqueid($unique_id);
          //for ($j=0; $j <count($files['certificate_file']['name']) ; $j++) { 
           if(!empty($files['certificate_file']['name'])){
              $filename= time()."_".$files['certificate_file']['name'];
              $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
              if(move_uploaded_file($files['certificate_file']['tmp_name'],$pathfilename)){
                 // insert in db
                 $data=array();
                 
                 $post['certificate_property_id']=$prop_id;
                 $post['certificate_unique_id']=$this->ion_auth->generate_hash();
                 $post['certificate_file']=$filename;
                 $pro= $this->db->insert('certificate_files', $post);

                 // change status of property
				          $assigned_job =$this->assignjob_model->list_all_property_job($prop_id);
				          $certificate_ids=json_decode($assigned_job[0]['certficate_id']);	
				          $required_certificates=count($certificate_ids);	 
					
				          $uploded_certificate=count($this->assignjob_model->list_all_property_certificate($prop_id));
				 
				          if($uploded_certificate==$required_certificates)
					           $status=1;
				          else
					           $status=2;
				 
                  $status_arr=array();
                  $status_arr['status']=$status;
                  $this->db->where('id', $prop_id);
                  $pro= $this->db->update('properties', $status_arr);

              }

           // }
            }

            for ($j=0; $j <count($files['other_certificate_file']['name']) ; $j++) {
              if(!empty($files['other_certificate_file']['name'][$j])){

                $other_files = array();

                $other_files['certificate_property_id'] = $prop_id;
                $other_files['certificate_unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_name'] = 'Other '.$post['certificate_name'];
                $other_files['certificate_type'] = $post['certificate_type'];
                $other_files['certificate_date'] = date('Y-m-d',strtotime($post['certificate_date']));
                #$other_files['certificate_date'] = $post['certificate_date'];
                $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $post['certificate_expire'];

                $filename= time()."_".$files['other_certificate_file']['name'][$j];
                $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
                if(move_uploaded_file($files['other_certificate_file']['tmp_name'][$j],$pathfilename)){                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
                   $pro= $this->db->insert('other_certificate_files', $other_files);
                }

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

public function upload_job_certificate($unique_id=NULL,$job_id=NULL){
  $data['title']='Upload Certificate';
  
  $loggedin_user=$this->loggedin_user; 
  $disabledcertificates = array();
  $certificatestodisable= array();
   //$unique_id is property unique id
   $disabledcertificates=$this->assignjob_model->get_assigned_certificates($this->assignjob_model->get_prop_by_uniqueid($unique_id),$job_id);
   //print_r($disabledcertificates);  exit();
   if(!empty($disabledcertificates)){
   foreach($disabledcertificates as $key=>$val){
	   $certificatestodisable[]=$val['certificate_type'];
   }
  }
   $data['certificatestodisable']=$certificatestodisable;
   $job_details=$this->assignjob_model->get_job_details($job_id);
   $assigned_certificates=json_decode($job_details[0]['certficate_id']);
   foreach($assigned_certificates as $key=>$val){
	   $certificatename=$this->assignjob_model->get_certificatefile_by_id($val);
	   $certificates[$key]['id']=$val;
	   $certificates[$key]['name']=$certificatename;
   }
   
   if($unique_id){

      $data['unique_id']=$unique_id;	
	  
      if($_POST){
		  $all_assigned_certificates=$this->assignjob_model->get_all_assigned_certificates($this->assignjob_model->get_prop_by_uniqueid($unique_id),$job_id);
		 
		 $all_certifcates=json_decode($all_assigned_certificates[0]['certficate_id']);
		 
		 if(!in_array($_POST['certificate_type'],$all_certifcates)){
			$this->session->set_flashdata('error', 'Certificate type has been unassigned to you.');
            redirect('jobs/upload_job_certificate/'.$unique_id.'/'.$job_id, 'refresh');
		 }
		  
		  
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
                 $post['certificate_job_id']=base64_decode($job_id);
                 $pro= $this->db->insert('certificate_files', $post);

                 // change status of property
				$assigned_job =$this->assignjob_model->list_all_property_job($prop_id);
				$certificate_ids=json_decode($assigned_job[0]['certficate_id']);	
				$required_certificates=count($certificate_ids);	 
					
				 $uploded_certificate=count($this->assignjob_model->list_all_property_certificate($prop_id));
				 
				 if($uploded_certificate==$required_certificates)
					 $status=1;
				 else
					 $status=2;
				 
                 $status_arr=array();
                 $status_arr['status']=$status;
                 $this->db->where('id', $prop_id);
                 $pro= $this->db->update('properties', $status_arr);

              }

           }
		   
		    for ($j=0; $j <count($files['other_certificate_file']['name']) ; $j++) {
              if(!empty($files['other_certificate_file']['name'][$j])){

                $other_files = array();

                $other_files['certificate_property_id'] = $prop_id;
                $other_files['certificate_unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_name'] = 'Other '.$post['certificate_name'];
                $other_files['certificate_type'] = $post['certificate_type'];
                $other_files['certificate_date'] = date('Y-m-d',strtotime($post['certificate_date']));
                #$other_files['certificate_date'] = $post['certificate_date'];
                $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $post['certificate_expire'];

                $filename= time()."_".$files['other_certificate_file']['name'][$j];
                $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
                if(move_uploaded_file($files['other_certificate_file']['tmp_name'][$j],$pathfilename)){                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
                   $pro= $this->db->insert('other_certificate_files', $other_files);
                }

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
            redirect('jobs/upload_job_certificate/'.$unique_id.'/'.$job_id, 'refresh');
        }
      }


     $data['login_user']=$this->loggedin_user;	
     $loggedin_user=$this->loggedin_user;
     $id=$loggedin_user->id;	
     //$data['certificate_list'] = $this->assignjob_model->get_certificate_list();
     $data['certificate_list'] = $certificates;
     $data['job_id'] = $job_id;
     $this->load->view('layout/dashboard_header',$data);
     $this->load->view('job/upload_job_certificate',$data);
     $this->load->view('layout/dashboard_footer');
   }else{
	    redirect('auth/error_404'); 
   }
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

public function view_certificate($unique_id=NULL,$job_id=NULL,$cert_type=NULL){
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
       
	   $data['job_id']=$job_id;
	   
       $all_assigned_certificates=$this->assignjob_model->get_certificate_by_prop_id($prop_id,$cert_type,$job_id);

       //echo "<pre>";print_r($all_assigned_certificates);
       $new_array = array();
       $i=0;
       foreach ($all_assigned_certificates as $all_certificates) {
         $certificate_file =$this->assignjob_model->get_other_cert_by_cerunique($prop_id,$all_certificates['certificate_type']);
          
         $all_certificates['property_id'] = $prop_id;
         $all_certificates['certificate_type'] = $all_certificates['certificate_type'];
         $all_certificates['job_id'] = $job_id;
         $all_certificates['cert_files'] = $this->assignjob_model->get_certificate_type_by_prop_id($prop_id,$all_certificates['certificate_type'],$job_id);
         $all_certificates['count_other_cert_files'] = count($certificate_file);
         $new_array[$i] = $all_certificates;
         $i++;
       }
      $data['all_certificates'] =  $new_array;
      //echo "<pre>";print_r($data['all_certificates']); exit();
	   $data['job_id']=$job_id;
	   //$data['property_unique_id'] =$this->user_model->get_property_unique_id($id);
	   
	   $data['get_all_dates'] = $this->get_all_dates();
       $this->load->view('layout/dashboard_header',$data);
       $this->load->view('job/view_certificate',$data);
       $this->load->view('layout/dashboard_footer');
   }else{
      redirect('auth/error_404'); 
   }
}

public function view_property_certificate($unique_id=NULL,$cert_type=NULL){
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
     	   
       //$all_assigned_certificates=$this->assignjob_model->get_certificate_by_prop_id($prop_id,$cert_type,1);
	   
       $all_assigned_certificates=$this->assignjob_model->get_certificate_by_type($prop_id,$cert_type,1);
	
       //echo "<pre>";print_r($all_assigned_certificates);
       $new_array = array();
       $i=0;
       foreach ($all_assigned_certificates as $all_certificates) {
		 
         $certificate_file =$this->assignjob_model->get_other_cert_by_cerunique($prop_id,$all_certificates['certificate_type']);
          
         $all_certificates['property_id'] = $prop_id;
         $all_certificates['certificate_type'] = $all_certificates['certificate_type'];
         $all_certificates['certificate_date'] = $all_certificates['certificate_date'];
         $all_certificates['cert_files'] = $this->assignjob_model->get_certificate_type_by_prop_id($prop_id,$all_certificates['certificate_type']);
         $all_certificates['count_other_cert_files'] = count($certificate_file);
         $new_array[$i] = $all_certificates;
         $i++;
       }
      $data['all_certificates'] =  $new_array;
      //echo "<pre>";print_r($data['all_certificates']); exit();
	  
	   //$data['property_unique_id'] =$this->user_model->get_property_unique_id($id);
	   
	   $data['get_all_dates'] = $this->get_all_dates();
       $this->load->view('layout/dashboard_header',$data);
       $this->load->view('job/view_property_certificate',$data);
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

public function other_certificate_zip($prop_id=NULL,$cert_type=NULL,$job_id=NULL){
    $certificate_file =$this->assignjob_model->get_other_cert_by_cerunique($prop_id,$cert_type); 
    //echo "<pre>";print_r($certificate_file); exit();
   foreach ($certificate_file as $file) {
      $folder_name = $file['certificate_name'];
      $data[] = FCPATH.'uploads/cert/'.$file['other_certificate_file'];      
      
      $path = FCPATH.'uploads/cert/'.$file['other_certificate_file'];
      $this->zip->read_file($path);     
   }
  $this->zip->download($folder_name.'.zip'); 
}

public function certificate_zip($prop_id=NULL,$cert_type=NULL,$job_id=NULL){
   $other_certificate_file =$this->assignjob_model->get_other_cert_by_cerunique($prop_id,$cert_type);     
   foreach ($other_certificate_file as $other_cert) {      
      $path = FCPATH.'uploads/cert/'.$other_cert['other_certificate_file'];
      $new_path = $other_cert['other_certificate_file'];
      $this->zip->add_data('other files/' . $new_path, file_get_contents($path));
   }
   $files = $this->assignjob_model->get_certificate_type_by_prop_id($prop_id,$cert_type,$job_id);
   foreach ($files as $file) {
      $certificate_file =$this->assignjob_model->get_certificatefile_by_cerunique($file['certificate_unique_id']); 
      $data[] = FCPATH.'uploads/cert/'.$certificate_file;
      
      //$this->zip->add_dir($file['certificate_name']);
      $path = FCPATH.'uploads/cert/'.$certificate_file;
      $this->zip->read_file($path);     
   }
  $this->zip->download($file['certificate_name'].'.zip');  
}



public function edit_certificate($certificate_unique_id = NULL,$job_id=NULL){
   $data = $this->input->post();
   $data['title']='Edit Certificate';
   $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   $data['login_user']=$this->loggedin_user; 
   $data['job_id']=$job_id; 
 
   $certificates = array(); 
   
   if(!empty($job_id)){
	   $job_details=$this->assignjob_model->get_job_details($job_id);

	   if(!empty($job_details)){
      $assigned_certificates=json_decode($job_details[0]['certficate_id']);
	    foreach($assigned_certificates as $key=>$val){
		    $certificatename=$this->assignjob_model->get_certificatefile_by_id($val);
		    $certificates[$key]['certificate_id']=$val;
		    $certificates[$key]['certificate_name']=$certificatename;
	    }
     }	   
   }
  
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
           //echo "<pre>";print_r($post); exit();
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
           for ($j=0; $j <count($files['other_certificate_file']['name']) ; $j++) {
              if(!empty($files['other_certificate_file']['name'][$j])){

                $other_files = array();

                $other_files['certificate_property_id'] = $post['certificate_property_id'];
                $other_files['certificate_unique_id'] = $this->ion_auth->generate_hash();
                $other_files['certificate_name'] = 'Other '.$post['certificate_name'];
                $other_files['certificate_type'] = $post['certificate_type'];
                $other_files['certificate_date'] = date('Y-m-d',strtotime($post['certificate_date']));
                $other_files['uploaded_date'] = date('Y-m-d h:i:s');
                $other_files['certificate_uploadedby'] = $id;
                $other_files['certificate_expire'] = $post['certificate_expire'];

                $filename= time()."_".$files['other_certificate_file']['name'][$j];
                $pathfilename =  $_SERVER['DOCUMENT_ROOT']."/safetycerts/uploads/cert/".$filename;
                if(move_uploaded_file($files['other_certificate_file']['tmp_name'][$j],$pathfilename)){                
                   $data=array();
                   $other_files['other_certificate_file'] = $filename;
                   $pro= $this->db->insert('other_certificate_files', $other_files);
                }

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
   //
   $data['other_certificate'] = $this->assignjob_model->get_other_certificates_row($data['all_certificate']['certificate_property_id'],$data['all_certificate']['certificate_type']);  
   //echo "<pre>";print_r($data['other_certificate']); exit();
   $data['cert_types'] = $this->assignjob_model->get_certificate_type();
   
	
   $data['property_unique_id'] =$this->user_model->get_property_unique_id($data['all_certificate']['certificate_property_id']);
     
   $disabledcertificates=$this->assignjob_model->get_assigned_certificates($this->assignjob_model->get_prop_by_uniqueid($this->user_model->get_property_unique_id($data['all_certificate']['certificate_property_id'])),$job_id);
   
   if(is_array($disabledcertificates)){
	foreach($disabledcertificates as $key=>$val){
	   $certificatestodisable[]=$val['certificate_type'];
	}
   }
   $data['certificatestodisable']=$certificatestodisable;
      
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
public function delete_otherCertificateAjax(){
   $certificate_unique_id= $this->input->post('certificate_unique_id');
      $this->db->where('certificate_unique_id', $certificate_unique_id);
      //unlink(base_url("safetycerts/uploads/cert/".$group_picture));
      $this->db->delete('other_certificate_files'); 
      echo "deleted";
}

public function delete_CertificateAjax(){
  $post=$this->input->post();
  $post['certificate_file']= NULL;
  $certificate_unique_id= $this->input->post('certificate_unique_id');
  $this->db->where('certificate_unique_id', $certificate_unique_id);
  $this->db->update('certificate_files',$post);
   echo "updated";
}

}
 