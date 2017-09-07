   <footer class="bottom">
        <div class="container">

        </div>
    </footer>

  <script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/tether/tether.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/jquery-validation/jquery.validate.min.js"></script>



	<script src="<?php echo base_url(); ?>assest/js/lib/jquery-steps/jquery.steps.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/js/lib/jquery-steps/jquery.steps.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   	<script src="http://www.safetycerts.co.uk/safetycerts/assest/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
   	<script>
   	  $( function() {
        //$( ".datepicker" ).datepicker();
        $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
      });
    </script>
    <script>
		$(function() {
			/* ==========================================================================
			 Validation
			 ========================================================================== */
           
			$('#form-signin_v2').validate({
				submit: {
					settings: {
						inputContainer: '.form-group',
						errorListClass: 'form-error-text-block',
						display: 'block',
						insertion: 'prepend'
					}
				}
			});

			$('#form-signup_v2').validate({
				submit: {
					settings: {
						inputContainer: '.form-group',
						errorListClass: 'form-tooltip-error'
					}
				}
			});


		});

		 $('.swal-btn-warning').click(function(e){
    e.preventDefault();
    var unique_id= $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You want to delete this Property ?",
          type: "warning",
          showCancelButton: true,
          cancelButtonClass: "btn-default",
          confirmButtonClass: "btn-danger btn-cont",
          confirmButtonText: "Delete Property",
          closeOnConfirm: false
        },
        function(){

           $('.btn-cont').html('Please Wait...');           
           var path="<?php echo base_url() ?>user/deletePropertyAjax"; 
           var redirect_path = "<?php echo base_url() ?>user/viewproperty"; 
           $.ajax({
                type:"POST",
                url:path,
                data:{unique_id:unique_id},
                success:function(result){
                    
                   if(result=='deleted'){
                       window.location.href=redirect_path;
                   }
                }
             });
          
          

        });
  }); 




	</script>
<script src="<?php echo base_url(); ?>assest/js/app.js"></script>
</body>
</html>