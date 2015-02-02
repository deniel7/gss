
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
		    font-size:12px;
		}
		.print_area{
		    width:210px;
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
                    <td class="hdr">Nama</td>
                    <td><?php echo $item->nama_depan." ".$item->nama_belakang; ?></td>
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
          <th>PLU</th>
	  <th>Nama Barang</th>
          <th style="text-align:right">Jml</th>
	  <!--<th style="text-align:center">SV</th>-->
          
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
		  <td style="text-align: right"><?php echo $item->kuantitas; ?></td>
		 <!-- <td colspan="2" style="text-align: right">-->
		    <?php
		
			//echo $item->SV;
		    ?>
		 <!-- </td>-->
        	  
        	</tr>
        
        <?php $i++;$total_belanja = $total_belanja + $item->subtotal; ?>
        
        <?php endforeach; ?>
        
	
	
	<tr>
	  <td><strong>Biaya Kirim</strong></td>
          <td colspan="3" style="background-color: #FFF0F0;"><strong>Rp. <?php echo $this->cart->format_number($item->biaya_kirim); ?></strong></td>
	  
	</tr>
	
        
        <?php //endforeach; ?>
        </table>
	  
	  <p>Transaksi Anda akan <b>batal</b> jika melebihi 30 menit belum melakukan transaksi di kassa.</p>
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