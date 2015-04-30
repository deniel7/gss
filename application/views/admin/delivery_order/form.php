<script type="text/javascript">
	    $(document).ready(
		    function() {
			
			setInterval(loaded2, 3000);
			
			loaded2();
			
		    }
		    
		    
		    
		    );
	    
	    function get_id(){
			
			//alert(p);
			
		    } 
	    
	    function loaded2() {
		//alert('hit');
		if ($('#c_pesanan').length > 0)
		{
		$.ajax({
			type: 'POST',                        
			url: '<?php echo site_url('admin/refresh'); ?>',
			dataType: 'json',
			
			async : false,
			success:function(res){
			  $('#c_pesanan').html(
					res.result);
			  $('#c_gold_proses').html(
					res.result2);
			  $('#c_print_do').html(
					res.result3);
			  $('#c_receiving').html(
					res.result4);
			  //setTimeout(loaded2,2000);
			},
			error:function(res){
			    alert(JSON.stringify(res));
			    //setTimeout(loaded2,5000);
			}
		    });
		}
		
	    }
	    
	    
	    
	    
	</script>



<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
		    <h1 class="page-header">Print Delivery Order</h1>
		    <?php
		    
		    if (@$sukses) {
		    echo '<p class="msg done">'.@$sukses.'</p>';
		    }
		    ?>
		    
		</div>
	    </div>
	    <br/>
	    <div class="row">
                <div class="col-lg-12">
		    
		    <table id="datatables" class="table table-striped table-bordered table-hover">
		    <thead>
		    <tr>
		      <td>Nomor Transaksi</td>
		      <td>Cabang</td>
		      <td>Waktu</td>
		      <td>Waktu Pengiriman</td>
		     <!-- <td>Total</td>-->
		      <td>Nama SC</td>
		      <td>No. Struk</td>
		      <td>Print Status</td>
		      <td>Action</td>
		      
		    </thead>
		    <tbody>
		    <?php if($pesanan!= array()): ?>
			    <?php foreach ($pesanan as $item): ?>
				    <tr>
					<td>
					
					    <?php echo $item->ORDER_NO_GTRON; ?>
					    
					    <?php
						    $print = $item->PRINT_STATUS;
						    
						    if($print == 0){
							echo"
							<p class='btn btn-danger btn-sm' style='font-size:9px; text-align:right'>
							<i class='fa fa-exclamation-circle fa-fw'></i>New
							</p";
							
						    }
					    
					    ?>
					
					</td>
					<td><?php echo $item->SITE_STORE_CODE; ?></td>
					<td><?php echo $item->tanggal_masuk; ?></td>
					<td>
					    <?php
						    echo $item->ORDER_DELIVERY_DATE;
						    
						    if($item->ORDER_DELIVERY_DATE == date('Y-m-d')){
						    
						    echo"
							<p class='btn btn-warning btn-sm' style='font-size:9px; text-align:right'>
							<i class='fa fa-exclamation-circle fa-fw'></i>Today!
							</p";
						    }
					    ?>
					</td>
					<!--<td>Rp. <?php //echo $this->cart->format_number($item->total_biaya); ?></td>-->
					<td><?php echo $item->USERNAME; ?></td>
					<td><?php echo $item->no_struk; ?></td>
					<td>
					    
					</td>
					<td>
					    
					    <input type="hidden" id="id_order_<?php echo $item->id_order; ?>" value="<?php echo $item->id_order; ?>" />
					    <button type="button" class="btn btn-info btn-sm" id="btn_print_<?php echo $item->id_order; ?>">
						<i class="fa fa-print fa-fw"></i>Print
					      </button>
					      <form id="upd_<?php echo $item->id_order; ?>" method="post" action="<?php echo site_url(uri_string()).'/print_do/'; ?>">
						<?php
				      
						    echo form_hidden('orderno',$item->ORDER_NO_GTRON);
						    echo form_hidden('store_sc',$item->STORE_SITE_CODE);
						    echo form_hidden('id_order',$item->id_order);
						?>
					      </form>
					</td>
					<script>
					    $("#btn_print_<?php echo $item->id_order; ?>").click(function(){
						var id_order = $(this).attr("id").split("_")[2];
						var x = confirm("Want to print Delivery Order for this transaction?");
						if (x) {
						    $("#upd_"+id_order).submit();
						}
					    });
					</script>
				    </tr>
			    
			    
			    
			    <!-- Modal -->
			    <div class="modal fade" id="myModal<?php echo $item->id_order; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			      <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				    <h4 class="modal-title">Want to print Delivery Order for this transaction?</h4>
				  </div>
				  <div class="modal-body">
				  <div class="row-fluid">
				  Nomor Transaksi : <b><?php echo $item->ORDER_NO_GTRON; ?></b>
				  <form action="<?php echo site_url(uri_string()).'/print_do/'; ?>" method="POST">
				  
				  <?php
				      
				      echo form_hidden('orderno',$item->ORDER_NO_GTRON);
				      echo form_hidden('store_sc',$item->STORE_SITE_CODE);
				      echo form_hidden('id_order',$item->id_order);
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
			    
			    
			    <div class="modal fade" style="width: 100px;" id="myModals" tabindex="-1" role="dialog" aria-labelledby="comment-label" aria-hidden="true">
				<h1>Hello</h1>
			    </div> 
			    
			    
			    
		    <?php else: ?>
			<p class="bg-info btn-lg" style="text-align: center">Belum ada Data Print Delivery Order</p>
		    <?php endif; ?>
		    
		    </tbody>
		    
		    </table>
		    
		</div>
	    </div>
</div>

