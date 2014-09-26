<h2>Profil Pengguna</h2>
<p>Data yang anda isikan akan digunakan sebagai alamat pengiriman pesanan.</p>
<?php if(@$sukses){echo @$sukses;} ?>
<?php echo validation_errors(); ?>
<br />
<?php echo form_open(site_url(uri_string()),'class="order"'); ?>
<?php echo form_label('Nama Depan'); ?>
<?php echo form_input('nama_depan',$nama_depan); ?>
<?php echo form_label('Nama Belakang'); ?>
<?php echo form_input('nama_belakang',$nama_belakang); ?>
<?php echo form_label('Alamat'); ?>
<?php echo form_textarea('alamat',$alamat,'style="width:400px;height:150px;"'); ?>
<?php echo form_label('Kode Pos'); ?>
<?php echo form_input('kode_pos',$kode_pos); ?>
<?php echo form_label('Telephone'); ?>
<?php echo form_input('phone',$phone); ?>

<p style="float: left">
<?php echo form_submit('submit','Simpan'); ?></p>
<p style="float: left; margin-left: 50px">
<?php echo anchor(site_url('store'),'Cancel') ?></p>
<?php echo form_close(); ?>
