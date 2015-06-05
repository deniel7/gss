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
  <td>Nomor Transaksi</td>
  <td>Waktu Booking</td>
  <td>Waktu Confirm</td>
  <td>Nominal Struk</td>
  <td>Nama SC</td>
  <td>Cabang</td>
  <td>No. Struk Input</td>
  <td>Nama SPV Validator</td>
  <td>Tanggal Update</td>
  
</thead>
<tbody>
<?php if($pesanan!= array()): ?>
        <?php foreach ($pesanan as $item): ?>
		<tr>
		    <td><?php echo anchor('store/pending_detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
		    <td><?php echo $item->tanggal_masuk; ?></td>
		    <td><?php echo $item->waktu_confirm; ?></td>
		    <td><?php if($item->TOTAL_BIAYA_INPUT){ echo "Rp. ".$item->TOTAL_BIAYA_INPUT; } ?></td>
		    <td><?php echo $item->USERNAME; ?></td>
		    <td><?php echo $item->SITE_STORE_CODE; ?></td>
		    <td><?php echo $item->no_struk; ?></td>
		    <td><?php echo $item->updated_by; ?></td>
		    <td><?php echo $item->struk_update_time; ?></td>
		</tr>
        <?php endforeach; ?>
	
<?php else: ?>
    <p class="msg info" color="">Belum ada Pesanan</p>
<?php endif; ?>

</tbody>
<div style="color:#fff"></div>
</table>


<?php endif; ?>
