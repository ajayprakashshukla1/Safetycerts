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

public function get_assigned_certificates($unique_id,$job_id){
    $this->db->select('certificate_type');
    $this->db->from('certificate_files');
    $this->db->where('certificate_property_id', $unique_id);
    $this->db->where('certificate_job_id', base64_decode($job_id));
    //return $this->db->get()->row()->certificate_id;
    $query=$this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
}

public function get_all_assigned_certificates($unique_id,$job_id){
    $this->db->select('certficate_id');
    $this->db->from('assign_jobs');
    $this->db->where('job_id', base64_decode($job_id));
    //return $this->db->get()->row()->certificate_id;
    $query=$this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
}

public function get_assigned_certificates_id($unique_id){
    $this->db->select('id');
    $this->db->from('properties');
    $this->db->where('properties.unique_id', $unique_id);
    $property_id=$this->db->get()->row()->id;
    
    $this->db->select('certficate_id');
    $this->db->from('assign_jobs');
    $this->db->where('assign_jobs.job_prop_id', $property_id);
    $query=$this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
     
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
    
    $this->db->select('users.first_name,users.last_name,properties.name,properties.unique_id as prop_unique_id,properties.status as prop_status,properties.address,assign_jobs.created_date,assign_jobs.certficate_id,assign_jobs.job_id');
    $this->db->from('assign_jobs');
    $this->db->join('users', 'assign_jobs.job_con_id = users.id');
    $this->db->join('properties', 'assign_jobs.job_prop_id = properties.id');
    if($id){
        $this->db->where('assign_jobs.job_con_id',$id);
    }
    $this->db->order_by("job_id", "desc");
    $query =$this->db->get();
    return  $row=$query->result_array();

}

public function list_all_property_job($id=NULL){
    $limit=1;
    $this->db->select('users.first_name,users.last_name,properties.name,properties.unique_id as prop_unique_id,properties.status as prop_status,properties.address,assign_jobs.created_date,assign_jobs.certficate_id');
    $this->db->from('assign_jobs');
    $this->db->join('users', 'assign_jobs.job_con_id = users.id');
    $this->db->join('properties', 'assign_jobs.job_prop_id = properties.id');
    if($id){
        $this->db->where('assign_jobs.job_prop_id',$id);
    }
    $this->db->order_by('job_id', 'desc');
    $this->db->limit($limit);
    $query =$this->db->get();
    return  $row=$query->result_array();

}

