<? include_once('header.php'); ?>

<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="http://www.feuerwehr-bs.de/">Projektstartseite</a> &nbsp;&#8250;&nbsp; <a href="#">Entwicklerhandbuch</a> &nbsp;&#8250;&nbsp; Form Validation
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="example.com/user_guide/" />Entwicklerhandbuch durchsuchen&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<!-- START CONTENT -->
<div id="content">

<h1>Form Validation (custom)</h1>

<p>Diese Klasse erweitert die CodeIgniter Formularvalidierung um kundeneigene Funktionen. Die generelle Funktionsweise ist in der CodeIgniter Dokumentation nachzulesen.</p>

<ul>
<li><a href="#rulereference">Regel Referenz</a></li>
<li><a href="#preppingreference">Prepping Referenz</a></li>
<li><a href="#functionreference">Funktionsreferenz</a></li>

</ul>






<p>&nbsp;</p>


<a name="rulereference"></a>
<h1>Regel Referenz</h1>

<p>Die folgende Liste umfasst alle kundeneigenen Validierungsregeln.</p>


<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
	<tr>
		<th>Regel</th>
		<th>Parameter</th>
		<th>Beschreibung</th>
		<th>Beispiel</th>
	</tr>

	<tr>
		<td class="td"><strong>edit_unique</strong></td>
		<td class="td">Ja</td>
		<td class="td">Gibt FALSE zur&uuml;ck, wenn der Wert schon in der &uuml;bergebenen Tabelle enthalten ist. Als Erweiterung zur is_unique Funktion von CI erm&ouml;glicht diese Funktion die &Uuml;berpr&uuml;fung eines schon vorhandenen Datensatzes. Hierzu wird die Datenbank-ID &uuml;bergeben.</td>
		<td class="td">edit_unique[table.field.id_value.id_name]</td>
	</tr>

	<tr>
		<td class="td"><strong>alpha</strong></td>
		<td class="td">No</td>
		<td class="td">Erweiterung der CodeIgniter Regel um die deutschen Umlaute.</td>
		<td class="td">&nbsp;</td>
	</tr>

	<tr>
		<td class="td"><strong>alpha_numeric</strong></td>
		<td class="td">No</td>
		<td class="td">Erweiterung der CodeIgniter Regel um die deutschen Umlaute.</td>
		<td class="td">&nbsp;</td>
	</tr>

	<tr>
		<td class="td"><strong>alpha_dash</strong></td>
		<td class="td">No</td>
		<td class="td">Erweiterung der CodeIgniter Regel um die deutschen Umlaute.</td>
		<td class="td">&nbsp;</td>
	</tr>

	<tr>
		<td class="td"><strong>decimal</strong></td>
		<td class="td">Yes</td>
		<td class="td">Erweiterung der CodeIgniter Regel, damit statt des Dezimalpunktes ein Dezimalkomma erwartet wird.</td>
		<td class="td">&nbsp;</td>
	</tr>


</table>

<p>&nbsp;</p>

<a name="preppingreference"></a>
<h1>Prepping Referenz</h1>

<p>Liste aller kundeneigenen Prepping Funktionen:</p>



<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
	<tr>
		<th>Name</th>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</tr><tr>

		<td class="td"><strong>&nbsp;</strong></td>
		<td class="td">&nbsp;</td>
		<td class="td">&nbsp;</td>
	</tr><tr>

</table>





<p>&nbsp;</p>

<a name="functionreference"></a>
<h1>Funktions Referenz</h1>

<p>Die folgenden kundeneigenen Funktionen sind implementiert.</p>

<h2>&nbsp;</h2>

<p>&nbsp;</p>


<p>&nbsp;</p>


</div>
<!-- END CONTENT -->

<? include_once('footer.php'); ?>