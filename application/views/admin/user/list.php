<h1><?php echo $judul ?></h1>
<div id="menu" class="box">
	<ul class="box f-right">
	   <li><a href="<?php echo site_url('admin/user/tambah') ?>" id="add"><span><strong>Tambah Admin Baru</strong></span></a></li>
    </ul>
</div>
<h3 class="tit">Daftar User</h3>
<?php echo $this->session->flashdata('user_note'); ?>

<div id="search_container">
	<?php
		$attributes = array('id' => 'form_pencarian');
		echo form_open('admin/user/search');
	?>
			<span>
				<?php
					$data_search = array(
					'name'        => 'search_name',
					'id'          => 'search_name',
					//'placeholder' => 'Username',
					'font-color'   => 'red'
					
					);
					
					$data_member = array(
					'name'        => 'search_mem',
					'id'          => 'search_mem',
					//'placeholder' => 'No. Member',
					'font-color'   => 'red'
					
					);
					
					$search_level = array(
					'name'        => 'search_level',
					'id'          => 'search_level'
					
					);
					
					
					echo form_close();
				?>
				
				<div class="table">
					<div class="headRow">
					    <!--<div class="col">Pencarian :</div>-->
					    <div class="col">Username<?php echo form_input($data_search); ?></div>
					    <div class="col">No. Member<?php echo form_input($data_member); ?></div>
					    <div class="col">Level
						<?php
							$options = array(
								''  => '-Pilih-',
								'admin' => 'Admin',
								'user' => 'User',
							      );
					      
							echo form_dropdown('level', $options);
						?>
					    </div>
					    <div class="col">&nbsp<?php echo form_submit('submit', 'Cari','class = "btn large"'); ?></div>
					</div> 
				</div>
				<div id="result"></div>
			</span>
			
</div>
<?php if ($user == NULL){
    echo "<p class='msg warning'>User yang dicari tidak ditemukan</p>";
}else{ ?>
<?php if($user!= array()): ?>
	<table>
		<tr>
		    <th>Membercard</th>
		    <th>Username</th>
		    <th>Email</th>
		    <th>Telepon</th>
                    <th>Level</th>
		    <th>Cabang</th>
		    <th>Status</th>
                    <th>Penolakan</th>
		    <th>Action</th>
		    
		</tr>
        <?php $i=1; foreach ($user as $val): ?>
		<tr <?php echo $i%2 == 0 ? 'class="bg"' : '';  ?>>
		    <td><?php echo $val->membercard; ?></td>
		    <td><?php echo $val->username; ?></td>
		    <td><?php echo $val->email; ?></td>
		    <td><?php echo $val->telepon; ?></td>
		    <td><?php echo $val->level; ?></td>
		    <td><?php echo $val->kode_cabang; ?></td>
		    <td><?php echo $val->status == 1 ? anchor(uri_string(),'Aktif', 'class="active"') : anchor(uri_string().'/aktifasi/'.$val->id_user.'/1','Tidak Aktif', 'class="no-active"'); ?></td>
		    <td style="text-align:center"><?php //echo anchor('admin/user/email_ditolak/'.$val->id_user,'Kirim','id="email_ditolak"')?>
			<a href="<?php echo site_url('admin/user/email_ditolak/'.$val->id_user); ?>" id="email_ditolak"><img src="<?php echo base_url().'images/send-mail.png'; ?>"/></a>
		    </td>
			<td>
			    <?php //echo anchor('admin/user/record/'.$val->id_user,'Record')?> 
			     
			    <?php echo anchor('admin/user/profile/'.$val->id_user,'Profile','id="profile"')?> 			    
			     | 
			    <?php echo anchor('admin/user/ubah/'.$val->id_user,'Ubah','id="ubah"')?>
			     |
			    <?php echo anchor('admin/user/hapus/'.$val->id_user,'Hapus',array('onclick'=>"return confirm('Yakin akan menghapus user ini?')")) ?>
			</td>
			
		</tr>
        <?php $i++; endforeach; ?>
    <tr><td colspan="9" align="center"><?php  echo $this->pagination->create_links(); ?></td></tr>
	</table>
<?php else: ?>
    <p class="msg info">Belum ada Produk yang tersedia</p>
<?php endif; ?>
<script type="text/javascript">
jQuery(function($) {
	$("#add,#ubah,#profile").colorbox({
		width:"500", height:"500", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
<?php } ?>