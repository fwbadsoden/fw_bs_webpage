<? include_once('header.php'); ?>


<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="http://www.feuerwehr-bs.de/">Projektstartseite</a> &nbsp;&#8250;&nbsp; <a href="#">Entwicklerhandbuch</a> &nbsp;&#8250;&nbsp; URI Routing
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="example.com/user_guide/" />Entwicklerhandbuch durchsuchen&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<!-- START CONTENT -->
<div id="content">

<h1>URI Routing (custom) </h1>

<p>Diese Klasse erweitert die CodeIgniter Routing-Funktionalit&auml;t um kundeneigene Funktionen. Die generelle Funktionsweise ist in der CodeIgniter Dokumentation nachzulesen.</p>

<a name="functionreference"></a>
<h1>Funktions Referenz</h1>

<p>Die folgenden kundeneigenen Funktionen sind implementiert.</p>

<h2>_parse_routes()</h2>

<p>Die systemeigene Funktion wurde um Debugmeldungen erweitert, damit w&auml;hrend der Entwicklung das Verhalten im Routing besser nachvollzogen werden kann.</p>



<h2>_validate_request(<var>$segments</var>)</h2>

<p>Die systemeigene Funktion wurde erweitert, so dass die Controller in Unterordner sortiert werden k&ouml;nnen.</p>

</div>
<!-- END CONTENT -->

<? include_once('footer.php'); ?>