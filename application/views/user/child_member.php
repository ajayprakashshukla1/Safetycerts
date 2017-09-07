<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}

.chosen-container{
   font-size: 16px !important;
} 

.chosen-container-single .chosen-single {
    border: 1px solid #aaa;
    border-radius: 2px;
    height: 36px;
    line-height: 29px;
} 
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
        <h5 class="with-border" style="margin-top:5px;"><span style="color: red"><?php echo $parent->first_name ?>'s</span> Child Member</h5>

          <div id="notf"></div>
          <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-6">
              
              <select data-placeholder="Choose Child Member" class="chosen-select form-control" id="child_id">
                <option value=""></option>
                <?php foreach($user_lists as $user){ if($user->id != $parent->id){ ?>
                  <option value="<?php echo $user->id ?>"><?php echo $user->first_name." ".$user->last_name ?></option>
                <?php } } ?>
              </select>
            </div>
            <div class="col-md-6">
              <button class="btn add-chid-btn">Add Child Member</button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="table-edit" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th width="1">#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th width="">Company</th>
              <th style="">Action</th>
            </tr>
            </thead>
            <tbody>
             <?php $i=1; foreach($childs as $child){ ?>
               <tr>
                 <td><?php echo $i ?></td>
                 <td><?php echo $child['first_name']." ".$child['last_name'] ?></td>
                 <td><?php echo $child['email'] ?></td>
                 <td><?php echo $child['phone'] ?></td>
                 <td><?php echo $child['company'] ?></td>
                 <td><a class="btn btn-sm btn-danger swal-btn-warning" id="<?php echo $child['id'] ?>" title="Remove Child Member"><span class="glyphicon glyphicon-trash"></span></a></td>
               </tr>
             <?php $i++; } ?>
             
             
            </tbody>
          </table>
         </div>
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assest/js/chosen.jquery.js"></script>
<script type="text/javascript">

var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : { allow_single_deselect: true },
  '.chosen-select-no-single' : { disable_search_threshold: 10 },
  '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
  '.chosen-select-rtl'       : { rtl: true },
  '.chosen-select-width'     : { width: '95%' }
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}


//=====================================

$(document).ready(function(){
  $('.add-chid-btn').click(function(){
     var child_id= $('#child_id').val();
     var parent_id= '<?php echo $parent->id ?>';
     if(child_id==''){
        $('#notf').html('<div role="alert" class="alert alert-danger">'+
                                   '<strong><p>Please Select child member</p></strong>'+
                                 '</div>');
        setTimeout(
            function() 
            {
              //do something special
              $('#notf').html('');
            }, 2000);
        return false;
     }
     $(this).html('Please Wait...');
     var path="<?php echo base_url() ?>user/addChildMemberAjax"; 
     $.ajax({
          type:"POST",
          url:path,
          data:{child_id:child_id,parent_id:parent_id},
          success:function(result){
             if(result=='added'){
                 window.location.href='<?php echo base_url() ?>user/child_member/<?php echo $parent->unique_id ?>';
             }else{
                 $('#notf').html('<div role="alert" class="alert alert-danger">'+
                                   '<strong><p>'+result+'</p></strong>'+
                                 '</div>');
                 $('.add-chid-btn').html('Add Child Member');
             }
          }
       });

  })
})


$('.swal-btn-warning').click(function(e){
  e.preventDefault();
  var child_id= $(this).attr('id');
  var parent_id= '<?php echo $parent->id ?>';
  swal({
        title: "Are you sure?",
        text: "You want to remove this from child member ?",
        type: "warning",
        showCancelButton: true,
        cancelButtonClass: "btn-default",
        confirmButtonClass: "btn-danger btn-cont",
        confirmButtonText: "Remove Child Member",
        closeOnConfirm: false
      },
      function(){

         $('.btn-cont').html('Please Wait...');
         var path="<?php echo base_url() ?>user/removeChildMemberAjax"; 
         $.ajax({
              type:"POST",
              url:path,
              data:{child_id:child_id,parent_id:parent_id},
              success:function(result){
                 if(result=='deleted'){
                  window.location.href='<?php echo base_url() ?>user/child_member/<?php echo $parent->unique_id ?>';
                 }
              }
           });
      
      });
}); 



</script>