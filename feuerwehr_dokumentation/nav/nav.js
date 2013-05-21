function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<ul>' +
		'<li><a href="'+base+'index.php">Entwicklerhandbuch Startseite</a></li>' +
		'<li><a href="'+base+'index.php?op=toc.php">Inhaltsverzeichnis</a></li>' +
		'</ul>' +

		'<h3>Basis Informationen</h3>' +
		'<ul>' +
			'<li><a href="'+base+'index.php?op=requirements">Server Requirements</a></li>' +
			'<li><a href="'+base+'index.php?op=changelog">Change Log</a></li>' +
		'</ul>' +

		'<h3>Installation</h3>' +
		'<ul>' +
			'<li><a href="'+base+'index.php?op=install_php">Installation (PHP Code)</a></li>' +
			'<li><a href="'+base+'index.php?op=install_db">Installation (Datenbank)</a></li>' +
			'<li><a href="'+base+'index.php?op=konfiguration">Konfiguration</a></li>' +
		'</ul>' +
		
		'</td><td class="td_sep" valign="top">' +

		'<h3>Library Referenz</h3>' +
		'<ul>' +
		'<li><a href="'+base+'index.php?op=auth">Auth Class</a></li>' +
		'<li><a href="'+base+'index.php?op=debug">Debug Class</a></li>' +
		'<li><a href="'+base+'index.php?op=form_validation">Form Validation Class</a></li>' +
		'<li><a href="'+base+'index.php?op=image_lib">Image Manipulation Class</a></li>' +
		'<li><a href="'+base+'index.php?op=image_moo">Image Moo Class</a></li>' +
		'<li><a href="'+base+'index.php?op=routing">URI Routing</a></li>' +
		'<li><a href="'+base+'index.php?op=whence">Whence Class</a></li>' +
		'</ul>' +

		'<h3>Helper Referenz</h3>' +
		'<ul>' +
		'<li><a href="'+base+'index.php?op=date_helper">Date Helper</a></li>' +
		'<li><a href="'+base+'index.php?op=html_helper">HTML Helper</a></li>' +
		'<li><a href="'+base+'index.php?op=loadcontroller_helper">Load Controller Helper</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Backend Controller Referenz</h3>' +
		'<ul>' +
			'<li><a href="'+base+'index.php?op=admin">Admin</a></li>' +
			'<li><a href="'+base+'index.php?op=einsatz_admin">Einsatz</a></li>' +
			'<li><a href="'+base+'index.php?op=fahrzeug_admin">Fahrzeug</a></li>' +
			'<li><a href="'+base+'index.php?op=file_admin">File</a></li>' +
			'<li><a href="'+base+'index.php?op=maintenance">Maintenance</a></li>' +
			'<li><a href="'+base+'index.php?op=menue_admin">Menue</a></li>' +
			'<li><a href="'+base+'index.php?op=module_admin">Module</a></li>' +
			'<li><a href="'+base+'index.php?op=news_admin">News</a></li>' +
			'<li><a href="'+base+'index.php?op=pages_admin">Pages</a></li>' +
			'<li><a href="'+base+'index.php?op=termin_admin">Termin</a></li>' +
			'<li><a href="'+base+'index.php?op=user_admin">User</a></li>' +
		'</ul>' +

		'<h3>Frontend Controller Referenz</h3>' +
		'<ul>' +
			'<li><a href="'+base+'index.php?op=einsatz">Einsatz</a></li>' +
			'<li><a href="'+base+'index.php?op=fahrzeug">Fahrzeug</a></li>' +
			'<li><a href="'+base+'index.php?op=frontend">Frontend</a></li>' +
			'<li><a href="'+base+'index.php?op=news">News</a></li>' +
			'<li><a href="'+base+'index.php?op=pages">Pages</a></li>' +
			'<li><a href="'+base+'index.php?op=termin">Termin</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Model Referenz</h3>' +
		'<ul>' +
		'<li><a href="'+base+'index.php?op=admin_model">Admin</a></li>' +
		'<li><a href="'+base+'index.php?op=auth_model">Auth</a></li>' +
		'<li><a href="'+base+'index.php?op=einsatz_model">Einsatz</a></li>' +
		'<li><a href="'+base+'index.php?op=fahrzeug_model">Fahrzeug</a></li>' +
		'<li><a href="'+base+'index.php?op=file_model">File</a></li>' +
		'<li><a href="'+base+'index.php?op=maintenance_model">Maintenance</a></li>' +
		'<li><a href="'+base+'index.php?op=menue_model">Menue</a></li>' +
		'<li><a href="'+base+'index.php?op=module_model">Module</a></li>' +
		'<li><a href="'+base+'index.php?op=news_model">News</a></li>' +
		'<li><a href="'+base+'index.php?op=pages_model">Pages</a></li>' +
		'<li><a href="'+base+'index.php?op=termin_model">Termin</a></li>' +
		'<li><a href="'+base+'index.php?op=user_model">User</a></li>' +
		'</ul>' +

		'</td></tr></table>');
}