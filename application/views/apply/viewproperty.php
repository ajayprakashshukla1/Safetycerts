<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}
.error { color:red; }  
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
      <div class="text-right">
        <a href="<?=base_url()?>user/addproperty" class="btn">Add Properties</a>
      </div>
        <h5 class="with-border" style="margin-top:5px;">All properties</h5>
        <div class="row">
					<div class="col-lg-12">		
			      <div class="card-block row">
			        <form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1">
			          <div class="row">
					        <div class="col-lg-12">
		                <div class="card-block row">
			                <table id="example" class="display table table-striped table-bordered">
                        <thead>
                         <tr>
                           <th width="1">#</th>
			                     <th width="180px">Name</th>
                           <th width="320px">Address</th>
			                     <th>Property Type</th>
                           <th>Test Created</th>
                            <?php if($login_user->role=='admin'){ ?>
                           <th>paid</th>  
                           <? } ?>
			                     <th class="table-icon-cell" style="width: 188px;">Action</th>
                         </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($property_data as $data){ ?>
			   
                          <tr>
                            <td><?php echo $i; ?></td>
				                    <td><a href="<?php echo base_url('user/property_details/'.$data['unique_id']); ?>"><?php echo $data['name'];?></a></td>

                            <td><?php echo $data['address'];?></td>
				                    <td><?php echo $data['property_type'];?></td>
                            <td><?php echo date('d/m/Y',strtotime($data['created']));?></td>
                            <?php if($login_user->role=='admin'){ ?>
                            <td><input type="checkbox" name="mycheckbox" class="myCheckbox" id='<?=$data['id'];?>' <?php echo ($data['invoice']=='1') ? "checked='checked'" : '' ?>></td>
                            <? }
                            ?>
				                    <td class="hello"> 
                               <a href="<?php echo base_url() ?>user/property_edit/<?php echo $data['unique_id']; ?>" class=" btn btn-sm btn-success">
                                 <span class="glyphicon glyphicon-pencil"></span>
                               </a> &nbsp;
                           
                               <?php if($login_user->role=='admin'){ ?>
                               <a href="<?php echo base_url() ?>jobs/upload_certificate/<?php echo $data['unique_id']; ?>" class=" btn btn-sm btn-primary">
                                 <span class="font-icon font-icon-upload"></span>
                               </a> &nbsp;
                               <?php } ?>

                               <a href="<?php echo base_url() ?>jobs/view_certificate/<?php echo $data['unique_id']; ?>" title="View Certificate" class=" btn btn-sm btn-warning">
                                 <span class="font-icon font-icon-eye"></span>
                               </a> &nbsp;
                               
                               <a href="" class="del_prop swal-btn-warning btn btn-sm btn-danger " id="<?php echo $data['unique_id']; ?>"  pid="<?php echo $data['id'];?>" title="Delete Property">
                                <span class="glyphicon glyphicon-trash"></span>
                               </a>
                               
                            </td>
                
              </tr>
             <?php $i++; } ?>
              
             
            </tbody>
          </table>
	</div>
					</div>
				
				</div>
				
				
				</form>
				
				
	</div>

        
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.myCheckbox').click(function(){
    var myVal = ( $('.myCheckbox').is(':checked') ) ? 1 : 0;
    var pro_id = $(this).attr('id');
  $.post("<?=base_url().'user/invoice'?>",{myVal:myVal,pro_id:pro_id},function(data){
    });

}); 
</script>