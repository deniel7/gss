<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>untitled</title>
	
	
        <!--<script src="/assets/js/script.js"></script>-->
	
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

	#pagination a, #pagination strong {
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
	}		
	</style>
<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/date/functions.js"></script>

<!--Event Calendar on export penjualan-->

<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/fullcalendar/fullcalendar.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>template/palmtree/fullcalendar/fullcalendar.print.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/fullcalendar/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>template/palmtree/fullcalendar/fullcalendar.min.js"></script>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>-->
<script type="text/javascript">
$(function() {
 
    $('#download').click(function(event) {
 
        event.preventDefault();
 
        document.location.href = 'download';
    });
 
});
</script>

<!--Event Calendar on export penjualan-->
<script>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		
		$('#calendar').fullCalendar({
			editable: false,
			events: [
				<?php foreach ($stat_exp as $val): ?>
				{
					
					<?php
					
					$tg = explode('-',$val->tanggals);
					$tg[1]= $tg[1] -1;
					
					$tgl = implode(',',$tg);
					
					?>
					title: 'Exported on <?php echo $val->jam; ?>',
					start: new Date(<?php echo $tgl; ?>)
				},
				<?php endforeach; ?>
				
				//{
				//	title: 'Birthday Party',
				//	start: new Date(y, 0,17)
				//	
				//},
				//{
				//	title: 'Click for Google',
				//	start: new Date(y, m, 28),
				//	end: new Date(y, m, 29),
				//	url: 'http://google.com/'
				//}
			]
		});
		
	});

</script>

<style>

	#calendar {
		width: 700px;
		margin: 0 auto;
		}

</style>
<!--end Event Calendar on export penjualan-->
</head>
<div>
 
 </div>
<h1><?php //echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right">
	   </ul>
</div>
<h3 class="tit">Export Penjualan</h3>
<?php
		echo form_open('admin/export_penjualan/export');
?>

<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		//echo form_open('admin/export_penjualan/search');
	?>
	<span>
		<?php
			$search_cabang = array(
			'name'        => 'search_cabang',
			'id'          => 'search_cabang',
			'placeholder' => 'Cabang'
			);
			
			
			$date = new DateTime();
			$date->sub(new DateInterval('P1D'));
			
			
			$search_tg1 = array(
			'name'        => 'search_tg1',
			//'id'          => 'datepicker-example1',
			'value'	      => $date->format('00:00:00 / d-m-Y') , PHP_EOL,
			'placeholder' => 'dari tanggal...',
			'readonly' => 'true'

			);
			
			$search_tg2 = array(
			'name'        => 'search_tg2',
			//'id'          => 'datepicker-example14',
			//'placeholder' => 'sampai tanggal...'
			'value'	      => $date->format('22:00:00 / d-m-Y') , PHP_EOL,
			'readonly' => 'true'
			);
			
			//echo form_close();
		?>
		
		<div>
			<div style="float: right">
			   <div style=""><u><b>WAKTU PENGAMBILAN DATA</b></u></div>
			   <div class="col">Dari : <?php echo form_input($search_tg1,array('disabled'=>'disabled')); ?></div>
			   <div class="col">Hingga : <?php echo form_input($search_tg2,array('disabled'=>'disabled')); ?></div>
			</div> 
		</div>
		<div id="result">
		  
		  
		  <div class="col">Export Data Penjualan : </div><div class="col"><?php echo form_submit('submited', 'Export','style = "width:120px; height:60px"'); ?></div>
		</div>
	</span>
	<?php echo form_close(); ?>
</div>

<br/><br/><br/><br/><br/>
<hr/>
<br/>
<h3 class="tit">Status Export Penjualan</h3>
<div id='calendar'>
 
</div>
</div>