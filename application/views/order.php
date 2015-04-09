<div class="row">
<div class="span12">
  <div class="row">
    <div class="span12">
      <p>
	<ul id="checkout-progress">
	  <li id="checkout-step-0" class="checkout-step"  style="border-bottom: 3px solid red;">
	    <a id="checkout-step-link-0" class="checkout-step-link" href="javascript:void(0)" title="Review Pesanan">
		<div class="checkout-step-number">1</div>
		<div class="checkout-step-label">Pengiriman</div>
	    </a>
	  </li>
	  
	  <li id="checkout-step-1" class="checkout-step" style="border-bottom: 3px solid red;">
	    <a id="checkout-step-link-1" class="checkout-step-link" href="javascript:void(0)" title="Pengiriman &amp Pembayaran">
		<div class="checkout-step-number-active">2</div>
		<div class="checkout-step-label-active">Review Pesanan</div>
	    </a>
	  </li>
	  
	  <li id="checkout-step-2" class="checkout-step" style="border-bottom: 3px solid #CCC;">
	    <a id="checkout-step-link-2" class="checkout-step-link" href="javascript:void(0)" title="Pemesanan Selesai">
		<div class="checkout-step-number">3</div>
		<div class="checkout-step-label">Print Nota</div>
	    </a>
	  </li>
	  
	</ul>
      </p>
    </div>
  </div>

    <div class="span12">
	<?php if (!$logged_in): ?>
	    <div class="error">Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.</div>
	    <br/>
	    <div><?php echo anchor(site_url('user/login'),'LOGIN disini') ?></div>
   

    <?php else: ?>
    
	<?php if($this->session->flashdata('pesan')): ?>
	    <?php echo $this->session->flashdata('pesan');
		  
		  $this->load->model('order_m');
		  $id = $this->session->userdata('user_id');
		  $order = $this->order_m->get_record(array('user_id'=>$id));
		  
	    ?>
    </div>
    
    <?php else:?>

<div class="row">  
  <div class="span12">
    <span>
	<?php if(@$error){echo @$error;} ?>
	<?php echo validation_errors('<div class="alert-danger">', '</div><br/>'); ?>
	<br/>
    </span>
  </div>
</div>

<div class="row">
  <div class="span12">
	  <table class="table table-bordered">
	  <thead>
	  <tr>
	    <th>PLU</th>
	    <th>Nama Barang</th>
	    <th align="center">Jumlah</th>
	    <th align="center">SV</th>
	    
	  </tr>
	  </thead>
	  
		  <?php foreach ($transaksi as $item): ?>
		  <tr>
		    <td>
			<p><strong><?php echo $item->PLU; ?></strong></p>
		    </td>
		    <td>
			<p><strong><?php echo $item->ARTICLE_DESC; ?></strong></p>
		    </td>
		    <td align="center"><?php echo $item->kuantitas; ?></td>
		    <td align="center">
		      <?php
			//if($item->SV == '1'){
			//  echo "CREDIT";
			//}else{
			//  echo "CASH";
			//}
			echo $item->SV;
		      ?>
		    </td>
		    
		  </tr>
	  
	  
		   <?php endforeach; ?>
		  <tr>
		    
		    <td></td>
		    <td></td>
		    <td style="text-align:right; background-color: #FFF0F0;"><strong>Biaya Kirim</strong></td>
		    <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($item->biaya_kirim); ?></strong></td>
		    
		  </tr>
	  
		  <tr>
		    
		    <?php
		      
		      $total_belanja = $this->cart->total();
		      $total = $total_belanja + $biaya;
		      
		    ?>
		    
		  </tr>
	  
	  </table>
  </div>
</div>

<br/>

<div class="row">

  <div class="span12">
	  <?php echo form_fieldset('Alamat Pengiriman', 'class="produk"'); ?>
	  
	  <?php $i = 1;$total_belanja = 0; ?>
	  <?php foreach ($pembeli as $item): ?>
	   <?php
  
	      echo form_open(site_url('store/order_selesai/'.$item->ORDER_NO_GTRON));
	      
	    ?>
	   <table class="table table-bordered">
		  
		<?php
			$tanggal = explode(' ',$item->tanggal_masuk);
		?>
		<tr>
                    <td class="hdr">Tanggal Pemesanan</td>
                    <td><?php echo $tanggal[0]; ?></td>
                </tr>
		  <tr>
		      <td class="hdr">No. Order</td>
		      <td><?php echo $item->ORDER_NO_GTRON; ?></td>
		  </tr>
		  <tr>
		      <td class="hdr">Nama Depan</td>
		      <td><?php echo $item->nama_depan; ?></td>
		  </tr>
		  <tr>
		      <td class="hdr">Nama Belakang</td>
		      <td><?php echo $item->nama_belakang; ?></td>
		  </tr>
		  <tr>
		      <td class="hdr">Alamat</td>
		      <td><?php echo $item->alamat; ?></td>
		  </tr>
		  <tr>
		      <td class="hdr">Kode Pos</td>
		      <td><?php echo $item->kode_pos; ?></td>
		  </tr>
		  <tr>
		      <td class="hdr">Telepon</td>
		      <td><?php echo $item->phone; ?></td>
		  </tr>
		  <tr>
		      <td class="hdr">Penerima</td>
		      <td><?php echo $item->penerima; ?></td>
		  </tr>
	   </table>
	  <?php endforeach; ?>
	  
	  <?php echo form_fieldset_close(); ?>
  </div>
</div>
	    
<div class="row">
  <div class="span12">
    <?php
	    //echo "<br/><br/><br/>";
	    
	    $datestring = "%H";
	    $time = time();
	    $t = date($datestring, $time);
	    
	    
	    
	    echo form_fieldset('Estimasi Pengiriman', 'class="produk"');
	    
	    
	    foreach ($transaksi as $item):
	    $tgl_kirim = $item->ORDER_DELIVERY_DATE;
	    	    
	    endforeach;
	    
	    if($tgl_kirim != NULL){
	      
	      echo "<span class='btn btn-success'>".$tgl_kirim."</span>";
	    }else{

	      if($t > 8 && $t <15){
		echo "<span class='btn btn-info'>".date('d-m-Y').' /Besok Pagi'."</span>";
	      }else{
		//echo date('Y-m-d','+ 1 day');  
		echo "<span class='btn btn-warning'>".date('d-m-Y', strtotime(' +1 day')).' / Besok Sore'."</span>";
	      }
	    }
	    
    ?>

	<br/><br/>
	<?php
	
	  echo form_fieldset('Catatan Pembeli', 'class="produk"');
	    
	    echo $item->catatan;
	
	?>
	
	
	<br/><br/>
	<hr/>
	<?php
	
	
	echo "<br/><br/>";
	echo '<div style="text-align:center">'.form_submit(array('name'=>'submit','value'=>'Konfirmasi Pesanan','class'=>'btn btn-large btn-success')).'</div>';
	echo "<br/><br/>";
	
	echo form_fieldset_close();
	
	?>
  </div>
</div>
	
        
    <?php endif; ?>
<?php endif; ?>

</div>
</div>
  
