<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
      <div class="text-right"><a href="<?=base_url()?>auth/create_user" class="btn">Add Contractor</a></div>
        <h5 class="with-border" style="margin-top:5px;">Contractor List</h5>

            <table id="table-edit" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th width="1">#</th>
              <th>Name</th>
              <th>Email</th>
              <th class="table-icon-cell">Phone</th>
              <th class="table-icon-cell">Company</th>
              <th width="120">Date Created</th>
              <th width="120">Status</th>
              <th style="width: 13%;">Action</th>
            </tr>
            </thead>
            <tbody>
             <?php $i=1; foreach($user_lists as $user){ ?>            
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $user->first_name." ".$user->last_name ?></td>
                <td class="color-blue-grey-lighter"><?php echo $user->email ?></td>
                <td class="table-icon-cell"><?php echo $user->phone ?></td>
                <td class="table-icon-cell"><?php echo $user->company ?></td>
                <td class="table-date"><?php echo date('d/m/Y',$user->created_on); ?></td>
                <td class="table-icon-cell"><?php echo ($user->active=='1') ? '<span style="color:green">Active</span>' : '<span style="color:red">Inactive</span>' ?></td>
                <td class="table-photo">
                  
                  <a href="<?php echo base_url() ?>user/edit_contrator/<?php echo $user->unique_id ?>" class="tabledit-edit-button btn btn-sm btn-success"><span class="glyphicon glyphicon-pencil"></span></a>

                  <?php if($user->active=='1'){ ?>
                  <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning" id="<?php echo $user->unique_id ?>" title="Trash/Inactive Contrator"><span class="glyphicon glyphicon-eye-open"></span></a>
                  <?php }else{ ?>
                  <a class="tabledit-edit-button btn btn-sm btn-success swal-btn-warning-act" id="<?php echo $user->unique_id ?>" title="Activate Contrator"><span class="glyphicon glyphicon-eye-close"></span></a>
                  <?php } ?>

                  <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-delete" id="<?php echo $user->unique_id ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
              </tr>
             <?php $i++;  } ?>
              
             
            </tbody>
          </table>
        
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
            text: "You want to deactivate this contrator ?",
            type: "warning",
            showCancelButton: true,
            cancelButtonClass: "btn-default",
            confirmButtonClass: "btn-danger btn-cont",
            confirmButtonText: "Deactivate Contrator",
            closeOnConfirm: false
          },
          function(){

             $('.btn-cont').html('Please Wait...');
             var path="<?php echo base_url() ?>user/deactivateContratorAjax"; 
             $.ajax({
                  type:"POST",
                  url:path,
                  data:{unique_id:unique_id},
                  success:function(result){
                     if(result=='Deactivate'){
                         window.location.href='<?php echo base_url() ?>user/contractor_list';
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

  $('.swal-btn-delete').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to Delete this Contrator ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Contrator",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>user/deleteContratorAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url() ?>user/contractor_list';
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

//=========== Activate ====================


$('.swal-btn-warning-act').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to activate this contrator ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-warning btn-cont",
          confirmButtonText: "Activate Contrator",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>user/ActivateContratorAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                   if(result=='activated'){
                       window.location.href='<?php echo base_url() ?>user/contractor_list';
                   }
                }
             });

        });
});

</script>