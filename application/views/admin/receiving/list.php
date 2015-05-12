<head>

<script>
	    $(document).ready(
		    function() {
			
			setInterval(loaded2, 3000);
			
			loaded2();
		    });
	    
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

</head>

<div id="page-wrapper">

	<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Konfirmasi DO</h1>
                </div>
                <!-- /.col-lg-12 -->
        </div>
	
	<div class="row">
                <div class="col-lg-12">
			
		
		
		
		
		<table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
<thead>
<tr>
  <td>Nomor Transaksi</td>
  <td>Cabang</td>
  <td>Waktu Booking</td>
  <td>Waktu Kirim</td>
  <td>Nama SC</td>
  <td>No. Struk</td>
  <td>Konfirmasi File</td>
  <td>Upload DO Date</td>
  <td>Status</td>
</thead>
<tbody>
<?php if($pesanan!= array()): ?>
        <?php foreach ($pesanan as $item): ?>
		<tr>
		    <td><?php echo anchor(uri_string().'/detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
		    <td><?php echo $item->SITE_STORE_CODE; ?></td>
		    <td><?php echo $item->tanggal_masuk; ?></td>
		    <td><?php echo $item->ORDER_DELIVERY_DATE; ?></td>
		    <td><?php echo $item->USERNAME; ?></td>
		    <td><?php echo $item->no_struk; ?></td>
		    <td>
			<?php if ($item->RECEIVING_DN): ?>
			<p style="color:green">Received</p>
			<?php endif; ?>
		    </td>
		    <td><?php echo $item->receiving_dn_time; ?></td>
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
	</div>
</div>