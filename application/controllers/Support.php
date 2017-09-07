<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {
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

}
public function documentation(){
  $data['title']='Documentation';
  $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   $data['login_user']=$this->loggedin_user; 
  $this->load->view('layout/dashboard_header',$data);
  $this->load->view('faq/documentation',$data);
  $this->load->view('layout/dashboard_footer');
  
}
public function faq(){
  $data['title']='FAQ Simple';
  $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   $data['login_user']=$this->loggedin_user; 
   $this->load->view('layout/dashboard_header',$data);
   $this->load->view('faq/faq',$data);
   $this->load->view('layout/dashboard_footer');
  
}
public function faq_search(){
  $data['title']='FAQ Search';
  $loggedin_user=$this->loggedin_user;
   $id=$loggedin_user->id;
   $data['login_user']=$this->loggedin_user; 
   $this->load->view('layout/dashboard_header',$data);
  $this->load->view('faq/faq_search',$data);
  $this->load->view('layout/dashboard_footer');
  
}

}