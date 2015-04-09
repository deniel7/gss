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
<?php $i++; $cpv = $cpv + $items['stock_cost'];?>

<?php endforeach; ?> 


</tbody>
</table>
<br/>

<div class="row">
  
  <div class="span5">
    <table class="table table-bordered">
    <thead>
      <tr>
	<th>SC Information</th>
      </tr>
    </thead>
    
    <tbody>
      <tr>
	<td>Nama</td>
	<td><?php echo $user_desc; ?></td>
      </tr>
	<tr>
	<td>ID</td>
	<td><?php echo $user_id; ?></td>
      </tr>
    </tbody>
    
    </table>
  </div>
  
  <div class="span7"></div>

</div>
<br/><br/>

<?php 
        echo form_fieldset('Alamat Pengiriman','class="produk"');
	echo form_hidden('order_no',$order_no);
	echo form_hidden('total_item',$total_item);
	echo form_hidden('total',$this->cart->total());
	echo form_hidden('cpv',$cpv);
	
?>

<input id="nama_depan" name="nama_depan" class="form-control input-lg" type="text" required placeholder="Nama Depan" oninvalid="this.setCustomValidity('Kolom Nama Depan Harus diisi')"></input><br/>
<input id="nama_belakang" name="nama_belakang" class="form-control input-lg" type="text"  required placeholder="Nama Belakang" oninvalid="this.setCustomValidity('Kolom Nama Belakang Harus diisi')"></input><br/>
<textarea required="true" style="width:400px;height:50px;" placeholder="Alamat" id="alamat" rows="12" cols="90" name="alamat" oninvalid="this.setCustomValidity('Kolom Alamat Harus diisi')"></textarea><br/>
<input id="kota" name="kota" class="form-control input-lg" type="text" required placeholder="Kota" title="Bandung" pattern="^[a-zA-Z]+$"></input><br/>
<input id="kode_pos" name="kode_pos" class="form-control input-lg" type="text"  required placeholder="Kode Pos" title="40101" pattern="[0-9]{2,20}"></input><br/>
<input id="phone" name="phone" class="form-control input-lg" type="text" required placeholder="Telepon" title="02212345678 / 0856232323232" pattern="[0-9]{3,15}"></input><br/>
<input id="penerima" name="penerima" class="form-control input-lg" type="text" required placeholder="Penerima" oninvalid="this.setCustomValidity('Kolom Penerima Harus diisi')"></input><br/>


<?php
echo form_fieldset_close();
?>

<br/><br/>
<div>
  <br/>
  
  <?php
	  
	  echo form_fieldset('Negosiasi Tanggal Pengiriman','class="produk"');
	  
	 $d=strtotime("tomorrow");
	 $today = date("d M Y", $d)
	  
  ?>
  
  
        <fieldset>
            
	    <div class="control-group">
                <!--<label class="control-label">Tanggal Pengiriman</label>-->
                <div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input size="16" type="text" value="<?php echo $today; ?>" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
				<input type="hidden" id="dtp_input2" name="tgl" value="" /><br/>
            </div>
        </fieldset>
    
  
  
  <?php	  
	  
	  echo form_fieldset_close();
  ?>
  
</div>

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
	<input id="biaya_nego" name="biaya_nego" class="form-control input-lg" type="text" placeholder="Biaya nego" title="70000" pattern="[0-9]{2,20}"></input>
	</div>

<br/><br/>
        <div>
	
	<?php
	  
	  echo form_fieldset('Catatan Pembeli','class="produk"');
	?>
	  
	  <textarea style="width:400px;height:150px;" placeholder="Catatan Pembeli" id="catatan" rows="20" cols="90" name="catatan"></textarea><br/>
	
	<?php  
	  echo form_fieldset_close();
	?>
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
<script type="text/javascript">
  
var date = new Date();
date.setDate(date.getDate()+2);
  
    $('.form_date').datetimepicker({
    //language:  'uk',
	    weekStart: 1,
	    todayBtn:  1,
	    autoclose: 1,
	    todayHighlight: 1,
	    startView: 2,
	    minView: 2,
	    forceParse: 0,
	    startDate: date
});

</script>
