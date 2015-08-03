<html>
    <head>
    <script type="text/javascript">
	 function PrintContent()
		{
		var DocumentContainer = document.getElementById('print');
		var WindowObject = window.open('', 'PrintWindow',
		'width=1000,height=800,top=0,left=0,toolbars=no,scrollbars=yes,status=yes,resizable=yes');
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		
                WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
		location="";
		}
    </script>
    
    
    
    </head>
    <body>
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Print Orders</h1>
                </div>
                
            </div>
            
	    <div class="row">
                <div class="col-lg-12">
		 
                    <form action="<?php echo site_url().'admin/delivery_order/printed/'; ?>" method="POST">
				  
		    <?php //echo site_url().'delivery_order/printed/'; ?>
		    <center>
			<!--<input name="button" type="button"  value="PRINT" onClick="PrintContent()" class="btn btn-info btn-lg" />-->
		
			    <input type="submit" name="submit" value="PRINT" onClick="PrintContent()" class="btn btn-info btn-lg">
		   
		    </center>
		
		    <div id="print">
			<div class="print_area">
			    <head>
			    <style type="text/css" media="print">
			    

* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box
}

:before, :after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box
}

html {
    
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
}

body {
    font-family: Verdana,Geneva,sans-serif;
    font-size: 8px;
    line-height: 1.42857143;
    color: #333;
    background-color: #fff
}


table {
    background-color: transparent
}

th {
    text-align: left
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px
}

.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td,
.table>tbody>tr>td, .table>tfoot>tr>td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd
}

.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd
}

.table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>th, .table>caption+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>td, .table>thead:first-child>tr:first-child>td {
    border-top: 0
}

.table>tbody+tbody {
    border-top: 2px solid #ddd
}

.table .table {
    background-color: #fff
}

.table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th,
.table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
    padding: 5px
}

.table-bordered {
    border: 1px solid #ddd
}

.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th,
.table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #ddd
}

.table-bordered>thead>tr>th, .table-bordered>thead>tr>td {
    border-bottom-width: 2px
}

.table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th {
    background-color: #f9f9f9
}

.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
    background-color: #f5f5f5
}

table col[class*=col-] {
    position: static;
    display: table-column;
    float: none
}

table td[class*=col-], table th[class*=col-] {
    position: static;
    display: table-cell;
    float: none
}

.table>thead>tr>td.active, .table>tbody>tr>td.active, .table>tfoot>tr>td.active,
.table>thead>tr>th.active, .table>tbody>tr>th.active, .table>tfoot>tr>th.active,
.table>thead>tr.active>td, .table>tbody>tr.active>td, .table>tfoot>tr.active>td,
.table>thead>tr.active>th, .table>tbody>tr.active>th, .table>tfoot>tr.active>th {
    background-color: #f5f5f5
}

.table-hover>tbody>tr>td.active:hover, .table-hover>tbody>tr>th.active:hover, .table-hover>tbody>tr.active:hover>td, .table-hover>tbody>tr:hover>.active, .table-hover>tbody>tr.active:hover>th {
    background-color: #e8e8e8
}

.table>thead>tr>td.success, .table>tbody>tr>td.success, .table>tfoot>tr>td.success,
.table>thead>tr>th.success, .table>tbody>tr>th.success, .table>tfoot>tr>th.success,
.table>thead>tr.success>td, .table>tbody>tr.success>td, .table>tfoot>tr.success>td,
.table>thead>tr.success>th, .table>tbody>tr.success>th, .table>tfoot>tr.success>th {
    background-color: #dff0d8
}

.table-hover>tbody>tr>td.success:hover, .table-hover>tbody>tr>th.success:hover, .table-hover>tbody>tr.success:hover>td, .table-hover>tbody>tr:hover>.success, .table-hover>tbody>tr.success:hover>th {
    background-color: #d0e9c6
}

.table>thead>tr>td.info, .table>tbody>tr>td.info, .table>tfoot>tr>td.info,
.table>thead>tr>th.info, .table>tbody>tr>th.info, .table>tfoot>tr>th.info,
.table>thead>tr.info>td, .table>tbody>tr.info>td, .table>tfoot>tr.info>td,
.table>thead>tr.info>th, .table>tbody>tr.info>th, .table>tfoot>tr.info>th {
    background-color: #d9edf7
}

.table-hover>tbody>tr>td.info:hover, .table-hover>tbody>tr>th.info:hover, .table-hover>tbody>tr.info:hover>td, .table-hover>tbody>tr:hover>.info, .table-hover>tbody>tr.info:hover>th {
    background-color: #c4e3f3
}

