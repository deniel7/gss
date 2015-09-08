<script type="text/javascript">
    $("document").ready(function() {
	
        $("#test").dataTable({
            "ajax": "<?php echo base_url(); ?>admin/produk/get_produk_json"
        });

//        $(".dataTables_empty").html("Enter PLU in Search Field to select Article(s)");

    });
</script>

<div id="page-wrapper">
            <table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
				  <td>ARTICLE CODE</td>
				  <td>ARTICLE DESC</td>				  
				  <td>CLASS DESC</td>
				  <td>ATTRIB DESC</td>
				  <td>IMAGES</td>
				</tr>
				</thead>
				
				<tbody>
					<?php foreach ($produk as $item): ?>
						<tr>
						    <td><?php echo anchor(base_url().'admin/produk/detail/'.$item->ARTICLE_CODE, $item->ARTICLE_CODE, 'class="active" id="detail"'); ?></td>
						    <td><?php echo $item->ARTICLE_DESC; ?></td>
						    
						    <td><?php echo $item->CLASS_DESC; ?></td>
						    <td><?php echo $item->ATTRIB_DESC; ?></td>
						    
						    
						    <td>
						    <?php
							if($item->IMG1){
								echo "<div class= 'btn btn-success'><i class='fa fa-check-square-o fa-fw'>.</i></div>";
							}else{
								echo "<div class= 'btn btn-danger'><i class='fa fa-times-circle-o fa-fw'>,</i></div>";
							}
							
						    ?>
						    </td>
						    
						    
						   
						</tr>
					<?php endforeach; ?>
						
				</tbody>
	    </table>
			
</div>

