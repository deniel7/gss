<div id="page-wrapper">
            <?php if($multiuser == 0){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
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
                                  <!--<td>Cost Price Value</td>-->
				  <td>Nominal Struk</td>
				  <td>SPV</td>
				  <td>No. Struk</td>
                                  <td>Konfirmasi File</td>
				  <td>Status</td>
				</thead>
				<tbody>
				<?php if($pesanan!= array()): ?>
					<?php foreach ($pesanan as $item): ?>
						<tr>
						    <td><?php echo anchor(uri_string().'/pesanan/detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
						    <td><?php echo $item->ORDER_NO_GOLD; ?></td>
                                                    <td><?php echo $item->DN_NO; ?></td>
                                                    <td><?php echo $item->REC_NO; ?></td>
                                                    <td><?php echo $item->SITE_STORE_CODE; ?></td>
						    <td><?php echo $item->tanggal_masuk; ?></td>
						    <td><?php if($item->TOTAL_BIAYA_INPUT){ echo "Rp. ".$item->TOTAL_BIAYA_INPUT; } ?></td>
						    <td><?php echo $item->USERNAME; ?></td>
						    <td><?php echo $item->no_struk; ?></td>
                                                    <td>
                                                            <?php if ($item->RECEIVING_DN): ?>
                                                            <p style="color:green">Received</p>
                                                            <?php endif; ?>
                                                    <td>
							
							<?php
							
								switch($item->FLAG) {
								
								case '0':
								$item->FLAG = '<div style="color:red;">Booked</div>';
								continue;
								
								case '1':
								$item->FLAG = '<div style="color:orange;">Confirmed</div>';
								continue;
								
								case '2':
								$item->FLAG = '<div style="color:blue;">Picking List Submited</div>';
								continue;
								
								case '3':
								$item->FLAG = '<div style="color:purple;">on Progress Gold</div>';
								continue;
								
								case '4':
								$item->FLAG = '<div style="color:silver;">Cancel</div>';
								continue;
							
								case '5':
								$item->FLAG = '<div style="color:chocolate;">Shipment Gold</div>';
								continue;
							
								case '6':
								$item->FLAG = '<div style="color:green;">on Delivery</div>';
								continue;
							
								case '7':
								$item->FLAG = '<div style="color:pink;">Receiving Gold</div>';
								continue;
							
								case '8':
								$item->FLAG = '<div style="color:black;">Gold Error!</div>';
								continue;
						    
								}          
							echo $item->FLAG;
							?>
						    
						    </td>
						    
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
                                <?php } ?>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                </div>
                
                    