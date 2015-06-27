<!--<script type="text/javascript">
    $("document").ready(function() {
	
        $("#test").dataTable({
            "ajax": "<?php //echo base_url(); ?>admin/produk/get_produk_json"
        });


    });
</script>-->

<div id="page-wrapper">
            <table id="test" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
				  <td>ARTICLE CODE</td>
				  <td>TILL CODE</td>				  
				  <td>SV</td>
				  <td>ARTICLE DESC</td>
				  <td>QTY</td>
				  <td>SALES PRICE</td>
				  <td>CABANG</td>
				  <td>MS</td>
				  <td>CATEGORY</td>
				  <td>ATTRIBUTE CLASS</td>
				</tr>
				</thead>
				<tbody></tbody>
				<!--<tbody>
					<?php //foreach ($produk as $item): ?>
						<tr>
						    <td><?php //echo anchor(uri_string().'/detail/'.$item->id_order, $item->ARTICLE_CODE, 'class="active" id="detail"'); ?></td>
						    <td><?php //echo $item->ARTICLE_DESC; ?></td>
						    
						    <td><?php //echo $item->CLASS_DESC; ?></td>
						    <td><?php //echo $item->ATTRIB_DESC; ?></td>
						    
						    
						    <td>
						    <?php
							//if($item->IMG1){
							//	echo "<div class= 'btn btn-success'><i class='fa fa-check-square-o fa-fw'>.</i></div>";
							//}else{
							//	echo "<div class= 'btn btn-danger'><i class='fa fa-times-circle-o fa-fw'>,</i></div>";
							//}
							
						    ?>
						    </td>
						    
						    
						   
						</tr>
					<?php //endforeach; ?>
						
				</tbody>-->
	    </table>
			
</div>

