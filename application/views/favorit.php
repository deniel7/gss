<h2>List Belanja</h2>
<p>Buat dan gunakan List belanja ini untuk belanja secara periodik (Bulanan / Mingguan). <br/> Ketika Anda belanja,
cukup buka List Belanja Anda, klik Masukan Trolley sesuai dengan jumlah produk yang dikehendaki. <br/>
List Belanja ini membantu proses pemilihan produk menjadi lebih mudah dan cepat.</p>
<?php if ($order == array()): ?>
<div class="note-cart">List Belanja Anda masih kosong</div>
<?php else: ?>
<div class="clear"></div>
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">
    <tr>
        <th>Nama List</th>
	<th>Hapus</th>
	<th>Detail</th>
    </tr>
<?php foreach ($order as $item): ?>
    <tr>
        <td><?php echo $item->nama; ?></td>
	<td style="text-align:center"><?php echo anchor('user/hapus_detail_fav/'.$item->nama,'<img src="'.base_url().'images/delete.png" title="hapus" alt="hapus" />',array('onclick'=>"return confirm('Yakin akan menghapus List ini?')")) ?></td>
	<td style="text-align:center"><?php echo anchor('user/detail_fav/'.$item->nama, 'Detail', 'class="active" id="detail"'); ?></td>
    </tr>
<?php endforeach; ?>
    
</table>
<?php endif; ?>

<br/><br/>
<?php
    if(@$error)
    {echo @$error;}
    
    echo form_fieldset('Tambah List Belanja');
    echo form_open(site_url('user/favorit'));
    echo form_label('Nama List : ');
    echo form_input('nama');
    echo form_submit('submit','Tambah');
    echo form_close();
    echo "<br/>".validation_errors();
    echo form_fieldset_close();   
?>