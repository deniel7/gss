<script type="text/javascript">

$(document).ready(function() {		
	
	//Execute the slideShow
	slideShow();

});

function slideShow() {

	//Set the opacity of all images to 0
	$('#gallery a').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	$('#gallery a:first').css({opacity: 1.0});
	
	//Set the caption background to semi-transparent
	$('#gallery .caption').css({opacity: 0.7});

	//Resize the width of the caption according to the image width
	$('#gallery .caption').css({width: $('#gallery a').find('img').css('width')});
	
	//Get the caption of the first image from REL attribute and display it
	$('#gallery .content').html($('#gallery a:first').find('img').attr('rel'))
	.animate({opacity: 0.7}, 400);
	
	//Call the gallery function to run the slideshow, 6000 = change to next image after 6 seconds
	setInterval('gallery()',6000);
	
}

function gallery() {
	
	//if no IMGs have the show class, grab the first image
	var current = ($('#gallery a.show')?  $('#gallery a.show') : $('#gallery a:first'));

	//Get next image, if it reached the end of the slideshow, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('caption'))? $('#gallery a:first') :current.next()) : $('#gallery a:first'));	
	
	//Get next image caption
	var caption = next.find('img').attr('rel');	
	
	//Set the fade in effect for the next image, show class has higher z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
	
	//Set the opacity to 0 and height to 1px
	$('#gallery .caption').animate({opacity: 0.0}, { queue:false, duration:0 }).animate({height: '1px'}, { queue:true, duration:300 });	
	
	//Animate the caption, opacity to 0.7 and heigth to 100px, a slide up effect
	$('#gallery .caption').animate({opacity: 0.7},100 ).animate({height: '60px'},500 );
	
	//Display the content
	$('#gallery .content').html(caption);
	
	
}

</script>
<style type="text/css">

.clear {
	clear:both
}

#gallery {
	position:relative;
	height:310px;
	margin-top:0px
}
	#gallery a {
		float:left;
		position:absolute;
	}
	
	#gallery a img {
		border:none;
	}
	
	#gallery a.show {
		z-index:500
	}

	#gallery .caption {
		z-index:600; 
		background-color:#000; 
		color:#ffffff; 
		height:60px; 
		width:100%; 
		position:absolute;
		bottom:0;
	}

	#gallery .caption .content {
		margin:5px
	}
	
	#gallery .caption .content h3 {
		margin:0;
		padding:0;
		color:#1DCCEF;
	}
	

</style>


{topmenu}
<div id="page">
	<div id="page-bgtop">
		<!--SLIDESHOW IMAGE-->
		<div id="gallery">
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img1.jpg" alt="img1" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img2.jpg" alt="img2" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img3.jpg" alt="img3" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img4.jpg" alt="img4" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img5.jpg" alt="img5" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img6.jpg" alt="img3" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img7.jpg" alt="img4" rel="<h3>Antapani Town House</h3>" />
			</a>
			<a href="#" class="show">
			    <img src="<?php echo base_url();?>images/img8.jpg" alt="img5" rel="<h3>Antapani Town House</h3>" />
			</a>

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