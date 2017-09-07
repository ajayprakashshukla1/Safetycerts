<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assest/js/lib/tether/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assest/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assest/js/plugins.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="<?php echo base_url(); ?>assest/js/app.js"></script>
</body>
</html>