.table>thead>tr>td.warning, .table>tbody>tr>td.warning, .table>tfoot>tr>td.warning,
.table>thead>tr>th.warning, .table>tbody>tr>th.warning, .table>tfoot>tr>th.warning,
.table>thead>tr.warning>td, .table>tbody>tr.warning>td, .table>tfoot>tr.warning>td,
.table>thead>tr.warning>th, .table>tbody>tr.warning>th, .table>tfoot>tr.warning>th {
    background-color: #fcf8e3
}

.table-hover>tbody>tr>td.warning:hover, .table-hover>tbody>tr>th.warning:hover, .table-hover>tbody>tr.warning:hover>td, .table-hover>tbody>tr:hover>.warning, .table-hover>tbody>tr.warning:hover>th {
    background-color: #faf2cc
}

.table>thead>tr>td.danger, .table>tbody>tr>td.danger, .table>tfoot>tr>td.danger,
.table>thead>tr>th.danger, .table>tbody>tr>th.danger, .table>tfoot>tr>th.danger,
.table>thead>tr.danger>td, .table>tbody>tr.danger>td, .table>tfoot>tr.danger>td,
.table>thead>tr.danger>th, .table>tbody>tr.danger>th, .table>tfoot>tr.danger>th {
    background-color: #f2dede
}

.table-hover>tbody>tr>td.danger:hover, .table-hover>tbody>tr>th.danger:hover, .table-hover>tbody>tr.danger:hover>td, .table-hover>tbody>tr:hover>.danger, .table-hover>tbody>tr.danger:hover>th {
    background-color: #ebcccc
}


.table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd
}

.table-responsive>.table {
    margin-bottom: 0
}

.table-responsive>.table>thead>tr>th, .table-responsive>.table>tbody>tr>th,
.table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td,
.table-responsive>.table>tbody>tr>td, .table-responsive>.table>tfoot>tr>td {
    white-space: nowrap
}

.table-responsive>.table-bordered {
    border: 0
}

.table-responsive>.table-bordered>thead>tr>th:first-child, .table-responsive>.table-bordered>tbody>tr>th:first-child, .table-responsive>.table-bordered>tfoot>tr>th:first-child, .table-responsive>.table-bordered>thead>tr>td:first-child, .table-responsive>.table-bordered>tbody>tr>td:first-child, .table-responsive>.table-bordered>tfoot>tr>td:first-child {
    border-left: 0
}

.table-responsive>.table-bordered>thead>tr>th:last-child, .table-responsive>.table-bordered>tbody>tr>th:last-child, .table-responsive>.table-bordered>tfoot>tr>th:last-child, .table-responsive>.table-bordered>thead>tr>td:last-child, .table-responsive>.table-bordered>tbody>tr>td:last-child, .table-responsive>.table-bordered>tfoot>tr>td:last-child {
    border-right: 0
}

.table-responsive>.table-bordered>tbody>tr:last-child>th, .table-responsive>.table-bordered>tfoot>tr:last-child>th, .table-responsive>.table-bordered>tbody>tr:last-child>td, .table-responsive>.table-bordered>tfoot>tr:last-child>td {
    border-bottom: 0
}

