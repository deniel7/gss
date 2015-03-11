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


<?php foreach($detail as $data): ?>
<?php $orderno = $data['ORDER_NO_GTRON']; ?>


<?php if($multiuser !=1): ?>
<div class="responsive span6" style="margin-bottom: 50px">
	
<form action="<?php echo site_url(uri_string()); ?>" method="POST">
<table cellspacing="0" cellpadding="3px">
	<tr>
	    <td>Order No</td>
	    <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
	</tr>
	<tr>
	    <td>Nomor Struk</td>
	    <td>
		<?php
	
			echo form_hidden('orderno',$orderno);
			
			echo form_input(array(
							'id' => 'nomor',
							'name' => 'nomor',
							'placeholder' => 'Nomor Struk Pembayaran',
							'value' =>  $data['no_struk'],
							'class' => 'form-control input-lg'
					)); 
			
		?>
	    </td>
	</tr>
	<tr>
		<td>Nominal Struk</td>
		<td>Rp. <input id="price" type="text" value="<?php echo $data['TOTAL_BIAYA_INPUT']; ?>" name="total_biaya_input" placeholder="Total Nominal Transaksi"></input></td>
		
	</tr>
	<tr>
		<td></td>
		<td>
   
		<?php echo form_submit('submit', 'Submit','class = "btn btn-primary"'); ?>
		<button class="demo btn btn-warning btn-lg" data-toggle="modal" href="#myModal">Cancel Pesanan</button>
		<?php echo form_close(); ?>
		</td>
		
	</tr>

</table>
            
</div>
<?php endif; ?>


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
        <th>Total Belanja</th>
    </tr>

    <tr>
        <td><?php echo $data['ORDER_NO_GTRON']; ?></td>
        <td><?php echo $data['tanggal_masuk']; ?></td>
        <td><?php echo $data['total_item']; ?></td>
        <td> Rp. <?php echo $this->cart->format_number($data['total_biaya']); ?></td>
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
        <td>Rp. <?php echo $this->cart->format_number($detail['subtotal']); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td colspan="2" style="text-align: right"><b>Biaya Kirim</b></td>
	<td>Rp. <?php echo $this->cart->format_number($data['biaya_kirim']); ?></td>
    </tr>
    
</table>


<br/>
<div>
    
</div>



<?php
    
    endforeach;
?>
<div id="responsive" class="modal fade" tabindex="-1" data-width="160" style="display: none">
    <form action="<?php echo site_url(uri_string()); ?>" method="POST">
    
    <?php //echo form_open('pesanan/submit_pesanan'); ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Submit Pesanan</h4>
    </div>
    <div class="modal-body">
    <div class="row">
    <div class="span4">
    <!--<h4>Bukti Pembayaran Transaksi</h4>-->
    <p>
    <?php
	
	echo form_hidden('orderno',$orderno);
	
	echo form_input(array(
					'id' => 'nomor',
                                        'name' => 'nomor',
					'placeholder' => 'Nomor Struk Pembayaran',
					'value' =>  $data['no_struk'],
                                        'class' => 'form-control input-lg'
			)); 
	
    ?>
    </p>
    
    <p>
	<input id="price" type="text" value="<?php echo $data['TOTAL_BIAYA_INPUT']; ?>" name="total_biaya_input" placeholder="Total Nominal Transaksi"></input>
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


<!-- Modal -->
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
	
	echo form_hidden('orderno',$orderno); 
	
      ?>
      </div>
      </div>
      <div class="modal-footer">
	
	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	<?php echo form_submit('submit2', 'Yes','class = "btn btn-success"'); ?>
	
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
</style>

<?php endif; ?>