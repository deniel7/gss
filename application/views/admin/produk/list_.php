<h1><?php echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right">
	   <li><a href="<?php echo site_url('admin/produk/tambah') ?>" id="add"><span><strong>Tambah Produk Baru</strong></span></a></li>
    </ul>
</div>
<!--<h3 class="tit">Daftar Produk</h3>-->

<h4>Keterangan Import Data</h3>
<table style="position:right">
	<tr>
		<td colspan="2">Total Produk</td>
		<td colspan="2"><?php echo $total_rows; ?></td>
		
	</tr>
	<tr>
		<td>Nama Produk Kosong</td>
		<?php
		
			foreach ($total_empty_name as $tot):
		
		?>
		<?php
		
		if($tot == 0)
                {
			echo '<td class="count_green">'.anchor(site_url('admin/produk/list_empty_name'),$tot).'</td>';
		}else{
                
		?>
		
		<td class="count_red"><?php echo anchor(site_url('admin/produk/list_empty_name'),$tot); ?></td>
		<?php } ?>
		<?php endforeach; ?>
	<!--<td>-->
		<td>Gambar Produk Kosong</td>
		<?php
		
			foreach ($total_empty_pic as $tot_pic):
		
		?>
		<?php
		
		if($tot_pic == 0)
                {
			echo '<td class="count_green">'.anchor(site_url('admin/produk/list_empty_pic'),$tot_pic).'</td>';
		}else{
                
		?>
		
		<td class="count_red"><?php echo anchor(site_url('admin/produk/list_empty_pic'),$tot_pic); ?></td>
		<?php } ?>
		<?php endforeach; ?>
		
	<!--</td>-->
	
	</table><br/>

<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('admin/produk/search');
	?>

			<span>
				<?php
					$data_s = array(
					'name'        => 'search_plu',
					'id'          => 'search_plu',
					'placeholder' => '',
					'font-color'   => 'red'
					//'value'	      => $search_name,
					);
					
					$data_n = array(
					'name'        => 'search_name',
					'id'          => 'search_name',
					'placeholder' => '',
					'font-color'   => 'red'
					//'value'	      => $search_name,
					);
					
					echo form_close();
				?>
					<div class="table">
					<div class="headRow">
					    <!--<div class="col">Pencarian :</div>-->
					   <!-- <br/>-->
					    <div class="col">PLU <?php echo form_input($data_s); ?></div>
					    <div class="col">Nama Produk<?php echo form_input($data_n); ?></div>
					    <!--<br/>-->
					    
					    <div class="col">
					    Kategori
					    <?php 
						//echo form_dropdown('search_kat', $list_kat);
						echo form_dropdown('search_kat',$list_kategori,@$kategori);	
						 //echo form_input($data_kat); ?>
					    </div>
					    
					    <div style="margin-left:700px; margin-top:15px"><?php echo form_submit('submit', 'Go','class = "btn large"'); ?></div>
					</div> 
					</div>
						<div id="result"></div>
				
			</span>
			
</div>
<br/>
<?php if ($produk == NULL){
    echo "<p class='msg warning'>Produk yang dicari tidak ditemukan</p>";
}else{ ?>



<?php if($produk!= array()): ?>
	<table>
		<tr>
            <th>PLU</th>
		    <th>Nama Produk</th>
		    <th>Deskripsi PLU</th>
            <th>Kategori</th>
		    <th>Harga</th>
            <!--<th>Stok</th>-->
		    <th>Status</th>
            <th>Action</th>
		</tr>
        <?php $i=0; foreach ($produk as $val): ?>
		<tr <?php echo $i%2 == 0 ? 'class="bg"' : '';  ?>>
		    <td><?php echo $val->plu; ?></td>
		    <td><?php echo $val->nama_produk; ?></td>
		    <td><?php echo $val->plu_descriptor; ?></td>
		    <td><?php echo $val->nama_kategori; ?></td>
		    <td><?php echo $val->harga_jual; ?></td>
		    <!--<td><?php //echo $val->harga_baru == 0 ? $val->harga_jual : '<div style="color:red">'.$val->harga_baru.'</div>'; ?></td>-->
		    
		    <!--<td><?php //echo $val->stok != 0 ? $val->stok : '<div class="no-stock">stok habis</div>'; ?></td>-->
		    <td><?php echo $val->status_produk == 1 ? anchor('admin/produk/aktifasi/'.$val->id_produk.'/0','Aktif', 'class="active"') : anchor('admin/produk/aktifasi/'.$val->id_produk.'/1','Tidak Aktif', 'class="no-active"'); ?></td>
		    <td>
			<?php echo anchor('admin/produk/ubah/'.$val->id_produk,'Ubah','class="ubah"')?>
			|
			<?php echo anchor('admin/produk/hapus/'.$val->id_produk,'Hapus',array('onclick'=>"return confirm('Yakin akan menghapus produk ini?')")) ?>
		    </td>
		</tr>
        <?php $i++; endforeach; ?>
	<tr>
		<td colspan="6" align="center"><?php  echo $this->pagination->create_links(); ?></td>
		
	</tr>
	</table><br/>
	
<?php else: ?>
    <p class="msg info">Belum ada Produk yang tersedia</p>
<?php endif; ?>

<script type="text/javascript">
jQuery(function($) {
	$("#add").colorbox({
		width:"500", height:"500", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
<?php } ?>