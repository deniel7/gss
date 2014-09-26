<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>untitled</title>
	<style type="text/css" media="screen">
	#container {
	 width: 600px;
	 margin: auto;
	font-family: helvetica, arial;
	}

	table {
	 width: 600px;
	 margin-bottom: 10px;
	}

	td {
	 border-right: 1px solid #aaaaaa;
	 padding: 1em;
	}

	td:last-child {
	 border-right: none;
	}

	th {
	 text-align: left;
	 padding-left: 1em;
	 background: #cac9c9;
	border-bottom: 1px solid white;
	border-right: 1px solid #aaaaaa;
	}

	/*#pagination a, #pagination strong {
	 background: #e3e3e3;
	 padding: 4px 7px;
	 text-decoration: none;
	border: 1px solid #cac9c9;
	color: #292929;
	font-size: 13px;
	}

	#pagination strong, #pagination a:hover {
	 font-weight: normal;
	 background: #cac9c9;
	}		*/
	</style>
</head>
<body>
     <!--<div id="container">
		<h1>Super Pagination with CodeIgniter</h1>
		
		<?php //echo $this->table->generate($records); ?>
		<?php //echo $this->pagination->create_links(); ?>
	 </div>-->
     
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>	

<script type="text/javascript" charset="utf-8">
	$('tr:odd').css('background', '#e3e3e3');
</script>



<?php foreach($produk as $item): ?>
    <div class="produk-wrap">
        
        <div class="image-wrap">
            <div class="image-iner">
                <?php if($item->thumb == ''): ?>
                    <div class="no-image">
                        <span>Belum ada Gambar</span>
                    </div>
                <?php else: ?>
                    <img src="<?php echo base_url().$item->thumb ?>" />
                <?php endif; ?>
                <?php //if ($item->stok == 0): ?>
                    <!--<div class="trans">
                        <span>Stok Habis</span>
                    </div>-->
                <?php //endif; ?>
            </div>
        </div>
        <div class="produk-name">
            <?php echo anchor(site_url(uri_string().'/'.$item->url_produk),$item->nama_produk);?>
        </div>
        <?php if($item->harga_baru != 0): ?>
            <div class="harga-lama">
                Rp. <?php echo $this->cart->format_number($item->harga_jual) ?>
            </div>
            <div class="harga-jual">
                Rp. <?php echo $item->harga_baru ?>
            </div>
        <?php else: ?>
            <div class="harga-jual">
                Rp. <?php echo $this->cart->format_number($item->harga_jual) ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'?>



</body>
</html>	