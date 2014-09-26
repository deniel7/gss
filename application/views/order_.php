<div>
  <p>
    <ul id="checkout-progress">
      <li id="checkout-step-0" class="checkout-step"  style="border-bottom: 3px solid red;">
	<a id="checkout-step-link-0" class="checkout-step-link" href="javascript:void(0)" title="Review Pesanan">
            <div class="checkout-step-number">1</div>
            <div class="checkout-step-label">Review Pesanan</div>
        </a>
      </li>
      
      <li id="checkout-step-1" class="checkout-step" style="border-bottom: 3px solid red;">
	<a id="checkout-step-link-1" class="checkout-step-link" href="javascript:void(0)" title="Pengiriman &amp Pembayaran">
            <div class="checkout-step-number-active">2</div>
            <div class="checkout-step-label-active">Pengiriman &amp Pembayaran</div>
        </a>
      </li>
      
      <li id="checkout-step-2" class="checkout-step" style="border-bottom: 3px solid #CCC;">
	<a id="checkout-step-link-2" class="checkout-step-link" href="javascript:void(0)" title="Pemesanan Selesai">
            <div class="checkout-step-number">3</div>
            <div class="checkout-step-label">Pemesanan Selesai</div>
        </a>
      </li>
      
    </ul>
  </p>
</div>
<div class="clear"></div>
<?php
  
  function random_salt($size=32, $number=false, $hash=false) {
    
    //Get insanely random data
    $rand = mt_rand().microtime(true).uniqid('',true).join('',stat(__FILE__)).memory_get_usage().getmypid();
    
    //Remove everything that isn't a number
    $rand = preg_replace('/[^0-9]+/', '', $rand);

    //Randomly shuffle the string
    $rand = str_shuffle($rand);
    
    //Did they just want a long number?
    if($number) {
        return substr($rand, 0, $size);
    }
    
    $offset = 0;
    for($i=0;$i<$size;$i++) {
        
        //Random starting point
        $start = mt_rand(1,3);
        //1 to 3 digit number
        $length = mt_rand(1,3);
        //Add to the total offset
        $offset += $start;
        
        //If the offset is past the last char on the rand string - start over
        $offset = ($offset + $length) >= strlen($rand) ? $start : $offset;
        
        //Fetch this number
        $number = substr($rand, $offset, $length);
        
        //Force it to be larger than ascii 33
        while($number < 33) {
            $number += rand(1, 30);
        }
        
        //Force it to be smaller than ascci 255
        while($number > 255) {
            $number -= rand(10, 100);
        }
        
        //Get the ascii symbol for it
        $string .= chr($number);
    }
    
    //If the user wants us to hash it also
    if($hash) {
        return hash('sha256', $string);
    }
    
    return $string;
} 
  $order_no = random_salt(5, TRUE);
?>

<?php if (!$logged_in): ?>
    Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.
