<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/tab_nav.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="icon" href="images/favicon.gif" type="image/x-icon"/>

<?php
	$this->load->helper('HTML');
	echo link_tag('templates/css/styles.css');
?>

<link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
    <body>
    <!--start container-->
    <div id="container">
    <section id="intro">
	<div class="logo">
		<!--<span>Logo</span>-->
	</div>
	<div id="banner_text">
		<h1>Find your Place,<br/> Location, <br/> and Destination</h1>
	</div>
   </section>
   
   <!--start holder-->
   <div class="holder_content1">
   
   <section class="group_content">
   
   <article>
    <div>

    <h1>Login</h1>
    <p>Please login with your email and password below.</p>
	    
    <div id="infoMessage"><?php echo $message;?></div>
    
    <?php echo form_open("auth/login");?>
	    
      <p>
	<label for="identity">Your Email:</label>
	<?php echo form_input($identity);?>
      </p>
    
      <p>
	<label for="password">Password:</label>
	<?php echo form_input($password);?>
      </p>
    
      <!--<p>
	<label for="remember">Remember Me:</label>
	<?php //echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
      </p>-->
	
	
      <p><?php echo form_submit('submit', 'Login');?><?php echo anchor(base_url(),'Cancel','class="btn large"');?></p>
	
    <?php echo form_close();?>
    
    <p><a href="forgot_password">Forgot your password?</a></p>
    </div>
    
</article>
   </section>
   	
   </div>
   
   </div>
   <!--end container-->
   
   <!--start footer-->
   <footer>
   <div class="container">
   <section class="footer_left">
   <h3><u>Recent Places</u> : 
   <?php foreach($recent as $row): ?>
	<span><?php echo $row['nama'];?></span>
   <?php endforeach; ?>
   </h3>
   </section> 
   
   <section class="footer_left">
   <h3><u>Cities</u> :
   <?php foreach($city as $row): ?>
	<span><?php echo $row['nama_kota'];?></span>
   <?php endforeach; ?>
   </h3>
   </section> 

   <aside class="footer_left">
   <h3><u>Partners</u> :
   <span><?php echo anchor('http://www.traksi.com','Traksi.com'); ?></span>
   </h3>
   </aside> 
   <!--<img src="templates/images/contact-us.png" width="240" height="230" alt="contact" class="picture_footer"/>-->

   <div id="FooterTwo"> © 2012 Direktori.com </div>
   <!--<div id="FooterTree">Copyrights</div>--> 
   </div>
   </footer>
 <!--end footer-->
 <!-- Free template distributed by http://freehtml5templates.com -->  
   </body>
</html>