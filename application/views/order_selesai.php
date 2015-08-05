    <body>
        <?php //$num=1; ?>
        <div class="row" style="padding: 50px 100px 150px 100px">
	  <div class="span10">
	    <center><input name="button" type="button" class="btn btn-small btn-success"  value="PRINT" onClick="PrintContent()" /></center>
	    <div id="print">
            <div class="print_area">
	      <head>
	      <style type="text/css" media="print">
	      
		*{
		    /*font-size:16px;*/
		    
		}
		.print_area{
		    /*width:210px;*/
		    /*width:3000px;
		    font-size:120px;*/
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
		
		/*SET PAPER to A4*/
		.page {
		    width: 80mm;
		    min-height: 297mm;
		    
		    margin: 10mm auto;
		    border: 1px #D3D3D3 solid;
		    border-radius: 5px;
		    background: white;
		    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}
		
		@page {
		    size: 3.1in 11.6in;
		    margin: 0;
		}
		@media print {
		    *{
			font-family: Verdana,Geneva,sans-serif;
			font-size: 14px;
			line-height: 1.42857143;
			color: #333;
			background-color: #fff
		    }
		    html, body {
			width: 80mm;
			height: 297mm;
			
		    }
		    .page {
			margin: 0;
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		    }
		}
	    /*END SET PAPER to A4*/
	      
	      
	      </style>
	      </head>
	      <div class="page">
	      <p><img src="<?php echo base_url().'asset/themes/images/logo.png';?>" /></a></p>

            <table class="table table-bordered">
		<?php $i = 1;$total_belanja = 0; ?>
		<?php foreach ($pembeli as $item): ?>
		
		<?php
		
			$tanggal = explode(' ',$item->tanggal_masuk);
			
		?>
		<tr>
                    <td class="hdr">Tanggal Pemesanan</td>
                    <td><?php echo $tanggal[0]; ?></td>
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
	    
	    
	    <table class="table table-bordered" style="margin-top: 20px !important;">
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
	  <td rowspan="2"><strong>PLU : 01342635</strong></td>
	  <td style="background-color: #FFF0F0;"  colspan="2">
	    <strong>Desc : Biaya Kirim</strong>
	</tr>
	<tr>

	  <td style="background-color: #FFF0F0;" colspan="2">
	    <strong>
	     Rp. <?php echo $this->cart->format_number($item->biaya_kirim); ?>
	    </strong>
	  </td>
	</tr>
	
        
        <?php //endforeach; ?>
        </table>
	  
	  <p style="font-size: larger"><b>Transaksi Anda akan batal jika melebihi 30 menit belum melakukan transaksi di kassa.</b></p>
	    </div>
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
		location="<?php echo base_url(); ?>";
		}
    </script>