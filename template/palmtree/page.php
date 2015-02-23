<head>
<!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">	
</head>

{topmenu}

<div id="myCarousel" class="carousel slide">
			<?php
			if(!empty($slidebanner)){
						echo $slidebanner;	
			}
			?>
</div>

<div id="mainBody">
	<div class="container">
			<div class="row">
			
			<?php
			if(!empty($sidebar)){
						echo $sidebar;	
					}else{
							
					}
			?>
			
			{body}
			
			
			
			</div>
	</div>
</div>

		
		
	