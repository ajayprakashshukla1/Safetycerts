<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
       parent::__construct();
    }

//============================================



public function get_cert_files()
{
	
	
	$SQL = "SELECT * FROM `certificate_types`";

$query = $this->db->query($SQL);

$arr = $query->result_array();



      
}

public function get_user_by_uname($uname){
	$this->db->select('*');
    $this->db->from('users');
    $this->db->where('username', $uname);
    return $this->db->get()->row();
}


public function delete_property($id){

	
	$SQL = "DELETE  FROM `properties` WHERE `id` = '$id'";

$exe = $this->db->query($SQL);

echo $exe;

}



public function get_property_by_userid($id){

	
$SQL = "SELECT * FROM `properties` WHERE  `user_id` = '$id'";

$query = $this->db->query($SQL);

$row = $query->result_array();






?>

<div style="width:100%;padding-top:10px;">
<?php
$red = array();
$orange = array();
$green = array();

	
	foreach($row as $key)
	{
          
		
		
         $id = $key['id'];
		 
		 $sql = "SELECT * FROM `certificate_files` WHERE `certificate_property_id` = '$id'";
		 
		// echo $sql;die();

         $query1 = $this->db->query($sql);
		 
		 $row1 = $query1->result_array();





    	foreach($row1 as $key1)
	   {
		
		    $date = date('d F Y');
			
		
		 
         $datetime1 = strtotime($date);
         $certificate_date = $key1['certificate_date'];
		 		 
		 
	    
		 
		 $expiry = $key1['certificate_expire'];
		 
		 $expiry = strtolower($expiry);
		 
		 
		  
	
		  
         $cdxx = explode("/",$certificate_date);

         $cdate = $cdxx[0]."-".$cdxx[1]."-".$cdxx[2];		 
		  
		 $cd = date('d M Y',strtotime($cdate)); 
		 
		 
		 
		 
		 $str1 = strtotime($cd);
		 
	
		 
		 $str = strtotime("+".$expiry,$str1);
       
		 $exp_date = date("d-m-Y",$str);
		 
         $ed = explode("-",$exp_date);
		 
	     $datetime2 = strtotime($exp_date);
		 
		 $exp_date1 =  $ed[0]."/".$ed[1]."/".$ed[2];
		 

		 
	
     
		$date1 = new DateTime($date);
        $date2 = new DateTime($exp_date);
        $interval = $date1->diff($date2);
  if($datetime2<$datetime1 && $interval->y==0 && $interval->m>=0 &&  $interval->d>=0)
		 {
              $key1['exp_date'] = $exp_date1;
              $key1['interval'] = $interval;
              $key1['name'] = $key['name']; 
			  $key1['user_id'] = $key['user_id']; 
		      array_push($red,$key1);  
		
		 }
		

		 
		 if($datetime2>$datetime1 && $interval->y==0 && $interval->m<=1 &&  $interval->d>=0)
		 {
			 
		
		$key1['interval'] = $interval;
		$key1['exp_date'] = $exp_date1;
$key1['name'] = $key['name'];	
$key1['user_id'] = $key['user_id']; 	
		array_push($orange,$key1);  
			  
	     }
		
	   
		 if($datetime2>$datetime1 && $interval->y>=0 && $interval->m>=1 &&  $interval->d>=0)
		 {
           $key1['interval'] = $interval;
		   $key1['exp_date'] = $exp_date1;
          $key1['name'] = $key['name'];		   
         $key1['user_id'] = $key['user_id']; 
		   array_push($green,$key1);  
	

			  }

	

		
	   }
	   
	   
	}


	
	
foreach($red as $key)
{
	
	 $certificate_type = $key['certificate_type'];
		$sqlxx = "SELECT * FROM `certificate_types` WHERE `certificate_id` = '$certificate_type'";
        $queryxx = $this->db->query($sqlxx);
		 
		$rowxx = $queryxx->result_array();
		$exp_date = $key['exp_date'];
		
		$interval = $key['interval'];
		
?>	
	
			<div class="list-item grey highlighted" data-ix="list-
	item" style="width:96%;margin-left:auto;margin-right:auto;height:70px;margin-top:-5px;cursor:pointer;">
            <div onclick="press('<?php echo $key['certificate_property_id'];?>','<?php echo str_replace("'s","",$key['name']);?>','<?php echo $key['user_id'];?>');" style="background:red;width:100%;" class="w-clearfix w-inline-block highlighted">
              <div class="icon-list highlighted" style="font-size: 25px;color: white;">
                <div class="icon ion-alert"></div>
              </div>
              <div  style="color:white; margin-top:0px; text-transform:uppercase;text-align:left;"> EXPIRED   - <?php echo $exp_date;?></div>
			  
			     <div  style="color:white; margin-top:0px;margin-left:-160px;  text-transform:uppercase;text-align:left;"> 		  <?php echo $key['name']; ?> </div>
	
            <div  style="color:white; margin-top:0px;margin-left:-200px; text-transform:uppercase;text-align:left;"><?php echo $rowxx[0]['certificate_name'];?>   </div> 
			
              <div onClick="deleteapp('<?php echo $key['certificate_property_id'];?>');"  style="margin-top:-30px;margin-right:10px;float:right; font-size:24px;cursor:pointer;">
              <div class="ion-close" style="color:white;"></div>
			  
			     
              </div>
  
            </div>
			 
          </div>
	<div style="clear:both;"></div>
	

	
<?php	
}


