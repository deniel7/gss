<?php
                    //$komplemen = array('id'=>'addForm', 'name'=>'addForm');
		    echo form_open_multipart('admin/slide_banner/tambah');
	       ?>

	       <div class="table">
		    <div class="row">
		      Format gambar yang diwajibkan adalah : <br/>
		      Panjang : 960px <br/>
		      Lebar : 300px <br/>
		      Besar File : 500kb<br/>
		    
		    </div>
		    <br/><br/>
		    <div class="row">
		    <div class="col">Pilih Gambar : </div>
                    <div class="col"><input type="file" name="userfile" id="userfile" size="20" /></div>
		    </div>
		    
                    

	       
               <input type="submit" value="upload" name="go_upload"/>
	       <?php

               //echo form_submit('save','Save')
		
	       ?>

	       <?php echo form_close() ?>
               
	       <?php if (isset ($error)) { ?>
		<div class="row">
                <div style="color:red"><?php echo $error; ?></div>
		</div>
                <?php } else if(isset ($sukses)){ ?>
                <div style="color:green"><?php echo $sukses; ?></div>
                <?php } ?>
		
	       </div>