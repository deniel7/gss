
<div class="row">
<?php if (!$logged_in): ?>
    <div class="error">Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.</div>
    <br/>
    <div><?php echo anchor(site_url('user/login'),'LOGIN disini') ?></div>
<?php else: ?>


<div class="span12">

<table class="table table-bordered">
<thead>
  <tr>
  <th>Nomor Transaksi</th>
  <th>Waktu</th>
  <th>Total</th>
  <th>SPV</th>
  <th>No. Struk</th>
  <th>Status</th>
  </tr>
</thead>

<tbody>
<?php if($pesanan!= array()): ?>
        <?php foreach ($pesanan as $item): ?>
		<tr>
		    <td><?php echo anchor('store/detail/'.$item->id_order, $item->ORDER_NO_GTRON, 'class="active" id="detail"'); ?></td>
		    <!--<td><?php //echo $item->order_no; ?></td>-->
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
				$item->FLAG = '<div style="color:purple;">on Delivery</div>';
				continue;
				
				case '4':
				$item->FLAG = '<div style="color:green;">Cancel</div>';
				continue;
		    
				}          
			echo $item->FLAG;
			?>
		    
		    </td>
		    
		</tr>
        <?php endforeach; ?>
	<tr><td colspan="10" align="center"><?php  echo $this->pagination->create_links(); ?></td></tr>
<?php else: ?>
    <p class="msg info">Belum ada Pesanan</p>
<?php endif; ?>

</tbody>
</table>

</div>
<?php endif; ?>
</div>

