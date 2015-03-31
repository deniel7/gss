
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">

		
		
                            
                                
                                    <div class="table-responsive">
					<table id="datatables" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
						<tr>
						  <td>PLU</td>
						  <td>Article Code</td>
						  <td>Article Desc</td>
						  <td>Images</td>
						  <td>Action</td>
						</thead>
						<tbody>
						
						<?php $i=0; foreach ($produk as $val): ?>
							<tr>
							    <td><?php echo $val->PLU; ?></td>
							    <td><?php echo $val->ARTICLE_CODE; ?></td>
							    <td><?php echo $val->ARTICLE_DESC; ?></td>
							    <td><?php echo $val->THUMB; ?></td>
							    <td><?php echo anchor('admin/produk/ubah/'.$val->ARTICLE_CODE,'Ubah','class="ubah"'); ?></td>
							</tr>
						<?php $i++; endforeach; ?>
						
						
						</tbody>
						
					</table>
                                    </div>
                                    
		
<div id="menu" class="box">
	<ul class="box f-right">
	   <!--<li><a href="<?php //echo site_url('admin/produk/tambah') ?>" id="add"><span><strong>Import Produk Baru</strong></span></a></li>-->
	<li><div id="clasp_" class="clasp"><a href="javascript:lunchboxOpen('');"><span><strong>Import Produk</strong></span></a></div></li>	
	</ul>
</div>




<div id="lunch_" class="lunchbox">
	
	<h4>Keterangan Import Data</h3>

		<table>
			<tr>
		<?php foreach ($who_imp as $who): ?>
		
		
		<td colspan="4"><b>Tanggal Update Produk</b></td>
		<td colspan="4">
		
		<?php
			//echo date ("d/m/Y | h:ia",strtotime($who->import_time));
			echo $who->import_time;
		?><br/>
		</td><td><input type=button onClick="location.href='<?php echo site_url('admin/import') ?>'" value='Import' style = 'width:120px; height:30px'></td>
	</tr>
	<tr>
		<td colspan="4"><b>Pengguna</b></td>
		<td colspan="5">
			<?php echo $who->username; ?>
		<?php endforeach; ?>
		
		</td>
		
	</tr>
		</table><br/>
	

<table style="position:right">
	
	<tr>
		<td colspan="5"><b>Produk Tidak Memiliki Nama</b></td>
		<?php
		
			foreach ($total_empty_name as $tot):
		
		?>
		<?php
		
		if($tot == 0)
                {
			echo '<td class="count_green">'.anchor(site_url('admin/produk/list_empty_name'),$tot).'</td>';
		}else{
                
		?>
		
		<td class="count_red"><?php echo anchor(site_url('admin/produk/list_empty_name'),$tot); ?></td>
		<?php } ?>
		<?php endforeach; ?>
	</tr><tr>
		
		<td colspan="5"><b>Produk Tidak Memiliki Gambar</b></td>
		<?php
		
			foreach ($total_empty_pic as $tot_pic):
		
		?>
		<?php
		
		if($tot_pic == 0)
                {
			echo '<td class="count_green">'.anchor(site_url('admin/produk/list_empty_pic'),$tot_pic).'</td>';
		}else{
                
		?>
		
		<td class="count_red"><?php echo anchor(site_url('admin/produk/list_empty_pic'),$tot_pic); ?></td>
		<?php } ?>
		<?php endforeach; ?>
		
	<!--</td>-->
	</tr>
	<tr>
		<td colspan="5"><b>Top Sales Produk</b></td>
		
			<?php
				
				foreach ($total_topsales as $tot_topsales):
				echo '<td class="count_green">' .anchor(site_url('admin/produk/list_top_sales'),$tot_topsales).'</td>';
			?>
		<?php endforeach; ?>
		
		
	</tr>
	<tr>
		<td colspan="4"><b>Total Produk</b></td>
		<td colspan="5"><?php echo $total_rows; ?></td>
		
	</tr>
	</table><br/>
	
	
	
</div>
<br/><br/>


<!--<h4>Keterangan Import Data</h3>-->
<h3 class="tit">Daftar Produk</h3>
<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('admin/produk/search');
	?>

			<span>
				<?php
					$data_s = array(
					'name'        => 'search_plu',
					'id'          => 'search_plu',
					'placeholder' => '',
					'font-color'   => 'red'
					//'value'	      => $search_name,
					);
					
					$data_n = array(
					'name'        => 'search_name',
					'id'          => 'search_name',
					'placeholder' => '',
					'font-color'   => 'red'
					//'value'	      => $search_name,
					);
					
					echo form_close();
				?>
					<div class="table">
					<div class="headRow">
					    <!--<div class="col">Pencarian :</div>-->
					   <!-- <br/>-->
					    <div class="col">PLU <?php echo form_input($data_s); ?></div>
					    <div class="col">Nama Produk<?php echo form_input($data_n); ?></div>
					    <!--<br/>-->
					    
					    <div class="col">
					    Kategori
					    <?php 
						//echo form_dropdown('search_kat', $list_kat);
						echo form_dropdown('search_kat',$list_kategori,@$kategori);	
						 //echo form_input($data_kat); ?>
					    </div>
					    
					    <div style="margin-left:700px; margin-top:15px"><?php echo form_submit('submit', 'Cari','class = "btn large"'); ?></div>
					</div> 
					</div>
						<div id="result"></div>
				
			</span>
			
</div>

