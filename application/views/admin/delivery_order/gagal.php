<?php if($this->session->flashdata('pesan')): ?>
<?php else: ?>

<div id="page-wrapper">
     
     <div class="row">
                <div class="col-lg-12">
		    <h1 class="page-header">SPV Password</h1>
		    <form action="<?php echo site_url().'admin/delivery_order/spv_pass/'; ?>" method="POST">
		    <p>Input SPV Password :</p>
		    <input type="password" name="pass" />
		   
			<!--<input name="button" type="button"  value="PRINT" onClick="PrintContent()" class="btn btn-info btn-lg" />-->
			
			
				<?php echo form_hidden('id_order',$id_order); ?>
				<input type="submit" name="submit" value="Submit" class="btn btn-info btn-sm">
			
		    </form>
		</div>
     </div><br/>
     <?php if(@$error){echo @$error;} ?>
</div>

<?php endif; ?>