<!-- Footer ================================================================== -->
	
	<!--<div  id="footerSection">
	<div class="container">
		<div class="row">-->
			
			<!--<div class="span6">
				<h5>INFORMATION</h5>
				<a href="contact.html">SYARAT & KETENTUAN</a>  
				<a href="register.html">CONTACT</a>  
				
			 </div>
			 <div class="span6">
				<h5>TUTORIAL</h5>
				<a href="contact.html">CARA PENGGUNAAN APLIKASI</a>  
			 </div>-->
		 <!--</div>
		<p class="pull-right">&copy; YOGYA GROUP</p>-->
	<!--</div>--><!-- Container End -->
	<!--</div>-->
<!-- Placed at the end of the document so the pages load faster ============================================= -->
	<!--<script src="<?php echo base_url();?>template/palmtree/js/jquery.js" type="text/javascript"></script>-->
	
	<script src="<?php echo base_url();?>template/palmtree/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>template/palmtree/js/google-code-prettify/prettify.js"></script>
	
	<script src="<?php echo base_url();?>template/palmtree/js/bootshop.js"></script>
    <script src="<?php echo base_url();?>template/palmtree/js/jquery.lightbox-0.5.js"></script>
	
	<!-- Themes switcher section ============================================================================================= -->

<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.cookie.js"></script>
    
   

<script>
/*jQuery time*/
$(document).ready(function(){
	$("#accordian h3").click(function(){
		//slide up all the link lists
		$("#accordian ul ul").slideUp();
		//slide down the link list below the h3 clicked - only if its closed
		if(!$(this).next().is(":visible"))
		{
			$(this).next().slideDown();
		}
	})
})
</script>
</body>
</html>