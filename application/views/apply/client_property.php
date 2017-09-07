<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}
.error { color:red; }  
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
        <h5 class="m-t-lg with-border">All properties of (<?php echo $client->first_name." ".$client->last_name  ?>)</h5>
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
			                     <th>Name</th>
                           <th>Address</th>
			                     <th>Property Type</th>
                           <th>CREATED TEST</th>
			                     <th class="table-icon-cell">Action</th>
                         </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($property_data as $data){ ?>
			   
                          <tr>
                            <td><?php echo $i; ?></td>
				                    <td><a href="<?php echo base_url('user/property_details/'.$data['unique_id']); ?>"><?php echo $data['name'];?></a></td>

                            <td><?php echo $data['address'];?></td>
				                    <td><?php echo $data['property_type'];?></td>
                            <td><?php echo $data['created'];?></td>
               
				                    <td class="hello"> 
                               <a href="<?php echo base_url() ?>user/property_edit/<?php echo $data['unique_id']; ?>">
                                 <span class="glyphicon glyphicon-pencil"></span>
                               </a> &nbsp;

                               <a href="<?php echo base_url() ?>jobs/view_certificate/<?php echo $data['unique_id']; ?>" title="View Certificate">
                                 <span class="font-icon font-icon-eye"></span>
                               </a> &nbsp;

                               <a href="" class="del_prop swal-btn-warning " id="<?php echo $data['unique_id']; ?>"  pid="<?php echo $data['id'];?>">
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