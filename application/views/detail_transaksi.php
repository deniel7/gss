<script type="text/javascript">

/*

* Price Format jQuery Plugin
* Created By Eduardo Cuducos
* Currently maintained by Flavio Silveira flavio [at] gmail [dot] com
* Version: 2.0
* Release: 2014-01-26

*/

(function($) {

	/****************
	* Main Function *
	*****************/
	$.fn.priceFormat = function(options)
	{

		var defaults =
		{
			prefix: 'Rp. ',
            suffix: '',
			centsSeparator: '.',
			thousandsSeparator: '.',
			limit: false,
			centsLimit: 0,
			clearPrefix: false,
            clearSufix: false,
			allowNegative: false,
			insertPlusSign: false,
			clearOnEmpty:false
		};

		var options = $.extend(defaults, options);

		return this.each(function()
		{
			// pre defined options
			var obj = $(this);
			var value = '';
			var is_number = /[0-9]/;

			// Check if is an input
			if(obj.is('input'))
				value = obj.val();
			else
				value = obj.html();

			// load the pluggings settings
			var prefix = options.prefix;
            var suffix = options.suffix;
			var centsSeparator = options.centsSeparator;
			var thousandsSeparator = options.thousandsSeparator;
			var limit = options.limit;
			var centsLimit = options.centsLimit;
			var clearPrefix = options.clearPrefix;
            var clearSuffix = options.clearSuffix;
			var allowNegative = options.allowNegative;
			var insertPlusSign = options.insertPlusSign;
			var clearOnEmpty = options.clearOnEmpty;
			
			// If insertPlusSign is on, it automatic turns on allowNegative, to work with Signs
			if (insertPlusSign) allowNegative = true;

			function set(nvalue)
			{
				if(obj.is('input'))
					obj.val(nvalue);
				else
					obj.html(nvalue);
			}
			
			function get()
			{
				if(obj.is('input'))
					value = obj.val();
				else
					value = obj.html();
					
				return value;
			}

			// skip everything that isn't a number
			// and also skip the left zeroes
			function to_numbers (str)
			{
				var formatted = '';
				for (var i=0;i<(str.length);i++)
				{
					char_ = str.charAt(i);
					if (formatted.length==0 && char_==0) char_ = false;

					if (char_ && char_.match(is_number))
					{
						if (limit)
						{
							if (formatted.length < limit) formatted = formatted+char_;
						}
						else
						{
							formatted = formatted+char_;
						}
					}
				}

				return formatted;
			}

			// format to fill with zeros to complete cents chars
			function fill_with_zeroes (str)
			{
				while (str.length<(centsLimit+1)) str = '0'+str;
				return str;
			}

			// format as price
			function price_format (str, ignore)
			{
				if(!ignore && (str === '' || str == price_format('0', true)) && clearOnEmpty)
					return '';

				// formatting settings
				var formatted = fill_with_zeroes(to_numbers(str));
				var thousandsFormatted = '';
				var thousandsCount = 0;

				// Checking CentsLimit
				if(centsLimit == 0)
				{
					centsSeparator = "";
					centsVal = "";
				}

				// split integer from cents
				var centsVal = formatted.substr(formatted.length-centsLimit,centsLimit);
				var integerVal = formatted.substr(0,formatted.length-centsLimit);

				// apply cents pontuation
				formatted = (centsLimit==0) ? integerVal : integerVal+centsSeparator+centsVal;

				// apply thousands pontuation
				if (thousandsSeparator || $.trim(thousandsSeparator) != "")
				{
					for (var j=integerVal.length;j>0;j--)
					{
						char_ = integerVal.substr(j-1,1);
						thousandsCount++;
						if (thousandsCount%3==0) char_ = thousandsSeparator+char_;
						thousandsFormatted = char_+thousandsFormatted;
					}
					
					//
					if (thousandsFormatted.substr(0,1)==thousandsSeparator) thousandsFormatted = thousandsFormatted.substring(1,thousandsFormatted.length);
					formatted = (centsLimit==0) ? thousandsFormatted : thousandsFormatted+centsSeparator+centsVal;
				}

				// if the string contains a dash, it is negative - add it to the begining (except for zero)
				if (allowNegative && (integerVal != 0 || centsVal != 0))
				{
					if (str.indexOf('-') != -1 && str.indexOf('+')<str.indexOf('-') )
					{
						formatted = '-' + formatted;
					}
					else
					{
						if(!insertPlusSign)
							formatted = '' + formatted;
						else
							formatted = '+' + formatted;
					}
				}

				// apply the prefix
				if (prefix) formatted = prefix+formatted;
                
                // apply the suffix
				if (suffix) formatted = formatted+suffix;

				return formatted;
			}

			// filter what user type (only numbers and functional keys)
			function key_check (e)
			{
				var code = (e.keyCode ? e.keyCode : e.which);
				var typed = String.fromCharCode(code);
				var functional = false;
				var str = value;
				var newValue = price_format(str+typed);

				// allow key numbers, 0 to 9
				if((code >= 48 && code <= 57) || (code >= 96 && code <= 105)) functional = true;
				
				// check Backspace, Tab, Enter, Delete, and left/right arrows
				if (code ==  8) functional = true;
				if (code ==  9) functional = true;
				if (code == 13) functional = true;
				if (code == 46) functional = true;
				if (code == 37) functional = true;
				if (code == 39) functional = true;
				// Minus Sign, Plus Sign
				if (allowNegative && (code == 189 || code == 109 || code == 173)) functional = true;
				if (insertPlusSign && (code == 187 || code == 107 || code == 61)) functional = true;
				
				if (!functional)
				{
					
					e.preventDefault();
					e.stopPropagation();
					if (str!=newValue) set(newValue);
				}

			}

			// Formatted price as a value
			function price_it ()
			{
				var str = get();
				var price = price_format(str);
				if (str != price) set(price);
				if(parseFloat(str) == 0.0 && clearOnEmpty) set('');
			}

			// Add prefix on focus
			function add_prefix()
			{
				obj.val(prefix + get());
			}
            
            function add_suffix()
			{
				obj.val(get() + suffix);
			}

			// Clear prefix on blur if is set to true
			function clear_prefix()
			{
				if($.trim(prefix) != '' && clearPrefix)
				{
					var array = get().split(prefix);
					set(array[1]);
				}
			}
            
            // Clear suffix on blur if is set to true
			function clear_suffix()
			{
				if($.trim(suffix) != '' && clearSuffix)
				{
					var array = get().split(suffix);
					set(array[0]);
				}
			}

			// bind the actions
			obj.bind('keydown.price_format', key_check);
			obj.bind('keyup.price_format', price_it);
			obj.bind('focusout.price_format', price_it);

			// Clear Prefix and Add Prefix
			if(clearPrefix)
			{
				obj.bind('focusout.price_format', function()
				{
					clear_prefix();
				});

				obj.bind('focusin.price_format', function()
				{
					add_prefix();
				});
			}
			
			// Clear Suffix and Add Suffix
			if(clearSuffix)
			{
				obj.bind('focusout.price_format', function()
				{
                    clear_suffix();
				});

				obj.bind('focusin.price_format', function()
				{
                    add_suffix();
				});
			}

			// If value has content
			if (get().length>0)
			{
				price_it();
				clear_prefix();
                clear_suffix();
			}

		});

	};
	
	/**********************
    * Remove price format *
    ***********************/
    $.fn.unpriceFormat = function(){
      return $(this).unbind(".price_format");
    };

    /******************
    * Unmask Function *
    *******************/
    $.fn.unmask = function(){

        var field;
		var result = "";
		
		if($(this).is('input'))
			field = $(this).val();
		else
			field = $(this).html();

        for(var f in field)
        {
            if(!isNaN(field[f]) || field[f] == "-") result += field[f];
        }

        return result;
    };

})(jQuery);    

