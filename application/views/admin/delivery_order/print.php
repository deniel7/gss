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
		location="index.php";
		}
    </script>
    
    <style type="text/css">
    table{
	width:320px;
	padding:3px;
	
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
        <style type="text/css" media="print">
	
        *{
	    font-size:10px;
	}
	.print_area{
	    width:350px;
	}
	table,td{
	  
	   border: 2px solid #cfcfcf;
	   border-collapse: collapse;
	   padding:3px;
	}
	.hdr{
	    background-color:silver;
	    font-weight:bold;
	}
	.status{
	    width:350px;
	    float:right;
	}
	</style>
        </head>
        
        <?php $data_table=array();
		
                foreach ($q->result_array() as $row) {
			$data_table[]=$row;
		}
        ?>
        <p><img src="<?php echo base_url().'asset/images/logo.gif';?>" /></a></p>
        <p style= "float:right">
            <?php
                switch($row['status_print']) {
                case '0':
                echo "PRINTED";
                continue;
                
		case 'PRINTED':
                echo "PRINTED";
                continue;
		
		case 'COPIED':
                echo "COPIED";
                continue;   
            }
            
                echo " - ";
                echo date('d/m/Y - H:i:s');
            ?>
        </p>
        <?php
                echo (empty($row['ambil_cabang'])) ? '<h3>DELIVERY ORDER</h3>' :  '<h3>PENGAMBILAN BARANG</h3>' ;
        ?>
        

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
                    <td class="hdr">Nama Depan</td>
                    <td><?php echo $row['nama_depan']; ?></td>
                </tr>
                <tr>
                    <td class="hdr">Nama Belakang</td>
                    <td><?php echo $row['nama_belakang']; ?></td>
                </tr>
                <tr>
                    <td class="hdr">Alamat</td>
                    <td><?php echo $row['alamat']; ?></td>
                </tr>
                <tr>
                    <td class="hdr">Kode Pos</td>
                    <td><?php echo $row['kode_pos']; ?></td>
                </tr>
                <tr>
                    <td class="hdr">Telepon</td>
                    <td><?php echo $row['phone']; ?></td>
                </tr>
            </table>
            <br/>
            
        <table width="200px">
	        
        <tr>
            <td class="hdr">Penerima</td>
            <td class="hdr">Pengirim</td>
        </tr>
        <tr>
            <td><br/><br/><br/></td>
            <td><br/><br/><br/></td>
        </tr>
        <tr>
            <td><br/></td>
            <td><br/></td>
        </tr>
        
        </table>
        </div>
        </div>
        
        
    </body>
</html>