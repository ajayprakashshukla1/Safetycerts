    <footer class="bottom">
        <div class="container">

        </div>
    </footer>

    <script src="<?php echo base_url(); ?>assest/apply/js/jquery-3.2.0.min.js"></script>

    <script src="<?php echo base_url(); ?>assest/apply/js/parsley.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/apply/js/scripts.js?v1"></script>
    <script type="text/javascript">
    
		function let_signup(){
		   	
           var error=false;
		   if($("#apply_first_name").val()==''){
			  error= true;
		   }

		   if($("#apply_last_name").val()==''){
		   	  error= true;
		   }

		   if($(".apply_email").val()==''){
		   	  error= true;
		   }

		   if($("#apply_confirm_email").val()==''){
		   	  error= true;
		   }

		   if($("#apply_password").val()==''){
		   	  error= true;
		   }

		   if($("#apply_confirm_password").val()==''){
		   	  error= true;
		   }

		   if(error){
		   	  $('#applyform').submit();
		   }

		   if(error){
		   	  return false;
		   }

		   $('.sign-up').html('Please Wait...');
		   var path="<?php echo base_url() ?>apply/createAjax"; 
		   var redirect_path = "<?php echo base_url() ?>auth/login"; 
		   $.ajax({
	          type:"POST",
	          url:path,
	          data:{first_name:$("#apply_first_name").val(),
	                last_name:$("#apply_last_name").val(),
	                email:$(".apply_email").val(),
	                confirm_email:$("#apply_confirm_email").val(),
	                password:$("#apply_password").val(),
	                confirm_password:$("#apply_confirm_password").val(),
	                phone:$("#apply_phone").val(),
	               },
	          success:function(result){
	             if(result=='saved'){

	             	$('#notify').empty().append('<div class="alert alert-success">'+
					                      '<strong>Success!</strong> You have successfully signed up. please click <a href="<?php echo base_url() ?>auth/login">here</a>'+
					                    '</div>');

	             	 $('#applyform').find("input[type=text],input[type=email],input[type=password], textarea").val("");
	             	 window.location.href = redirect_path;
	             }else{
	             	$('#notify').empty().append('<div class="alert alert-danger">'+
					                      '<strong>Error ! </strong> '+result+' '+
					                    '</div>');
	             }

	             $('.sign-up').html('Sign-up & add property later');

	             $('html, body').animate({ scrollTop: 0 }, 'slow', function () {
			        
			    });
	          }
	       });
		}     

    </script>
</body>
</html>

