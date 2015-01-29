

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
	<ul id="acdnmenu" class="accordion">
	    <li class="files" id="one">
		<?php //echo $kategori; ?>
		<?php foreach ($kat as $item): ?>
		<li class="btn-info">
		    <!--<a href="#" id="a">-->
					
			<?php //echo $item->ATTRIB_DESC; ?><!--<span>`</span>-->
			<?php echo anchor(site_url('/store/kategori/'.$item->ATTRIB_CODE), $item->ATTRIB_DESC.'<span>`</span>','id="'.$item->MS_CHILD.'"'); ?>			
		    <!--</a>-->
		</li>
		<?php endforeach; ?>
	    
	    </li>
	</ul>
</div>

<!--<div class="well well-small">
	<ul id="acdnmenu" class="accordion">
	    <li class="files" id="one">
		<?php //echo $kategori; ?>
	    </li>
	</ul>
</div>-->
<div style="height: 125px"></div>
