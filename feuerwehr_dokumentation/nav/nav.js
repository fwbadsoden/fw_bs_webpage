function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<ul>' +
		'<li><a href="'+base+'index.php">Entwicklerhandbuch Startseite</a></li>' +
		'<li><a href="'+base+'toc.php">Inhaltsverzeichnis</a></li>' +
		'</ul>' +

		'<h3>Basis Informationen</h3>' +
		'<ul>' +
			'<li><a href="'+base+'requirements.php">Server Requirements</a></li>' +
			'<li><a href="'+base+'changelog.php">Change Log</a></li>' +
		'</ul>' +

		'<h3>Installation</h3>' +
		'<ul>' +
			'<li><a href="'+base+'php.php">Installation (PHP Code)</a></li>' +
			'<li><a href="'+base+'db.php">Installation (Datenbank)</a></li>' +
			'<li><a href="'+base+'konfiguration.php">Konfiguration</a></li>' +
		'</ul>' +
		
		'</td><td class="td_sep" valign="top">' +

		'<h3>Library Referenz</h3>' +
		'<ul>' +
		'<li><a href="'+base+'auth.php">Auth Class</a></li>' +
		'<li><a href="'+base+'debug.php">Debug Class</a></li>' +
		'<li><a href="'+base+'form_validation.php">Form Validation Class</a></li>' +
		'<li><a href="'+base+'image_lib.php">Image Manipulation Class</a></li>' +
		'<li><a href="'+base+'image_moo.php">Image Moo Class</a></li>' +
		'<li><a href="'+base+'routing.php">URI Routing</a></li>' +
		'<li><a href="'+base+'cp_whence.php">Whence Class</a></li>' +
		'</ul>' +

		'<h3>Helper Referenz</h3>' +
		'<ul>' +
		'<li><a href="'+base+'date_helper.php">Date Helper</a></li>' +
		'<li><a href="'+base+'html_helper.php">HTML Helper</a></li>' +
		'<li><a href="'+base+'loadcontroller_helper.php">Load Controller Helper</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Backend Controller Referenz</h3>' +
		'<ul>' +
			'<li><a href="'+base+'admin.php">Admin</a></li>' +
			'<li><a href="'+base+'einsatz_admin.php">Einsatz</a></li>' +
			'<li><a href="'+base+'fahrzeug_admin.php">Fahrzeug</a></li>' +
			'<li><a href="'+base+'file_admin.php">File</a></li>' +
			'<li><a href="'+base+'maintenance.php">Maintenance</a></li>' +
			'<li><a href="'+base+'menue_admin.php">Menue</a></li>' +
			'<li><a href="'+base+'module_admin.php">Module</a></li>' +
			'<li><a href="'+base+'news_admin.php">News</a></li>' +
			'<li><a href="'+base+'pages_admin.php">Pages</a></li>' +
			'<li><a href="'+base+'termin_admin.php">Termin</a></li>' +
			'<li><a href="'+base+'user_admin.php">User</a></li>' +
		'</ul>' +

		'<h3>Frontend Controller Referenz</h3>' +
		'<ul>' +
			'<li><a href="'+base+'einsatz.php">Einsatz</a></li>' +
			'<li><a href="'+base+'fahrzeug.php">Fahrzeug</a></li>' +
			'<li><a href="'+base+'frontend.php">Frontend</a></li>' +
			'<li><a href="'+base+'news.php">News</a></li>' +
			'<li><a href="'+base+'pages.php">Pages</a></li>' +
			'<li><a href="'+base+'termin.php">Termin</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Model Referenz</h3>' +
		'<ul>' +
		'<li><a href="'+base+'admin.php">Admin</a></li>' +
		'<li><a href="'+base+'auth.php">Auth</a></li>' +
		'<li><a href="'+base+'einsatz.php">Einsatz</a></li>' +
		'<li><a href="'+base+'fahrzeug.php">Fahrzeug</a></li>' +
		'<li><a href="'+base+'file.php">File</a></li>' +
		'<li><a href="'+base+'maintenance.php">Maintenance</a></li>' +
		'<li><a href="'+base+'menue.php">Menue</a></li>' +
		'<li><a href="'+base+'module.php">Module</a></li>' +
		'<li><a href="'+base+'news.php">News</a></li>' +
		'<li><a href="'+base+'pages.php">Pages</a></li>' +
		'<li><a href="'+base+'termin.php">Termin</a></li>' +
		'<li><a href="'+base+'user.php">User</a></li>' +
		'</ul>' +

		'</td></tr></table>');
}