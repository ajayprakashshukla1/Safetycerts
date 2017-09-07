<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
    // Declaration of the propery
    protected $loggedin_user; 
    
    public function __construct(){
        parent::__construct();
        $this->load->database();	
		
        $this->load->helper(array('url','language','form'));
        $this->load->library(array('ion_auth','form_validation','session'));
        $this->load->model('user_model');
		    $this->load->model('assignjob_model');
		    $this->load->library('email');


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
Description:Function to send email

*/



public function send_email_expired_certificate(){
  $data = array();
  
  $users = $this->ion_auth->users()->result();
  $certificates = $this->assignjob_model->getCertificateCronList();
  // get expired certificate
  $expired_arr= array();
  foreach($certificates as $cert){
     $current_date= date('m/d/Y');
     $cert_date = $cert['certificate_date']; 
     $cert_time = strtotime($cert_date); 
     $actual_expire_date = strtotime('+'.$cert['certificate_expire'], $cert_time); 
     if(strtotime($current_date) > $actual_expire_date){
        // get user id
        $user_id= $this->assignjob_model->get_user_id_by_property_id($cert['certificate_property_id']);
        // get email
        $email= $this->assignjob_model->get_user_email_by_user_id($user_id);
        $fname = $this->assignjob_model->get_user_fname($user_id);
        $lname = $this->assignjob_model->get_user_lname($user_id);
        $cert['user_id']=$user_id;
        $cert['email']=$email;
        $cert['first_name']=$fname;
        $cert['last_name']=$lname;
        $expired_arr[]=$cert;
      
     }
    
  }

  // send mail

  foreach($expired_arr as $row){
     
      $this->email->from('info@safetycerts.co.uk');
      //$this->email->to($row['email']);
      $user_email = $row['email'];
      $name = $row['first_name']." ".$row['last_name'];
      $certificate_name = $row['certificate_name'];
      $certificate_file = $row['certificate_file'];
      $certificate_date = $row['certificate_date'];
      $uploaded_date = $row['uploaded_date'];

      $this->email->to($user_email);      
      $this->email->subject('Expired Certificate');
      $message= "Dear"." ".$name;
      $message .= "\r\n";
      $message.="Your Cretificate has been expired.";
      $message .= "\r\n";
      $message.="Expired Certificate Details Are As Follows.";
      $message .= "\r\n";
       $message .= "\r\n";
      $message.="Certificate Name:"." ".$certificate_name;
      $message .= "\r\n";
      $message.="Certificate File:"." ".$certificate_file;
      $message .= "\r\n";
      $message.="Certificate Date:"." ".$certificate_date;
      $message .= "\r\n";
      $message.="Certificate Upload Date:"." ".$uploaded_date;
      $this->email->message($message);

      $send = $this->email->send();
      if($send){
        $data = array();
        $data['email'] = $user_email;
        $data['message'] = $message;
        $data['send_date'] = date('Y-m-d h:i:sa');
        $result = $this->db->insert('email_logs', $data);
      }
      else{
        echo 'failed';
      }
      //echo $this->email->print_debugger();
      //exit;
  }
  

}


}
 