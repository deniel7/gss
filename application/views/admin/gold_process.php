<div id="page-wrapper">
            <?php //if($multiuser == 0){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GOLD Process</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-shopping-cart fa-fw"></i> All Orders
                           
                        </div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        			<table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
				  <td>Nomor Transaksi</td>
                                  <td>No PO</td>
                                  <td>DN No.</td>
                                  <td>REC No.</td>
				  <td>Cabang</td>
				  <td>Waktu Transaksi</td>
				  <td>Total</td>
				  
				  <td>No. Struk</td>
				  
				</thead>
				<tbody>
				<?php if($pesanan!= array()): ?>
					<?php foreach ($pesanan as $item): ?>
						<tr>
						    <td><?php echo $item->ORDER_NO_GTRON; ?></td>
						    <td><?php echo $item->ORDER_NO_GOLD; ?></td>
                                                    <td><?php echo $item->DN_NO; ?></td>
                                                    <td><?php echo $item->REC_NO; ?></td>
                                                    <td><?php echo $item->SITE_STORE_CODE; ?></td>
						    <td><?php echo $item->tanggal_masuk; ?></td>
						    <td>Rp. <?php echo $this->cart->format_number($item->total_biaya); ?></td>
						    
						    <td><?php echo $item->no_struk; ?></td>
						    
						    
						</tr>
					<?php endforeach; ?>
					
				<?php else: ?>
				    <p class="msg info">Belum ada Pesanan</p>
				<?php endif; ?>
				
				</tbody>
				
			</table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <?php //} ?>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                </div>
                
                    