<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assignjob_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
       parent::__construct();
    }

public function get_user_id($unique_id){
    $this->db->select('id');
    $this->db->from('users');
    $this->db->where('unique_id', $unique_id);
    return $this->db->get()->row()->id;
}

public function get_prop_by_id($unique_id){
    $this->db->select('id');
    $this->db->from('properties');
    $this->db->where('unique_id', $unique_id);
    return $this->db->get()->row()->id;
}	
	
public function add_job($post){
	$insert =array();
	$insert['job_con_id']=$this->get_user_id($post['job_con_id']);
	$insert['job_prop_id']=$this->get_prop_by_id($post['job_prop_id']);
	$insert['certficate_id']=$post['certificate_id'];
	$insert['assigned_by']=$post['assigned_by'];
	$insert['created_date']=$post['created_date'];

	$this->db->insert('assign_jobs', $insert);
    return $job_id = $this->db->insert_id();
}
public function assign_job_row($job_id){
   /*$this->db->select('*');
   $this->db->from('assign_jobs');
   $this->db->where('job_id',$job_id);
   $result = $this->db->get()->row();
   return $result;*/

   $this->db->select('users.first_name,users.last_name,properties.name,properties.unique_id as prop_unique_id,properties.status as prop_status,properties.address,assign_jobs.created_date');
    $this->db->from('assign_jobs');
    $this->db->join('users', 'assign_jobs.job_con_id = users.id');
    $this->db->join('properties', 'assign_jobs.job_prop_id = properties.id');
    $this->db->where('assign_jobs.job_id',$job_id);
    
    return $result = $this->db->get()->row();

}

public function list_all_job($id=NULL){
	
    $this->db->select('users.first_name,users.last_name,properties.name,properties.unique_id as prop_unique_id,properties.status as prop_status,properties.address,assign_jobs.created_date,assign_jobs.certficate_id');
    $this->db->from('assign_jobs');
	$this->db->join('users', 'assign_jobs.job_con_id = users.id');
	$this->db->join('properties', 'assign_jobs.job_prop_id = properties.id');
	if($id){
		$this->db->where('assign_jobs.job_con_id',$id);
	}
    $query =$this->db->get();
    return  $row=$query->result_array();

}

public function getcertificate($id=NULL){
	
    $this->db->select('certificate_types.certificate_name');
    $this->db->from('certificate_types');
	$this->db->where('certificate_types.certificate_id',$id);
    $query =$this->db->get();
    return  $row=$query->result_array();

}

public function get_certificate_list(){
	
    $this->db->select('*');
    $this->db->from('certificate_types');
	$query =$this->db->get();
    return  $row=$query->result_array();

}

public function get_prop_by_job_uniqueid($unique_id){
    $this->db->select('job_prop_id');
    $this->db->from('assign_jobs');
    $this->db->where('unique_id', $unique_id);
    return $this->db->get()->row()->job_prop_id;
}

public function get_prop_by_uniqueid($unique_id){
    $this->db->select('id');
    $this->db->from('properties');
    $this->db->where('unique_id', $unique_id);
    return $this->db->get()->row()->id;
}

public function get_prop_details_by_id($id){
    $this->db->select('*');
    $this->db->from('properties');
    $this->db->where('id', $id);
    return $this->db->get()->row();
}

public function get_certificate_by_prop_id($id,$cert_type){
    $this->db->select('certificate_files.*,certificate_types.certificate_name as certificate_type_name');
    $this->db->from('certificate_files');
	$this->db->join('certificate_types', 'certificate_files.certificate_type = certificate_types.certificate_id');
    $condition=array('certificate_property_id'=>$id);
    if($cert_type){
       $condition=array('certificate_type'=>$cert_type,'certificate_property_id'=>$id);
    }

    $this->db->where($condition);
    return $this->db->get()->result_array();
}

public function get_certificatefile_by_cerunique($id){
    $this->db->select('certificate_file');
    $this->db->from('certificate_files');
    $this->db->where('certificate_unique_id', $id);
    return $this->db->get()->row()->certificate_file;
}


public function get_allcertificate_list($id=NULL){
	
    $this->db->select('properties.*,certificate_files.*,certificate_types.certificate_name as certificate_type_name');
    $this->db->from('certificate_files');
	$this->db->join('properties', 'properties.id = certificate_files.certificate_property_id');
	$this->db->join('certificate_types', 'certificate_files.certificate_type = certificate_types.certificate_id');
	if($id){
	  $this->db->where('properties.user_id',$id);
	}
	$this->db->order_by('certificate_files.certificate_id DESC');
	$query =$this->db->get();
    return  $row=$query->result_array();

}


