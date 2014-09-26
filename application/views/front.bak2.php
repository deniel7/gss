 <head>
        
		<!--<link rel="stylesheet" type="text/css" href="asset/css/demo.css" />-->
		<!--<link rel="stylesheet" type="text/css" href="asset/css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="asset/css/custom.css" />
		<script src="asset/js/modernizr.custom.17475.js"></script>-->
    </head>
<p>
<?php //echo @$sambutan ?>
</p>
<div style="height:500px">
    <span>
       
    <img src="./images/opening.jpg">
    </span>
</div>

<div>
    <div style="border:solid thin; height:30px; background-image: url('images/h3bg.png'); background-repeat:no-repeat; background-position:right; background-color:#E61A13; border:none; margin-bottom:20px">
        <span style="font-size:16px; color:white;">TOP SALES</span>
    </div>
    
    <div id="wrapper">
		 
		<div id="container">
			<div class="sliderbutton" id="slideleft" onclick="slideshow.move(-1)"></div>
			<div id="slider">
				<ul>
					<li><img src="<?php echo base_url();?>images/img1.jpg" /></li>
					<li><img src="<?php echo base_url();?>images/img2.jpg" /></li>
					<li><img src="<?php echo base_url();?>images/img3.jpg" /></li>
					<li><img src="<?php echo base_url();?>images/img4.jpg" /></li>
				</ul>
			</div>
			<div class="sliderbutton" id="slideright" onclick="slideshow.move(1)"></div>
			<ul id="pagination" class="pagination">
				<li onclick="slideshow.pos(0)"></li>
				<li onclick="slideshow.pos(1)"></li>
				<li onclick="slideshow.pos(2)"></li>
				<li onclick="slideshow.pos(3)"></li>
			</ul>
		</div>
		  
    </div>
    
</div>