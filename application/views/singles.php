<head>
    <style>
    #gallery_01 img{border:2px solid white;width: 60px;}
    .active img{border:2px solid #333 !important;}
 
 </style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()."asset/css/elastislide.css"; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()."asset/css/custom.css"; ?>" />
<script src="<?php echo base_url()."asset/js/modernizr.custom.17475.js"; ?>"></script>

</head>

<?php echo $this->session->flashdata('user_note'); ?>
<br/>
<?php
foreach($data as $item):
    //echo $item['ARTICLE_DESC'];
    
endforeach;

?>

<?php //foreach($produk as $item): ?>

    <div class="image-section">
        
	
    <div class="image-wrap">
	<div class="image-iner">
	<!--<img style="border:1px solid #e8e8e6;" id="zoom_03" src="<?php //echo base_url().$item->thumb ?>" 
	data-zoom-image="<?php //echo base_url().@$item->image; ?>"
	width="200"  />-->
	
	    <div id="gallery_01" style="width="100px float:left; ">
	    
		<div style="float:left">
		<!--<a  href="#" class="elevatezoom-gallery active" data-update="" data-image="<?php //echo base_url().$item->thumb ?>" 
		data-zoom-image="<?php //echo base_url().@$item->image; ?>">-->
		<!--<img src="<?php //echo base_url().$item->thumb ?>" width="100"  /></a>-->
		</div>
		
		<?php //foreach($item->picture as $key=>$pic): ?>
		<!--<div style="float:left">
		<a  href="#" class="elevatezoom-gallery" data-update="" data-image="<?php //echo base_url().$pic['thumb']; ?>" data-zoom-image="<?php //echo base_url().@$pic['image']; ?>">
		<img src="<?php //echo base_url().@$pic['thumb']; ?>" width="100"  /></a>               
		</div>	-->    
		<?php //endforeach; ?>
		
	    </div>
	</div>
    </div>
    
    <script type="text/javascript">
    $(document).ready(function () {
    $("#zoom_03").elevateZoom({gallery:'gallery_01', cursor: 'pointer', galleryActiveClass: "active"}); 
    
    $("#zoom_03").bind("click", function(e) {  
      var ez =   $('#zoom_03').data('elevateZoom');
      ez.closeAll(); //NEW: This function force hides the lens, tint and window	
	    $.fancybox(ez.getGalleryList());
      return false;
    }); 
    
    }); 
    
    </script>
	
    </div>
    <div class="desc-section">
        <div class="produk-name">
            <h2><?php echo $item['ARTICLE_DESC'];?></h2>
        </div>
        <div class="produk-deskripsi">
            <p>
            <?php //echo $item->deskripsi_produk;?>
            </p>
        </div>
        <div class="meta-produk">
            <div class="stok">
                <!--<span class="stok">Stok</span>--><?php //echo $item->stok;?>
            </div>
            
                <div class="harga-jual">
                    <span class="harga">Harga</span>Rp. <?php echo $this->cart->format_number($item['CINL']) ?>
                </div>
            
        </div>
        <?php //if ($item->stok != 0): ?>
        <div class="button-wrap">
        <?php 
	    echo form_open(site_url('store/add_cart'));
	    echo form_hidden('id',$item['ARTICLE_CODE']);
	    echo form_hidden('plu',$item['PLU']);
	    echo form_hidden('name',$item['ARTICLE_DESC']);
	    echo form_hidden('url',uri_string());
	    
	    echo form_hidden('price',$item['CINL']);
	    
	    echo form_label('Quantity');
	    echo form_input('qty','1');
	    //echo form_submit('submit','Add ','class="button-buy"');
	    echo form_submit(array('name' => 'submit','value'=>'Masukan Trolley ', 'class' => 'button-buy' ));
	    echo form_close();
        ?>
        </div>
        <?php //endif; ?>
	<div>
	    <span>
		<?php if($cart == array()): ?>
   
		<?php else: ?>
		    <!--<span><div class="sukses">Produk berhasil ditambahkan ke keranjang belanja Anda</div></span>-->
		    <div><a href="<?php echo site_url('store/checkout'); ?>" class="checkout">Selesai Belanja</a></div>
		<?php endif; ?>
	    </span>
	</div>
    </div>
    
    <div class="clear"></div>
    <br/><br/>
    <div style="position:relative">
	<h2>Rincian Produk</h2>
	<div class="meta-produk">
	    
	    
	    <p><?php echo $item['ARTICLE_DESC'];?></p>
	    
	    
	</div>
	
    </div>

    <div>
	<span>
		<?php if($cart == array()): ?>
   
		<?php else: ?>
		    <!--<span><div class="sukses">Produk berhasil ditambahkan ke keranjang belanja Anda</div></span>-->
		    <div style="text-align:center"><a href="<?php echo site_url('store/checkout'); ?>" class="checkout">Selesai Belanja</a></div>
		<?php endif; ?>
	</span>
    </div>

<?php //endforeach; ?>
