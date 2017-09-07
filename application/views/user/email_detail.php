<style type="text/css">
.sweet-alert .btn{
  min-width: 0px;
}  
</style>

<div class="page-content">
   <div class="container-fluid">
      <div class="box-typical box-typical-padding">
     
        <h5 class="with-border" style="margin-top:5px;">Email Logs</h5>
          <div class="table-responsive">
            <table id="table-edit" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th width="1">#</th>
              
              <th>Email</th>
              <th>Message</th>
              <th width="167px">Send Date</th>
            
          </tr>
            </thead>
            <tbody>
             <?php 
             $i=1;
             foreach($email_lists as $email_list){ ?> 
              <tr>
                <td><?php echo $i; ?></td>
                <td><?=$email_list['email']?></td>
                <td><?=$email_list['message']?></td>
                <td><?=date('d/m/Y',strtotime($email_list['send_date']))?></td>
              </tr>
             <?php $i++; } ?>
              
             
            </tbody>
          </table>
         </div>
      </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>