</script>
	
<script type="text/javascript">
$(function(){

$('#price').priceFormat({
	clearPrefix: true
});


});
</script>






<?php if(@$sukses):?>
    <?php echo '<p class="msg done">'.@$sukses.'</p>';?>
    <script type="text/javascript">
    (function($) {
    	$(function() {
    		parent.jQuery.colorbox.close();
    		return false;
    	});
    })(jQuery);
    </script>
<?php else: ?>

<?php if(@$error_pass){echo @$error_pass;} ?>
<br/>
<div class="span6">

<?php foreach($detail as $data): ?>
<?php
	
    $orderno = $data['ORDER_NO_GTRON'];
    $id_order = $data['id_order'];
?>

<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Order No :</td>
    <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
</tr>
</table>
</div>

<div class="clear"></div>
<br />

<div class="span10">
<b>Data Konsumen :</b>
<table cellspacing="0" cellpadding="3px">
<tr>
    <td>Nama </td><td><?php echo $data['nama_depan'].' '.$data['nama_belakang']; ?></td>
</tr>
<tr>
    <td>Alamat</td><td><?php echo $data['alamat']; ?></td>
</tr>
<tr>
    <td>Kode Pos</td><td><?php echo $data['kode_pos']; ?></td>
</tr>
<tr>
    <td>Telepon</td><td><?php echo $data['phone']; ?></td>
