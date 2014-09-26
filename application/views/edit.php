<?php if(@$sukses):?>
    <?php echo $sukses; ?>
    Anda bisa login <a href="<?php echo site_url('user/login'); ?>">di sini.</a>
<?php else: ?>
    <h2>Edit Akun Pengguna</h2>
    <?php if(@$error){echo @$error;} ?>
    <?php echo validation_errors(); ?>
    <br />
    <?php echo form_open(site_url(uri_string()),'class="order"'); ?>
    <?php echo form_label('Username'); ?>
    <?php echo form_input('username',$username); ?>
    <?php echo form_label('E-mail'); ?>
    <?php echo form_input('email',$email); ?>
    <?php echo form_label('Password Baru'); ?>
    <?php echo form_password('new_password'); ?>
    <?php echo form_label('Confirm Password'); ?>
    <?php echo form_password('conf_password'); ?>
    
    <p style="float: left">
    <?php echo form_submit('submit','Update'); ?></p>
    <p style="float: left; margin-left: 50px">
    <?php echo anchor(site_url('store'),'Cancel') ?></p>
    <?php echo form_close(); ?>
    <br />
<?php endif ?>