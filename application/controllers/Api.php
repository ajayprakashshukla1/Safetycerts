<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
        $this->load->model('user_model');
		$this->load->model('api_model');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}
	
	public function login()
	{
		
		$username = $_GET['email'];
        $password = $_GET['password'];
		$remember = FALSE;
		
	
		echo $this->ion_auth->login($username, $password, $remember);

		
	}
	
	
	public function signup()
	{
		$identity = $_GET['email'];
		
		$email = $_GET['email'];
		$password = $_GET['password'];
		 $additional_data = array(
                'first_name' => $_GET['name']
           
            );
			
			$group = array();
		
		echo $this->ion_auth->register($identity, $password, $email, $additional_data,$group);
		
	}

	public function add_property()
	{
		
		
		$post = array();
		
		$uname = $_POST['uname'];
		
	    $name =  $_POST['name'];
		$address =  $_POST['address'];
		$postcode = $_POST['postcode'];
		$type = $_POST['type'];
		
		$electrical= $_POST['electrical'];
		$emergency= $_POST['emergency'];
		$portable= $_POST['portable'];
		$fire= $_POST['fire'];
		$smoke= $_POST['smoke'];
		$carbon= $_POST['carbon'];
		$gas= $_POST['gas'];
		
		
		$user = $this->api_model->get_user_by_uname($uname);
		

       $user_id = $user->id;
	   

		
		$post['user_id']= $user_id;
		$post['name']= $name;
		$post['address']= $address;
	
		$post['zip_code']= $postcode;
		$post['property_type']= $type;
		$post['electrical_test']= $electrical;
		$post['emergency_test']= $emergency;
		$post['portable_test']= $portable;
		$post['fire_test']= $fire;
		$post['smoke_test']= $smoke;
		$post['carbon_test']= $carbon;
		$post['gas_safety_test']= $gas;
		$post['unique_id']= $this->ion_auth->generate_hash();
		$post['created']=date('Y-m-d h:i:s');
		
		
		if(!empty($_POST['date_of_cert1']))
		{
	     $datexx = explode("/",$_POST['date_of_cert1']);
		 
		 $date_of_cert1 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
		 
	    }
		if(!empty($_POST['date_of_cert2']))
		{
	     $datexx = explode("/",$_POST['date_of_cert2']);
		 
		 $date_of_cert2 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
	    }
		if(!empty($_POST['date_of_cert3']))
		{
	     $datexx = explode("/",$_POST['date_of_cert3']);
		 
		 $date_of_cert3 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
	    }
		if(!empty($_POST['date_of_cert4']))
		{
	     $datexx = explode("/",$_POST['date_of_cert4']);
		 
		 $date_of_cert4 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
	    }
		
		if(!empty($_POST['date_of_cert5']))
		{
	     $datexx = explode("/",$_POST['date_of_cert5']);
		 
		 $date_of_cert5 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
	    }
		
		if(!empty($_POST['date_of_cert6']))
		{
	     $datexx = explode("/",$_POST['date_of_cert6']);
		 
		 $date_of_cert6 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
	    }
		
		if(!empty($_POST['date_of_cert7']))
		{
	     $datexx = explode("/",$_POST['date_of_cert7']);
		 
		 $date_of_cert7 = $datexx[1]."/".$datexx[0]."/".$datexx[2];
	    }
	
		
	 
	  
		
		$pro_id=$this->user_model->add_property_detail($post);
		
		
		
		if($electrical=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'electrical_test';
		$arr['certificate_type']= '1';
  		$arr['certificate_date']= $date_of_cert1;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity1'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
		
		if($emergency=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'emergency_test';
		$arr['certificate_type']= '2';
  		$arr['certificate_date']= $date_of_cert2;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity2'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
		
		
		if($portable=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'portable_test';
		$arr['certificate_type']= '3';
  		$arr['certificate_date']= $date_of_cert3;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity3'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
		
		
		
		if($fire=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'fire_test';
		$arr['certificate_type']= '4';
  		$arr['certificate_date']= $date_of_cert4;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity4'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
		
		
		
		if($smoke=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'smoke_test';
		$arr['certificate_type']= '5';
  		$arr['certificate_date']= $date_of_cert5;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity5'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
		
		
		
		if($carbon=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'carbon_test';
		$arr['certificate_type']= '6';
  		$arr['certificate_date']= $date_of_cert6;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity6'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
		
		
		
		if($gas=="yes")
		{
		$arr = array();
		$arr['certificate_property_id'] = $pro_id;
		$arr['certificate_name']= 'gas_safety_test';
		$arr['certificate_type']= '7';
  		$arr['certificate_date']= $date_of_cert7;		
  		$arr['certificate_uploadedby']= $user_id;
  		$arr['certificate_expire']= $_POST['validity7'];
		$arr['certificate_unique_id']= $this->ion_auth->generate_hash();
	    $this->db->insert('certificate_files', $arr);
		}
		
	
		
	}	
	
	public function get_all_data()
	{
		
		
		
		$username = $_POST['user'];
		
		
		$user = $this->api_model->get_user_by_uname($username);
		

       $user_id = $user->id;
	   
	   $prop = $this->api_model->get_property_by_userid($user_id);
		
		
       echo $prop;


	   
	}
	

       public function createprop()
        {

          
		  
		  
		  $exe = $this->api_model->get_cert_files();
		  
		  echo $exe;
        }

    	public function delete_property()
	{
		
		
		
		$id = $_POST['id'];
		
		
		$exe = $this->api_model->delete_property($id);
		

        echo $exe;


	   
	}
	
	
	public function renew_property()
	{
		
		$fname=$_REQUEST['fname'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$padd= $_REQUEST['paddress'];
$certi= $_REQUEST['ncertificate'];
$date= $_REQUEST['date'];
$adinfo= $_REQUEST['addinfo'];
$pid= $_REQUEST['pid'];

$subject="Renewal";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$txt='Hello Admin. You have a certificate renewal enquiry<br/><br/>'
. 'First name:' . $fname . '<br/>'
. 'Phone Number:' . $phone . '<br/>'
. 'Email Address: ' . $email . '<br/>'
. 'Property Address:' . $padd. '<br/>'
. 'Certificate:' . $certi. '<br/>'
. 'Date:' . $date. '<br/>'
. 'Additional Info:' . $adinfo. '<br/>';

$sendmessage = wordwrap($txt, 70);

mail("kevin@londonsparks.com",$subject,$sendmessage ,$headers);

	}
}



