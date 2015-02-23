<head>
    <style>
    #gallery_01 img{border:2px solid white;width: 60px;}
    .active img{border:2px solid #333 !important;}
 
    </style>


<script type="text/javascript" src="<?php echo base_url()."template/palmtree/js/jquery.min.js"; ?>"></script>
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

<?php if (!$logged_in): ?>
    <div class="error">Anda Harus Login terlebih dahulu untuk melakukan langkah berikutnya.</div>
    <br/>
    <div><?php echo anchor(site_url('user/login'),'LOGIN disini') ?></div>
<?php else: ?>
    <?php if($this->session->flashdata('pesan')): ?>
        <?php echo $this->session->flashdata('pesan');
	      
	      $this->load->model('order_m');
	      $id = $this->session->userdata('user_id');
              $order = $this->order_m->get_record(array('user_id'=>$id));
	      
	?>
    <?php else:?>
        
        <div class="span12">
	  <span>
	    
	      <?php //if(@$error){echo @$error;} ?>
	      <?php //echo validation_errors(); ?>
	      <?php echo $this->session->flashdata('error'); ?>
	      <br/>
	  </span>

<div class="row">	  
    <div id="gallery" class="span3">
	<?php foreach($produk as $item): ?>
	<a href="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG1; ?>" title="">
				
				<img src="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG1; ?>" style="width:100%" />
            </a>
			<div id="differentview" class="moreOptopm carousel slide">
			    <div class="carousel-inner">
			      <div class="item active">
			       
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG1; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG1; ?>" alt=""/></a>
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG2; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG2; ?>" alt=""/></a>
			       <a href="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG3; ?>"> <img style="width:29%" src="<?php echo base_url().'/asset/themes/images/products/large/'.$item->IMG3; ?>" alt=""/></a>
			      </div>
			      
			    </div>
			</div>
    </div>
    
    <div class="span9">
		<h3><?php echo $item->ARTICLE_DESC;?></h3>
		<small></small>
		<hr class="soft"/>
		<div class="row">
		    <div class="span9" style="text-align: right">
			
			<?php
					$stok = $item->STOCK_QTY;
					$booked = $item->BOOK_QTY;
					$confirm = $item->CONFIRM_QTY;
					
					$stock = $stok - $booked - $confirm;
					
				    
			?>
			
			
			<h4>Stock : <?php echo $stock; ?></h4>
		    </div>
			<?php echo form_open(site_url('store/add_cart')); ?>
			
			<div class="span9">
			    <div class="span3">
				<div class="checkbox">
				    <label>
					<input id="colorRadio" type="radio" name="colorRadio" value="1" checked="checked">
					&nbsp; TC <?php echo $item->SV; ?> (harga promo / cicilan)
				    </label>
				</div>
				<div class="credit box">
				    <?php
					    $pprice = $this->cart->format_number($item->SALES_UNIT_PRICE);
					    $plu_credit = $item->PLU;
				    ?>
				<input type="hidden" name='pcredit' class='form-control input-lg' value='<?php echo $pprice ?>'>
				<input type="hidden" name='plu_credit' class='form-control input-lg' value='<?php echo $plu_credit ?>'>
				</div>
			    
			    </div>
			    <div class="span3">
			    : <?php echo $plu_credit; ?>
			    </div>
			</div>
			
			<?php foreach($sv2_price as $price): ?>
			<div class="span9">
			<div class="span3">
			    <div class="checkbox">
				<label>
				    <input id="colorRadio" type="radio" name="colorRadio" value="2">&nbsp;&nbsp; TC <?php echo $price->SV; ?> (harga cash / debit) 
				</label>
			    </div>
			    
			    <div class="cash box">
				    <?php
					    $cprice = $this->cart->format_number($price->SALES_UNIT_PRICE);
					    $plu_cash = $price->PLU;
				    
				    ?>
				
				<input type="hidden" name='pcash' class='form-control input-lg' value='<?php echo $cprice ?>'>
				<input type="hidden" name='plu_cash' class='form-control input-lg' value='<?php echo $plu_cash ?>'>
				</div>
			
			</div>
			
			<div class="span3">: <?php echo $plu_cash; ?></div>
			</div>
			<?php endforeach; ?>
			
			<?php foreach($sv3_price as $sv3): ?>
			<div class="span9">
			<div class="span3">
			    <div class="checkbox">
				<label>
				    <input id="colorRadio" type="radio" name="colorRadio" value="3">&nbsp;&nbsp; TC<?php echo $sv3->SV; ?> (harga normal)
				</label>
			    </div>
			    
			    <div class="cash box">
				    <?php
					    $sv3price = $this->cart->format_number($sv3->SALES_UNIT_PRICE);
					    $plu_sv3 = $sv3->PLU;
				    
				    ?>
				
				<input type="hidden" name='psv3' class='form-control input-lg' value='<?php echo $sv3price ?>'>
				<input type="hidden" name='plu_sv3' class='form-control input-lg' value='<?php echo $plu_sv3 ?>'>
				</div>
			
			</div>
			
			<div class="span3">: <?php echo $plu_sv3; ?></div>
			</div>
			<?php endforeach; ?>
			
		</div>
		
		<hr class="soft"/>
		<hr class="soft clr"/>
		
		  <div class="control-group">
			
			<label class="control-label"><span>Jumlah Pemesanan : </span></label>
			
			<div class="controls">
			<?php 
			    
			    echo form_hidden('ARTICLE_CODE',$item->ARTICLE_CODE);
			    //echo form_hidden('PLU',$item->PLU);
			    echo form_hidden('ARTICLE_DESC',$item->ARTICLE_DESC);
			    echo form_hidden('url',uri_string());
			    //echo form_hidden('SALES_UNIT_PRICE',$item->SALES_UNIT_PRICE);
			    
			    if ($stock != 0 || $stock >0)
			    {
				echo form_hidden('recent_stock',$stock);
				echo form_input(array('id' => 'qty','name' => 'qty','placeholder'=>'jumlah', 'value' =>'1', 'class' => 'span2' ));
				
				if($multiuser == 0){
				    echo form_submit(array('name' => 'submit','value'=>'Pesan', 'class' => 'btn btn-large btn-primary pull-right' ));
				}
			    
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
</div>
    <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