</tr>
</table>
</div>

<div class="span2">
    <p><b>Bukti Penerimaan :</b></p>
    <?php if($data['RECEIVING_DN']): ?>
    <a data-toggle="modal" href="#long" class="thumbnail">
	<img src="<?php echo base_url().'uploads/receiving/'.$data['RECEIVING_DN']; ?>" alt="...">
    </a>
    <?php else: ?>
    <p style="font-size: 12px">Belum Ada</p>
    <?php endif; ?>
</div>

<div class="clear"></div>
<br />


<div class="span12">
<b>Detail Pesanan :</b>
<table cellspacing="0" cellpadding="3px">
    <tr>
        <th>Order No</th>
        <th>Tanggal Belanja</th>
        <th>Jumlah Item</th>
        
    </tr>
    <?php $waktu_masuk = $data['tanggal_masuk']; ?>
    <tr>
        <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
        <td><?php echo $data['tanggal_masuk']; ?></td>
        <td><?php echo $data['total_item']; ?></td>
        
    </tr>
    <tr><td><br/></td></tr>
    <tr>
        <td></td>
        <td colspan="3"><b>Detail : </b></td>
    </tr>
    
    
    <?php foreach($data['detail'] as $detail): ?>
    <tr>
        <td></td>
        <td><?php echo $detail['ARTICLE_DESC']; ?></td>
        <td><?php echo $detail['kuantitas']; ?></td>
        
    </tr>
    <?php endforeach; ?>
    <tr>
        
        <td colspan="2" style="text-align: right"><b>Biaya Kirim</b></td>
	<td>Rp. <?php echo $this->cart->format_number($data['biaya_kirim']); ?></td>
    </tr>
    
</table>


<br/>

<?php if ($data['FLAG'] == 1 AND $multiuser != 1){ ?>
<div class="responsive" style="margin-bottom: 50px">
            
            <div class="text-center">
	    
	    <?php //echo anchor('store/cancel_confirm/'.$this->uri->segment(3),'<button class="demo btn btn-warning btn-lg">Cancel Confirm</button>','class="active" id="detail"'); ?>
            
	    <button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#cancelConf">Cancel Confirm</button>
	    </div>
</div>
<?php } ?>

