<h2>Riwayat Belanja</h2>
<p>Berikut ini adalah riwayat belanja anda di toko kami</p>
<?php if ($order == array()): ?>
<div class="note-cart">Anda Belum pernah berbelanja di sini</div>
<?php else: ?>
<table class="user-record" cellspacing="0" cellpadding="20px">
    <tr>
        <th>No. Order</th>
        <th>Tanggal Belanja</th>
        <th>Jumlah Item</th>
        <th>Total Belanja</th>
        <th>Status</th>
        <th>Detail</th>
    </tr>
<?php foreach ($order as $item): ?>
    <tr>
        <td><?php echo $item->order_no; ?></td>
        <td><?php echo date("d/m/Y - H:i",strtotime($item->tanggal_masuk)); ?></td>
        <td style="text-align:center"><?php echo $item->total_item; ?></td>
        <td> Rp. <?php echo $this->cart->format_number($item->total_biaya); ?></td>
        <td>
        
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
    <td><?php echo anchor('user/detail_record/'.$item->id_order, 'Detail', 'class="active" id="detail"'); ?></td>
    </tr>
    <!--<tr>
        <td></td>
        <td colspan="4">Detail</td>
    </tr>
    <?php //foreach($item->detail as $detail): ?>
    <tr>
        <td></td>
        <td><?php //echo $detail->nama_produk; ?></td>
        <td><?php //echo $detail->kuantitas; ?></td>
        <td>Rp. <?php //echo $this->cart->format_number($detail->subtotal); ?></td>
    </tr>-->
    <?php //endforeach; ?><div><?php  //echo $this->pagination->create_links(); ?></div>
<?php endforeach; ?>
    
</table>
<?php endif; ?>