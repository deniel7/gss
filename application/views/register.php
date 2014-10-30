<head>
	<script src="<?php echo base_url();?>asset/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>asset/js/scripts.js"></script>
	<style type="text/css">
	    #register {
		margin-left:80px;	
	    }
	    
	    
	    #result{
		    margin-left:1px;
	    }
	    
	    #register .short{
		    color:#FF0000;
	    }
	    
	    #register .weak{
		    color:#E66C2C;
	    }
	    
	    #register .good{
		    color:#2D98F3;
	    }
	    
	    #register .strong{
		    color:#006400;
	    }
       </style>    
</head>
<?php if(@$sukses):?>
    <?php echo $sukses; ?>
    <br/><br/>
    Anda bisa melakukan <?php echo anchor(site_url('user/login'),'<span class="btn btn-small btn-success">Login</span>') ?>
	<br/><br/> <br/><br/> <br/><br/> <br/><br/><br/>
    

<?php else: ?>
    <div class="row">
	<div class="span12">
	<?php echo form_fieldset('REGISTRASI'); ?>
        </div>
	<div class="span12" style="text-align: center">
		
		<br/>
		
		<?php if(@$error){echo @$error;} ?>
		<?php echo validation_errors(); ?>
		<br />
		
		
		<?php echo form_open(site_url(uri_string()),'class="order" id="register"'); ?>
		<?php echo form_dropdown('store_site_code',$site_master); ?>
		<br/>
		<?php echo form_input(array(
						    'name' => 'userId',
						    'id' => 'userId',
						    'placeholder' => 'NIK',
						    'value'       => $userId	,
						    'class' => 'form-control input-lg'
				    )); ?>
		<br/>
		<?php echo form_input(array(
						    'name' => 'username',
						    'id' =>'username',
						    'placeholder' => 'Username',
						    'value'       => $username,
						    'class' => 'form-control input-lg'
				    )); ?>
		
		<br/>
		    <span id="result"></span>
		    <br/>
		<?php echo form_password(array('name' => 'password','id' =>'password','value'=>set_value('password'),'placeholder' => 'Password')); ?>
	    
		<br/>
		<?php echo form_password(array('name' => 'conf_password','id' =>'conf_password','value'=>set_value('conf_password'),'placeholder' => 'Confirm Password')); ?>
		<br/>
		<?php echo form_submit('submit','Register'); ?>
		<?php echo form_close(); ?>
		<?php echo form_fieldset_close(); ?>
		<br />
	    <?php endif ?>
	</div>
    </div>