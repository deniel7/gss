<?php

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
<div class="row">
  <div class="span12">
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
   






<div class="span12">
  <p>
    <ul id="checkout-progress">
      <li id="checkout-step-0" class="checkout-step"  style="border-bottom: 3px solid red;">
	<a id="checkout-step-link-0" class="checkout-step-link" href="javascript:void(0)" title="Review Pesanan">
            <div class="checkout-step-number-active">1</div>
            <div class="checkout-step-label-active">Pengiriman</div>
        </a>
      </li>
      
      <li id="checkout-step-1" class="checkout-step" style="border-bottom: 3px solid #CCC;">
	<a id="checkout-step-link-1" class="checkout-step-link" href="javascript:void(0)" title="Pengiriman &amp Pembayaran">
            <div class="checkout-step-number">2</div>
            <div class="checkout-step-label">Review Pesanan</div>
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


<div class="clear"></div>


<div class="span12">
<!--<h2>Catatan Belanja</h2>-->
<?php
  echo form_open(site_url(uri_string()));
  
?>

<table class="table table-bordered">
<thead>
  <tr>
    <th>PLU</th>
  <th>Nama Barang</th>
  <th>Jumlah</th>
  <th>SV</th>
  <th>Hapus</th>
  
  </tr>
</thead>

<tbody>
<?php $i = 1;$total_item = 0; ?>
<?php if ($this->cart->contents() != NULL){ ?>
<?php foreach($this->cart->contents() as $items): ?>

	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

	<tr>
	  <td style="text-align: right"><?php echo $items['PLU']; ?> </td>
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
      <td style="text-align: right"><?php echo $items['qty']; ?><?php //echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
	  
	  <td style="text-align:right">
	  <?php
	    //if($items['pembayaran'] == '1'){
	    //  echo "CREDIT";
	    //}else{
	    //  echo "CASH";
	    //}
	    //echo form_input(array('name' => 'pemb', 'value' => $items['pembayaran'], 'maxlength' => '3', 'size' => '3'));
	    echo $items['pembayaran'];
	  ?>
	  </td>
	  <td style="text-align:center"><?php echo anchor('store/confirm_delete/'.$items['rowid'],'<img src="'.base_url().'images/delete.png" alt="hapus" />',array('onclick'=>"return confirm('Yakin akan menghapus produk ini?')")) ?></td>
	  <!--<td style="text-align:right">Rp. <?php //echo $this->cart->format_number($items['price']); ?></td>
	  <td style="text-align:right">Rp. <?php //echo $this->cart->format_number($items['subtotal']); ?></td>-->
	</tr>

<?php $i++; $total_item = $total_item + $items['qty'];?>


<?php endforeach; ?> 


<!--<tr>
  
  <td></td>
  <td align="center"></td>
  <td></td>
  <td></td>
  <td style="text-align:right; background-color: #FFF0F0;"><strong>Total</strong></td>
  <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php //echo $this->cart->format_number($this->cart->total()); ?></strong></td>
</tr>-->
</tbody>
</table>

<?php 
        echo form_fieldset('Alamat Pengiriman','class="produk"');
	echo form_hidden('order_no',$order_no);
	echo form_hidden('total_item',$total_item);
	echo form_hidden('total',$this->cart->total());
	//echo form_hidden('pemb',$items['pembayaran']);
	

	
//	echo form_input(array(
//					'id' => 'nama_depan',
//                                        'name' => 'nama_depan',
//					'placeholder' => 'Nama Depan',
//                                        'class' => 'form-control input-lg'
//			)); 
//	
//	echo "<br/>";
//	
//	echo form_input(array(
//					'id' => 'nama_belakang',
//                                        'name' => 'nama_belakang',
//					'placeholder' => 'Nama Belakang',
//                                        'class' => 'form-control input-lg'
//			)); 
//	
//	echo "<br/>";
//	
//	echo form_textarea(array(
//					'id' => 'alamat',
//                                        'name' => 'alamat',
//					'placeholder' => 'Alamat',
//                                        'style' => 'width:400px;height:50px;'
//			)); 
//	
//	echo "<br/>";
//        
//	echo form_input(array(
//					'id' => 'kota',
//                                        'name' => 'kota',
//					'placeholder' => 'Kota',
//                                        'class' => 'form-control input-lg'
//			)); 
//	
//       
//       echo "<br/>";
//       
//       echo form_input(array(
//					'id' => 'kode_pos',
//                                        'name' => 'kode_pos',
//					'placeholder' => 'Kode Pos',
//                                        'class' => 'form-control input-lg'
//			)); 
//       
//        echo "<br/>";
//       
//	echo form_input(array(
//					'id' => 'phone',
//                                        'name' => 'phone',
//					'placeholder' => 'Telepon',
//                                        'class' => 'form-control input-lg'
//			)); 
?>

<input id="nama_depan" name="nama_depan" class="form-control input-lg" type="text" required placeholder="Nama Depan" oninvalid="this.setCustomValidity('Kolom Nama Depan Harus diisi')"></input><br/>
<input id="nama_belakang" name="nama_belakang" class="form-control input-lg" type="text"  required placeholder="Nama Belakang" oninvalid="this.setCustomValidity('Kolom Nama Belakang Harus diisi')"></input><br/>
<textarea required="true" style="width:400px;height:50px;" placeholder="Alamat" id="alamat" rows="12" cols="90" name="alamat" oninvalid="this.setCustomValidity('Kolom Alamat Harus diisi')"></textarea><br/>
<input id="kota" name="kota" class="form-control input-lg" type="text" required placeholder="Kota" title="Bandung" pattern="^[a-zA-Z]+$"></input><br/>
<input id="kode_pos" name="kode_pos" class="form-control input-lg" type="text"  required placeholder="Kode Pos" title="40101" pattern="[0-9]{2,20}"></input><br/>
<input id="phone" name="phone" class="form-control input-lg" type="text" required placeholder="Telepon" title="02212345678 / 0856232323232" pattern="[0-9]{3,15}"></input><br/>


<?php
echo form_fieldset_close();
?>




<br/><br/>
        <div>
	
	<br/>
	
	<?php
	  
	  echo form_fieldset('Biaya Pengiriman','class="produk"');
	  
	  echo form_dropdown('biaya',$biaya);
	  
	  echo form_fieldset_close();
	  
	
//	echo form_input(array(
//					'id' => 'biaya_nego',
//                                        'name' => 'biaya_nego',
//					'placeholder' => 'Diatas 26 KM',
//                                        'class' => 'form-control input-lg'
//			)); 
	?>
	<input id="biaya_nego" name="biaya_nego" class="form-control input-lg" type="text" placeholder="Diatas 26 KM" title="70000" pattern="[0-9]{2,20}"></input>
	</div>


<br/><br/>
<hr/>
<br/><br/>
<br/><br/>

<div>
<a href="<?php echo site_url('store/kategori') ?>" class="btn btn-large"><i class="icon-arrow-left"></i> Back </a>
<!--<a href="<?php //echo site_url('store/order') ?>" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>-->
<?php echo form_submit(array('name'=>'submit','value'=>'Next','class'=>'btn btn-large pull-right')); ?>
</div>



  
  <?php } ?>
</div>

<?php
	
	
	echo "<br/><br/>";
	//echo '<div style= text-align:center>'.form_submit(array('name'=>'submit','value'=>'Pemesanan Selesai','class'=>'btn btn-large btn-success')).'</div>';
	echo "<br/><br/>";
	?>
	
<?php endif; ?>
<?php endif; ?>
</div>
</div>
<script type="text/javascript">
jQuery(function($) {
	$("#hapus").colorbox({
		width:"400", height:"400", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>

