<div id="page-wrapper">
            <?php if($multiuser == 0){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Stok Riil vs Virtual</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
			<div class="col-lg-12">
			<?php echo form_open(site_url('admin/dashboard/virturiil')); ?>
			<p>Lokasi DC : <?php echo form_dropdown('dc_site_code',array('dc' => 'DC Pusat')); ?>
			
			</p>
			
                        
			<?php echo form_submit(array('name' => 'submit','value'=>'Go', 'class' => 'btn btn-large btn-primary' )); ?>
                       
			</div>
			<?php echo form_close(); ?>
	    <!-- /.table-responsive -->
	    </div>
	<!-- /.col-lg-4 (nested) -->
	<?php } ?>
	<!-- /.col-lg-8 (nested) -->
</div>
                            <!-- /.row -->
                       
                       
                
                    