<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_job extends CI_Controller {
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


public function add($unique_id=NULL){
	$data['title']='Assign Job';
	$this->load->helper('url');
	if(!$this->ion_auth->is_admin()){
     redirect('auth/error_404');
   }

   // $unique_id= contractor unique id
   $data['unique_id'] =$unique_id;
   if($unique_id){
   
      $data['contractor_details'] = $this->user_model->getuserby_uniqueid($unique_id);
      $data['property_list'] = $this->user_model->display_all_properties();
      $data['job_lists'] = $this->assignjob_model->list_all_job($data['contractor_details']->id);
      $data['certificates'] = $this->user_model->display_all_certificates();
   }
 
	
   $data['login_user']=$this->loggedin_user;
   $role=3; // contrator
   $data['user_lists'] = $this->ion_auth->users($role)->result();
   $data['assign_prop_uids'] = $this->assignjob_model->get_assign_prop_uids();
   
	$this->load->view('layout/dashboard_header',$data);
   $this->load->view('assignjob/contractor_list',$data);
   $this->load->view('layout/dashboard_footer');
}

public function add_job(){
	 if(!$this->ion_auth->is_admin()){
      redirect('auth/error_404');
   }

   $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   //store all post data
   $post=$this->input->post();
   
   //=========================
   $return = array();
   $return['status']='error';
   $return['msg']='something went wrong';	
   //=========================

   if(empty($post['job_prop_id'])){
	 $return['status']='error';
     $return['msg']='select property.';
     echo json_encode($return); 
     die;	 
   }
   /*
   if(empty($post['certificate_id'])){
	 $return['status']='error';
     $return['msg']='select certificate.';
     echo json_encode($return); 
     die;	 
   }
   */
   $post['assigned_by']=$id;
   $post['created_date']=date('Y-m-d h:i:s');
   $post['certificate_id']=json_encode($post['certificate_id']);
   
   $job_id=$this->assignjob_model->add_job($post); 
     
	 if($job_id){
		    $return['status']='ok';
        $return['msg']='Thank you';
        $return['url']=base_url('assign_job/add/'.$post['job_con_id']); 
        //$return['assignjobs'] = $this->assignjob_model->assign_job_row($job_id);	
      
	 }
	 
	 echo json_encode($return);   
}

	public function getcertificates(){
		$certificatesid=$this->assignjob_model->get_assigned_certificates_id($_REQUEST['propertyid']);
		foreach($certificatesid as $key=>$val){
			$arrayid[]=$val['certficate_id'];
		}
		
		foreach($arrayid as $key=>$val){
			$newarray[]=json_decode($val);
		}
		
		foreach($newarray as $key=>$val){
			foreach($val as $key1=>$val1){
				$final_array[]=$val1;
			}
		}
		$final_array=array_unique($final_array);
		echo json_encode($final_array);
		exit;
	}
	
	public function edit($unique_id=NULL,$jobid=NULL,$msg=null){
	   $data['title']='Assign Job';
	   $this->load->helper('url');
	   if(!$this->ion_auth->is_admin()){
		redirect('auth/error_404');
	   }
		
	   // $unique_id= contractor unique id
	   $data['unique_id'] =$unique_id;
	   $data['login_user']=$this->loggedin_user;
	   $role=3; // contrator	
	   $data['user_lists'] = $this->ion_auth->users($role)->result();
	   $data['assign_prop_uids'] = $this->assignjob_model->get_assign_prop_uids();
	   $data['property_list'] = $this->user_model->display_all_properties();
	   $data['allcertificates'] = $this->user_model->display_all_certificates();
	   $data['assigned_jobs'] = $this->assignjob_model->get_assigned_jobs($unique_id,$jobid);
	   $data['msg'] = $msg;
	   
	   $this->load->view('layout/dashboard_header',$data);
	   $this->load->view('assignjob/edit',$data);
	   $this->load->view('layout/dashboard_footer');
   	}
	
	public function edit_job(){
		 if(!$this->ion_auth->is_admin()){
		  redirect('auth/error_404');
	   }

	   $loggedin_user=$this->loggedin_user;
	   $id=$loggedin_user->id;
	   //store all post data
	   $post=$this->input->post();
	   
	   //=========================
	   $return = array();
	   $return['status']='error';
	   $return['msg']='something went wrong';	
	   //=========================

	   if(empty($post['job_prop_id'])){
		 $return['status']='error';
		 $return['msg']='select property.';
		 echo json_encode($return); 
		 die;	 
	   }
	   /*
	   if(empty($post['certificate_id'])){
		 $return['status']='error';
		 $return['msg']='select certificate.';
		 echo json_encode($return); 
		 die;	 
	   }
	   */
	   $post['assigned_by']=$id;
	   $post['job_prop_id']=$post['job_prop_id'];
	   $post['created_date']=date('Y-m-d h:i:s');
	   $post['certificate_id']=json_encode($post['certificate_id']);
	   $post['job_id']=json_encode($post['job_id']);
	   
	   $job_id=$this->assignjob_model->edit_job($post); 
		 
		 if($job_id){
			$return['status']='ok';
			$return['msg']='Thank you';
			$return['url']=base_url('assign_job/edit/'+$post['job_prop_id']+"/"+$job_id); 
			$return['assignjobs'] = $this->assignjob_model->assign_job_row($job_id);	
		  
		 }
		 
		 echo json_encode($return);   
		 
	}
}
 