<?php
	//echo $waktu_masuk;
	//$hour = $waktu_masuk;
	$hours = date($waktu_masuk);
	$times = new DateTime($hours);
	
	$times->add(new DateInterval('PT1H')); 
	
	$timestamps = $times->format('M d Y H:i:s');
	
	
	//echo $timestamps;
	echo "<br/>";
	$time_now = date('M d Y H:i:s');
	//echo $time_now;
	
	
	
	if ($data['FLAG'] == 0 AND $multiuser != 1 AND $timestamps > $time_now){

?>

<div class="responsive span6">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <table cellspacing="0" cellpadding="3px">
    <h4 class="modal-title">Submit Pesanan</h4>
    
	<div id="countdown" style="text-align: right">Batas waktu input : 
	<!--<p class="days">00</p>
	<p class="timeRefDays">days</p>
	<p class="hours">00</p>
	<p class="timeRefHours">jam</p>-->
	<p class="minutes">00</p>
	<p class="timeRefMinutes">menit</p>
	<p class="seconds">00</p>
	<p class="timeRefSeconds">detik</p>
	</div>
    
    <tr>
	<td>Nomor Struk</td>
	<td>
	<?php
	    echo form_hidden('orderno',$orderno);	    
	?>
	<input id="nomor" type="text" name="nomor" required placeholder="Nomor Struk Pembayaran" pattern="[0-9]{2,20}" class='form-control input-lg'></input>
	</td>
    </tr>
    <tr>
	<td>Nominal Struk</td>
	<td>
	<input id="price" type="text" name="total_biaya_input" required placeholder="Total Nominal Transaksi" class='form-control input-lg'></input>
	
	</td>
    </tr>
    <tr>
	
    <td><button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#myModal">Cancel Pesanan</button></td>
    <td>
	
	<?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
    </td>
    </tr>
    <?php echo form_close(); ?>
    </table>
</div>


<!--<div class="responsive" style="margin-bottom: 50px">
            
            <div class="text-center">
            <button class="demo btn btn-primary btn-lg" data-toggle="modal" href="#responsive">Submit Pesanan</button>
	    
            </div>
</div>
-->


<?php }else{ ?>
	
	<button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#myModal">Cancel Pesanan</button>
<?php
    }
    endforeach;
?>
<div id="responsive" class="modal fade" tabindex="-1" data-width="160" style="display: none">
    
</div>


<div id="responsive2" class="modal fade" tabindex="-1" data-width="160" style="display: none;">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <?php //echo form_open('pesanan/submit_pesanan'); ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Submit Pesanan</h4>
    </div>
    <div class="modal-body">
    <div class="row">
    <div class="span4">
    
    <p>
    <?php
	
	echo form_hidden('orderno',$orderno);
	
	echo form_input(array(
					'id' => 'nomor',
                                        'name' => 'nomor',
					'placeholder' => 'Nomor Struk Pembayaran',
                                        'class' => 'form-control input-lg'
			)); 
	
    ?>
    
    </p>
    
    </div>
    
    </div>
    </div>
    <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
    <!--<button type="button" class="btn btn-primary">Submit</button>-->
    <?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
</div>


<!-- Modal Cancel Pesanan -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Want to cancel this transaction?</h4>
      </div>
      <div class="modal-body">
      <div class="row-fluid">
     
      <form action="<?php echo site_url(uri_string()); ?>" method="POST">
      
      <?php
	
	echo form_password(array(
					'id' => 'password',
                                        'name' => 'password',
					'placeholder' => 'SPV Password',
                                        'class' => 'form-control input-lg'
			)); 
	
	echo form_hidden('orderno',$orderno); 
	
      ?>
      </div>
      </div>
      <div class="modal-footer">
	
	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	<?php echo form_submit('submit2', 'Submit','class = "btn btn-success"'); ?>
	
	<?php echo form_close(); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
  <div class="modal fade" id="long" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" class="modal container hide fade">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">View Receiving DN</h4>
        </div>
        <div class="modal-body">
	    <img src="<?php echo base_url().'uploads/receiving/'.$data['RECEIVING_DN']; ?>">
	</div>
        <div class="modal-footer">
	  
	  <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
          
        </div>
      </div><!-- /.modal-content -->
    
  </div><!-- /.modal -->


