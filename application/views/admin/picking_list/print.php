<html>
    <head>
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
    
    <style type="text/css">
    
    table{
	width:320px;
	padding:3px;
	text-align:center;
	font-size:10px;
    }
    
    .hdr{
	background-color:silver;
	font-weight:bold;
	
    }
    
    </style>
    
    </head>
    <body><input name="button" type="button"  value="PRINT" onClick="PrintContent()" />
        <?php $num=1; ?>
        
        <div id="print">
        <div class="print_area">
	<head>
	<!--<style type="text/css" media="print">
	*{
	    font-size:10px;
	}
	.print_area{
	    width:320px;
	}
	table,td{
	   text-align:center;
	   border: 2px solid #cfcfcf;
	   border-collapse: collapse;
	   padding:3px;
	}
	.hdr{
	    background-color:silver;
	    font-weight:bold;
	}
	.status{
	    width:320px;
	    float:right;
	}
	</style>-->
	
	</head>
        
        <?php $data_table=array();
		
                foreach ($q->result_array() as $row) {
			$data_table[]=$row;
		}
        ?>
        <p><img src="<?php echo base_url().'asset/images/logo.png';?>" /></a></p>
        <p style= "float:right">
            <?php
                switch($row['status_print']) {
                case '0':
                echo "PRINTED";
                continue;
                
		case 'PRINTED':
                echo "COPIED";
                continue;
		
		case 'COPIED':
                echo "COPIED";
                continue;
            
            }     
            echo " - ";
	    echo date('d/m/Y - H:i:s');
	    ?>
        
	</p>
        
        <h3>PICKING LIST</h3>
	
            <table>
                <tr>
                    <td class="hdr">Tanggal Pemesanan</td>
                    <td><?php echo date("d/m/Y - H:i",strtotime($row['tanggal_masuk'])) ?></td>
                </tr>
                <tr>
                    <td class="hdr">No. Order</td>
                    <td><?php echo $row['order_no']; ?></td>
                </tr>
                <tr>
                    <td class="hdr">Cabang</td>
                    <td><?php echo $row['kode_cabang']; ?></td>
                </tr>
                <tr>
                    <td class="hdr">Nama Pembeli</td>
                    <td><?php echo $row['username']; ?></td>
                </tr>
            </table>
            
	<h4>LIST ITEM :</h4>
        <table>
        
        <?php foreach ($q->result_array() as $row): ?>
	
        <tr>
        <?php $num++; ?>    
        <td style="margin-top:80px" rowspan="4"><div id="bcTarget<?php echo $num;?>"></div></td>
	<td colspan="3" class="hdr">Nama Produk</td>
	</tr>
	<tr>
	<td colspan="4"><?php echo $row['nama_produk']; ?></td>
        </tr>
        <tr>
	    <td class="hdr">Harga</td>
	    <td class="hdr">Qty</td>
	    <td class="hdr">Cek</td>
	</tr>
	<tr>
        <td>Rp. <?php echo $row['harga_jual']; ?></td>
	<td align="center"><?php echo $row['kuantitas']; ?></td>
        <td><p class="cek">&nbsp; &nbsp; &nbsp; &nbsp;</p></td>
        </tr>
        <script>
        
        <?php  echo 'var value = "'.$row['entry_number'].'";'; ?>
        $("#bcTarget<?php echo $num;?>").barcode(value, "ean8",{barWidth:2, barHeight:45});
        
        </script>
        
        <?php 
	    endforeach;
	?>
        </table>
        </div>
        </div>
        
    </body>
</html>