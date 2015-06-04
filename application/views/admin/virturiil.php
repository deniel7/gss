<head>

<script>
	    
	    
	    
	</script>

</head>

<div id="page-wrapper">

	<div class="row">
                <div class="col-lg-12">
			
			
			
                    <h1 class="page-header"><?php echo $cabang; echo anchor(site_url('admin/dashboard/comp_stok'),'<span class="btn btn-large btn-info pull-right"><i class="fa fa-arrow-circle-left fa-fw"></i> Back</span>') ?></h1>
		    
                </div>
                <!-- /.col-lg-12 -->
        </div>
	
	<div class="row">
                <div class="col-lg-12">
			
			<table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
				  <td>Article Code</td>
				  <td>PLU</td>
				  <td>Article Desc</td>
				  <td>Stok Riil</td>
				  <td>Stok Virtual</td>
				</thead>
				<tbody>
				<?php if($stok!= array()): ?>
					<?php foreach ($stok as $item): ?>
						<tr>
						    <td><?php echo $item->ARTICLE_CODE; ?></td>
						    <td><?php echo $item->PLU; ?></td>
						    <td><?php echo $item->ARTICLE_DESC; ?></td>
						    <td><?php echo $item->STOCK_QTY; ?></td>
						    
						    <?php
							    $stok = $item->STOCK_QTY;
							    $booked = $item->BOOK_QTY;
							    $confirm = $item->CONFIRM_QTY;
							    
							    $stock = $stok - $booked - $confirm;
							
							?>
						    
						    <td><?php echo $stock; ?></td>
						</tr>
					<?php endforeach; ?>
					
				<?php else: ?>
				    <p class="msg info">Belum ada Pesanan</p>
				<?php endif; ?>
				
				</tbody>
				
			</table>
		
		
		
	
		</div>
	</div>
</div>