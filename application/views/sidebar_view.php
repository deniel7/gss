

<div class="well well-small">
    
    <h4><?php echo '<img src="'.base_url().'template/palmtree/images/list.gif" />' ?> List Pemesanan</h4>
    <hr>
    <?php if($cart == array()): ?>
    <div class="btn-info" style="text-align: center">List Anda Kosong</div>
<?php else: ?>
    <ul>
    <?php foreach($cart as $item): ?>
    <li><?php echo $item['qty']." : ".character_limiter($item['name'],$this->config->item('produk_name_limiter'))."   "; ?>
    <div style="text-align:right; float:right"><?php echo anchor('store/confirm_delete/'.$item['rowid'],'<img src="'.base_url().'images/delete.png" title="hapus" alt="hapus" />',array('onclick'=>"return confirm('Yakin akan menghapus barang ini?')")) ?></div></li>
    <hr>
    <?php endforeach; ?>
    </ul>
    <a href="<?php echo site_url('store/hapus_cart'); ?>"><span class="btn btn-mini btn-default">Kosongkan</span></a>
    <a href="<?php echo site_url('store/checkout'); ?>"><span class="btn btn-mini btn-success">Selesai</span></a>
<?php endif; ?>
</div>


<div class="well well-small">
    
    <div id="accordian">
	<ul>
		<li>
			<?php foreach ($kat as $item): ?>
			<h3><?php echo $item->CLASS_DESC; ?></h3>
		    
			<ul>
			    <?php foreach ($subkat as $items): ?>
			    <li>
				<?php if($items->CLASS_CODE == $item->CLASS_CODE): ?>
				<?php echo anchor(site_url('/store/kategori/'.$items->ATTRIB_CODE), $items->ATTRIB_DESC,'id="'.$items->MS_CHILD.'"'); ?>
				<?php endif; ?>
				
				
			    </li>
			    <?php endforeach; ?>
			</ul>
			<?php endforeach; ?>
		</li>
		
	</ul>
</div>
    
    
</div>

<div style="height: 125px"></div>
