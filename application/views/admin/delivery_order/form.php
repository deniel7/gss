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
		    <h1 class="page-header">Print Delivery Order</h1>
		
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
					
					<td><a data-toggle="modal" href="#myModal" class="btn btn-info btn"><i class="fa fa-print fa-fw"></i>Print</a></td>
					
				    </tr>
			    
			    
			    
			    <!-- Modal -->
			    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			      <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				    <h4 class="modal-title">Print Order</h4>
				  </div>
				  <div class="modal-body">
				  <div class="row-fluid">
				  Nomor Transaksi : <b><?php echo $item->ORDER_NO_GTRON; ?></b>
				  <form action="<?php echo site_url(uri_string()).'/print_do/'; ?>" method="POST">
				  
				  <?php
				      
				      echo form_hidden('orderno',$item->ORDER_NO_GTRON);
				      echo form_hidden('store_sc',$item->STORE_SITE_CODE);
				  ?>
				  </div>
				  </div>
				  <div class="modal-footer">
				    
				    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
				    <?php echo form_submit('submit', 'Yes','class = "btn btn-success"'); ?>
				    
				    <?php echo form_close(); ?>
				  </div>
				</div><!-- /.modal-content -->
			      </div><!-- /.modal-dialog -->
			    </div><!-- /.modal -->
			    
			    
			    
			    
			    
			    
			    <?php endforeach; ?>
			    
		    <?php else: ?>
			<p class="bg-info btn-lg" style="text-align: center">Belum ada Data Print Delivery Order</p>
		    <?php endif; ?>
		    
		    </tbody>
		    
		    </table>
		    
		</div>
	    </div>
</div>

