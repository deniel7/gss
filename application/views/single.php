<head>
    <style>
    #gallery_01 img{border:2px solid white;width: 60px;}
    .active img{border:2px solid #333 !important;}
 
 </style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()."asset/css/elastislide.css"; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()."asset/css/custom.css"; ?>" />
<script src="<?php echo base_url()."asset/js/modernizr.custom.17475.js"; ?>"></script>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="cash"){
                $(".box").hide();
                $(".cash").show();
            }
            if($(this).attr("value")=="credit"){
                $(".box").hide();
                $(".credit").show();
            }
        });
    });
</script>

</head>

<?php echo $this->session->flashdata('user_note'); ?>
<br/>


<div class="row">	  
    <div id="gallery" class="span3">
	<a href="<?php echo base_url().'/asset/themes/images/products/large/f1.jpg'; ?>" title="Fujifilm FinePix S2950 Digital Camera">
				
				<img src="<?php echo base_url().'/asset/themes/images/products/large/1.jpg'; ?>" style="width:100%" />
            </a>
			<div id="differentview" class="moreOptopm carousel slide">
			    <div class="carousel-inner">
			      <div class="item active">
			       
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/f1.jpg'; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/f1.jpg'; ?>" alt=""/></a>
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/f2.jpg'; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/f2.jpg'; ?>" alt=""/></a>
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/f3.jpg'; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/f3.jpg'; ?>" alt=""/></a>
			      </div>
			      <div class="item">
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/f3.jpg'; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/f3.jpg'; ?>" alt=""/></a>
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/f1.jpg'; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/f1.jpg'; ?>" alt=""/></a>
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/f2.jpg'; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/f2.jpg'; ?>" alt=""/></a>
			      </div>
			    </div>
			</div>
    </div>
    <?php foreach($produk as $item): ?>
    <div class="span9">
		<h3><?php echo $item->ARTICLE_DESC;?></h3>
		<small></small>
		<hr class="soft"/>
		<div class="row">
		    <div class="span9" style="text-align: right">
			<h4>Stock : <?php echo $item->STOCK_QTY ?></h4>
		    </div>
			<?php echo form_open(site_url('store/add_cart')); ?>
			
			
			
			
			
			
			<div class="span9">
			    <div class="span3">
				<div class="checkbox">
				    <label>
					<input type="radio" name="colorRadio" value="credit">
					&nbsp;<img src="<?php echo base_url().'/template/palmtree/images/visa_mastercard.jpeg'; ?>" />
				    </label>
				</div>
				<div class="credit box">
				    <?php $pprice = $this->cart->format_number($item->SALES_UNIT_PRICE); ?>
				<input type="text" name='pcredit' class='form-control input-lg' value='<?php echo $pprice ?>'>
				</div>
			    
			    </div>
			    <div class="span3">
			    : Rp. <?php echo $this->cart->format_number($item->SALES_UNIT_PRICE) ?>
			    </div>
			</div>
			
			<?php foreach($sv2_price as $price): ?>
			<div class="span9">
			<div class="span3">
			    <div class="checkbox">
				<label>
				    <input type="radio" name="colorRadio" value="cash">&nbsp;&nbsp;<b>PEMBAYARAN TUNAI</b>
				</label>
			    </div>
			    
			    <div class="cash box">
				    <?php $cprice = $this->cart->format_number($price->SALES_UNIT_PRICE); ?>
				
				<input type="text" name='pcash' class='form-control input-lg' value='<?php echo $cprice ?>'>
				</div>
			
			</div>
			
			<div class="span3">: Rp. <?php echo $this->cart->format_number($price->SALES_UNIT_PRICE) ?></div>
			</div>
			<?php endforeach; ?>
		</div>
		
		<hr class="soft"/>
		<hr class="soft clr"/>
		
		  <div class="control-group">
			
			<label class="control-label"><span>Pemesanan : </span></label>
			
			<div class="controls">
			<?php 
			    
			    echo form_hidden('ARTICLE_CODE',$item->ARTICLE_CODE);
			    echo form_hidden('PLU',$item->PLU);
			    echo form_hidden('ARTICLE_DESC',$item->ARTICLE_DESC);
			    echo form_hidden('url',uri_string());
			    //echo form_hidden('SALES_UNIT_PRICE',$item->SALES_UNIT_PRICE);
			    
			    if ($item->STOCK_QTY != 0)
			    {
				echo form_input(array('name' => 'qty','placeholder'=>'jumlah', 'value' =>'1', 'class' => 'span2' ));
				
				echo form_submit(array('name' => 'submit','value'=>'Pesan', 'class' => 'btn btn-large btn-primary pull-right' ));
			    
			    }else{
				echo"<center><div class='alert-info'>Stock Unavailable</div></center>";	
			    }
			    echo form_close();
			?>
			</div>
		  </div>
		
		
		<hr class="soft clr"/>
		<p>
		14 Megapixels. 18.0 x Optical Zoom. 3.0-inch LCD Screen. Full HD photos and 1280 x 720p HD movie capture. ISO sensitivity ISO6400 at reduced resolution. 
		Tracking Auto Focus. Motion Panorama Mode. Face Detection technology with Blink detection and Smile and shoot mode. 4 x AA batteries not included. WxDxH 110.2 ?81.4x73.4mm. 
		Weight 0.341kg (excluding battery and memory card). Weight 0.437kg (including battery and memory card).
		
		</p>
		<a class="btn btn-small pull-right" href="#detail">More Details</a>
		<br class="clr"/>
	<a href="#" name="detail"></a>
	<hr class="soft"/>
    </div>
    
    <div class="span12">
            <ul id="productDetail" class="nav nav-tabs">
              <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
              <li><a href="#profile" data-toggle="tab">Related Products</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade active in" id="home">
			  <h4>Product Information</h4>
                <table class="table table-bordered">
				<tbody>
				<tr class="techSpecRow"><th colspan="2">Product Details</th></tr>
				<tr class="techSpecRow"><td class="techSpecTD1">Brand: </td><td class="techSpecTD2">Fujifilm</td></tr>
				<tr class="techSpecRow"><td class="techSpecTD1">Model:</td><td class="techSpecTD2">FinePix S2950HD</td></tr>
				<tr class="techSpecRow"><td class="techSpecTD1">Released on:</td><td class="techSpecTD2"> 2011-01-28</td></tr>
				<tr class="techSpecRow"><td class="techSpecTD1">Dimensions:</td><td class="techSpecTD2"> 5.50" h x 5.50" w x 2.00" l, .75 pounds</td></tr>
				<tr class="techSpecRow"><td class="techSpecTD1">Display size:</td><td class="techSpecTD2">3</td></tr>
				</tbody>
				</table>
				
				<h5>Features</h5>
				<p>
				14 Megapixels. 18.0 x Optical Zoom. 3.0-inch LCD Screen. Full HD photos and 1280 x 720p HD movie capture. ISO sensitivity ISO6400 at reduced resolution. Tracking Auto Focus. Motion Panorama Mode. Face Detection technology with Blink detection and Smile and shoot mode. 4 x AA batteries not included. WxDxH 110.2 ?81.4x73.4mm. Weight 0.341kg (excluding battery and memory card). Weight 0.437kg (including battery and memory card).<br/>
				OND363338
				</p>

				
              </div>
		
	    <br class="clr">
	    </div>
    </div>


    <div style="text-align:center">
	<span>
		<?php if($cart == array()): ?>
   
		<?php else: ?>
		    
		    <?php echo anchor(site_url('store/checkout'),'<span class="btn btn-success">Pemesanan Selesai</span>') ?>
		<?php endif; ?>
	</span>
    </div>

<?php endforeach; ?>


