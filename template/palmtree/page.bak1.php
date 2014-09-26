<head>
	<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/css/flexslider.css" type="text/css" media="screen" />
</head>
{topmenu}
<div id="page">
	<div id="page-bgtop">
		<!--SLIDESHOW IMAGE-->
		<div style="width:1000px">
		<section>
		  <div class="flexslider">
		    <ul class="slides">
		      <li>
			      <img src="<?php echo base_url();?>images/img1.jpg" />
				  </li>
				  <li>
			      <img src="<?php echo base_url();?>images/img2.jpg" />
				  </li>
				  <li>
			      <img src="<?php echo base_url();?>images/img3.jpg" />
				  </li>
				  <li>
			      <img src="<?php echo base_url();?>images/img4.jpg" />
				  </li>
		    </ul>
		  </div>
		</section>
	  </div>
		

		<!--END SLIDESHOW IMAGE-->
		<div id="page-bgbtm">
			<div id="content">
				
            {body}
            </div>
			<!-- end #content -->
			{sidebar}
			<!-- end #sidebar -->
			<div style="clear: both;">&nbsp;</div>
		</div>
		<!-- end #page -->
	</div>
</div>
<!-- jQuery -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>
  
  <!-- FlexSlider -->
  <script defer src="<?php echo base_url();?>template/palmtree/js/jquery.flexslider.js"></script>
  
  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
