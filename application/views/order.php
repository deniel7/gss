<style type="text/css">
    .box{
        padding: 20px;
        display: none;
        margin-top: 30px;
	margin-bottom: 30px;
        border: 1px thin #000;
    }
    .cash{ background: #ff0000; }
    .credit{ background: #00ff00; }
    .indents{ background: #0000ff; }
</style>
<!--
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="cash"){
                $(".box").hide();
                $(".cash").show();
            }
            if($(this).attr("value")=="credit"){
                $(".box").hide();
                $(".credit").show();
            }
            if($(this).attr("value")=="indent"){
                $(".box").hide();
                $(".indent").show();
            }
        });
    });
</script>-->

<script type="text/javascript">
function FillBilling(f) {
  if(f.billingtoo.checked == true) {
    f.nama_depan_b.value = f.nama_depan.value;
    f.nama_belakang_b.value = f.nama_belakang.value;
    f.alamat_b.value = f.alamat.value;
    f.kota_b.value = f.kota.value;
    f.kode_pos_b.value = f.kode_pos.value;
    f.phone_b.value = f.phone.value;
  }
}
</script>



<div class="span12">
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
            <div class="checkout-step-label-active">Pengiriman</div>
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
  
  //function transaksi_id() {
  //      $dataMax = mysql_fetch_assoc(mysql_query("SELECT SUBSTR(MAX(`ORDER_NO_GTRON`),-5) AS ID  FROM SUPPLIER_ORDER_HEADER")); // ambil data maximal dari id transaksi
  //      
  //      if($dataMax['ID']=='') { // bila data kosong
  //          $ID = "00001";
  //      }else {
  //          $MaksID = $dataMax['ID'];
  //          $MaksID++;
  //          if($MaksID < 10) $ID = $param."0000".$MaksID; // nilai kurang dari 10
  //          else if($MaksID < 100) $ID = $param."000".$MaksID; // nilai kurang dari 100
  //          else if($MaksID < 1000) $ID = $param."00".$MaksID; // nilai kurang dari 1000
  //          else if($MaksID < 10000) $ID = $param."0".$MaksID; // nilai kurang dari 10000
  //          else $ID = $MaksID; // lebih dari 10000
  //      }
  //
  //      return $ID;
  //  }
    
    function transaksi_id() {
        $dataMax = mysql_fetch_assoc(mysql_query("SELECT SUBSTR(MAX(`ORDER_NO_GTRON`),-6) AS ID  FROM SUPPLIER_ORDER_HEADER")); // ambil data maximal dari id transaksi
        
        if($dataMax['ID']=='') { // bila data kosong
            $ID = "000001";
        }else {
            $MaksID = $dataMax['ID'];
            $MaksID++;
            if($MaksID < 10) $ID = $param."00000".$MaksID; // nilai kurang dari 10
            else if($MaksID < 100) $ID = $param."0000".$MaksID; // nilai kurang dari 100
            else if($MaksID < 1000) $ID = $param."000".$MaksID; // nilai kurang dari 1000
            else if($MaksID < 10000) $ID = $param."00".$MaksID; // nilai kurang dari 10000
            else $ID = $MaksID; // lebih dari 10000
        }

        return $ID;
    }
  
  $order_no = 'GT'.substr($this->session->userdata('store_site_code'),-3).transaksi_id();
