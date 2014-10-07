<script>
function myFunction()
{
var x;
var r=confirm("Press a button!");
if (r==true)
  {
    x="You pressed OK!";
  }
else
  {
    x="You pressed Cancel!";
  }
document.getElementById("demo").innerHTML=x;
}
</script>

<?php if (!$logged_in): ?>
    <div class="error">Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.</div>
    <br/>
    <div><?php echo anchor(site_url('user/login'),'LOGIN disini') ?></div>
<?php else: ?>

<div class="span12">
  <p>
    <ul id="checkout-progress">
      <li id="checkout-step-0" class="checkout-step"  style="border-bottom: 3px solid red;">
	<a id="checkout-step-link-0" class="checkout-step-link" href="javascript:void(0)" title="Review Pesanan">
            <div class="checkout-step-number-active">1</div>
            <div class="checkout-step-label-active">Review Pesanan</div>
        </a>
      </li>
      
      <li id="checkout-step-1" class="checkout-step" style="border-bottom: 3px solid #CCC;">
	<a id="checkout-step-link-1" class="checkout-step-link" href="javascript:void(0)" title="Pengiriman &amp Pembayaran">
            <div class="checkout-step-number">2</div>
            <div class="checkout-step-label">Pengiriman</div>
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


<div class="span12">
<!--<h2>Catatan Belanja</h2>-->
<?php echo form_open(site_url(uri_string())); ?>

<table class="table table-bordered">
<thead>
  <tr>
  <th>Nama Barang</th>
  <th>Jumlah</th>
  <th>Hapus</th>
  <th>Pembayaran</th>
  <th>Harga Satuan</th>
  <th>Sub-Total</th>
  </tr>
</thead>

<tbody>
<?php $i = 1; ?>
<?php if ($this->cart->contents() != NULL){ ?>
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
      <td align="center"><?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
	  <td style="text-align:center"><?php echo anchor('store/confirm_delete/'.$items['rowid'],'<img src="'.base_url().'images/delete.png" alt="hapus" />',array('onclick'=>"return confirm('Yakin akan menghapus produk ini?')")) ?></td>
	  <td style="text-align:center">
	  <?php
	    if($items['pembayaran'] == '1'){
	      echo "CREDIT";
	    }else{
	      echo "CASH";
	    }
	    //echo form_hidden(array('name' => 'pemb', 'value' => $items['pembayaran'], 'maxlength' => '3', 'size' => '5'));
	  ?>
	  </td>
	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
	</tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
  <!--<button onclick="myFunction()">try</button>-->
  <td></td>
  <td align="center"><?php echo form_submit('', 'Update Jumlah'); ?></td>
  <td></td>
  <td></td>
  <td style="text-align:right; background-color: #FFF0F0;"><strong>Total</strong></td>
  <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></strong></td>
</tr>
</tbody>
</table>
<a href="<?php echo site_url('store/kategori') ?>" class="btn btn-large"><i class="icon-arrow-left"></i> Back </a>
<a href="<?php echo site_url('store/order') ?>" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>



<div class="clear"></div>
<br/><br/>
<hr/>
<br/><br/>

  
  <?php } ?>
</div>
<?php endif; ?>
<script type="text/javascript">
jQuery(function($) {
	$("#hapus").colorbox({
		width:"400", height:"400", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>