/*SET PAPER to A4*/
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
	*{
	    font-family: Verdana,Geneva,sans-serif;
    font-size: 8px;
    line-height: 1.42857143;
    color: #333;
    background-color: #fff
	}
        html, body {
            width: 210mm;
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
			    <?php foreach($detail as $data): ?>
			    <?php $orderno = $data['ORDER_NO_GTRON']; ?>
			    <div>
					    
				<?php
					      
					      echo form_hidden('orderno', $orderno);
					      
				?>
			    </div>
				
			<div class="page">	
				<div class="row">
					<div class="col-lg-12">    
					    <p style="text-align: left; float: left">
						DN Number : <?php echo $data['DN_NO']; ?>
					    </p>
					    <p style="text-align: right; float: right">
					   <?php
						echo $copied.' : ';
					   
					    ?>
					    
					    <?php echo date('d/m/Y - H:i:s'); ?>
					    </p>
					</div>

				</div>
				
				
				<div class="row">
				    <div class="col-lg-12">
					<div class="panel panel-default">
							    <div class="panel-heading">
								<div class="row">
								<div class="col-lg-6">
								<img src="<?php echo base_url().'/template/palmtree/images/logo.png'; ?>" />
								</div>
								<div class="col-lg-6">
								    <div class="panel-body">
								<div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover">
									
									<tbody>
									    <tr>
										<td>Tanggal Pemesanan</td>
										<td><?php echo $data['tanggal_masuk']; ?></td>
									    </tr>
									    <tr>
										<td>Nomor Order</td>
										<td><?php echo $data['ORDER_NO_GTRON']; ?></td>
										
									    </tr>
									    <tr>
										<td>Nomor Struk</td>
										<td><?php echo $data['no_struk']; ?></td>
										
									    </tr>
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
									    <tr>
										<td>Catatan Pembeli</td>
										<td><?php echo $data['catatan']; ?></td>
									    </tr>
									    <tr>
										<td>Penerima</td>
										<td><?php echo $data['penerima']; ?></td>
									    </tr>
									</tbody>
								    </table>
								</div>
								<!-- /.table-responsive -->
							    </div>
								</div>
								</div>
								
							    </div>
							    <!-- /.panel-heading -->
							    <div class="panel-body">
								
								<div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover">
									<thead>
									    <tr>
										<th>PLU</th>
										<th>Barang</th>
										<th>Jumlah</th>
										
									    </tr>
									</thead>
									<tbody>
									    <?php foreach($data['detail'] as $detail): ?>
									    <tr>
										<td><?php echo $detail['PLU']; ?></td>
										<td><?php echo $detail['ARTICLE_DESC']; ?></td>
										<td style="text-align: right"><?php echo $detail['kuantitas']; ?></td>
										
									    </tr>
									    <?php endforeach; ?>
									    <!--<tr>
										<td colspan="2" style="text-align: right">Biaya</td>
										<td style="text-align: right"><?php //echo $this->cart->format_number($data['biaya_kirim']); ?></td>
									    </tr>-->
									    
									</tbody>
								    </table>
								</div>
								<!-- /.table-responsive -->
							    </div>
							    <!-- /.panel-body -->
					</div>
				    </div>
				</div>
				
				
				
			    
			    
			    <div class="row">
				    <div class="col-lg-12">
					<div class="panel panel-default">
					    <div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
						    <thead>
							<tr>
							    
							    <th>Warehouse YOEL</th>
							    <th>Supervisor DC</th>
							    <th>Loading YOEL</th>
							    <th>Pengirim</th>
							    <th>Penerima</th>
							</tr>
						    </thead>
						    <tbody>
							<tr>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							</tr>
							<tr>
							    <td>Nama : </td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							</tr>
							
						    </tbody>
						</table>
					    </div>
					</div>
				    </div>
				</div>
				
				<div class="panel-heading">
				    <p style="text-align: right">*Barang <b>telah dikirimkan dan diterima</b> dengan baik dan lengkap oleh konsumen</p>
				</div>	


			    
			</form>
			</div>
			
			<div class="page">	
				<div class="row">
					<div class="col-lg-12">    
					    <p style="text-align: left; float: left">
						DN Number : <?php echo $data['DN_NO']; ?>
					    </p>
					    <p style="text-align: right; float: right">
					   <?php
						echo $copied.' : ';
					   
					    ?>
					    
					    <?php echo date('d/m/Y - H:i:s'); ?>
					    </p>
					</div>

				</div>
				
				
				<div class="row">
				    <div class="col-lg-12">
					<div class="panel panel-default">
							    <div class="panel-heading">
								<div class="row">
								<div class="col-lg-6">
								<img src="<?php echo base_url().'/template/palmtree/images/logo.png'; ?>" />
								</div>
								<div class="col-lg-6">
								    <div class="panel-body">
								<div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover">
									
									<tbody>
									    <tr>
										<td>Tanggal Pemesanan</td>
										<td><?php echo $data['tanggal_masuk']; ?></td>
									    </tr>
									    <tr>
										<td>Nomor Order</td>
										<td><?php echo $data['ORDER_NO_GTRON']; ?></td>
										
									    </tr>
									    <tr>
										<td>Nomor Struk</td>
										<td><?php echo $data['no_struk']; ?></td>
										
									    </tr>
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
									    <tr>
										<td>Catatan Pembeli</td>
										<td><?php echo $data['catatan']; ?></td>
									    </tr>
									    <tr>
										<td>Penerima</td>
										<td><?php echo $data['penerima']; ?></td>
									    </tr>
									</tbody>
								    </table>
								</div>
								<!-- /.table-responsive -->
							    </div>
								</div>
								</div>
								
							    </div>
							    <!-- /.panel-heading -->
							    <div class="panel-body">
								
								<div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover">
									<thead>
									    <tr>
										<th>PLU</th>
										<th>Barang</th>
										<th>Jumlah</th>
										
									    </tr>
									</thead>
									<tbody>
									    <?php foreach($data['detail'] as $detail): ?>
									    <tr>
										<td><?php echo $detail['PLU']; ?></td>
										<td><?php echo $detail['ARTICLE_DESC']; ?></td>
										<td style="text-align: right"><?php echo $detail['kuantitas']; ?></td>
										
									    </tr>
									    <?php endforeach; ?>
									    <!--<tr>
										<td colspan="2" style="text-align: right">Biaya</td>
										<td style="text-align: right"><?php //echo $this->cart->format_number($data['biaya_kirim']); ?></td>
									    </tr>-->
									    
									</tbody>
								    </table>
								</div>
								<!-- /.table-responsive -->
							    </div>
							    <!-- /.panel-body -->
					</div>
				    </div>
				</div>
				
				
				
			    
			    
			    <div class="row">
				    <div class="col-lg-12">
					<div class="panel panel-default">
					    <div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
						    <thead>
							<tr>
							    
							    <th>Warehouse YOEL</th>
							    <th>Supervisor DC</th>
							    <th>Loading YOEL</th>
							    <th>Pengirim</th>
							    <th>Penerima</th>
							</tr>
						    </thead>
						    <tbody>
							<tr>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							</tr>
							<tr>
							    <td>Nama : </td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							</tr>
							
						    </tbody>
						</table>
					    </div>
					</div>
				    </div>
				</div>
				
				<div class="panel-heading">
				    <p style="text-align: right">*Barang <b>telah dikirimkan dan diterima</b> dengan baik dan lengkap oleh konsumen</p>
				</div>	


			    
			
			</div>
		    
			
			<div class="page">	
				<div class="row">
					<div class="col-lg-12">    
					    <p style="text-align: left; float: left">
						DN Number : <?php echo $data['DN_NO']; ?>
					    </p>
					    <p style="text-align: right; float: right">
					   <?php
						echo $copied.' : ';
					   
					    ?>
					    
					    <?php echo date('d/m/Y - H:i:s'); ?>
					    </p>
					</div>

				</div>
				
				
				<div class="row">
				    <div class="col-lg-12">
					<div class="panel panel-default">
							    <div class="panel-heading">
								<div class="row">
								<div class="col-lg-6">
								<img src="<?php echo base_url().'/template/palmtree/images/logo.png'; ?>" />
								</div>
								<div class="col-lg-6">
								    <div class="panel-body">
								<div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover">
									
									<tbody>
									    <tr>
										<td>Tanggal Pemesanan</td>
										<td><?php echo $data['tanggal_masuk']; ?></td>
									    </tr>
									    <tr>
										<td>Nomor Order</td>
										<td><?php echo $data['ORDER_NO_GTRON']; ?></td>
										
									    </tr>
									    <tr>
										<td>Nomor Struk</td>
										<td><?php echo $data['no_struk']; ?></td>
										
									    </tr>
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
									    <tr>
										<td>Catatan Pembeli</td>
										<td><?php echo $data['catatan']; ?></td>
									    </tr>
									    <tr>
										<td>Penerima</td>
										<td><?php echo $data['penerima']; ?></td>
									    </tr>
									</tbody>
								    </table>
								</div>
								<!-- /.table-responsive -->
							    </div>
								</div>
								</div>
								
							    </div>
							    <!-- /.panel-heading -->
							    <div class="panel-body">
								
								<div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover">
									<thead>
									    <tr>
										<th>PLU</th>
										<th>Barang</th>
										<th>Jumlah</th>
										
									    </tr>
									</thead>
									<tbody>
									    <?php foreach($data['detail'] as $detail): ?>
									    <tr>
										<td><?php echo $detail['PLU']; ?></td>
										<td><?php echo $detail['ARTICLE_DESC']; ?></td>
										<td style="text-align: right"><?php echo $detail['kuantitas']; ?></td>
										
									    </tr>
									    <?php endforeach; ?>
									    <!--<tr>
										<td colspan="2" style="text-align: right">Biaya</td>
										<td style="text-align: right"><?php //echo $this->cart->format_number($data['biaya_kirim']); ?></td>
									    </tr>-->
									    
									</tbody>
								    </table>
								</div>
								<!-- /.table-responsive -->
							    </div>
							    <!-- /.panel-body -->
					</div>
				    </div>
				</div>
				
				
				
			    
			    
			    <div class="row">
				    <div class="col-lg-12">
					<div class="panel panel-default">
					    <div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
						    <thead>
							<tr>
							    
							    <th>Warehouse YOEL</th>
							    <th>Supervisor DC</th>
							    <th>Loading YOEL</th>
							    <th>Pengirim</th>
							    <th>Penerima</th>
							</tr>
						    </thead>
						    <tbody>
							<tr>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							    <td><br/><br/><br/></td>
							</tr>
							<tr>
							    <td>Nama : </td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							    <td>Nama :</td>
							</tr>
							
						    </tbody>
						</table>
					    </div>
					</div>
				    </div>
				</div>
				
				<div class="panel-heading">
				    <p style="text-align: right">*Barang <b>telah dikirimkan dan diterima</b> dengan baik dan lengkap oleh konsumen</p>
				</div>	


			    
			
			</div>
			
			</div>
		    </div>
		    <?php endforeach; ?>
		</div>
	    </div>
    </body>
</html>