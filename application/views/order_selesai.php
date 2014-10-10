
    <body>
        <?php //$num=1; ?>
        <div class="row" style="padding: 50px 100px 150px 100px">
	  <div class="span10">
	    <center><input name="button" type="button" class="btn btn-small btn-success"  value="PRINT" onClick="PrintContent()" /></center>
        <div id="print">
            <div class="print_area">
	      <head>
	      <style type="text/css">
	      
		*{
		    font-size:10px;
		}
		.print_area{
		    width:350px;
		}
		table,td{
		  
		   /*border: 2px solid #cfcfcf;
		   border-collapse: collapse;
		   padding:3px;*/
		   
		   border-width: 1px 1px 1px 1px;
		    border-style: solid solid solid solid;
		    border-color: #DDD #DDD #DDD #DDD;
		    -moz-border-top-colors: none;
		    -moz-border-right-colors: none;
		    -moz-border-bottom-colors: none;
		    -moz-border-left-colors: none;
		    border-image: none;
		    border-collapse: separate;
		    border-radius: 1px;
		   
		   padding:3px;
		   
		   
		}
		.hdr{
		  
		    font-weight:bold;
		}
		
	      
	      </style>
	      </head>
	      
	      <p><img src="<?php echo base_url().'asset/themes/images/logo.gif';?>" /></a></p>

            <table class="table table-bordered">
		<?php $i = 1;$total_belanja = 0; ?>
		<?php foreach ($pembeli as $item): ?>
		<tr>
                    <td class="hdr">Tanggal Pemesanan</td>
                    <td><?php echo $item->tanggal_masuk; ?></td>
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
		<?php endforeach; ?>
            </table>
	    
	    
	    <table class="table table-bordered" style="margin-top: 20px;">
	<thead>
        <tr>
          <th>Nama Barang</th>
          <th style="text-align:right">QTY</th>
	  <th style="text-align:center">Pembayaran</th>
          <th style="text-align:right">Harga Satuan</th>
          <th style="text-align:right">Sub-Total</th>
        </tr>
        </thead>
        <?php foreach ($transaksi as $item): ?>
        
        	<tr>
        	  <td>
		      <p><strong><?php echo $item->ARTICLE_DESC; ?></strong></p>
        	  </td>
		  <td align="center"><?php echo $item->kuantitas; ?></td>
		  <td align="center">
		    <?php
		      if($item->SV == '1'){
			echo "CREDIT";
		      }else{
			echo "CASH";
		      }
		    ?>
		  </td>
        	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($item->SALES_UNIT_PRICE); ?></td>
        	  <td style="text-align:right">Rp. <?php echo $this->cart->format_number($item->subtotal); ?></td>
        	</tr>
        
        <?php $i++;$total_belanja = $total_belanja + $item->subtotal; ?>
        
        <?php endforeach; ?>
        
	<tr>
	  <td></td>
          <td></td>
	  <td></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Jumlah</strong></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($total_belanja); ?></strong></td>
	</tr>
	
	<tr>
	  <td></td>
          <td></td>
	  <td></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Handling Fee</strong></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php //echo $this->cart->format_number($biaya); ?>1,000</strong></td>
	  
	</tr>
	
        <tr>
          <td></td>
          <td></td>
	  <td></td>
	  <?php
	    
	    //$total_belanja = $this->cart->total();
	    //$total = $total_belanja + $biaya;
	    //echo $total_item;
	  ?>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Total</strong></td>
          <td style="text-align:right; background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($item->total_biaya); ?></strong></td>
        </tr>
        <?php //endforeach; ?>
        </table>
	  
	  </div>
	</div>
	<center><input name="button" type="button" class="btn btn-small btn-success"  value="PRINT" onClick="PrintContent()" /></center>
	
	
	</div>
	</div>
	<script type="text/javascript">
	 function PrintContent()
		{
		var DocumentContainer = document.getElementById('print');
		var WindowObject = window.open('', 'PrintWindow',
		'width=1000,height=600,top=0,left=0,toolbars=no,scrollbars=yes,status=yes,resizable=yes');
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		
                WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
		location="";
		}
    </script>