<?php else: ?>
    <?php if($this->session->flashdata('pesan')): ?>
        <?php echo $this->session->flashdata('pesan');
	      
	      $this->load->model('order_m');
	      $id = $this->session->userdata('user_id');
              $order = $this->order_m->get_record(array('user_id'=>$id));
	      
	      
	      //foreach ($order as $item):
	      //
	      //echo "Nomor order anda adalah :  ";
	      //echo $item['id_order'];
	      ////print $order_no;
	      //endforeach;
	?>
    <?php else:?>
        <!--<h2>Catatan Belanja</h2>-->
        <div>
	<?php echo form_open(site_url(uri_string()),'class="order"'); ?>
        <table cellpadding="6" cellspacing="1" style="width:100%" border="0">
    
        <tr>
          <th>Nama Barang</th>
          <th align="center">QTY</th>
          <th style="text-align:right">Harga Satuan</th>
          <th style="text-align:right">Sub-Total</th>
        </tr>
        
        <?php $i = 1;$total_item = 0; ?>
        
        <?php foreach($this->cart->contents() as $items): ?>
        
        	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
        
        	<tr>
        	  <td>
        		<?php echo $items['name']; ?>
        
        			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
        
        				<p>
        					<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
        
        						<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />
        
        					<?php endforeach; ?>
        				</p>
        
        			<?php endif; ?>
        
        	  </td>
              <td align="center"><?php echo $items['qty']; ?></td>
        	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
        	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
        	</tr>
        
        <?php $i++;$total_item = $total_item + $items['qty']; ?>
        
        <?php endforeach; ?>
        
        <tr>
          <td></td>
          <td></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Total</strong></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></strong></td>
        </tr>
        
        </table>
	
	<br/>
	
        
        <?php 
        echo form_fieldset('Alamat Pengiriman','class="produk"');
	echo form_hidden('order_no',$order_no);
	echo form_hidden('total_item',$total_item);
        echo form_label('Nama Depan');
        echo form_input('nama_depan',$nama_depan);
        echo form_label('Nama Belakang');
        echo form_input('nama_belakang',$nama_belakang);
        echo form_label('Alamat');
        echo form_textarea('alamat',$alamat,'style="width:400px;height:50px;"');
        echo form_label('Kota');
        echo form_input('kota','Bandung','disabled');
	echo form_label('Kode Pos');
        echo form_input('kode_pos',$kode_pos);
        echo form_label('Telephone');
        echo form_input('phone',$phone);
        echo form_fieldset_close();
	
	echo "<br/>";
	
	echo form_fieldset('Metode Pengiriman / Pengambilan','class="produk"');
	echo"<p>";
        echo form_label('Dikirim / Diambil di : ');
	echo form_dropdown('list_cab', $list_cab);
	echo"</p>";
	
	
	$datestring = "%H";
	$time = time();
	$t = mdate($datestring, $time);
	
	
	//if($t >= 1 && $t <= 4){
	//  $array = array('Pagi','Siang','Sore / Malam');
	//  
	//}else if ($t >= 4 && $t <= 12){
	//  $array = array('','Siang','Sore / Malam');
	//
	//}else if ($t >= 12 && $t <= 17){
	//  $array = array('','','Sore / Malam');
	//
	//}else{
	//  $array = array('Pagi','Siang','Sore / Malam');
	//}
	
	echo form_label('Waktu Ambil / Kirim');
	//echo form_dropdown('waktu_ambil', $array);
        
	echo "<p style='float:left'>";
	
	echo "</p>";
	
	echo "<p style='float:left'>";
	
	echo "</p>";
	
	?>
	
	<div class="table">
	  <div class="headRow">
	      <?php if($t >= 1 && $t <= 4){ ?>
	      <div class="col">
	      <?php
		    echo "PAGI";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'pagi','value' => 'pagi'),'',TRUE);
	      ?>
	      </div>
	      
	      <div class="col">
	      <?php
		    echo "SIANG";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'siang','value' => 'siang'));
	      ?>
	      </div>
	      
	      <div class="col">
	      <?php
		    echo "MALAM";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'malam','value' => 'malam'));
	      ?>
	      </div>
	      
	      <?php }else if ($t >= 4 && $t <= 12){ ?>
	      <div class="col">
	      <?php
		    echo "PAGI";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'pagi','value' => 'pagi', 'disabled' => 'disabled')); ?>
	      </div>
	      
	      <div class="col">
	      <?php
		    echo "SIANG";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'siang','value' => 'siang'),'',TRUE);
	      ?>
	      </div>
	      
	      <div class="col">
	      <?php
		    echo "MALAM";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'malam','value' => 'malam'));
	      ?>
	      </div>
	      
	      <?php }else if ($t >= 12 && $t <= 17){ ?>
	      <div class="col">
	      <?php
		    echo "PAGI";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'pagi','value' => 'pagi', 'disabled' => 'disabled')); ?>
	      </div>
	      
	      <div class="col">
	      <?php
		    echo "SIANG";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'siang','value' => 'siang', 'disabled' => 'disabled'));
	      ?>
	      </div>
	      
	      <div class="col">
	      <?php
		    echo "MALAM";
		    echo form_radio(array('name' =>'waktu_ambil','id'=>'malam','value' => 'malam'),'',TRUE);
	      ?>
	      </div>
	      <?php } ?>
	      
	  </div> 
	</div>
	</div>
	<?php
	
        echo form_fieldset_close();
	
	echo "<br/>";
	
	echo form_fieldset('Metode Pembayaran','class="produk"');
        echo "<table style='text-align:center'><tr><td>";
	echo form_radio(array('name' =>'transfer','id'=>'transfer','value' => 'transfer bank'),'',TRUE);
	echo "<img src=".base_url()."template/palmtree/images/transfer.png><br/>Transfer Bank";
	echo "</td>";
	
	echo "<td>";
	echo form_radio(array('name' =>'transfer','id'=>'cod','value' => 'bayar di tempat'));
	echo "<img src=".base_url()."template/palmtree/images/COD.jpg><br/>Bayar di Tempat";
	echo "</td>";
	
	echo "</tr></table>";
	
	?>
	
	<?php
	echo form_fieldset_close();
	
	
	echo '<div class="right">'.form_submit('submit','Pemesanan Selesai').'</div>';
	
	?>
    <?php endif; ?>
<?php endif; ?>
