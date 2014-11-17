 <head>
        
		<link rel="stylesheet" type="text/css" href="asset/css/style3.css" />
		<link rel="stylesheet" type="text/css" href="asset/css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="asset/css/custom.css" />
		<script src="asset/js/modernizr.custom.17475.js"></script>
 <style type="text/css">
 ol,ul {
	list-style:none;
}
 </style>
 </head>
<p>
<?php //echo @$sambutan ?>
</p>

<div style="text-align:right">
		
    <div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('store/search');
	?>

			<span>
				<?php
					$data_s = array(
					'name'        => 'search_name',
					'id'          => 'search_name',
					'placeholder' => 'Cari Produk..',
					'font-color'   => 'red'
					//'value'	      => $search_name,
					);
					
                                        
                                        
					echo form_input($data_s);
					
					echo form_submit('submit', 'Go','class = "btn large"');
					echo form_close();
				?>
				<ul>
						<div id="result"></div>
				</ul>
			</span>
			</div>
</div>



<div style="height:500px">
    <span>
    <!--<img src="./images/opening.jpg">-->
    
    <ul class="mh-menu">
	<li id="ada"><a href="#"><span>Selamat Datang</span> <span>Yogya E-Commerce</span></a><img src="./images/opening.jpg" alt="image01"/></li>
	<li><a href="#"><span>Produk</span> <span>Fashion</span></a><img src="images/2.jpg" alt="image02"/></li>
	<li><a href="#"><span>Produk</span> <span>Supermarket</span></a><img src="images/3.jpg" alt="image03"/></li>
    </ul>
    
    
    </span>
</div>

<!--<div style="height:500px">
    
    <span>
        <div style="border:solid thin; height:30px; background-image: url('images/h3bg.png'); background-repeat:no-repeat; background-position:right; background-color:#E61A13; border:none; margin-bottom:20px">
<span style="font-size:16px; color:white; ali">SUPERMARKET</span></div>
    <div class="produk-wrap-front">
        <div class="produk-name">
            FOOD
        </div>
        <div class="image-wrap">
            <div class="image-iner">
                
                    <a href="<?php //echo base_url()."index.php/store/kategori/food"; ?>"><img src="<?php echo base_url()."images/category/food.jpg"; ?>" /></a>
                
            </div>
        </div>
    </div>
    </span>
    <span>
    <div class="produk-wrap-front">
        <div class="produk-name">
            NON FOOD
        </div>
        <div class="image-wrap">
            <div class="image-iner">
                
                    <a href="<?php //echo base_url()."index.php/store/kategori/non_food"; ?>"><img src="<?php echo base_url()."images/category/nonfood.jpg"; ?>" /></a>
                
            </div>
        </div>
    </div>
    </span>
    
    <span>
    <div class="produk-wrap-front">
        <div class="produk-name">
            GMS
        </div>
        <div class="image-wrap">
            <div class="image-iner">
              
                    <a href="<?php //echo base_url()."index.php/store/kategori/gms"; ?>"><img src="<?php echo base_url()."images/category/gms.jpg"; ?>" /></a>
                
            </div>
        </div>
    </div>
    </span>
    
    <div>
        <span>
        <div class="produk-wrap-front">
        <div class="produk-name">
            FRESH
        </div>
        <div class="image-wrap">
            <div class="image-iner">
                
                    <a href="<?php //echo base_url()."index.php/store/kategori/fresh"; ?>"><img src="<?php echo base_url()."images/category/fresh.jpg"; ?>" /></a>
                
            </div>
        </div>
        </div>
        </span>
        
        <span>
        <div class="produk-wrap-front">
        <div class="produk-name">
            BAKERY
        </div>
        <div class="image-wrap">
            <div class="image-iner">
                
                    <a href="<?php //echo base_url()."index.php/store/kategori/bakery"; ?>"><img src="<?php echo base_url()."images/category/bakery.jpg"; ?>" /></a>
                
            </div>
        </div>
        </div>
        </span>
    </div>
</div>-->
<br/><br/>
<div>
    <div style="border:solid thin; height:30px; background-image: url('images/h3bg.png'); background-repeat:no-repeat; background-position:right; background-color:#E61A13; border:none; margin-bottom:20px">
        <span style="font-size:16px; color:white;">TOP SALES</span>
    </div>
    
    <div class="container">
            
            <div class="main">
				<!-- Elastislide Carousel -->
				
                                
                                <ul id="carousel" class="elastislide-list">
					<?php foreach($data as $item): ?>
                                        <li>
                                            <div class="ts-name"><?php echo anchor(site_url('/store/produk/'.$item->url_produk),$item->nama_produk);?></div>
                                            <a href="<?php echo site_url('/store/produk/'.$item->url_produk); ?>"><img src="<?php echo base_url().$item->thumb ?>" /></a>
                                        </li>
                                        <?php endforeach; ?>
				</ul>
				<!-- End Elastislide Carousel -->
			</div>
		</div>
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
		<script type="text/javascript" src="template/palmtree/js/jquery.min.js"></script>
                <script type="text/javascript" src="asset/js/jquerypp.custom.js"></script>
		<script type="text/javascript" src="asset/js/jquery.elastislide.js"></script>
		<script type="text/javascript">
			
			$( '#carousel' ).elastislide();
			
		</script>
</div>