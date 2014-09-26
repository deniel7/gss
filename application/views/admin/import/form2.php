<h1><?php echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right"></ul>
</div>
<?php if(@$error){echo @$error;} ?>

<h3 class="tit">Import Produk</h3>
<?php echo form_fieldset('Produk'); ?>
<?php echo form_open_multipart('admin/import/import_produk');?>
<ul>
	<li>Download file dan simpan di komputer Anda :
		<a href="http://172.16.9.58/ygecom/download/product.xls">Download Produk</a>
	</li>
	
	<br/><br/>
	
	
	<li>
		Pilih file yang sudah Anda download :<br/><br/>
		<input type="file" id="file_upload" name="userfile" size="20" />
	</li>
	
	<br/><br/><br/>
	
	<li>
		<li><?php echo form_submit('submit', 'Submit','style = "width:120px; height:40px"'); ?></li>
	</li>
</ul>
<br/>
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
