<html>
<body>
	<h3>Reset Password untuk Email : <?php echo $identity;?></h3>
	<p>Klik link ini untuk melakukan <?php echo anchor('auth/reset_password/'. $forgotten_password_code, 'Reset Password');?>.</p>
</body>
</html>