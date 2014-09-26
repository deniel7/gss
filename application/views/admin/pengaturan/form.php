<?php if(@$sukses):?>
    <?php
	echo '<p class="msg done">'.@$sukses.'</p>';
    ?>
    
<?php else: ?>
    <?php if(@$error){echo '<p class="msg error">'.@$error.'</p>';} ?>
    <?php
	echo validation_errors();
    ?>
    <br />

<h1><?php echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right">
	   </ul>
</div>
<h3 class="tit">Opsi Situs</h3>
<?php echo form_open(site_url(uri_string()));?>
<?php echo form_label('Handling Fee'); ?>
<?php echo "Rp. ".form_input('biaya',@$biaya); ?>
<?php echo form_submit('submit','Simpan'); ?>
<?php echo form_close(); ?>
<?php echo form_fieldset_close(); ?>
<?php endif ?>