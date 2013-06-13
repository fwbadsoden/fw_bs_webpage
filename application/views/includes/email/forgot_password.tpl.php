<html>
<body>
	<h1>Passwort zur&uuml;cksetzen f&uuml;r <?php echo $identity;?></h1>
	<?php 
		// Note: This template links to the manual password reset page, where the user can enter their new password themselves.
		// If you wish to automatically generate a new password for them, change the link from 'manual_reset_forgotten_password' to 'auto_reset_forgotten_password'
	?>
	<p>Bitte auf diesen Link klicken zum zur&uuml;cksetzen des Passworts: <?php echo anchor('admin/reset_forgotten_password/'.$user_id.'/'.$forgotten_password_token, 'Passwort zur&uuml;cksetzen');?>.</p>
</body>
</html>