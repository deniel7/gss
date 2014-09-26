<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/functions.js"></script>

<h1><?php //echo $judul ?></h1>
<!--<div id="menu" class="box">
	<ul class="box f-right">
	   <li><a href="<?php //echo site_url('admin/produk/tambah') ?>" id="add"><span><strong>Tambah Produk Baru</strong></span></a></li>
    </ul>
</div>-->
<h3 class="tit">Daftar Konfirmasi</h3>
<?php echo $this->session->flashdata('user_note'); ?>
<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('admin/konfirmasi/search');
	?>
			<span>
				<?php
					$search_orderno = array(
					'name'        => 'search_orderno',
					'id'          => 'search_orderno',
					
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
					    <!--<div class="col">Pencarian :</div>-->
					    <div class="col">Nomor Order<?php echo form_input($search_orderno); ?></div>
					    <div class="col">Dari Tanggal :<?php echo form_input($search_tg1); ?></div>
					    <div class="col">Sampai Tanggal :<?php echo form_input($search_tg2); ?></div>
					    <div class="col">&nbsp;<?php echo form_submit('submit', 'Go','class = "btn large"'); ?></div>
					    
					</div> 
				</div>
				<div id="result"></div>
			</span>
			
</div>
<?php if ($data_konfirm == NULL){
    echo "<p class='msg warning'>Data yang dicari tidak ditemukan</p>";
}else{ ?>
	<table>
		<tr>
            
	    <th>Tanggal Konfirmasi</th>
	    <th>Order No.</th>
	    <th>Nama</th>
	    <th>Email</th>
	    <th>No. Rek</th>
	    <th>Dari Rekening</th>
            <th>Rekening Tujuan</th>
            <th>Nominal</th>
	    <th>Waktu Input</th>
	    <th>Status</th>
		</tr>
        <?php $i=1; foreach ($data_konfirm as $item): ?>
		<tr> 
		    <td><?php echo date("d/m/Y",strtotime($item->tanggal)); ?></td>
		    <td><?php echo $item->order_no; ?></td>
		    <td><?php echo $item->nama; ?></td>
		    <td><?php echo $item->email; ?></td>
		    <td><?php echo $item->norek; ?></td>
		    <td><?php echo $item->dari_rekening; ?></td>
		    <?php
			$rek = $item->rekening_tujuan;
			
			if($rek == 1){
				$rek = 'BCA';
			}else if($rek == 2){
				$rek = 'MANDIRI';
			}
		    ?>
                    <td><?php echo $rek; ?></td>
		    <td><?php echo $this->cart->format_number($item->nominal);  ?></td>
		    <td><?php echo date("d/m/Y - H:i",strtotime($item->waktu_input_konfirmasi));  ?></td>
		    <td><?php echo $item->status == 1 ? anchor('admin/konfirmasi/aktifasi/'.$item->id_konfirmasi.'/0','OK', 'class="active"') : anchor('admin/konfirmasi/aktifasi/'.$item->id_konfirmasi.'/1','Baru', 'class="no-active"'); ?></td>
		</tr>
        <?php $i++; endforeach; ?>
	<tr><td colspan="10" align="center"><?php  echo $this->pagination->create_links(); ?></td></tr>
	</table>

<?php } ?>
    
<?php //endif; ?>