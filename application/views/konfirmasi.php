<head>
<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/functions.js"></script>
</head>
<?php if(@$sukses):?>
    <?php echo $sukses; ?>
<?php else: ?>
    <h2>Form Konfirmasi Pembayaran</h2>
    <?php if(@$error){echo @$error;} ?>
    <?php echo validation_errors(); ?>
    <br />
    <?php echo form_open(site_url(uri_string()),'class="order"'); ?>
    
    <?php echo form_label('Nomor Order'); ?>
    <?php echo form_input('order_no',set_value('order_no')); ?>
    
    <?php echo form_fieldset('Transfer Bank'); ?>
    <div style="float:right">
    <?php echo form_label('Tanggal Transfer'); ?>
    
    <div class="main-wrapper">

                <div><input id="datepicker-example1" name="tanggal"></div>
            
            <br><br><br>

        </div>
    </div>
    <?php echo form_label('Nama'); ?>
    <?php echo form_input('nama',set_value('nama')); ?>
    <?php echo form_label('Dari Rekening'); ?>
    <?php echo form_input('dari_rekening',set_value('dari_rekening')); ?>
    <?php echo form_label('No Rekening'); ?>
    <?php echo form_input('norek',set_value('norek')); ?>
    <?php echo form_label('Nominal'); ?>
    <?php echo form_input('nominal',set_value('nominal')); ?>
    <?php echo form_label('Rekening Tujuan'); ?>
    <?php
            //echo form_dropdown('rekening_tujuan',array('BCA','MANDIRI'));
            $select = array('-Silahkan Pilih-','BCA','MANDIRI');
            echo form_dropdown('rekening_tujuan',$select);
    ?>
    <br/><br/>
    <?php echo form_fieldset_close(); ?>
    <?php echo form_hidden('email',$email); ?>
    
    <?php echo form_submit('submit','Kirim'); ?>
    <?php echo form_close(); ?>
    <br />
    <?php //echo site_url(uri_string()); ?>
<?php endif ?>