<!-- Modal Cancel Confirm -->
<div class="modal fade" id="cancelConf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Want to cancel this confirmation?</h4>
      </div>
      <div class="modal-body">
      <div class="row-fluid">
     
      <form action="<?php echo site_url(uri_string()); ?>" method="POST">
      
      <?php
	
	echo form_password(array(
					'id' => 'password',
                                        'name' => 'password',
					'placeholder' => 'SPV Password',
                                        'class' => 'form-control input-lg'
			)); 
	
	echo form_hidden('id_order',$id_order); 
	
      ?>
      </div>
      </div>
      <div class="modal-footer">
	
	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	<?php echo form_submit('submit_conf', 'Submit','class = "btn btn-success"'); ?>
	
	<?php echo form_close(); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>

<style>
table { border: solid 1px gray; width: 100%; margin: 0 auto;}
th { text-align: center; background-color: black; color: white;}
td { border: solid 1px silver; padding: 5px;}
.col {width: 50%; float: left;}
.clear {clear: both;}

#countdown p {
  display: inline-block;
  padding: 5px;
  color: #FFF;
    text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25);
    background-color: #006DCC;
    background-image: linear-gradient(to bottom, #08C, #04C);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  margin: 0 0 20px;
}


</style>

<?php endif; ?>

<script>
/*
* Basic Count Down to Date and Time
* Author: @mrwigster / trulycode.com
*/
(function (e) {
  e.fn.countdown = function (t, n) {
  function i() {
    eventDate = Date.parse(r.date) / 1e3;
    currentDate = Math.floor(e.now() / 1e3);
    if (eventDate <= currentDate) {
      n.call(this);
      clearInterval(interval)
    }
    seconds = eventDate - currentDate;
    days = Math.floor(seconds / 86400);
    seconds -= days * 60 * 60 * 24;
    hours = Math.floor(seconds / 3600);
    seconds -= hours * 60 * 60;
    minutes = Math.floor(seconds / 60);
    seconds -= minutes * 60;
    days == 1 ? thisEl.find(".timeRefDays").text("day") : thisEl.find(".timeRefDays").text("days");
    hours == 1 ? thisEl.find(".timeRefHours").text("hour") : thisEl.find(".timeRefHours").text("hours");
    minutes == 1 ? thisEl.find(".timeRefMinutes").text("minute") : thisEl.find(".timeRefMinutes").text("minutes");
    seconds == 1 ? thisEl.find(".timeRefSeconds").text("second") : thisEl.find(".timeRefSeconds").text("seconds");
    if (r["format"] == "on") {
      days = String(days).length >= 2 ? days : "0" + days;
      hours = String(hours).length >= 2 ? hours : "0" + hours;
      minutes = String(minutes).length >= 2 ? minutes : "0" + minutes;
      seconds = String(seconds).length >= 2 ? seconds : "0" + seconds
    }
    if (!isNaN(eventDate)) {
      thisEl.find(".days").text(days);
      thisEl.find(".hours").text(hours);
      thisEl.find(".minutes").text(minutes);
      thisEl.find(".seconds").text(seconds)
    } else {
      alert("Invalid date. Example: 30 Tuesday 2013 15:50:00");
      clearInterval(interval)
    }
  }
  var thisEl = e(this);
  var r = {
    date: null,
    format: null
  };
  t && e.extend(r, t);
  i();
  interval = setInterval(i, 1e3)
  }
  })(jQuery);
  $(document).ready(function () {
  function e() {
    var e = new Date;
    e.setDate(e.getDate() + 60);
    dd = e.getDate();
    mm = e.getMonth() + 1;
    y = e.getFullYear();
    futureFormattedDate = mm + "/" + dd + "/" + y;
    return futureFormattedDate
  }
  $("#countdown").countdown({
    date: "<?php
		  
		  $jam = $waktu_masuk;
		  $jams = date($jam);
		  $time = new DateTime($jams);
		  
		  $time->add(new DateInterval('PT1H')); 
		  
		  $timestamp = $time->format('M d Y H:i:s');
		  
		  
		  echo $timestamp;

		  
		  
		  
	    ?>", // Change this to your desired date to countdown to
    format: "on"
  });
});

// Prints something like: Monday 8th of August 2015 03:12:46 PM


</script>
