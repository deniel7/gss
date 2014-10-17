<head>
<script src="<?php echo base_url();?>template/palmtree/datatables/media/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>template/palmtree/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>

<style type="text/css">
            @import "<?php echo base_url();?>template/palmtree/datatables/media/css/demo_table_jui.css";
            @import "<?php echo base_url();?>template/palmtree/datatables/media/themes/smoothness/jquery-ui-1.8.4.custom.css";
</style>

<script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[0, "desc"]],
                    "bJQueryUI":true
                });
            })
            
</script>

</head>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
		    <h1 class="page-header">Print Orders</h1>
		<?php 
		if (@$sukses) {
		    echo '<p class="msg done">'.@$sukses.'</p>';
		    ?>
		    <script type="text/javascript">
		    (function($) {
			$(function() {
				parent.jQuery.colorbox.close();
				return false;
			});
		    })(jQuery);
		    </script>
		    <?php 
		}else{
		    echo validation_errors();
		    //echo form_fieldset('Print Delivery Order','class="produk"');
		    echo '<div class="col-left">';
		    echo form_open(site_url(uri_string()).'/print_do/');
		    echo form_label('Input your Nomor Tranasksi');
		    echo form_input('order_no',@$id,'class="form-control"','placeholder="Nomor Order"');
		    //echo form_hidden('cabang',$cabang);
		    echo form_submit('submit','Input','class="input-submit"');
		    echo form_close();
		    echo '</div>';  
		    echo form_fieldset_close();
		    
		}
		?>
		</div>
	    </div>
	    <br/>
	    <div class="row">
                <div class="col-lg-12">
		    
		    <table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
		    <thead>
		    <tr>
		      <td>Nomor Transaksi</td>
		      <td>Cabang</td>
		      <td>Waktu</td>
		      <td>Total</td>
		      <td>SPV</td>
		      <td>No. Struk</td>
		      <td>Status</td>
		    </thead>
		    <tbody>
		    <?php if($pesanan!= array()): ?>
			    <?php foreach ($pesanan as $item): ?>
				    <tr>
					<td><?php echo $item->ORDER_NO_GTRON; ?></td>
					<td><?php echo $item->SITE_STORE_CODE; ?></td>
					<td><?php echo $item->tanggal_masuk; ?></td>
					<td>Rp. <?php echo $this->cart->format_number($item->total_biaya); ?></td>
					<td><?php echo $item->USERNAME; ?></td>
					<td><?php echo $item->no_struk; ?></td>
					<td>
					    
					    <?php
					    
						    switch($item->FLAG) {
						    
						    
					    
						    case '5':
						    $item->FLAG = '<div style="color:red;">Ready to Print!</div>';
						    continue;
					    
						    case '6':
						    $item->FLAG = '<div style="color:green;">on Delivery</div>';
						    continue;
					    
						    
						    }          
					    echo $item->FLAG;
					    ?>
					
					</td>
					
				    </tr>
			    <?php endforeach; ?>
			    
		    <?php else: ?>
			<p class="bg-info">Belum ada Pesanan</p>
		    <?php endif; ?>
		    
		    </tbody>
		    
		    </table>
		    
		</div>
	    </div>
</div>