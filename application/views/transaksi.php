<head>
<script src="<?php echo base_url();?>template/palmtree/datatables/media/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>template/palmtree/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href='<?php echo base_url();?>template/palmtree/datatables/media/css/jquery.dataTables.css'>

<script type="text/javascript" charset="utf-8">
            
	    $(document).ready(function(){
                $('#datatables').DataTable({
		    
		    dom: 'T<"clear">lfrtip',
                        tableTools: {
                        "sSwfPath": "<?php echo base_url();?>template/palmtree/datatables/media/swf/copy_csv_xls.swf",
                    
			"aButtons": [
			    
			    {
				"sExtends": "xls",
				"sButtonText": "Save to Excel"
			    },
			    
			]
		    
		    }
		    
                });
            })
            
</script>

<!--DataTable tools-->
<script type="text/javascript" charset="utf8" src='<?php echo base_url();?>template/palmtree/datatables/media/js/dataTables.tableTools.js'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url();?>template/palmtree/datatables/media/css/dataTables.tableTools.css'>


</head>

<?php if (!$logged_in): ?>
    <div class="error">Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.</div>
    <br/>
    <div><?php echo anchor(site_url('user/login'),'LOGIN disini') ?></div>
<?php else: ?>



<table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
<thead>
<tr>
  <th>Nomor Transaksi</th>
  <th>Waktu Booking</th>
  <th>Waktu Confirm</th>
  <th>Waktu Kirim</th>
  <th>SC</th>
  <th>Cabang</th>
  <th>No. Struk</th>
  <th>Nominal Struk</th>
  <th>Konfirmasi File</th>
  <th>Status</th>
</thead>
<tbody>
<?php if($pesanan!= array()): ?>
        <?php foreach ($pesanan as $item): ?>
		<tr>
		    <td><?php echo anchor('store/detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
		    <td><?php echo $item->tanggal_masuk; ?></td>
		    <td><?php
				    $a = $item->tanggal_masuk;
				    date_add($a,date_interval_create_from_date_string("1 days"));
				    echo date_format($a,"Y-m-d h:i:s");
				    echo $item->waktu_confirm;
			?>
	            </td>
		    <td><?php echo $item->ORDER_DELIVERY_DATE; ?></td>
		    <td><?php echo $item->USERNAME; ?></td>
		    <td><?php echo $item->SITE_DESC; ?></td>
		    <td><?php echo $item->no_struk; ?></td>
		    <td><?php if($item->TOTAL_BIAYA_INPUT){ echo "Rp. ".$item->TOTAL_BIAYA_INPUT; } ?></td>
		    <td> <?php if ($item->RECEIVING_DN): ?>
			<p style="color:green">Received</p>
			<?php endif; ?>
	            </td>
		    <td>
			
			<?php
			
				switch($item->FLAG) {
				
				case '0':
				$item->FLAG = '<div style="color:red;">Waiting for Payment</div>';
				continue;
				
				case '1':
				$item->FLAG = '<div style="color:orange;">Payment Confirmed</div>';
				continue;
				
				case '2':
				$item->FLAG = '<div style="color:blue;">on Progress</div>';
				continue;
				
				case '3':
				$item->FLAG = '<div style="color:blue;">on Progress Gold</div>';
				continue;
				
				case '4':
				$item->FLAG = '<div style="color:brown;">Expired</div>';
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
			
			        case '10':
				$item->FLAG = '<div style="color:#C2C2D6;">Order Canceled</div>';
				continue;
			
			        case '11':
				$item->FLAG = '<div style="color:#CCCCFF;">Transaction Canceled</div>';
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
<br/><hr/>
<div class="row">
<div>
	    <div class="span2" style="color: red">Waiting for Payment</div>
	    <div class="span10">Transaksi sudah dalam proses pemesanan oleh konsumen</div>
</div>
</div>

<div class="row">
<div>
	    <div class="span2" style="color: orange">Confirmed</div>
	    <div class="span10">Transaksi dalam kondisi konsumen sudah melakukan pembayaran di kassa dan sudah dilakukan konfirmasi ke dalam aplikasi</div>
</div>
</div>

<div class="row">
<div>
	    <div class="span2" style="color: blue">on Progress</div>
	    <div class="span10">Transaksi dalam kondisi pemrosesan oleh GOLD</div>
</div>
</div>

<div class="row">
<div>
	    <div class="span2" style="color: blue">on Progress Shipment</div>
	    <div class="span10">Transaksi dalam kondisi pemrosesan persiapan pengiriman</div>
</div>
</div>

<div class="row">
<div>
	    <div class="span2" style="color: green">on Delivery</div>
	    <div class="span10">Transaksi dalam kondisi sedang dalam pengiriman kepada konsumen</div>
</div>
</div>

<div class="row">
<div>
	    <div class="span2" style="color: magenta">Transaction Completed</div>
	    <div class="span10">Transaksi selesai</div>
</div>
</div>

<div class="row">
<div>
	    <div class="span2" style="color: brown">Expired</div>
	    <div class="span10">Batas waktu Booking habis</div>
</div>
</div>

<div class="row">
<div>
<div class="span2" style="color:#C2C2D6;">Order Canceled</div>
<div class="span10">Proses order dibatalkan dan konsumen belum melakukan pembayaran</div>
</div>
</div>

<div class="row">
<div>
<div class="span2" style="color:#CCCCFF;">Transaction Canceled</div>
<div class="span10">Transaksi dibatalkan dan konsumen sudah melakukan konfirmasi pembayaran</div>
</div>
</div>


<br/><hr/>