
	<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/tether/tether.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/plugins.js"></script>



	<script type="text/javascript" src="<?php echo base_url(); ?>assest/js/lib/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assest/js/lib/lobipanel/lobipanel.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assest/js/lib/match-height/jquery.matchHeight.min.js"></script>

	<script src="<?php echo base_url(); ?>assest/js/lib/datatables-net/datatables.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
     <!-- Datepicker JS start -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/js/lib/moment/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assest/js/lib/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/clockpicker/bootstrap-clockpicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/clockpicker/bootstrap-clockpicker-init.js"></script>
	<script src="<?php echo base_url(); ?>assest/js/lib/daterangepicker/daterangepicker.js"></script>
	 <!-- Datepicker JS END -->

    
    

	<script>   
		$(document).ready(function() {

			$('#daterange3').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true
			});

			$('.panel').lobiPanel({
				sortable: true
			});
			$('.panel').on('dragged.lobiPanel', function(ev, lobiPanel){
				$('.dahsboard-column').matchHeight();
			});		
			
		});
	</script>

	<script>
		$(function() {
			$('#example').DataTable();
			$('.example-datatable').DataTable();
		});
	</script>

<script src="<?php echo base_url(); ?>assest/js/app.js"></script>
</body>
</html>


