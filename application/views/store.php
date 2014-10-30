<div class="span9">
    <ul class="breadcrumb">
	<?php if(!empty($link_map2)): ?>
		    
		    <li><?php echo $link_map2; ?></li>
		    
	<?php endif; ?>
		<!--<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Products Name</li>-->
		<li><?php
		    echo $link_map;
	    ?></li>
    </ul>
	
	<?php echo $data->PLU; ?>
	<!--<h3> Products Name <small class="pull-right"> 40 products are available </small></h3>	
	<hr class="soft"/>
	<p>
		We always stay in touch with the latest fashion tendencies - that is why our goods are so popular and we have a great number of faithful customers all over the country.
	</p>-->
	<hr class="soft"/>
	
	  
<div id="myTab" class="pull-right">
 <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
 <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
 
</div>
<br class="clr"/>

<?php if ($data) : ?>
	<?php if (count($data) > 0) : ?>
	<?php if (!empty($search_name)): ?><p>Berhasil ditemukan untuk pencarian : <strong><?php echo $search_name ?></strong></p> <?php endif; ?>


<div class="tab-content">
	<div class="tab-pane" id="listView">
		<?php foreach($data as $item): ?>
		<div class="row">	  
			<div class="span2">
				<?php if($item->THUMB == NULL): ?>
				    <div class="thumbnail" style="padding-top:30px; padding-bottom: 30px; text-align: center; color: grey">
					<span>Belum ada Gambar</span>
				    </div>
				<?php else: ?>
				    <a href="<?php echo site_url('/store/produk/'.$item->url_produk.'/'.$item->id_produk); ?>"><img src="<?php echo base_url().'/asset/themes/images/products/'.$item->THUMB; ?>" /></a>
				    
				<?php endif; ?>
			</div>
			<div class="span4">
				<h5><?php echo $item->ARTICLE_CODE; ?></h5>
				<h5><?php echo anchor(site_url('/store/produk/'.$item->ARTICLE_CODE),$item->ARTICLE_DESC);?></h5>
				<hr class="soft"/>
				
				<br class="clr"/>
			</div>
			<div class="span3 alignR">
			<form class="form-horizontal qtyFrm">
			    
			    <?php
				$stok = $item->STOCK_QTY;
				$booked = $item->BOOK_QTY;
				$confirm = $item->CONFIRM_QTY;
				
				$stock = $stok - $booked - $confirm;
				
				if($stock == 0 || $stock <=0){
			    
			    ?>
			    
				<h4>Stok : <p class="btn btn-danger">Kosong</p></h4>
			    <?php }else{ ?>
				<h4>Stok : <p class="btn btn-success"><?php echo $this->cart->format_number($stock) ?></p></h4>
				
			    <?php } ?>
			    <a href="<?php echo site_url('/store/produk/'.$item->ARTICLE_CODE); ?>" class="btn btn-large btn-primary"> View</a>
				</form>
			</div>
		</div>
		
		    <div class="col-lg-12">
			<center></center>
		    </div>
		
		<hr class="soft"/>
		<?php endforeach; ?>
		
	</div>

	<div class="tab-pane active" id="blockView">
		
		<ul class="thumbnails">
			<?php foreach($data as $item): ?>
			<li class="span3">
			  <div class="thumbnail">
				<?php if($item->THUMB == NULL): ?>
				    <div class="thumbnail" style="padding-top:30px; padding-bottom: 30px; text-align: center; color: grey">
					<span>Belum ada Gambar</span>
				    </div>
				<?php else: ?>
				    <a href="<?php echo site_url('/store/produk/'.$item->ARTICLE_CODE); ?>"><img src="<?php echo base_url().'/asset/themes/images/products/'.$item->THUMB; ?>" /></a>
				    
				<?php endif; ?>
				
				<div class="caption">
				  <p style="font-size: 11px"><b><?php echo $item->ARTICLE_CODE; ?></b></p>
				  <p style="font-size: 11px"><?php echo anchor(site_url('/store/produk/'.$item->PLU),character_limiter($item->ARTICLE_DESC, $this->config->item('produk_name_limiter')));?></p>
				  
				  
				   <h4 style="text-align:center">
	    
				    <?php
					$stok = $item->STOCK_QTY;
					$booked = $item->BOOK_QTY;
					$confirm = $item->CONFIRM_QTY;
					
					$stock = $stok - $booked - $confirm;
					
					if($stock == 0 || $stock <=0){
				    
				    ?>
					<p style="font-size:11px" class="btn-danger">Stok Kosong</p>
				    <?php }else{ ?>
					<p style="font-size:11px" class="btn-success">Stok : <?php echo $stock; ?></p>
					
				    <?php } ?>
				   </h4>
				    <h4 style="text-align:center"><a class="btn btn-primary" href="<?php echo site_url('/store/produk/'.$item->ARTICLE_CODE); ?>">View</a></h4>
				</div>
			  </div>
			</li>
			<?php endforeach; ?>	
		  </ul>
		
	<hr class="soft"/>
	</div>
</div>

	<!--<a href="compair.html" class="btn btn-large pull-right">Compair Product</a>-->
	
	<?php echo '<div class="pagination"><ul><li>'.$this->pagination->create_links().'</li></ul></div>'?>
	
	<br class="clr"/>
	<br class="clr"/>
	<br class="clr"/>
	<br class="clr"/>
	<br class="clr"/>
	<br class="clr"/>
	<?php endif; ?>
	<?php else : ?>
	    <?php if (!empty($search_name)): ?>
		<p>Tidak berhasil ditemukan untuk pencarian: <strong><?php echo $search_name ?></strong></p>
	    <?php else:?>
		<p><strong>Tidak ada barang untuk kategori ini.</strong></p>
	    <?php endif; ?>
	<?php endif; ?>
	
	
    <br class="clr"/>
</div>
