<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<!--<meta http-equiv="refresh" content="10">-->
	<link href="<?php echo base_url();?>asset/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" />
	<?php echo @$metadata; ?>
	
	<!--Barcode picking list-->
	<!--<script type="text/javascript" src="<?php //echo base_url();?>asset/js/jquery-1.3.2.min.js"></script>    --> 
        <!--<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-barcode.js"></script>-->
	<!--<script type="text/javascript" src="<?php //echo base_url();?>asset/js/jquery-barcode-2.0.2.min.js"></script>-->
	<title><?php echo @$judul; ?></title>
	
	
    
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
	<script type="text/javascript">
	var auto_refresh = setInterval(
	function ()
	{
		$('#load_tweets').load('<?php echo site_url('dashboard/'); ?>').fadeIn("slow");
		}, 10000); // refresh every 10000 milliseconds
	
	</script>-->
	
	
	
	<script>
	    $(document).ready(
		    function() {
			
			setInterval(loaded2, 3000);
			
			//function doStuff() {
			//alert("run your code here when time interval is reached");
			//}
			//var myTimer = setTimeout(doStuff, 1000);
			
			loaded2();
		    });
	    
	    function loaded2() {
		//alert('hit');
		if ($('#c_pesanan').length > 0)
		{
		$.ajax({
			type: 'POST',                        
			url: '<?php echo site_url('admin/refresh'); ?>',
			dataType: 'json',
			
			async : false,
			success:function(res){
			  $('#c_pesanan').html(
					res.result);
			  $('#c_gold_proses').html(
					res.result2);
			  $('#c_print_do').html(
					res.result3);
			  //setTimeout(loaded2,2000);
			},
			error:function(res){
			    alert(JSON.stringify(res));
			    //setTimeout(loaded2,5000);
			}
		    });
		}
		
	    }
	    
	    
	</script>
	
	
</head>
<body>