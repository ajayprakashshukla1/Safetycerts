
<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}
.error { color:red; }  
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
		
        <h5 class="m-t-lg with-border">View Certificate</h5>
<div class="row">
					<div class="col-lg-12">	
                <?php if($this->ion_auth->is_admin() || $login_user->role=='contractor'){ ?>					
		            <button type="submit" style="" class="btn btn-inline"><a href="<?php echo base_url('jobs') ?>" style="color:#FFFFFF">All Jobs</a></button> <?php } ?> <a style="color:#FFFFFF" href="<?php echo base_url('jobs/upload_certificate/'.$unique_id) ?>"><button type="submit" style="" class="btn btn-inline">Upload Certificate</button></a>
		
			<div class="card-block row">
			<form method="post" enctype="multipart/form-data" name="form-signin_v1" id="form-signin_v1">
			<div class="row">
					<div class="col-lg-12">
		<div class="card-block row">
			<table id="example" class="display table table-striped table-bordered">
            <thead>
            <tr>
              <th width="1">#</th>
              <!--<th>Certificate Name</th> -->
			         <th>Certificate Type</th>
               <th>Certificate Date</th>
               <th class="table-icon-cell">Added Date</th>
			        <th class="table-icon-cell">Action</th>
             
            </tr>
            </thead>
            <tbody>
             <?php // echo "<pre>"; print_r($all_certificates); ?>
             <?php $i=1; foreach($all_certificates as $all_certificate){ ?> 
             
              <tr>
                <td><?php echo $i; ?></td>
                <!--<td><?php echo $all_certificate['certificate_name'] ?></td> -->
				        <td><?php echo $all_certificate['certificate_type_name'] ?></td>
                <td class="color-blue-grey-lighter"><?php echo $all_certificate['certificate_date']; ?></td>
                <td class="table-icon-cell"><?php echo date('m/d/Y g:i:a',strtotime($all_certificate['uploaded_date'])); ?></td>
				        <td class="table-icon-cell"><a href="<?php echo base_url("jobs/certificate_download/".$all_certificate['certificate_unique_id']) ?>" class="tabledit-edit-button btn btn-sm btn-primary" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a>

                <a href="<?php echo base_url() ?>jobs/edit_certificate/<?=$all_certificate['certificate_unique_id'] ?>" class="tabledit-edit-button btn btn-sm btn-success" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>

                <a class="tabledit-edit-button btn btn-sm btn-danger swal-btn-warning" id="<?php echo $all_certificate['certificate_unique_id'] ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
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

 $('.swal-btn-warning').click(function(e){
    e.preventDefault();
    var certificate_unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to Delete this Certificate ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Certificate",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');
           var path="<?php echo base_url() ?>jobs/deleteCertificateAjax"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{certificate_unique_id:certificate_unique_id},
                success:function(result){
                   if(result=='deleted'){
                       window.location.href='<?php echo base_url() ?>jobs/view_certificate/<?php echo $this->uri->segment(3); ?>';

                   }
                }
             });
          
         

        });
  }); 







</script>