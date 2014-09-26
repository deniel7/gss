
<div style="text-align:right">
		
    <div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('store/search');
	?>

			<span>
				<?php
					$data_s = array(
					'name'        => 'search_name',
					'id'          => 'search_name',
					'placeholder' => 'Cari Produk..',
					'font-color'   => 'red'
					//'value'	      => $search_name,
					);
					
                                        
                                        
					echo form_input($data_s);
					
					echo form_submit('submit', 'Go','class = "btn large"');
					echo form_close();
				?>
				<ul>
						<div id="result"></div>
				</ul>
			</span>
			</div>
    
</div>

<div>
	
	<div>
	    <?php
		    if(!empty($link_map2)){
		    
		    echo $link_map2;
		    }
	    ?>
	</div>
	<br/>
	<p style="font-size: 10px">
	    <?php
		    echo $link_map;
	    ?>
	</p>    
</div>

<?php //if ($data == NULL){
    //echo "<div class='sukses'>Produk yang dicari tidak ditemukan</div>";
//}else{ ?>
<?php if ($data) : ?>
<?php if (count($data) > 0) : ?>
<?php if (!empty($search_name)): ?><p>Berhasil ditemukan untuk pencarian : <strong><?php echo $search_name ?></strong></p> <?php endif; ?>
<?php foreach($data as $item): ?>

    <div class="produk-wrap">
        
        <div class="image-wrap">
            <div class="image-iner">
                <?php if($item->thumb == ''): ?>
                    <div class="no-image">
                        <span>Belum ada Gambar</span>
                    </div>
                <?php else: ?>
                    <a href="<?php echo site_url('/store/produk/'.$item->url_produk.'/'.$item->id_produk); ?>"><img src="<?php echo base_url().$item->thumb ?>" /></a>
                    
                <?php endif; ?>
                <?php //if ($item->stok == 0): ?>
                    <!--<div class="trans">
                        <span>Stok Habis</span>
                    </div>-->
                <?php //endif; ?>
            </div>
        </div>
        <div class="produk-name">
            <?php echo anchor(site_url('/store/produk/'.$item->url_produk),character_limiter($item->nama_produk, $this->config->item('produk_name_limiter')));?>
        </div>
        <?php if($item->harga_baru != 0): ?>
            <div class="harga-lama">
                Rp. <?php echo $this->cart->format_number($item->harga_jual) ?>
            </div>
            <div class="harga-jual">
                Rp. <?php echo $item->harga_baru ?>
            </div>
        <?php else: ?>
            <div class="harga-jual">
                Rp. <?php echo $this->cart->format_number($item->harga_jual) ?>
            </div><br/>
	    
        <?php endif; ?>
    </div>
<?php endforeach;
//}
?>
<?php echo '<div id="footer_paging"><div class="paging">'.$this->pagination->create_links().'</div></div>'?>
<?php endif; ?>
<?php else : ?>
    <?php if (!empty($search_name)): ?>
	<p>Tidak berhasil ditemukan untuk pencarian: <strong><?php echo $search_name ?></strong></p>
    <?php else:?>
	<p><strong>Tidak ada barang untuk kategori ini.</strong></p>
    <?php endif; ?>
<?php endif; ?>
