<head>
<style>
#table{width:700px;}
	div span{display:inline-block;}
	div .header2{border:3px solid #E3E3E3;font-weight:bold;}
	.kolom{width:175px;padding:2px;padding-left:30px;margin:2px;}
	.kolom_del{width:100px;padding:2px;padding-left:60px;margin:2px;text-align:left;}
	.baris{border:1px solid #E3E3E3;}
	.kolom_nm{width:300px;padding:2px;margin:2px;}
</style>
<h1>Pengaturan Slide Banner</h1>

</head>

<body>
    <div id="menu" class="box">
	<ul class="box f-right">
	   <li><a href="<?php echo site_url('admin/slide_banner/tambah') ?>" id="add"><span><strong>Tambah Gambar</strong></span></a></li>
        </ul>
    </div>
    <br/>
    <div id="table">
        <div class="header2">
                <!--<span class="kolom_nm">Nama</span>-->
                
                <span class="kolom">Gambar</span>
                <span class="kolom_del">Delete</span>
                
        </div>
        <?php foreach($gbr->result() as $row): ?>
        <div class="header2">
                
                
                <span class="kolom"><img src="<?php echo base_url().'images/banner/thumb/'.$row->thumb ?>"/></span>
                <span class="kolom_del"><?php echo anchor('admin/slide_banner/hapus/'.$row->id_banner,'Hapus',array('onclick'=>"return confirm('Yakin akan menghapus gambar ini?')"))."</span>"; ?></span>
        
        </div>
        <?php endforeach; ?>
    </div>
    
    
    
</body>
<script type="text/javascript">
jQuery(function($) {
	$("#add,#ubah,#profile").colorbox({
		width:"500", height:"500", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>