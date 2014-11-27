
				<?php //if (!$logged_in): ?>
                                <!--<li id="settingslink"><?php //echo anchor(site_url('user/login'),'LOGIN') ?></li>
				<li id="settingslink2"><?php //echo anchor(site_url('user/register'),'REGISTRASI') ?></li>-->
				<?php //else: ?>

<div id="logoArea" class="navbar">
<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
  <div class="navbar-inner">
    <a class="brand" href="<?php echo site_url(); ?>"><img src="<?php echo base_url();?>asset/themes/images/logo.gif" alt="Bootsshop"/></a>
		
		
		
		
    <ul id="topMenu" class="nav pull-right">
	 <?php if ($logged_in): ?>
	 <li class=""><?php echo anchor(site_url('store/home'),'<span class="btn btn-large btn-default"><i class="icon-home"></i> Home</span>'); ?></li>
	 
	 <li class=""><?php echo anchor(site_url('store/transaksi'),'<span class="btn btn-large btn-info"><i class="icon-file"></i> Transaksi</span>'); ?></li>
	 
	 
	 
	<!--<div>
		<form class="form-inline navbar-search" method="post" action="products.html" >
			<input class="srchTxt" type="text" placeholder="Search Here" />
			<button type="submit" id="submitButton" class="btn btn-primary">Go</button>
		</form>
	
	<div>-->
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('store/search_prod');
	?>

			<span>
				<?php
					$data_s = array(
					'name'        => 'search_name',
					'id'          => 'search_name',
					'placeholder' => 'Search here..',
					'class'   => 'srchTxt'
					//'value'	      => $search_name,
					);
					
                                        
                                        
					echo form_input($data_s);
					echo form_hidden('dc_site_code', $dc_site_code);
					echo form_hidden('store_site_code', $store_site_code);
					echo form_submit('submit', 'Go','class = "btn btn-primary"');
					echo form_close();
				?>
				<ul>
						<div id="result"></div>
				</ul>
			</span>
			</div>
	
	
	
	</div>
	 
	 
	 <?php else: ?>
	 
	 
	 <li>
		<?php echo anchor(site_url('user/login'),'<span class="btn btn-large btn-success"><i class="icon-user"></i> Login</span>') ?>
	 
	 </li>
	 
	 <li>
		<?php echo anchor(site_url('user/register'),'<span class="btn btn-large btn-info"><i class="icon-share"></i> Register</span>') ?>
	 
	 </li>
	 
	 
	 <?php endif; ?>
    </ul>
    
  </div>
</div>

<?php if($this->session->flashdata('pesan')): ?>
		<?php echo $this->session->flashdata('pesan'); ?>
	    <?php endif; ?>
</div>
</div>