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

<?php if (!$logged_in): ?>
    <div class="error">Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.</div>
    <br/>
    <div><?php echo anchor(site_url('user/login'),'LOGIN disini') ?></div>
<?php else: ?>



<table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
<thead>
<tr>
  <td>Nomor Transaksi</td>
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
		    <td><?php echo anchor('store/detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
		    <td><?php echo $item->tanggal_masuk; ?></td>
		    <td>Rp. <?php echo $this->cart->format_number($item->total_biaya); ?></td>
		    <td><?php echo $item->USERNAME; ?></td>
		    <td><?php echo $item->no_struk; ?></td>
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
				$item->FLAG = '<div style="color:blue;">on Progress</div>';
				continue;
				
				case '3':
				$item->FLAG = '<div style="color:blue;">on Progress Gold</div>';
				continue;
				
				case '4':
				$item->FLAG = '<div style="color:brown;">Cancel</div>';
				continue;
			      
				case '5':
				$item->FLAG = '<div style="color:blue;">on Progress Shipment</div>';
				continue;
			      
				case '6':
				$item->FLAG = '<div style="color:green;">on Delivery</div>';
				continue;
			      
				case '7':
				$item->FLAG = '<div style="color:magenta;">Transaction Completed</div>';
				continue;
		    
				}          
			echo $item->FLAG;
			?>
		    
		    </td>
		    
		</tr>
        <?php endforeach; ?>
	
<?php else: ?>
    <p class="msg info" color="">Belum ada Pesanan</p>
<?php endif; ?>

</tbody>
<div style="color:#fff"></div>
</table>


<?php endif; ?>
