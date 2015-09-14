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
<h1><?php //echo validation_errors('<p class="error">'); ?></h1>
<?php foreach($detail as $data): ?>
<?php $orderno = $data['ORDER_NO_GTRON']; ?>


<?php if($multiuser !=1): ?>
<div class="responsive span6" style="margin-bottom: 50px">
	
<form action="<?php echo site_url(uri_string()); ?>" method="POST">
<table cellspacing="0" cellpadding="3px">
	<tr>
	    <td>Order No</td>
	    <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
	</tr>
	
	<tr>
	    <td>Nomor Struk</td>
	    <td>
		<input id="nomor" type="text" value="<?php echo $data['no_struk']; ?>" name="nomor" placeholder="Nomor Struk Pembayaran"></input>
		
		<?php
	
			echo form_hidden('orderno',$orderno);
			
			//echo form_input(array(
			//				'id' => 'nomor',
			//				'name' => 'nomor',
			//				'placeholder' => 'Nomor Struk Pembayaran',
			//				'value' =>  $data['no_struk'],
			//				'class' => 'form-control input-lg'
			//		)); 
			
		?>
	    </td>
	</tr>
	<tr>
		<td>Nominal Struk</td>
		<td>Rp. <input onkeyup='val_number("total_biaya_input")' id="total_biaya_input" type="text" value="<?php echo $data['TOTAL_BIAYA_INPUT']; ?>" name="total_biaya_input" placeholder="Total Nominal Transaksi"></input></td>
		
	</tr>
	<tr>
		<td>Status Revisi Input</td>
		<td><span id="nominal_verify" class="verify"></span></td>
	</tr>
	<tr>
		<td>
			
			
			
		</td>
		<td>
			<?php
					echo form_password(array(
							    'id' => 'password',
							    'name' => 'password',
							    'placeholder' => 'SPV Password',
							    'class' => 'form-control input-lg'
					    )); 
			    
			?>
			<br/>
			<?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
			<!--<button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#myModal">Cancel Pesanan</button>-->
			<?php echo form_submit('submit2', 'Cancel Pesanan','class = "demo btn btn-warning btn-lg"'); ?>
		
		</td>
		<?php echo form_close(); ?>
	</tr>
	

</table>
            
</div>
<?php endif; ?>


<div class="span10">
<b>Data Konsumen :</b>
<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Nama </td><td><?php echo $data['nama_depan'].' '.$data['nama_belakang']; ?></td>
</tr>
<tr>
    <td>Alamat</td><td><?php echo $data['alamat']; ?></td>
</tr>
<tr>
    <td>Kode Pos</td><td><?php echo $data['kode_pos']; ?></td>
</tr>
<tr>
    <td>Telepon</td><td><?php echo $data['phone']; ?></td>
</tr>
</table>
</div>

<div class="span2">
    <p><b>Bukti Penerimaan :</b></p>
    <?php if($data['RECEIVING_DN']): ?>
    <a data-toggle="modal" href="#long" class="thumbnail">
	<img src="<?php echo base_url().'uploads/receiving/'.$data['RECEIVING_DN']; ?>" alt="...">
    </a>
    <?php else: ?>
    <p style="font-size: 12px">Belum Ada</p>
    <?php endif; ?>
</div>

<div class="clear"></div>
<br />


<div class="span12">
<b>Detail Pesanan :</b>
<table cellspacing="0" cellpadding="3px">
    <tr>
        <th>Order No</th>
        <th>Tanggal Belanja</th>
        <th>Jumlah Item</th>
        <!--<th>Total Belanja</th>-->
    </tr>

    <tr>
        <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
        <td><?php echo $data['tanggal_masuk']; ?></td>
        <td><?php echo $data['total_item']; ?></td>
        <!--<td> Rp. <?php //echo $this->cart->format_number($data['total_biaya']); ?></td>-->
    </tr>
    <tr><td><br/></td></tr>
    <tr>
        <td></td>
        <td colspan="3"><b>Detail : </b></td>
    </tr>
    
    
    <?php foreach($data['detail'] as $detail): ?>
    <tr>
        <td></td>
        <td><?php echo $detail['ARTICLE_DESC']; ?></td>
        <td><?php echo $detail['kuantitas']; ?></td>
        <!--<td>Rp. <?php //echo $this->cart->format_number($detail['subtotal']); ?></td>-->
    </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td colspan="1" style="text-align: right"><b>Biaya Kirim</b></td>
	<td>Rp. <?php echo $this->cart->format_number($data['biaya_kirim']); ?></td>
    </tr>
    
</table>


<br/>
<div>
    
</div>



<?php
    
    endforeach;
?>
<div id="responsive" class="modal fade" tabindex="-1" data-width="160" style="display: none">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <?php //echo form_open('pesanan/submit_pesanan'); ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Submit Pesanan</h4>
    </div>
    <div class="modal-body">
    <div class="row">
    <div class="span4">
    <!--<h4>Bukti Pembayaran Transaksi</h4>-->
    <p>
    <?php
	
	echo form_hidden('orderno',$orderno);
	
	echo form_input(array(
					'id' => 'nomor',
                                        'name' => 'nomor',
					'placeholder' => 'Nomor Struk Pembayaran',
					'value' =>  $data['no_struk'],
                                        'class' => 'form-control input-lg'
			)); 
	
    ?>
    </p>
    
    <p>
	<input id="total_biaya_input" type="text" value="<?php echo $data['TOTAL_BIAYA_INPUT']; ?>" name="total_biaya_input" placeholder="Total Nominal Transaksi"></input>
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
	
	echo form_hidden('orderno',$orderno); 
	
      ?>
      </div>
      </div>
      <div class="modal-footer">
	
	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	<?php echo form_submit('submit2', 'Yes','class = "btn btn-success"'); ?>
	
	<?php echo form_close(); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>

<style>
table { border: solid 1px gray; width: 100%; margin: 0 auto;}
th { text-align: center; background-color: black; color: white;}
td { border: solid 1px silver; padding: 5px;}
.col {width: 50%; float: left;}
.clear {clear: both;}
.verify
{
    margin-top: 0px;
    margin-left: 9px;
    position: relative;
    
}
</style>

<?php endif; ?>

<script type="text/javascript">



$(document).ready(function(){
	
	
	$("#total_biaya_input").keyup(function(){
		
        if($("#total_biaya_input").val().length >= 3)
        {
        
	$.ajax({
            type: "POST",
            url: "<?php echo base_url();?>store/check_nominal",
            data: "total_biaya_input="+$("#total_biaya_input").val()+"&nomor="+$("#nomor").val(),
            success: function(msg){
		
		
                if(msg=="true")
                {
		    
		    $("#nominal_verify").html("<p style='color:green'><img src='<?php echo base_url();?>images/yes.png'/> Penginputan Nomor & Nominal Struk Benar</p>");
		}
                else
		{
                    $("#nominal_verify").html("<p style='color:red'><img src='<?php echo base_url();?>images/no.png'/> Ulangi penginputan Nomor & Nominal Struk</p>");
		
		}
		
	    
            }
        });
		 
		}
        else 
		{
            $("#nominal_verify").css({ "background-image": "none" });
        }
    });
	
	
	
	//avoid bugs.. call function once	
    val_number('total_biaya_input');
    
});


</script>
<script type="text/javascript">
	 
	function val_number(id) {
		$("#"+id).keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	} 
</script>