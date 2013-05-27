<? include_once('header.php'); ?>


<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="http://www.feuerwehr-bs.de/">Projektstartseite</a> &nbsp;&#8250;&nbsp; <a href="#">Entwicklerhandbuch</a> &nbsp;&#8250;&nbsp; Wetter
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="example.com/user_guide/" />Entwicklerhandbuch durchsuchen&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<!-- START CONTENT -->
<div id="content">

<h1>Wetter</h1>

<p>Diese Klasse bietet Zugriff auf Wetterdaten &uuml;ber die Yahoo Wetter API. Dazu wird an Hand einer &uuml;bergebenen WOEID das gelieferte SimpleXML Objekt in ein Array umgewandelt.<br/>Die eingestellte WOEID ist f&uuml;r den Main-Taunus-Kreis.</p>

<a name="functionreference"></a>
<h1>Funktions Referenz</h1>

<p>Die folgenden kundeneigenen Funktionen sind implementiert.</p>

<h2>get_weather()</h2>

<p>Liefert an Hand der eingestellten WOEID die aktuellen Wetterdaten als Array.</p>
<code>
array(4) {<br />
&nbsp;&nbsp;["weather_unit"]=><br />
&nbsp;&nbsp;  array(4) {<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["temperature"]=>
    string(1) "{Temperatureinheit}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["distance"]=>
    string(2) " {Entfernungseinheit}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;["pressure"]=>
    string(2) "{Druckeinheit}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["speed"]=>
    string(4) "{Geschwindigkeitseinheit}"<br />
&nbsp;&nbsp;  }<br />
&nbsp;&nbsp;&nbsp;&nbsp;  ["weather_wind"]=><br />
&nbsp;&nbsp;&nbsp;&nbsp;  array(3) {<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["chill"]=>
    string(2) "{Windtemperatur}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["direction"]=>
    string(3) "{Windrichtung}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["speed"]=>
    string(5) "{Windgeschwindigkeit}"<br />
&nbsp;&nbsp;  }<br />
&nbsp;&nbsp;  ["weather_cond"]=><br />
&nbsp;&nbsp;  array(4) {<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["text"]=>
    string(33) "{Text}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["code"]=>
    string(2) "{Condition Code der API (&uuml;ber diesen Code ermittelt die Library den deutschen Text und das Bild}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["temp"]=>
    string(2) "{Temperatur}"<br />
&nbsp;&nbsp;&nbsp;&nbsp;    ["date"]=>
    string(29) "{Datum + Zeit}"<br />
&nbsp;&nbsp;  }<br />
&nbsp;&nbsp;&nbsp;&nbsp;  ["weather_img"]=>
  string(131) "{Bild}"<br />
}
</code>

<h2>cardinalize(<var>$degree</var>)</h2>

<p>Wandelt die von der API gelieferte Gradangabe in die Windrichtung um (N, NO, NW etc.).</p>

<p>&nbsp;</p>

<a name="woeidreference"></a>
<h1>WOEID Referenz</h1>

<p>Die folgende Liste umfasst alle in der Library defnierten WOEIDs.</p>


<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
	<tr>
		<th>WOEID</th>
		<th>Ort</th>
	</tr>

	<tr>
		<td class="td"><strong>12835281</strong></td>
		<td class="td">Main-Taunus-Kreis</td>
	</tr>


</table>

<p>&nbsp;</p>

</div>
<!-- END CONTENT -->

<? include_once('footer.php'); ?>