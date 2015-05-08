
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
    <a class="brand" href="<?php echo site_url(); ?>"><img src="<?php echo base_url();?>asset/themes/images/logo.png" alt="Yogya Elektronik"/></a>
		
		
		
		
    <ul id="topMenu" class="nav pull-right">
	 <?php if ($logged_in): ?>
	 <li class=""><?php echo anchor(site_url('store/home'),'<span class="btn btn-large btn-default"><i class="icon-home"></i> Home</span>'); ?></li>
	 
	 <li class=""><?php echo anchor(site_url('store/transaksi'),'<span class="btn btn-large btn-info"><i class="icon-file"></i> Transaksi</span>'); ?></li>
	 
	 
	 <li class=""><?php echo anchor(site_url('store/pending_transaksi'),'<span class="btn btn-large btn-danger"><i class="icon-file"></i>
 Pending</span>'); ?></li>
	 
	
    
	<?php
		if($nosearch){
			
		}else{
			
		//$attributes = array('id' => 'form_pencarian');
		echo form_open('store/search_prod');
	?>

	<li class="nav pull-right">
	<?php
		$data_s = array(
		'name'        => 'search_name',
		'id'          => 'search_name',
		'placeholder' => 'Search here..',
		'class'   => 'srchTxt'
		//'value'	      => $search_name,
		);
		
		
		echo "<div style='margin-top:10px; float:left'>".form_input($data_s)."</div>";
		echo form_hidden('dc_site_code', $dc_site_code);
		echo form_hidden('store_site_code', $store_site_code);
		echo "<div style='margin-top:10px; margin-left: 5px; float:left'>".form_submit('submit', 'Go','class = "btn btn-primary"')."</div>";
		}
		echo form_close();
	?>
	</li>
	
	
	<ul>
	<li class="nav pull-right">
	<!--<div id="search_container">-->
	<?php
//		if($nosearch){
//			
//		}else{
//			
//		$attributes = array('id' => 'form_pencarian');
//		echo form_open('store/search');
//		
//		$options = array(
//                  
//                  'artcode'    => 'Article Code',
//                  'brand'   => 'Brand',
//		  'tillcode'   => 'Tilcode',
//                  
//                );
//		
//		echo "<div style='margin-top:10px; float:left'>" .form_dropdown('search', $options, 'artcode')."</div>";
//		
//		
//	
//		$data_s = array(
//		'name'        => 'search_name',
//		'id'          => 'search_name',
//		'placeholder' => 'Cari Produk..',
//		'font-color'   => 'red'
//		//'value'	      => $search_name,
//		);
//		
//		
//		
//		echo "<div style='margin-top:10px; float:left'>".form_input($data_s)."</div>";
//		echo form_hidden('dc_site_code', $dc_site_code);
//		echo form_hidden('store_site_code', $store_site_code);
//		
//		echo "<div style='margin-top:10px; margin-left: 5px; float:left'>".form_submit('submit', 'Go','class = "btn btn-primary"')."</div>";
//		}
//		echo form_close();
	?>
	
	</li>
	</ul>
	
	
	
	<ul>
			<div id="result"></div>
	</ul>
	
</div>
	
	
	
	
	
	<?php if ($logged_in AND $multiuser == 1): ?>
	<div class="navbar-inner">
		
		<div><p><b>Halo Multi-User... Anda ingin menuju cabang?</b></p></div>
			<?php echo form_open('store/'); ?>
			<div class="span3">
				<?php echo form_dropdown('store_site_code',$site_master); ?>
			</div>
			
			<div class="span2" style="text-align: left">
			<?php
								
								echo form_submit(array(
								'value' => 'Submit',
								'id' =>'submit',
								'name' => 'submit',
								'class' => 'btn btn-lg btn-success btn-block'
								));
								
								echo form_close();
							?>
			</div>
			
		
	</div>
	<?php endif; ?>
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



</div>
</div>
	