
<?php 
if (@$sukses) {
    echo '<p class="msg done">'.@$sukses.'</p>';
    ?>
    <script type="text/javascript">
    (function($) {
    	$(function() {
    		parent.jQuery.colorbox.close();
    		return false;
    	});
    })(jQuery);
    </script>
    <?php 
}else{
    echo validation_errors();
    echo form_fieldset('Print Picking List','class="produk"');
    echo '<div class="col-left">';
    echo form_open(site_url(uri_string()).'/prints/');
    echo form_label('Input No. Order');
    echo form_input('order_no',@$id,'class="input-text"');
    echo form_hidden('cabang',$cabang);
    echo form_submit('submit','Input','class="input-submit"');
    echo form_close();
    echo '</div>';  
    echo form_fieldset_close();
}
?>
