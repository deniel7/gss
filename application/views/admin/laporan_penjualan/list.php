<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>untitled</title>
	<style type="text/css" media="screen">
	#container {
	 width: 600px;
	 margin: auto;
	font-family: helvetica, arial;
	}

	table {
	 width: 600px;
	 margin-bottom: 10px;
	}

	td {
	 border-right: 1px solid #aaaaaa;
	 padding: 1em;
	}

	td:last-child {
	 border-right: none;
	}

	th {
	 text-align: left;
	 padding-left: 1em;
	 background: #cac9c9;
	border-bottom: 1px solid white;
	border-right: 1px solid #aaaaaa;
	}

	#pagination a, #pagination strong {
	 background: #e3e3e3;
	 padding: 4px 7px;
	 text-decoration: none;
	border: 1px solid #cac9c9;
	color: #292929;
	font-size: 13px;
	}

	#pagination strong, #pagination a:hover {
	 font-weight: normal;
	 background: #cac9c9;
	}		
	</style>
<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/functions.js"></script>

</head>

<h1><?php //echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right">
	   </ul>
</div>
<h3 class="tit">Laporan Penjualan</h3>
<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('admin/laporan_penjualan/search');
	?>
			<span>
				<?php
					$search_cabang = array(
					'name'        => 'search_cabang',
					'id'          => 'search_cabang',
					'placeholder' => 'Cabang'
					);
					
					
					$search_tg1 = array(
					'name'        => 'search_tg1',
					'id'          => 'datepicker-example1',
					'placeholder' => 'dari tanggal...'

					);
					
					$search_tg2 = array(
					'name'        => 'search_tg2',
					'id'          => 'datepicker-example14',
					'placeholder' => 'sampai tanggal...'
					
					);
					
					echo form_close();
				?>
				
				<div class="table">
					<div class="headRow">
					   
					    <div class="col"><?php echo form_dropdown('search_cabang', $list_cab);//echo form_input($search_cabang); ?></div>
					    <div class="col"><?php echo form_input($search_tg1); ?></div>
					    <div class="col"><?php echo form_input($search_tg2); ?></div>
					    
					    <div class="col"><?php echo form_submit('submit', 'Cari','class = "btn large"'); ?></div>
					</div> 
				</div>
				<div id="result"></div>
			</span>
			
</div>

<?php if ($data_e == 1){
	//echo "<p class='msg warning'>Silahkan Pilih</p>";

}else if($data_e == 0){ 
	echo "<p class='msg warning'>Data yang dicari tidak ditemukan</p>";
}else{ ?>
<table class="user-record" cellspacing="0" cellpadding="3px">
    <tr>
	<th>Tanggal Belanja</th>
        <th>Cabang</th>
	<th>Order Number</th>
        <th>Username</th>
        <th>Total Belanja</th>
    </tr>
<?php foreach($data_e as $row): ?>
   
    <tr>
        <td><?php echo date("d/m/Y - H:i",strtotime($row->tanggal_masuk)); ?></td>
	<td><?php echo $row->kode_cabang; ?></td>
        <td><?php echo $row->order_no; ?></td>
        <td><?php echo $row->username; ?></td>
        <td> Rp.<?php echo $this->cart->format_number($row->total_biaya) ?></td>
    </tr>
    <tr>
	<td colspan="4" align="right">Total</td>
	<td>
	<?php
		$a = $this->cart->format_number($row->total_biaya);
		$jumlahnya = $a++;
		echo $jumlahnya;
	?>
	</td>
    </tr>
    
<?php endforeach; ?>

<tr><td><?php echo $this->pagination->create_links(); ?></td></tr>   
</table>
<br/><br/>

<?php
	if (!empty($data_ee)){
	foreach($data_ee as $rows):
?>
<div>
	<h3><?php echo "Total Penjualan : Rp. ".$this->cart->format_number($rows->total_biaya); ?></h3>
</div>
<?php endforeach; } ?>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>	-->

<script type="text/javascript" charset="utf-8">
	$('tr:odd').css('background', '#e3e3e3');
</script>
<?php } ?>