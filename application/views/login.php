<?php if($this->session->flashdata('pesan')): ?>
    <?php echo $this->session->flashdata('pesan'); ?>
<?php else:?>
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">DC Administrator</h3>
                    </div>
                    <div class="panel-body">
                        
                            <fieldset>
                                <div class="form-group">
				<?php 
					
					echo form_open('login');
					
					//echo form_dropdown('dc_site_code',$dc_site_code);
					
					echo form_input(array(
						'id' => 'user_id',
						'name' => 'user_id',
						'placeholder' => 'NIK',
						'class' => 'form-control'
						
					));

				?>
				</div>
				
				<div class="form-group">
				<?php
					echo form_password(array(
					'id' => 'password',
                                        'name' => 'password',
					'placeholder' => 'Password',
                                        'class' => 'form-control'
					)); 
					
				?>
				</div>
				
				<?php
					
					echo form_submit(array(
					'value' => 'Login',
                                        'id' =>'submit',
					'name' => 'submit',
                                        'class' => 'btn btn-lg btn-success btn-block'
					));
					
					echo form_close();
				?>
				
                            </fieldset>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>