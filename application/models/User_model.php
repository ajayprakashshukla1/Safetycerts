<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
       parent::__construct();
    }

//============================================


public function get_id($unique_id){
    $this->db->select('id');
    $this->db->from('users');
    $this->db->where('unique_id', $unique_id);
    return $this->db->get()->row()->id;
}

public function get_user_by_id($id){
	  $this->db->select('*');
    $this->db->from('users');
    $this->db->where('id', $id);
    return $this->db->get()->row();
}

public function getuserby_uniqueid($unique_id=NULL){
	if(!$unique_id){
		return false;
	}
    $this->db->select('id');
    $this->db->from('users');
    $this->db->where('unique_id', $unique_id);
    $id = $this->db->get()->row()->id;
	return $this->get_user_by_id($id);
}

public function isChildMemberExist($parent_id,$child_id){
    $this->db->select('*');
    $this->db->from('child_members');
    $this->db->where('parent_id', $parent_id);
    $this->db->where('child_id', $child_id);
    $exist=$this->db->get()->row();
    if(!empty($exist)){
       return true;
    }else{
       return false;
    }

}

public function get_all_child($parent_id){
    $this->db->select('child_members.child_id,users.id,users.first_name,users.last_name,users.email,users.phone,users.company');
    $this->db->from('child_members');
    $this->db->join('users', 'child_members.child_id = users.id');
    $this->db->where('child_members.parent_id',$parent_id);
    return $result = $this->db->get()->result_array();
}


public function get_all_parents($child_id){
    $this->db->select('child_members.parent_id');
    $this->db->from('child_members');
    $this->db->where('child_id', $child_id);
    return $result = $this->db->get()->result_array();
}


public function get_all_childs($parent_id){
    $this->db->select('child_members.child_id');
    $this->db->from('child_members');
    $this->db->where('parent_id', $parent_id);
    return $result = $this->db->get()->result_array();
}


public function delete_user_by_id($id){
   $this->db->where('id', $id);
   $this->db->delete('users');
} 

public function add_property_detail($post){

    if(isset($post['id'])){
        $this->db->where('id',$post['id']);
        $pro_id= $this->db->update('properties',$post);
        return $post['id'];
    }else{
        $this->db->insert('properties', $post);
        $pro_id = $this->db->insert_id();
        return $pro_id;
    }
     
}

public function update_property_certificate_date($certificate_date,$id){

    if(isset($id)){
        $this->db->where('certificate_id',$id);
        $pro_id= $this->db->update('certificate_files',$certificate_date);
        //return $post['id'];
        return $pro_id;
    }
     
}

public function display_all_properties($id=NULL){
    $this->db->select('*');
    $this->db->from('properties');
	if($id){
	   $this->db->where('user_id',$id);
	}
	$this->db->order_by("name", "asc");
    $query =$this->db->get();
    return  $row=$query->result_array();
}

public function display_all_certificates($id=NULL){
    $this->db->select('*');
    $this->db->from('certificate_types');
	if($id){
	   $this->db->where('user_id',$id);
	}
	 $this->db->order_by("certificate_name", "asc");
    $query =$this->db->get();
    return  $row=$query->result_array();
}


public function display_property_byuniqueid($unique_id=NULL){
   $this->db->select('*');
   $this->db->from('properties');
   $this->db->where('unique_id',$unique_id);
   $query =$this->db->get();
   return  $row=$query->row_array();
}



public function get_property_id_by_unique_id($unique_id){
    $this->db->select('id');
    $this->db->from('properties');
    $this->db->where('unique_id', $unique_id);
    return $this->db->get()->row()->id;
}


public function get_property_files($id){
   $this->db->select('*');
   $this->db->from('property_documents');
   $this->db->where('property_id',$id);
   $query =$this->db->get();
   return $row=$query->result_array();
}

public function get_property_certificates_files($id){
   $this->db->select('*');
   $this->db->from('certificate_files');
   $this->db->where('certificate_property_id',$id);
   $query =$this->db->get();
   return $row=$query->result_array();
}


public function get_property_certificates_files_first($id){
   $this->db->select('*');
   $this->db->from('certificate_files');
   $this->db->where('certificate_property_id',$id);
   $this->db->where('is_first_property_certificate','1');
   $query =$this->db->get();
   return $row=$query->result_array();
}

public function other_certificate_files($id){
   $this->db->select('*');
   $this->db->from('other_certificate_files');
   $this->db->where('certificate_property_id',$id);
   $this->db->where('is_first_property_certificate','1');
   $query =$this->db->get();
   return $row=$query->result_array();
}

public function delete_properties($pid){
   $this->db->where('id', $pid);
   $this->db->delete('properties');}

  public function get_client_list(){
   $this->db->select('*');
   $this->db->from('users');
  // $this->db->where('id',$id);
   $query =$this->db->get();
   return $row=$query->result_array();
}
public function get_property_unique_id($id=''){
    $this->db->select('unique_id');
    $this->db->from('properties');
    $this->db->where('id',$id);
    
    return $this->db->get()->row()->unique_id;
}  

public function find_certificate_for_property($prop_id='',$certificate_type=''){
    $this->db->select('certificate_id');
    $this->db->from('certificate_files');
    $this->db->where('certificate_property_id',$prop_id);
    $this->db->where('certificate_type',$certificate_type);
    $this->db->where('is_first_property_certificate',1);
    //return $this->db->get()->row()->certificate_id;
	$query=$this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->certificate_id;
    }
} 

public function find_otherfcertificates_for_property($prop_id='',$certificate_type=''){
    $this->db->select('certificate_id');
    $this->db->from('other_certificate_files');
    $this->db->where('certificate_property_id',$prop_id);
    $this->db->where('certificate_type',$certificate_type);
    $this->db->where('is_first_property_certificate',1);
    //return $this->db->get()->row()->certificate_id;
	$query=$this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->certificate_id;
    }
} 
}