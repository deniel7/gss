<?php if(@$sukses):?>
    <?php echo '<p class="msg done">'.@$sukses.'</p>';?>
    <script type="text/javascript">
    (function($) {
    	$(function() {
    		parent.jQuery.colorbox.close();
    		return false;
    	});
    })(jQuery);
    </script>
<?php else: ?>

<div class="col">

<?php foreach($detail as $data): ?>

<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Order No :</td>
    <td><?php echo $data['order_no']; ?></td>
</tr>
</table>
</div>

<div class="clear"></div>
<br />

<div class="col">
<b>Data Konsumen :</b>
<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Nama </td><td><?php echo $data['nama_depan'].' '.$data['nama_belakang']; ?></td>
</tr>
<tr>
    <td>Alamat</td><td><?php echo $data['alamat']; ?></td>
</tr>
<tr>
    <td>Kode Pos</td><td><?php echo $data['kode_pos']; ?></td>
</tr>
<tr>
    <td>Telepon</td><td><?php echo $data['phone']; ?></td>
</tr>
</table>
</div>
<div class="clear"></div>
<br />
<b>Detail Pesanan :</b>
<table cellspacing="0" cellpadding="3px">
    <tr>
        <th>Order No</th>
        <th>Tanggal Belanja</th>
        <th>Jumlah Item</th>
        <th>Total Belanja</th>
    </tr>

    <tr>
        <td><?php echo $data['order_no']; ?></td>
        <td><?php echo date("d/m/Y - H:i",strtotime($data['tanggal_masuk'])); ?></td>
        <td><?php echo $data['total_item']; ?></td>
        <td> Rp. <?php echo $this->cart->format_number($data['total_biaya']); ?></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><b>Rincian :: </b></td>
    </tr>
    <?php foreach($data['detail'] as $detail): ?>
    <tr>
        <td></td>
        <td><?php echo $detail['nama_produk']; ?></td>
        <td><?php echo $detail['kuantitas']; ?></td>
        <td>Rp. <?php echo $this->cart->format_number($detail['subtotal']); ?></td>
    </tr>
    
    <?php endforeach; ?>
    <tr>
	<td></td>
        <td></td>
        <td>Handling Fee</td>
        <td>Rp. <?php echo $this->cart->format_number($biaya); ?></td>
    </tr>
</table>
<?php endforeach; ?>

<br/>
<div class="col">

<!--<form action="<?php //echo site_url(uri_string()); ?>" method="POST">-->
<?php 


//echo form_submit('submit','Add to Cart');
?>
<?php echo form_button('back','Kembali',$js = 'onClick="history.go(-1)"');	?>
</form>
</div>

<style>
table { border: solid 1px gray; width: 100%; margin: 0 auto;}
th { text-align: center; background-color: black; color: white;}
td { border: solid 1px silver; padding: 5px;}
.col {width: 50%; float: left;}
.clear {clear: both;}
</style>

<?php endif; ?>