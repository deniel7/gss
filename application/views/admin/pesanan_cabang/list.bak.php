<h1><?php echo $judul ?></h1>
<!--<div id="menu" class="box">
	<ul class="box f-right">
	   <li><a href="<?php //echo site_url('admin/produk/tambah') ?>" id="add"><span><strong>Tambah Produk Baru</strong></span></a></li>
    </ul>
</div>-->
<h3 class="tit">Daftar Pesanan</h3>
<?php if($pesanan!= array()): ?>
	<table>
		<tr>
			<th>No</th>
			<th>Order No</th>
			<th>Member No</th>
			<th>Nama</th>
			<th>Tanggal Masuk</th>
			<th>Status</th>
			<th>Total</th>
			<th>Action</th>
		</tr>
        <?php $i=1; foreach ($pesanan as $item): ?>
		<tr <?php echo $i%2 == 0 ? 'class="bg"' : '';  ?>>
		    <td><?php echo $i; ?>
		    <td><?php echo $item['order_no']; ?></td>
		    <td><?php echo $item['membercard']; ?></td>
		    <td><?php echo $item['nama_depan'].' '.$item['nama_belakang']; ?></td>
		    <td><?php echo $item['tanggal_masuk']; ?></td>
		    <td><?php echo $item['status_order_text']; ?></td>
		    <?php //foreach($item['detail'] as $detail): ?>
		    <td>Rp. <?php echo $this->cart->format_number($item['total_biaya']); ?><?php //endforeach; ?></td>
		    <td><?php echo anchor(uri_string().'/detail/'.$item['id_order'], 'Detail', 'class="active" id="detail"') ?></td>
		</tr>
        <?php $i++; endforeach; ?>
	<tr><td><?php  echo $this->pagination->create_links(); ?></td></tr>
	</table>
<?php else: ?>
    <p class="msg info">Belum ada Pesanan</p>
<?php endif; ?>
<script type="text/javascript">
jQuery(function($) {
	$(".active").colorbox({
		width:"500", height:"500", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>