public function list_all_property_certificate($id=NULL,$job_id=NULL){
    $this->db->select('certificate_files.*');
    $this->db->from('certificate_files');
    if($id){
        $this->db->where('certificate_files.certificate_property_id',$id);
    }
    if($job_id){
        $this->db->where('certificate_files.certificate_job_id',$job_id);
    }
    $this->db->order_by('certificate_id', 'desc');
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

public function get_job_details($id){
    
    $this->db->select('*');
    $this->db->from('assign_jobs');
    $this->db->where('job_id', base64_decode($id));
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
    //return $this->db->get()->row()->id;
    $query=$this->db->get();
    if($query->num_rows() > 0)
        return $query->row()->id;
    else
        return 0;
}

public function get_prop_details_by_id($id){
    $this->db->select('*');
    $this->db->from('properties');
    $this->db->where('id', $id);
    return $this->db->get()->row();
}

public function get_certificate_by_prop_id($id,$cert_type,$job_id=NULL){
    
    $this->db->select('certificate_files.*, certificate_types.certificate_name as certificate_type_name');
    $this->db->from('certificate_files');
    $this->db->join('certificate_types', 'certificate_files.certificate_type = certificate_types.certificate_id');
    $condition=array('certificate_property_id'=>$id);
    if($cert_type){
        if($job_id){
            $condition=array('certificate_type'=>$cert_type,'certificate_property_id'=>$id,'certificate_job_id'=>base64_decode($job_id));
        }
        else{
                $condition=array('certificate_type'=>$cert_type,'certificate_property_id'=>$id);
            }
    }
    
    if($job_id){
        $condition=array('certificate_property_id'=>$id,'certificate_job_id'=>base64_decode($job_id));
    }
    

    $this->db->where($condition);
    $this->db->group_by('certificate_type');
    return $this->db->get()->result_array();
}

public function get_certificate_by_type($id,$cert_type,$is_first=NULL){
    
    $this->db->select('certificate_files.*, certificate_types.certificate_name as certificate_type_name');
    $this->db->from('certificate_files');
    $this->db->join('certificate_types', 'certificate_files.certificate_type = certificate_types.certificate_id');
    $condition=array('certificate_property_id'=>$id);
    if($cert_type){
		$condition=array('certificate_type'=>$cert_type,'certificate_property_id'=>$id);
    }
    
    if($is_first){
        $condition=array('is_first_property_certificate'=>$is_first,'certificate_type'=>$cert_type,'certificate_property_id'=>$id);
    }
    

    $this->db->where($condition);
    $this->db->group_by('certificate_type');
    return $this->db->get()->result_array();
}

public function get_certificate_type_by_prop_id($id,$cert_type){
    $this->db->select('certificate_id,certificate_unique_id,certificate_file,certificate_name');
    $this->db->from('certificate_files');
    $condition=array('certificate_type'=>$cert_type,'certificate_property_id'=>$id);
    $this->db->where($condition);
    return $this->db->get()->result_array();
}



public function get_certificatefile_by_cerunique($id){
    $this->db->select('certificate_file');
    $this->db->from('certificate_files');
    $this->db->where('certificate_unique_id', $id);
    return $this->db->get()->row()->certificate_file;
}

public function get_other_cert_by_cerunique($prop_id='',$cert_type=''){
    $this->db->select('other_certificate_file,certificate_name');
    $this->db->from('other_certificate_files');
    $this->db->where('certificate_property_id', $prop_id);
    $this->db->where('certificate_type', $cert_type);
    return $this->db->get()->result_array();
}

/*public function get_certificatefile_by_zip($id){
    $this->db->select('certificate_file');
    $this->db->from('certificate_files');
    $this->db->where('certificate_property_id', $id);
    return $this->db->get()->row()->certificate_file;
}*/

public function get_certificatefile_by_id($id){
    $this->db->select('certificate_name');
    $this->db->from('certificate_types');
    $this->db->where('certificate_id', $id);
    return $this->db->get()->row()->certificate_name;
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
function admin_assigned_job($user_id=NULL){
     $where = '';
     if($user_id){
        $this->db->select('id');
        $this->db->from('properties');
        $condition = array('user_id'=> $user_id);
        $this->db->where($condition);
        $sql = $this->db->get();
        $prop_ids = $sql->result_array();
        
        if(!empty($prop_ids)){
            $units = implode('","', $prop_ids[0]);
            $where = ' job_prop_id IN ("'.$units.'") ';  
            
        }              
     }
     $this->db->select('count(*) as assigned_job');
     $this->db->from('assign_jobs');
     $condition = array('assigned_by' => 1);
     $this->db->where($condition);
     if($where!='')$this->db->where($where);
     $sql = $this->db->get();
     $admin_assigned_job = $sql->result();
     return $admin_assigned_job;
}

function admin_assigned_list($user_id=NULL){
    $where = '';
    if($user_id){
        $this->db->select('id');
        $this->db->from('properties');
        $condition = array('user_id'=> $user_id);
        $this->db->where($condition);
        $sql = $this->db->get();
        $prop_ids = $sql->result_array();
        
        if(!empty($prop_ids)){
            $units = implode('","', $prop_ids[0]);
            $where = ' job_prop_id IN ("'.$units.'") ';              
        }              
    }
    $this->db->select('users.first_name,users.last_name,properties.name,properties.unique_id as prop_unique_id,properties.status as prop_status,properties.address,assign_jobs.created_date,assign_jobs.certficate_id,assign_jobs.job_id');
    $this->db->from('assign_jobs');
    $this->db->join('users', 'assign_jobs.job_con_id = users.id');
    $this->db->join('properties', 'assign_jobs.job_prop_id = properties.id');
    if($where){
        $where = ' job_prop_id IN ("'.$units.'") ';  
        $this->db->where($where);
    }
    $this->db->order_by("job_id", "desc");
    $query =$this->db->get();
    //echo "<pre>"; print_r($row=$query->result_array()); exit();
    return  $row=$query->result_array();
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

 public function get_other_certificates_row($prop_id='',$cert_type=''){
    $this->db->select('*');
    $this->db->from('other_certificate_files');
    $this->db->where('certificate_property_id', $prop_id);
    $this->db->where('certificate_type', $cert_type);
    $result = $this->db->get()->result_array();
    return $result;
 }
 public function get_certificate_type(){
    $this->db->select('*');
    $this->db->from('certificate_types'); 
    $sql = $this->db->get();
    $pages = $sql->result_array();
    return $pages;
}

    public function get_assigned_jobs($unique_id,$job_id){
        $this->db->select('*');
        $this->db->from('assign_jobs');
        $this->db->where('job_id', base64_decode($job_id));
        $query=$this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
    }
    
    public function get_property_unique_id($property_id){
        $this->db->select('unique_id');
        $this->db->from('properties');
        $this->db->where('id', $property_id);
        $query=$this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
    
    public function edit_job($post){
        $insert =array();
        $insert['job_prop_id']=$this->get_prop_by_id($post['job_prop_id']);
        $insert['certficate_id']=$post['certificate_id'];
        if(isset($post['assigned_by']))
            $insert['assigned_by']=$post['assigned_by'];
        $insert['created_date']=$post['created_date'];
        $job_id=str_replace('"', '', $post['job_id']);
        $this->db->where('job_id', $job_id);
        $this->db->update('assign_jobs', $insert);
        return true;
    }
    
    
}