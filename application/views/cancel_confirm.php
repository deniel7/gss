
<?php if(@$sukses):?>
    <?php echo '<p class="msg done">'.@$sukses.'</p>';?>
    <script type="text/javascript">
    (function($) {
    	$(function() {
    		parent.jQuery.colorbox.close();
    		return false;
    	});
    })(jQuery);
    </script>
<?php else: ?>

<?php if(@$error_pass){echo @$error_pass;} ?>
<br/>
<div class="span6">

<?php $i=1; foreach($detail as $data): ?>
<?php $orderno = $data['ORDER_NO_GTRON']; ?>

<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Order No :</td>
    <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
</tr>
</table>
</div>
<br/><br/>

<?php echo form_open(site_url(uri_string())); ?>

<div class="span12">
<b>Detail Pesanan :</b>
<table cellspacing="0" cellpadding="3px">
    <tr>
        <th>Order No</th>
        <th>Tanggal Belanja</th>
        <th></th>
        
    </tr>

    <tr>
        <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
        <td><?php echo $data['tanggal_masuk']; ?></td>
        <td><?php echo anchor('store/ex_all_cancel_confirm/'.$data['ORDER_NO_GTRON'],'<div class="demo btn btn-warning btn-lg">Transaction Canceled</div>',array('onclick'=>"return confirm('Cancel Transaksi ini?')")); ?></td>
        
    </tr>
    <tr><td><br/></td></tr>
    <tr>
        <td><b>Jumlah</b></td>
        <td colspan="3"><b>Detail : </b></td>
    </tr>
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    <?php foreach($data['detail'] as $detail): ?>
    <tr>
        <td>
		
		<input type=button class="btn btn-sm btn-info" value='-' onclick='javascript:process(-1, "<?php echo "v".$i; ?>")'>
		<input type=text size='5' id='<?php echo 'v'.$i; ?>' name='v[]' value='<?php echo $detail['kuantitas']; ?>' readonly style='margin-top:10px'>
		<input type="reset" value="Reset">
		<input type="hidden" size='5' value="<?php echo $detail['id_order_detail']; ?>" name="id_order_detail[]" id="id_order_detail" />
		<input type="hidden" size='5' value="<?php echo $detail['STOCK_COST']; ?>" name="test" id="id_order_detail" />
		
	</td>
        <td><?php echo $detail['ARTICLE_DESC']; ?></td>
        <td>
	
	<?php echo anchor('store/ex_cancel_confirm/'.$detail['ARTICLE_CODE'].'/'.$detail['ORDER_NO_GTRON'].'/'.$detail['id_order'],'<img src="'.base_url().'images/delete.png" title="hapus" alt="hapus" />',array('onclick'=>"return confirm('Cancel barang ini?')")) ?>
	</td>
        
    </tr>
    
    <?php $i++; $total_item = $total_item + $detail['kuantitas'];?>
    <?php $i++; $total_cpv = $total_cpv + ($detail['STOCK_COST'] * $detail['kuantitas']);?>
    
    <?php $i++; endforeach; ?>
    <input type="hidden" size='5' value="<?php echo $total_cpv; ?>" name="total_cpv" id="total_cpv" />
    <input type="hidden" size='5' value="<?php echo $total_item; ?>" name="total_item" id="total_item" />
    <input type="hidden" size='5' value="<?php echo $orderno; ?>" name="orderno" id="order_no" />
    <tr>
	<td>
		
		<?php echo form_submit(array('name'=>'update','value'=>'Update','class'=>'btn btn-info btn-lg')); ?>
	</td>
    </tr>
    </form>
</table>

<br/><center><?php echo form_submit(array('name'=>'save','value'=>'save','class'=>'btn btn-success btn-large')); ?></center>

<div class="responsive" style="margin-bottom: 50px">
            
            <div class="text-center">
	    
	    
            </div>
</div>


<?php if ($data['FLAG'] == 0 AND $multiuser != 1){ ?>

<div class="responsive span6">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <table cellspacing="0" cellpadding="3px">
    <h4 class="modal-title">Submit Pesanan</h4>
    <tr>
	<td>Nomor Struk</td>
	<td>
	<?php
	    echo form_hidden('orderno',$orderno);	    
	?>
	<input id="nomor" type="text" name="nomor" required placeholder="Nomor Struk Pembayaran" pattern="[0-9]{2,20}" class='form-control input-lg'></input>
	</td>
    </tr>
    <tr>
	<td>Nominal Struk</td>
	<td>
	<input id="price" type="text" name="total_biaya_input" required placeholder="Total Nominal Transaksi" class='form-control input-lg'></input>
	
	</td>
    </tr>
    <tr>
    <td><button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#myModal">Cancel Pesanan</button></td>
    <td>
	<?php
	echo form_password(array(
					    'id' => 'password',
					    'name' => 'password',
					    'placeholder' => 'SPV Password',
					    'class' => 'form-control input-lg'
			    )); 
	    
	?>
	
	<?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
    </td>
    </tr>
    <?php echo form_close(); ?>
    </table>
</div>

<?php
    }
    endforeach;
?>
<div id="responsive" class="modal fade" tabindex="-1" data-width="160" style="display: none">
    
</div>


<div id="responsive2" class="modal fade" tabindex="-1" data-width="160" style="display: none;">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <?php //echo form_open('pesanan/submit_pesanan'); ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Submit Pesanan</h4>
    </div>
    <div class="modal-body">
    <div class="row">
    <div class="span4">
    
    <p>
    <?php
	
	echo form_hidden('orderno',$orderno);
	
	echo form_input(array(
					'id' => 'nomor',
                                        'name' => 'nomor',
					'placeholder' => 'Nomor Struk Pembayaran',
                                        'class' => 'form-control input-lg'
			)); 
	
    ?>
    
    </p>
    
    </div>
    
    </div>
    </div>
    <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
    <!--<button type="button" class="btn btn-primary">Submit</button>-->
    <?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Want to cancel this transaction?</h4>
      </div>
      <div class="modal-body">
      <div class="row-fluid">
     
      <form action="<?php echo site_url(uri_string()); ?>" method="POST">
      
      <?php
	
	echo form_password(array(
					'id' => 'password',
                                        'name' => 'password',
					'placeholder' => 'SPV Password',
                                        'class' => 'form-control input-lg'
			)); 
	
	echo form_hidden('orderno',$orderno); 
	
      ?>
      </div>
      </div>
      <div class="modal-footer">
	
	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	<?php echo form_submit('submit2', 'Submit','class = "btn btn-success"'); ?>
	
	<?php echo form_close(); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
  <div class="modal fade" id="long" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" class="modal container hide fade">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">View Receiving DN</h4>
        </div>
        <div class="modal-body">
	    <img src="<?php echo base_url().'uploads/receiving/'.$data['RECEIVING_DN']; ?>">
	</div>
        <div class="modal-footer">
	  
	  <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
          
        </div>
      </div><!-- /.modal-content -->
    
  </div><!-- /.modal -->


</div>

<style>
table { border: solid 1px gray; width: 100%; margin: 0 auto;}
th { text-align: center; background-color: black; color: white;}
td { border: solid 1px silver; padding: 5px;}
.col {width: 50%; float: left;}
.clear {clear: both;}
</style>

<?php endif; ?>

<script language=javascript>
function process(v, target){
    var value = parseInt(document.getElementById(target).value);
    if (value >1) {
	value+=v;
    }
    
    document.getElementById(target).value = value;

}
</script>