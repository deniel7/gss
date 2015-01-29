<!-- Footer ================================================================== -->
	
	<div  id="footerSection">
	<div class="container">
		<div class="row">
			
			<!--<div class="span6">
				<h5>INFORMATION</h5>
				<a href="contact.html">SYARAT & KETENTUAN</a>  
				<a href="register.html">CONTACT</a>  
				
			 </div>
			 <div class="span6">
				<h5>TUTORIAL</h5>
				<a href="contact.html">CARA PENGGUNAAN APLIKASI</a>  
			 </div>-->
		 </div>
		<p class="pull-right">&copy; YOGYA GROUP</p>
	</div><!-- Container End -->
	</div>
<!-- Placed at the end of the document so the pages load faster ============================================= -->
	<!--<script src="<?php echo base_url();?>template/palmtree/js/jquery.js" type="text/javascript"></script>-->
	
	<script src="<?php echo base_url();?>template/palmtree/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>template/palmtree/js/google-code-prettify/prettify.js"></script>
	
	<script src="<?php echo base_url();?>template/palmtree/js/bootshop.js"></script>
    <script src="<?php echo base_url();?>template/palmtree/js/jquery.lightbox-0.5.js"></script>
	
	<!-- Themes switcher section ============================================================================================= -->

<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.dcjqaccordion.2.7.js"></script>
    
    <script>
    
    function initMenu() {
    
    var checkCookie = $.cookie("nav-item");
    if (checkCookie != "") {
	  
	var checkElement = $('#'+checkCookie).next();
	    
        $('#acdnmenu ul:visible').not(checkElement.parentsUntil('#acdnmenu')).hide();
	
	$('#'+checkCookie).parentsUntil('#acdnmenu').show();
        
    }
    $('#acdnmenu  li  a').click(

    function() {
	
	$.cookie("nav-item", $(this).attr('id'));
	
        var checkElement = $(this).next();
        if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            checkElement.slideUp('normal');
            return false;
        }
        if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('#acdnmenu ul:visible').not(checkElement.parentsUntil('#acdnmenu')).slideUp('normal');
            checkElement.slideDown('normal');
            return false;
        }
	
    });
    
    $('.current-menu-item').parentsUntil('#nav').slideDown('normal');
    }
    
    $(function() {
	initMenu();
    });
    </script>

</body>
</html>