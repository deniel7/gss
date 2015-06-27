<div id="page-wrapper">
            <?php if($multiuser == 0){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Riwayat Pembeli</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    
                    
                        
                        <!-- /.panel-heading -->
                        
                        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                        <table id="datatables" class="table table-striped table-bordered table-hover col-lg-12">
				<thead>
				<tr>
				  <td>Nomor Transaksi</th>
                                  <th>Nama Depan</th>
                                  <th>Nama belakang</th>
                                  <th>Alamat</th>
				  <th>Telepon</th>
				  <th>Cabang</th>
				  <th>Tanggal Transaksi</th>
				  <th>Tanggal Kirim</th>
				  <th>Nominal Struk</th>
				  
				</thead>
				<tbody>
				<?php if($pesanan!= array()): ?>
					<?php foreach ($pesanan as $item): ?>
						<tr>
						    <td><?php echo anchor(base_url().'admin/ho/dashboard_detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
						    <td><?php echo $item->nama_depan; ?></td>
                                                    <td><?php echo $item->nama_belakang; ?></td>
                                                    <td><?php echo $item->alamat; ?></td>
                                                    <td><?php echo $item->telepon; ?></td>
						    <td><?php echo $item->SITE_STORE_CODE; ?></td>
						    <td><?php echo $item->tanggal_masuk; ?></td>
						    <td><?php echo $item->ORDER_DELIVERY_DATE; ?></td>
						    <td><?php echo $item->TOTAL_BIAYA_INPUT; ?></td>
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
                
                    