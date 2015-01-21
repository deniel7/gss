<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	<div class="span6">
	<div>
		
		<span style="margin-left: 25px">Cabang : </span><span class="btn btn-mini btn-primary"><?php echo $site_desc; ?></span>
		<!--<span class="btn btn-mini btn-info"><?php //echo $dc_supp_code; ?></span>  -->
		
		
		
	</div>	
	</div>
	<div class="span6">

	<div class="pull-right">
		
		<!--<span class="btn btn-mini">En</span>
		<a href="product_summary.html"><span>&pound;</span></a>
		<span class="btn btn-mini">$155.00</span>
		<a href="product_summary.html"><span class="">$</span></a>
		<a href="product_summary.html"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ 3 ] Itemes in your cart </span> </a> -->
	
		<?php if($this->session->flashdata('pesan')): ?>

		<?php echo $this->session->flashdata('pesan'); ?>
		
		<?php endif; ?>
		
		<span class="btn btn-mini">
		
		
		
		<?php echo $user_desc; ?>
		
		</span>
		<?php
			if ($logged_in):
			echo anchor(site_url('user/logout'),'<span class="btn btn-mini btn-danger">Logout</span>');
			endif;
		?>
	
	</div>
	</div>
</div>






<div class="topground"></div>
<div id="header">

	<div id="wrap">
		
		<div class="my_headers">
			<ul class="profilenav">
				
				{topmenu_data}
			</ul>
		</div>
	</div>
</div>
