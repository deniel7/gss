<head>
	   
</head>
<h2>Cara Belanja</h2>
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
			<h2>Tahapan Berbelanja di Yogya E-Commerce : </h2>
				<ol>
					<li>Lakukan Registrasi / Pengajuan sebagai Member</li>
                                        <li>Tunggu Approval Pengajuan yang akan dikirim melalui email saat registrasi</li>
					<li>Lakukan Login</li>
					<li>Cari Barang / Cari berdasarkan kategori</li>
					<li>Masukan jumlah barang yang akan dipesan, klik Checkout</li>
					<li>Tentukan alamat pengiriman dan metoda pembayaran</li>
					<li>Lakukan Pembayaran, dan lakukan konfirmasi melalui website</li>
                                        <li>Tunggu Email dari kami bahwa Notifikasi konfirmasi Anda telah kami terima</li>
                                        <li>Pesanan diproses dan dan dilakukan proses packing</li>
                                        <li>Pesanan diantar menuju Alamat Anda, konfirmasi bahwa pesanan sudah diterima.</li>
                                </ol>
		</p>
    </fieldset>
    <br/>
<?php endif ?>