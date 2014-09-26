<head>
	   
</head>
<h2>Term & Condition</h2>
<br/>
<?php if(@$sukses):?>
    <?php echo $sukses; ?>
    <br/><br/>
    Cek Email Anda dan setelah Anda menerima konfirmasi email atas permohonan registrasi yang dikirimkan, <br/>
    Anda bisa login <a href="<?php echo site_url('user/login'); ?>">di sini.</a>
    

<?php else: ?>
    
    <?php if(@$error){echo @$error;} ?>
    <?php echo validation_errors(); ?>
    <br />
    
    <fieldset style="border:solid thin; background-color:#f4f2f2; border-radius:10px; border-color:#F1F1F1; padding:10px">
		<p>
			<h2>Term of Service</h2>
				<ol>
					<li>Hanya pemilik kartu <strong><span style="color: #ff0000;">Member Card Yogya</span></strong> dapat melakukan registrasi di Yogya E-Commerce</li>
					<li>Setiap data yang dimasukan ke dalam website dan berhubungan dengan registrasi / pemesanan harus bersifat lengkap, akurat dan valid</li>
					<li>Alamat pengiriman hanya berlaku di wilayah kota <strong>Bandung</strong></li>
					<li>Pembeli setuju bahwa barang yang diterima mungkin memiliki sedikit perbedaan dalam warna karena untuk memantau pengaturan, dan pencahayaan studio yang kuat ketika gambar diambil dan mungkin memiliki sedikit perbedaan dalam ukuran (1-2 variasi cm)</li>
					<li>Barang hanya dapat disimpan selama 1 x 24 jam selama check out. Jika pembayaran belum dilakukan dalam waktu 1x24 jam. Kami diizinkan untuk menjual barang ke pelanggan lain</li>
					<li>Pembeli diwajibkan melakukan <span style="text-decoration: underline;">Konfirmasi Pembayaran</span> sebelum kemudian pesanan akan diproses lebih lanjut</li>
					
				</ol>
		</p>
	</fieldset>
    <br/>
    
    <br />
<?php endif ?>