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
<?php $orderno = $data['ORDER_NO_GTRON']; ?>

<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Order No :</td>
    <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
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
        <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
        <td><?php echo $data['tanggal_masuk']; ?></td>
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
        <td><?php echo $detail['ARTICLE_DESC']; ?></td>
        <td><?php echo $detail['kuantitas']; ?></td>
        <td>Rp. <?php echo $this->cart->format_number($detail['subtotal']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>


<br/>
<div>

<?php if ($data['FLAG'] == 0){ ?>
<div class="responsive">
            
            <div class="text-center">
            <button class="demo btn btn-primary btn-lg" data-toggle="modal" href="#responsive">Submit Pesanan</button>
	    <button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#responsive2">Cancel Pesanan</button>
            </div>
</div>

<?php
    }
    endforeach;
?>
<div id="responsive" class="modal fade" tabindex="-1" data-width="160" style="display: none;">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <?php //echo form_open('pesanan/submit_pesanan'); ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Submit Pesanan</h4>
    </div>
    <div class="modal-body">
    <div class="row">
    <div class="span4">
    <!--<h4>Bukti Pembayaran Transaksi</h4>-->
    <p>
    <?php
	
	echo form_hidden('orderno',$orderno);
	
	echo form_input(array(
					'id' => 'nomor',
                                        'name' => 'nomor',
					'placeholder' => 'Nomor Struk Pembayaran',
                                        'class' => 'form-control input-lg'
			)); 
	
    ?>
    </p>
    <!--<p><input class="form-control" type="text"></p>-->
    
    </div>
    
    </div>
    </div>
    <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
    <!--<button type="button" class="btn btn-primary">Submit</button>-->
    <?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
</div>


</div>

<style>
table { border: solid 1px gray; width: 100%; margin: 0 auto;}
th { text-align: center; background-color: black; color: white;}
td { border: solid 1px silver; padding: 5px;}
.col {width: 50%; float: left;}
.clear {clear: both;}
</style>

<?php endif; ?>