<head>
	<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.css" type="text/css"/>
	<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/functions.js"></script>
</head>

<h1><?php echo $judul ?></h1>
<!--<div id="menu" class="box">
	<ul class="box f-right">
	   <li><a href="<?php //echo site_url('admin/produk/tambah') ?>" id="add"><span><strong>Tambah Produk Baru</strong></span></a></li>
    </ul>
</div>-->
<h3 class="tit">Daftar Pesanan</h3>

<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('admin/pesanan/search');
	?>
			<span>
				<?php
					$data_search = array(
					'name'        => 'search_orderno',
					'id'          => 'search_orderno',
					'size'        => '20',
					'maxlength'   => '5',
					'style'       => 'width:40%',
					
					);
					
					$data_member = array(
					'name'        => 'search_mem',
					'id'          => 'search_mem',
					
					
					);
					
					$search_tg1 = array(
					'name'        => 'search_tg1',
					'id'          => 'datepicker-example1',
					

					);
					
					$search_tg2 = array(
					'name'        => 'search_tg2',
					'id'          => 'datepicker-example14',
					
					
					);
					
					
					echo form_close();
				?>
				
				<div class="table">
					<div class="headRow">
					    <!--<div>Pencarian :</div>-->
					    
					    <div class="col">No. Order<?php echo form_input($data_search); ?></div>
					    <div class="col">No. Member<?php echo form_input($data_member); ?></div>
					    <div class="col">Dari Tanggal :<?php echo form_input($search_tg1); ?></div>
					    <div class="col">Sampai Tanggal :<?php echo form_input($search_tg2); ?></div>
					    <div class="col">
						<?php
							$options = array(
								''  => '-Status-',
								'0' => 'Pending',
								
								'2' => 'Picking',
								'3' => 'Shipped',
								'4' => 'Closed',
							      );
					      
							echo form_dropdown('status', $options);
						?>
					    </div>
					    <div class="col"><?php echo form_dropdown('search_cab', $list_cab); ?></div>
					    <div class="col">
						<?php
							$optionss = array(
								''  => '-Waktu-',
								'pagi' => 'pagi',
								'siang' => 'siang',
								'malam' => 'malam'
								
							      );
					      
							echo form_dropdown('waktu', $optionss);
						?>
					    </div>
					    
					    
					</div>
					<div class="col"><?php echo form_submit('submit', 'Cari','class = "btn large"'); ?></div>
				</div>
				<div id="result"></div>
			</span>
			
</div>

<?php if($pesanan!= array()): ?>
	<table>
		<tr>
			<th>Order No</th>
			<th>Member No</th>
			<th>Nama</th>
			<th>Tanggal Masuk</th>
			<th>Status</th>
			<th>Total</th>
			<th>Cabang</th>
			<th>Diambil?</th>
			<th>Waktu Ambil / Kirim</th>
			<th>Action</th>
		</tr>
        <?php foreach ($pesanan as $item): ?>
		<tr>
		    
		    <td><?php echo $item ->order_no; ?></td>
		    <td><?php echo $item->membercard; ?></td>
		    <td><?php echo $item->nama_depan.' '.$item->nama_belakang; ?></td>
		    <td><?php echo date("d/m/Y - H:i",strtotime($item->tanggal_masuk)); ?></td>
		    <td><?php //echo $item->status_order; ?>
			
			<?php
			
				switch($item->status_order) {
				case '-1':
				$item->status_order = '<div style="color:silver;">Cancel</div>';
				continue;
				
				case '0':
				$item->status_order = '<div style="color:red;">Pending</div>';
				continue;
				
				case '1':
				$item->status_order = '<div style="color:orange;">Confirmed</div>';
				continue;
				
				case '2':
				$item->status_order = '<div style="color:blue;">Picking</div>';
				continue;
				
				case '3':
				$item->status_order = '<div style="color:purple;">Shipped</div>';
				continue;
				
				case '4':
				$item->status_order = '<div style="color:green;">Closed</div>';
				continue;
		    
				}          
			echo $item->status_order;
			?>
		    
		    </td>
		    <td>Rp. <?php echo $this->cart->format_number($item->total_biaya); ?></td>
		    <td><?php echo $item->kode_cabang; ?></td>
		    <td><?php echo (empty($item->ambil_cabang)) ? '&nbsp;':'V'; ?></td>
		    <td><?php echo $item->waktu_ambil; ?></td>
		    <td><?php echo (empty($item->ambil_cabang)) ? anchor('admin/pesanan/detail/'.$item->id_order, 'Detail', 'class="active" id="detail"') : '&nbsp;' //echo anchor(uri_string().'/detail/'.$item->id_order, 'Detail', 'class="active" id="detail"') '?></td>
		    
		</tr>
        <?php endforeach; ?>
	<tr><td colspan="10" align="center"><?php  echo $this->pagination->create_links(); ?></td></tr>
	</table>
<?php else: ?>
    <p class="msg info">Belum ada Pesanan</p>
<?php endif; ?>
<script type="text/javascript">

jQuery(function($) {
	$(".active").colorbox({
		width:"500", height:"500", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});

</script>
