
<div id="page-wrapper">

<div class="col-lg-10">
	<?php foreach ($detail as $item): ?>
	<h1><?php echo $item->ARTICLE_DESC; ?></h1>
		
		
		
		
		
	
	
</div>
<div class="col-lg-6">
	<div class="panel-body">
		<div class="table-responsive">
		    <table class="table table-striped table-bordered table-hover">
			
			<tbody>
			    <tr>
				<td>Article Code</td>
				<td><?php echo $item->ARTICLE_CODE; ?></td>
				
			    </tr>
			    <tr>
				<td>CLASS DESC</td>
				<td><?php echo $item->CLASS_DESC; ?></td>
				
			    </tr>
			    <tr>
				<td>ATTRIB DESC</td>
				<td><?php echo $item->ATTRIB_DESC; ?></td>
			    </tr>
			    
			</tbody>
		    </table>
		</div>
		<!-- /.table-responsive -->
	</div>
</div>

<div class="col-lg-6"><?php //echo site_url(uri_string()); ?>
	<div class="panel-body">
		
	<?php if($item->IMG1){ ?>
	<img src="<?php echo base_url().'asset/themes/images/products/'.$item->IMG1; ?>">
	
	<?php }else{ ?>
	
	<a data-toggle="modal" href="#myUpload" class="btn btn-large btn-info"><i class="fa fa-upload"></i> Upload Picture</a>
	<?php } ?>
	</div>
</div>


<!-- Modal -->
  <div class="modal fade" id="myUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Processing Order</h4>
        </div>
        <div class="modal-body">
        
	<?php
                    //$komplemen = array('id'=>'addForm', 'name'=>'addForm');
		    echo form_open_multipart(site_url(uri_string()));
		    
		    
	       ?>
		
		    
		    <div class="row">
		    
                    <div class="col-lg-6"><input type="file" name="userfile" id="userfile" size="20" /></div>
		    </div>

               
	       
	
	<!--<form action="<?php //echo site_url(uri_string()); ?>" method="POST">-->
	<?php
	   echo form_input('ARTICLE_CODE', $item->ARTICLE_CODE);
	?>
	</div>
        <div class="modal-footer">
	  <?php //echo form_submit('submit', 'Yes','class = "btn btn-primary"'); ?>
	  <input type="submit" value="upload" name="do_upload" class="btn btn-primary" />
	  <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
          <?php echo form_close(); ?>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  <?php endforeach; ?>