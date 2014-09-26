<h1><?php echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right"></ul>
</div>
<?php
if(@$error){
	echo @$error;
	echo"<br/>";
	echo form_button('back','Back',$js = 'onClick="history.go(-1)"');
}else if(@$sukses){ 

echo @$sukses; ?>
<h3 class="tit">Import Produk</h3>
<?php echo form_fieldset('Produk'); ?>
<?php echo form_open_multipart('admin/import/finish_process');?>

<p>Klik Tombol dibawah ini untuk menyelesaikan proses import :</p>
<input type="submit" value="Selesai" />
<br/>
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>

<?php } ?>