?>

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
    <?php else:?>
        
        <div class="span12">
	  <span>
	      <?php if(@$error){echo @$error;} ?>
	      <?php echo validation_errors('<div class="alert-danger">', '</div><br/>'); ?>
	      <br/>
	  </span>
	  
	  <?php
	    if($stok){
	      echo "<div class='alert-danger'>Tidak cukup stok untuk produk dibawah ini : <br/><br/><b>".$stok."</b></div><br/>"; 
	    }
	  ?>
	
	<?php
	  
	  echo form_open(site_url(uri_string()),'class="order"');
	
	?>
        <table class="table table-bordered">
	<thead>
        <tr>
          <th>Nama Barang</th>
          <th align="center">QTY</th>
          <th align="center">Pembayaran</th>
	  <th style="text-align:right">Harga Satuan</th>
          <th style="text-align:right">Sub-Total</th>
        </tr>
        </thead>
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
		  <td align="center">
			  <?php
			    if($items['pembayaran'] == '1'){
			      echo "CREDIT";
			    }else{
			      echo "CASH";
			    }
			    //echo form_hidden(array('name' => 'pemb', 'value' => $items['pembayaran'], 'maxlength' => '3', 'size' => '5'));
			  ?>
			  <input type="hidden" name="pemb" value="<?php echo $items['pembayaran']; ?>" />
		  </td>
        	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
        	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
        	</tr>
        
        <?php $i++;$total_item = $total_item + $items['qty']; ?>
        
        <?php endforeach; ?>
        
	<tr>
          <td></td>
          <td></td>
	  <td></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Handling Fee</strong></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($biaya); ?></strong></td>
	  
	</tr>
	
        <tr>
          <td></td>
          <td></td>
	  <td></td>
	  <?php
	    
	    $total_belanja = $this->cart->total();
	    $total = $total_belanja + $biaya;
	    
	  ?>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Total</strong></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($total); ?></strong></td>
        </tr>
        
        </table>
	
	<br/>
	<?php //echo form_fieldset('Metoda Pembayaran','class="produk"'); ?>
	<!--<div class="span12">
	  
	<div class="span3">
	  <label><input type="radio" name="colorRadio" value="cash">&nbsp;<b>PEMBAYARAN TUNAI</b></label>
	</div>
	<div class="span3">
	  <label><input type="radio" name="colorRadio" value="credit">&nbsp;<img src="<?php //echo base_url().'/template/palmtree/images/visa_mastercard.jpeg'; ?>" /></label>
	</div>
	<div class="span3">
	  <label><input type="radio" name="colorRadio" value="indent">&nbsp;<b>INDENT</b></label>
	</div>
	
	<div class="indent box">
	Down Payment : <?php /*echo form_input(array(
					'id' => 'dp',
                                        'name' => 'dp',
					'placeholder' => 'Rp.',
                                        'class' => 'form-control input-lg'
			));*/  ?>
	
	</div>
	  
	</div>-->
        <br/><br/>
        <div class="row">
	<?php 
        echo form_fieldset('Alamat Pengiriman','class="produk"');
	echo form_hidden('order_no',$order_no);
	echo form_hidden('total_item',$total_item);
	echo form_hidden('total',$total);
        
	
	echo form_input(array(
					'id' => 'nama_depan',
                                        'name' => 'nama_depan',
					'placeholder' => 'Nama Depan',
                                        'class' => 'form-control input-lg'
			)); 
	
	echo "<br/>";
	
	echo form_input(array(
					'id' => 'nama_belakang',
                                        'name' => 'nama_belakang',
					'placeholder' => 'Nama Belakang',
                                        'class' => 'form-control input-lg'
			)); 
	
	echo "<br/>";
	
	echo form_textarea(array(
					'id' => 'alamat',
                                        'name' => 'alamat',
					'placeholder' => 'Alamat',
                                        'style' => 'width:400px;height:50px;'
			)); 
	
	echo "<br/>";
        
	echo form_input(array(
					'id' => 'kota',
                                        'name' => 'kota',
					'placeholder' => 'Kota',
                                        'class' => 'form-control input-lg'
			)); 
	
       
       echo "<br/>";
       
       echo form_input(array(
					'id' => 'kode_pos',
                                        'name' => 'kode_pos',
					'placeholder' => 'Kode Pos',
                                        'class' => 'form-control input-lg'
			)); 
       
        echo "<br/>";
       
	echo form_input(array(
					'id' => 'phone',
                                        'name' => 'phone',
					'placeholder' => 'Telepon',
                                        'class' => 'form-control input-lg'
			)); 
	?>
	</div>
	
	<div class="row">
	<?php
	echo "<br/><br/><br/>";
        
	echo form_fieldset('Estimasi Pengiriman','class="produk"');
	
	$datestring = "%H";
	$time = time();
	$t = mdate($datestring, $time);
	if($t > 8 && $t <=15){
	  echo "<span class='btn btn-info'>".date('d-m-Y').' /sore ini'."</span>";
	}else{
	  //echo date('Y-m-d','+ 1 day');  
	  echo "<span class='btn btn-warning'>".date('d-m-Y', strtotime(' +1 day')).' / Besok Pagi'."</span>";
	}
	
	
	
	
	
	echo form_fieldset_close();
	?>
	
	</div>
	<br/>
	
	
	
	<?php
	echo form_fieldset_close();
	
	echo "<br/><br/>";
	echo '<div style= text-align:center>'.form_submit(array('name'=>'submit','value'=>'Pemesanan Selesai','class'=>'btn btn-large btn-success')).'</div>';
	echo "<br/><br/>";
	?>
    
    <?php endif; ?>
<?php endif; ?>

  
