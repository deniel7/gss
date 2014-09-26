<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/js/development-bundle/jquery-1.8.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/js/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/css" src="<?php echo base_url();?>template/palmtree/js/development-bundle/themes/ui-lightness/jquery.ui.datepicker.css"></script>
<script type="text/javascript">
	$(function(){
		$("#tanggal").datepicker();
	});
</script>

<fieldset style="border:solid thin; background-color:#f4f2f2; border-radius:10px; border-color:#F1F1F1; padding:10px">
		<p>
			<h2>Konfirmasi Pesanan</h2>
				<ol>
					<li>Pastikan seluruh barang pesanan Anda sudah terkirim dan sesuai dengan pesanan Anda</li>
					<li>Periksa kondisi barang pesanan Anda dalam keadaan baik</li>
					<li>Pastikan bahwa Anda memperoleh struk pembelian / List belanja Anda setelah Anda memperoleh barang yang dipesan</li>
					<li>Lakukan Konfirmasi pesanan dengan melakukan tanda tangan pada list Delivery Order / melakukan konfirmasi di dalam website</li>
				</ol>
		</p>
	</fieldset>

<?php if(@$sukses):?>
    <?php
		echo "<br/>";
		echo $sukses;
    ?>
<?php else: ?>
    
    <?php if(@$error){echo @$error;} ?>
    <?php echo validation_errors(); ?>
    <br />
    <?php echo form_open(site_url(uri_string()),'class="order"'); ?>
    
    <?php echo form_fieldset('Konfirmasi Pesanan'); ?>
    <br/>
    
    <?php echo form_label('Nomor Order'); ?>
    <?php echo form_input('order_no'); ?>
    
    <?php echo form_label('Nama Pengirim'); ?>
    <?php echo form_input('nama_pengirim'); ?>
    
    <br/>
    <?php echo form_fieldset_close(); ?>
    <?php echo form_submit('submit','Confirm'); ?>
    <?php echo form_close(); ?>
    <br />
    <?php //echo site_url(uri_string()); ?>
<?php endif ?>