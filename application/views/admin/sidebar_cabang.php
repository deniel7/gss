
        <!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px)-->
				<p id="logo"><a href="#"><img src="<?php echo base_url().'asset/images/logo.gif';?>" alt="Our logo" title="Visit Site" /></a></p>
			
			<ul id="nav">
				<li><?php echo anchor(site_url('admin'),'Home'); ?></li>
				
				
					<li><?php echo anchor('http://www.google.com','Member Yogya',array('target' => '_blank')); ?></li>
					
				  
				<li><a href="#" class="sub" tabindex="1">PEMESANAN</a><img src="<?php echo base_url().'asset/images/menu_adm/up.gif'; ?>" alt="" />
					<ul>
						<li><?php echo anchor(site_url('admin/pesanan_cabang'),'Pesanan'); ?></li>
						<li><?php echo anchor(site_url('admin/picking_list'),'Print Picking List'); ?></li>
						<li><?php echo anchor(site_url('admin/delivery_order'),'Print Delivery Order'); ?></li>
					</ul>
				</li>
			</ul>
			
			<br/>
			
			<ul id="nav">
				
				<li id="c_psn_cbg"></li>			
				
			</ul>
			
	
			</div> <!-- /padding -->
			
			
			

		</div> <!-- /aside -->
        <hr class="noscreen" />
        
        <!-- Content (Right Column) -->
		<div id="content" class="box">