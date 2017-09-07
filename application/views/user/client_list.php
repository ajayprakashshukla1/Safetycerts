<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
      <div class="text-right"><a href="<?=base_url()?>auth/create_member" class="btn">Add Client</a></div>
        <h5 class="with-border" style="margin-top:5px;">Client List</h5>
          <div class="table-responsive">
            <table id="table-edit" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th width="1">#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th width="167px">Company</th>
              <th width="100">Status</th>
              <th style="width:240px;">------------Action------------</th>
            </tr>
            </thead>
            <tbody>
             <?php 
             $i=1;
             foreach($user_lists as $user){ ?> 
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $user->first_name." ".$user->last_name ?></td>
                <td class="color-blue-grey-lighter"><?php echo $user->email ?></td>
                <td class="table-icon-cell"><?php echo $user->phone ?></td>
                <td class="table-icon-cell"><?php echo $user->company ?></td>
                
                <td class="table-icon-cell"><?php echo ($user->active=='1') ? '<span style="color:green">Active</span>' : '<span style="color:red">Inactive</span>' ?></td>
                <td class="table-photo" style="text-align:center;">
                  <a href="<?php echo base_url() ?>user/addproperty/<?php echo $user->id ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Add"><span class="glyphicon glyphicon-plus"></span></a>
                  
                  <a href="<?php echo base_url() ?>user/edit_member/<?php echo $user->unique_id ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>

                  <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning" id="<?php echo $user->unique_id ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>

                  <?php if($user->active=='1'){ ?>
                    <a class="tabledit-edit-button btn btn-sm btn-primary swal-btn-danger" id="<?php echo $user->unique_id ?>" title="Inactive Client"><span class="glyphicon glyphicon-eye-open"></span></a>
                  <?php }else{ ?>
                    <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning-act" id="<?php echo $user->unique_id ?>" title="Activate Client"><span class="glyphicon glyphicon-eye-close"></span></a>
                  <?php } ?>

                  <a href="<?php echo base_url() ?>user/client_property/<?php echo $user->unique_id ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Property"><span class="font-icon font-icon-build"></span></a>

                  <a href="<?php echo base_url() ?>user/child_member/<?php echo $user->unique_id ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Add child member"><span class="font-icon font-icon-user"></span></a>

                </td>
              </tr>
             <?php $i++; } ?>
              
             
            </tbody>
          </table>
         </div>
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script type="text/javascript">
 
  $('.swal-btn-warning').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to Delete this Member ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Client",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>user/deleteMemberAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url() ?>user/client_list';
                   }
                }
             });
          
          /*swal({
            title: "Deleted!",
            text: "Your imaginary file has been deleted.",
            type: "success",
            confirmButtonClass: "btn-success"
          });*/


        });
  }); 

  $('.swal-btn-danger').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to deactivate this Client ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-warning btn-cont",
          confirmButtonText: "Deactivate Client",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>user/deactivateClientAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='Deactivate'){
                       window.location.href='<?php echo base_url() ?>user/client_list';
                   }else{
                    sweetAlert("Oops...", "Something went wrong!", "error");
                    $('.btn-cont').html('Deactivate Client');
                   }
                }
             });          
        });
  });
//=========== Activate ====================


$('.swal-btn-warning-act').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to activate this Client ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-warning btn-cont",
          confirmButtonText: "Activate Client",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>user/ActivateMemberAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='activated'){
                       window.location.href='<?php echo base_url() ?>user/client_list';
                   }
                }
             });

        });
  });

</script>