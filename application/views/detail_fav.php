<h2>List Belanja Anda</h2>
<br/>
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
  <th>Nama Barang</th>
  <th align="center">Jumlah</th>
  <th align="center">Hapus</th>
  <th style="text-align:right">Harga Satuan</th>
  <th style="text-align:right">Pilih</th>
</tr>

<?php $i = 1; ?>
<?php $id_list = array(); $qty_list = array(); ?>
<?php //var_dump($detail) ?>
<?php if(!empty($detail)){ ?>

<?php foreach($detail as $data): ?>


	<?php echo form_open(site_url('store/update_list')); ?>
	
	<tr>
	  <td>
		<?php echo $data->nama_produk; ?>

	  </td>
      <td align="center"><?php echo form_input(array('name' => 'qty-'.$data->id_produk.'-'.$data->id_fav, 'value' => $data->qty, 'maxlength' => '3', 'size' => '5', 'id' =>'jumlah')); ?></td>
	  <td style="text-align:center"><?php echo anchor('user/delete_det_fav/'.$data->id_fav,'<img src="'.base_url().'images/delete.png" alt="hapus" />',array('onclick'=>"return confirm('Yakin akan menghapus produk ini?')")) ?></td>
	  <td style="text-align:right"><?php echo $this->cart->format_number($data->harga_jual); ?></td>
	  <td style="text-align:right"><?php echo form_submit(array('name' => 'submit-'.$data->id_produk,'value'=>'Masukan Trolley ', 'class' => 'button-buy' )); ?></td>
	</tr>

        <?php 
	
	    echo form_hidden('id-'.$data->id_produk,$data->id_produk);
	    echo form_hidden('plu-'.$data->id_produk,$data->plu);
	    echo form_hidden('name-'.$data->id_produk,$data->nama_produk);
	    
	    echo form_hidden('url',uri_string());
	    
	    
	    if($data->harga_baru != 0){
		echo form_hidden('price-'.$data->id_produk,$data->harga_baru);
	    } else {
		echo form_hidden('price-'.$data->id_produk,$data->harga_jual);
	    }
	    
	    
	    
        ?>

<?php $i++; ?>

<?php endforeach; ?>
<tr>
    <td></td>
<td style="text-align:center">    
    <?php echo form_submit(array('name' => 'simpan','value'=>'Update Jumlah')); ?>
</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<?php echo form_close(); ?>
</table>

<?php }else{ ?>

<table cellpadding="6" cellspacing="1" style="width:100%" border="0">
	<tr>
	  <td>
	    <div class="note-cart"><b>List Belanja Anda Kosong</b> <br/><br/>
	    Tambahkan barang belanjaan ke List Belanja Anda pada saat proses :<br/><br/> Selesai Belanja - Review Pesanan
	    <br/><br/>
	    <?php echo '<img src="'.base_url().'images/list_kosong.jpg" alt="hapus" />'; ?>
	    </div>
	  </td>
	</tr>
</table>
<?php } ?>

<div style="text-align:right"><?php echo form_button('back','Kembali',$js = 'onClick="history.go(-1)"');	?></div>