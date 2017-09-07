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


public function display_all_properties($id=NULL){
    $this->db->select('*');
    $this->db->from('properties');
	if($id){
	   $this->db->where('user_id',$id);
	}

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
public function get_property_unique_id($id=NULL){
    $this->db->select('unique_id');
    $this->db->from('properties');
    $this->db->where('id',$id);
    return $this->db->get()->row()->unique_id;
}   
}