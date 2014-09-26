<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Yogya E-Commerce</title>
<link href="<?php echo base_url();?>/template/palmtree/css/store.css" rel="stylesheet" >
<link href="<?php echo base_url();?>/template/palmtree/css/style.css" rel="stylesheet" >
</head>
<body><head>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>asset/js/jquery.cookie.js"></script>
</head>
<div class="topground"></div>
<div id="header">
	<div id="logo">
		<h1><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>asset/images/logo.gif"/></a></h1>
		<h2></h2>
    </div>
	
	<!--<hr />-->
	<div id="wrap">
		<div class="my_headers">
			<ul class="profilenav">
			<li><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/icon_home.png" style="margin-top:5px"/></a></li>
				
				                                <li id="settingslink"><a href="<?php echo base_url();?>/user/login">LOGIN</a></li>
				<li id="settingslink2"><a href="<?php echo base_url();?>/user/register">REGISTRASI</a></li>
								</li>
			
	<!--</div>-->
        
<script type="text/javascript">
		$(document).ready(function(){
			var sub = $("#settingslist");
			var root = $("#settingslink");
			
                        var sub2 = $("#settingslist2");
			var root2 = $("#settingslink2");
                        
			$(root).hover(
        		function() {
                            sub.fadeIn("slow");
                            $("#settingslink a").addClass("hvr");
                            return false;
                        },
        		
                        function() {
                            sub.fadeOut("fast");
                            $("#settingslink a").removeClass("hvr");
                            return false;
                        });
                        
                        $(root2).hover(
        		function() {
                            sub2.fadeIn("slow");
                            $("#settingslink2 a").addClass("hvr");
                            return false;
                        },
        		
                        function() {
                            sub2.fadeOut("fast");
                            $("#settingslink2 a").removeClass("hvr");
                            return false;
                        });
                        
		});
	</script>
			</ul>
		</div>
	</div>
	<!-- end #menu -->
</div>
<div id="page">
	<div id="page-bgtop">
		
		<div id="page-bgbtm">
			<div style="padding:50px 50px 50px 50px">


<div style="position:relative; height:250px">
    <span>
    
    <div class="container">
    <div>

      <h2>Lupa Password</h2>
      <p>Silahkan input Email Anda sehingga kami bisa mengirimkan email kepada Anda untuk reset password Anda</p>
      
      
      <?php echo form_open("auth/forgot_password");?>
      
	    <p>
	      Alamat Email : <br />
	      <?php echo form_input($email);?>
	    </p>
	    
	    <p>
		<?php echo form_submit('submit', 'Submit');?>
		<?php echo form_button('back','Kembali',$js = 'onClick="history.go(-1)"');	?>
	    </p>
	    
	<?php
		if($message !=NULL){
			echo"<div class='error'" .$message."</div>";
		}	
	?>
      <?php echo form_close();?>
      
     </div>
        
    </div>
    
    </span>
</div>

			</div>
			<!-- end #content -->
			
			<div style="clear: both;">&nbsp;</div>
		</div>
		<!-- end #page -->
		
	</div>
</div>


<div id="footer-bgcontent">
	
	<div style="height:5px;"></div>
	<div id="footer_info">
	
	<div id="container_footer_info">
    
		<div id="primary">
		    <h1><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>asset/images/logo.gif"/></a></h1>
		</div>
		
		<div id="content_footer_info">
		    <div>
		    <h2><a href="<?php echo base_url();?>/user/term_condition">Term & Condition</a></h2>
		    <p>Syarat dan Kondisi berbelanja</p>
		    </div>
		    
		    <div>
		    <h2><a href="<?php echo base_url();?>/user/register">Registrasi Member</a></h2>
		    <p>Pendaftaran menjadi Member</p>
		    </div>
		
		    <div>
		    <h2><a href="<?php echo base_url();?>/user/cara_belanja">Cara Belanja</a></h2>
		    <p>Cara belanja di Yogya E-Commerce</p>
		    </div>
		    
		</div>
		
		<div id="secondary">
		    <h2>Hubungi Kami</h2>
		    <br/>
		    <b>Email :</b>
		    <br/>support@toserbayogya.com
		    <br/>
		    <br/>
		    <b>Phone :</b>
		    <br/>022-1234567
		</div>
    
	</div>

	
	</div>
	<div id="footer">
		<p>Copyright (c) 2012 Toserba Yogya.com. All rights reserved.</p>
	</div>
	<!-- end #footer -->

</div>
</body>
</html>