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
<?php foreach($detail as $data): ?>
<?php $orderno = $data['ORDER_NO_GTRON']; ?>

<div id="page-wrapper">
<?php echo"<br/><div class='bg-danger'>".$error.'</div>';?>
<div class="row">
	    <div class="col-lg-10">
		<h1 class="page-header">Detail Order</h1>
	    </div>
	    <?php if($cek_dn): ?>
		
		<?php if ($data['RECEIVING_DN'] ==NULL){ ?>
		<div class="col-lg-2">
		    <h1><a data-toggle="modal" href="#myUpload" class="btn btn-large btn-info"><i class="fa fa-upload"></i> Receiving DN</a></h1>
		</div>
		
		<?php }else{ ?>
		
		<div class="col-lg-2 col-md-3">
		    <a data-toggle="modal" href="#long" class="thumbnail">
		      <img src="<?php echo base_url().'uploads/receiving/'.$data['RECEIVING_DN']; ?>" alt="...">
		    </a>
		</div>
		<?php } ?>
	    <?php endif; ?>

</div>

<div class="row">
    <div class="col-lg-12">
	<div class="panel panel-default">
			    <div class="panel-heading">
				<h4>Detail Pesanan</h4>
			    </div>
			    <!-- /.panel-heading -->
			    <div class="panel-body">
				<div class="table-responsive">
				    <table class="table table-striped table-bordered table-hover">
					
					<tbody>
					
					    <tr>
						<td>Nomor Order</td>
						<td><?php echo $data['ORDER_NO_GTRON']; ?></td>
						
					    </tr>
					    
					    <tr>
						<td>Tanggal Pemesanan</td>
						<td><?php echo $data['tanggal_masuk']; ?></td>
						
					    </tr>
					    
					    
					   
					</tbody>
				    </table>
				</div>
				
				<div class="table-responsive">
				    <table class="table table-striped table-bordered table-hover">
					<thead>
					    <tr>
						
						<th>Items</th>
						<th>Jumlah</th>
						<th>Harga</th>
					    </tr>
					</thead>
					<tbody>
					    <?php foreach($data['detail'] as $detail): ?>
					    <tr>
						<td><?php echo $detail['ARTICLE_DESC']; ?></td>
						<td><?php echo $detail['kuantitas']; ?></td>
						<td>Rp. <?php echo $this->cart->format_number($detail['subtotal']); ?></td>
					    </tr>
					    <?php endforeach; ?>
					    <tr>
						<td colspan="2" style="text-align: right;">Biaya</td>
						<td>Rp. 1,000</td>
					    </tr>
					    <tr>
						<td colspan="2" style="text-align: right">Total</td>
						
						<td>Rp. <?php echo $this->cart->format_number($data['total_biaya']); ?></td>
					    </tr>
					</tbody>
				    </table>
				</div>
				<!-- /.table-responsive -->
			    </div>
			    <!-- /.panel-body -->
	</div>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-lg-8">
	<div class="panel panel-default">
			    <div class="panel-heading">
				<h4>Data Pembeli</h4>
			    </div>
			    <!-- /.panel-heading -->
			    <div class="panel-body">
				<div class="table-responsive">
				    <table class="table table-striped table-bordered table-hover">
					
					<tbody>
					    <tr>
						<td>Nama</td>
						<td><?php echo $data['nama_depan'].' '.$data['nama_belakang']; ?></td>
						
					    </tr>
					    <tr>
						<td>Alamat</td>
						<td><?php echo $data['alamat']; ?></td>
						
					    </tr>
					    <tr>
						<td>Kode Pos</td>
						<td><?php echo $data['kode_pos']; ?></td>
					    </tr>
					    <tr>
						<td>Telepon</td>
						<td><?php echo $data['phone']; ?></td>
					    </tr>
					</tbody>
				    </table>
				</div>
				<!-- /.table-responsive -->
			    </div>
			    <!-- /.panel-body -->
	</div>
    </div>
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


<?php endforeach; ?>

<br/>


<?php 

//echo form_submit('submit','SUBMIT PESANAN');

?>



<!--<div class="responsive">
            
            <div class="text-center">
	    <a data-toggle="modal" href="#myModal" class="btn btn-success btn">Process</a>
	    
            <?php //echo form_button(array('class' =>'btn btn-warning btn'),'Back',$js = 'onClick="history.go(-1)"'); ?>
	    </div>
</div>-->
<br/>




</div>


<!-- Modal -->
  <div class="modal fade" id="myUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Processing Order</h4>
        </div>
        <div class="modal-body">
        
	<?php
                    //$komplemen = array('id'=>'addForm', 'name'=>'addForm');
		    echo form_open_multipart(site_url(uri_string()));
	       ?>
		
		    
		    <div class="row">
		    
                    <div class="col-lg-6"><input type="file" name="userfile" id="userfile" size="20" /></div>
		    </div>

               
	       
	
	<!--<form action="<?php //echo site_url(uri_string()); ?>" method="POST">-->
	<?php
	    echo form_hidden('orderno',$orderno);
	?>
	</div>
        <div class="modal-footer">
	  <?php //echo form_submit('submit', 'Yes','class = "btn btn-primary"'); ?>
	  <input type="submit" value="upload" name="go_upload" class="btn btn-primary" />
	  <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
          <?php echo form_close(); ?>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Processing Order</h4>
        </div>
        <div class="modal-body">
        Yakin akan memproses pesanan ini?
	<form action="<?php echo site_url(uri_string()); ?>" method="POST">
	<?php
	    echo form_hidden('orderno',$orderno);
	?>
	</div>
        <div class="modal-footer">
	  <?php echo form_submit('submit', 'Yes','class = "btn btn-primary"'); ?>
	  <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
          <?php echo form_close(); ?>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->




<style>
table { border: solid 1px gray; width: 100%; margin: 0 auto;}
th { text-align: center; background-color: black; color: white;}
td { border: solid 1px silver; padding: 5px;}
.col {width: 50%; float: left;}
.clear {clear: both;}
</style>

<?php endif; ?>