foreach($orange as $key)
{
	
	
	 $certificate_type = $key['certificate_type'];
		$sqlxx = "SELECT * FROM `certificate_types` WHERE `certificate_id` = '$certificate_type'";
        $queryxx = $this->db->query($sqlxx);
		 
		$rowxx = $queryxx->result_array();
				$exp_date = $key['exp_date'];

		
		$interval = $key['interval'];
		
?>	
	        
	<div class="list-item grey highlighted" data-ix="list-
	item" style="width:96%;margin-left:auto;margin-right:auto;height:70px;margin-top:-5px;cursor:pointer;">
            <div onclick="press('<?php echo $key['certificate_property_id'];?>','<?php echo str_replace("'s","",$key['name']);?>','<?php echo $key['user_id'];?>');" style="background:#FFC200;width:100%;" class="w-clearfix w-inline-block highlighted">
              <div class="icon-list highlighted" style="font-size: 25px;color: white;">
                <div class="icon ion-alert-circled"></div>
              </div>
              <div  style="color:white; margin-top:0px; text-transform:uppercase;text-align:left;"> <?php echo $interval->format('%a days to expire');?> - <?php echo $exp_date;?> </div>
			  
			     <div  style="color:white; margin-top:0px;margin-left:-160px;  text-transform:uppercase;text-align:left;"> 		  <?php echo $key['name']; ?> </div>
	
            <div  style="color:white; margin-top:0px;margin-left:-200px; text-transform:uppercase;text-align:left;">  <?php echo $rowxx[0]['certificate_name'];?> </div> 
			
              <div onClick="deleteapp('<?php echo $key['certificate_property_id'];?>');"  style="margin-top:-30px;margin-right:10px;float:right; font-size:24px;cursor:pointer;">
              <div class="ion-close" style="color:white;"></div>
			  
			     
              </div>
  
            </div>
			 
          </div>
	<div style="clear:both;"></div>

	
<?php	
}	
	
foreach($green as $key)
{
	
	 $certificate_type = $key['certificate_type'];
		$sqlxx = "SELECT * FROM `certificate_types` WHERE `certificate_id` = '$certificate_type'";
        $queryxx = $this->db->query($sqlxx);
		 
		$rowxx = $queryxx->result_array();
					$exp_date = $key['exp_date'];
		
		$interval = $key['interval'];


?>	
	
	<div class="list-item grey highlighted" data-ix="list-
	item" style="width:96%;margin-left:auto;margin-right:auto;height:70px;margin-top:-5px;cursor:pointer;">
            <div onclick="press('<?php echo $key['certificate_property_id'];?>','<?php echo str_replace("'s","",$key['name']);?>','<?php echo $key['user_id'];?>');" style="background:green;width:100%;" class="w-clearfix w-inline-block highlighted">
              <div class="icon-list highlighted" style="font-size: 25px;color: white;">
                <div class="icon ion-checkmark"></div>
              </div>
              <div  style="color:white; margin-top:0px; text-transform:uppercase;text-align:left;"> <?php echo $interval->format('%a days to expire');?> - <?php echo $exp_date;?> </div>
			  
			     <div  style="color:white; margin-top:0px;margin-left:-160px;  text-transform:uppercase;text-align:left;"> 		  <?php echo $key['name']; ?> </div>
	
            <div  style="color:white; margin-top:0px;margin-left:-200px; text-transform:uppercase;text-align:left;">  <?php echo $rowxx[0]['certificate_name'];?>   </div> 
			
              <div onClick="deleteapp('<?php echo $key['certificate_property_id'];?>');"  style="margin-top:-30px;margin-right:10px;float:right; font-size:24px;cursor:pointer;">
              <div class="ion-close" style="color:white;"></div>
			  
			     
              </div>
  
            </div>
			 
          </div>
	<div style="clear:both;"></div>
		
	
	
	
<?php	
}	
	
	
	
?>
</div>

<?php

}




}



?>

