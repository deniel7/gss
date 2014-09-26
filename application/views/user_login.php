<?php if($this->session->flashdata('pesan')): ?>
    <?php //echo $this->session->flashdata('pesan'); ?>
<?php else:?>
 
    <div class="row">
        <div class="span12">
        <?php echo form_fieldset('LOGIN'); ?>
        <?php if(@$error){echo @$error;} ?>
        <?php echo validation_errors(); ?>
        </div>
        <br />
    
        <div class="span12" style="text-align: center">
        
        <?php echo form_open(site_url(uri_string()),'class="order"'); ?>
        
	<?php echo form_dropdown('store_site_code',$site_master); ?>
        <br/>
        <?php echo form_input(array(
					'id' => 'user_id',
                                        'name' => 'user_id',
					'placeholder' => 'Gold User ID',
                                        'class' => 'form-control input-lg',
					'onclick' => 'if(this.value == \'userId\') this.value = \'\'', //IE6 IE7 IE8
					'onblur' => 'if(this.value == \'\') this.value = \'userId\''       //IE6 IE7 IE8
			)); ?>
			<br/>
			<?php echo form_password(array(
                                        'id' => 'password',
					'name' => 'password',
					'placeholder' => 'password',
					'onclick' => 'if(this.value == \'user_password\') this.value = \'\'', //IE6 IE7 IE8
					'onblur' => 'if(this.value == \'\') this.value = \'user_password\''       //IE6 IE7 IE8
			)); ?>
			
			<br/>
			
			<?php echo form_submit(array(
					'name' => 'login',
					'value' => 'Login',
					'class' => 'btn btn-success',
			)); ?>
        
        <br/>
        <?php echo form_close(); ?>
        <?php echo form_fieldset_close(); ?>
        </div>
        
    </div>
    
<?php endif ?>