public function getCertificateCronList(){
   $this->db->select('*');
   $this->db->from('certificate_files');
   $query =$this->db->get();
   return  $row=$query->result_array();
}

public function get_user_id_by_property_id($property_id){
    $this->db->select('user_id');
    $this->db->from('properties');
    $this->db->where('id', $property_id);
    //return $this->db->get()->row()->user_id;
    $query=$this->db->get();
	if($query->num_rows()){
		return $query->row()->user_id;
	}
}

public function get_user_email_by_user_id($user_id){
    $this->db->select('email');
    $this->db->from('users');
    $this->db->where('id', $user_id);
    //return $this->db->get()->row()->email;
	$query=$this->db->get();
	if($query->num_rows()){
		return $query->row()->email;
	}
}
public function get_user_fname($user_id){
    $this->db->select('first_name');
    $this->db->from('users');
    $this->db->where('id', $user_id);
	//return $this->db->get()->row()->first_name;
	$query=$this->db->get();
	if($query->num_rows()){
		return $query->row()->first_name;
	}
}
public function get_user_lname($user_id){
    $this->db->select('last_name');
    $this->db->from('users');
    $this->db->where('id', $user_id);
    //return $this->db->get()->row()->last_name;
	$query=$this->db->get();
	if($query->num_rows()){
		return $query->row()->last_name;
	}
}




public function get_cont_certificate_list($id=NULL){
    
    $this->db->select('properties.*,certificate_files.*,certificate_types.certificate_name as certificate_type_name');
    $this->db->from('certificate_files');
    $this->db->join('properties', 'properties.id = certificate_files.certificate_property_id');
    $this->db->join('certificate_types', 'certificate_files.certificate_type = certificate_types.certificate_id');
    if($id){
      $this->db->where('certificate_files.certificate_uploadedby',$id);
    }
    $this->db->order_by('certificate_files.certificate_id DESC');
    $query =$this->db->get();
    return  $row=$query->result_array();

}

public function getfile($id){
    $this->db->select('doc');
    $this->db->from('property_documents');
    $this->db->where('property_id', $id);
    return $this->db->get()->row()->doc;
}



public function get_assign_prop_uids(){
    $this->db->select('job_prop_id');
    $this->db->from('assign_jobs');
    $ids=$this->db->get()->result_array();
    $data= array();
    foreach($ids as $id){
        $this->db->select('unique_id');
        $this->db->from('properties');
        $this->db->where('id', $id['job_prop_id']);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        if($rowcount>0){
           $result=$query->result(); 
           $data[]=$result[0]->unique_id;
       }

          }

    return $data;

}

function status_count($user_id = NULL) {
        
    $status = 0;
    $this->db->from('properties');
    $condition = array();
     if($user_id){
        $condition = array('status' => $status, 'user_id'=> $user_id);
     }else{
       $condition = array('status' => $status); 
     }
    $this->db->where($condition);   
    $count = $this->db->count_all_results();
    return $count;

    }
 function get_pending_list($user_id = NULL){
     $status = 0;
     $this->db->select('*');
     $this->db->from('properties');
     $condition = array();
     if($user_id){
        $condition = array('status' => $status, 'user_id'=> $user_id);
     }else{
       $condition = array('status' => $status); 
     }

     $this->db->where($condition);
     $sql = $this->db->get();
     $pages = $sql->result_array();
     return $pages;

 }
 function get_expired_certificate(){
     $this->db->select('*');
     $this->db->from('certificate_files');
     $this->db->join('properties', 'certificate_files.certificate_id = properties.id');
     $result = $this->db->get()->row_array();
    return $result;

 }
  function get_email_detail_list(){   
     $this->db->select('*');
     $this->db->from('email_logs');
     $sql = $this->db->get();
     $pages = $sql->result_array();
     return $pages;

 }
 function get_certificate_row($certificate_unique_id = NULL){
     $this->db->select('*');
     $this->db->from('certificate_files');
     $this->db->where('certificate_unique_id', $certificate_unique_id);
     $result = $this->db->get()->row_array();
     return $result;

 }
 public function get_certificate_type(){
    $this->db->select('*');
    $this->db->from('certificate_types'); 
    $sql = $this->db->get();
    $pages = $sql->result_array();
    return $pages;
}
}