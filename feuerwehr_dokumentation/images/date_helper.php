<? include_once('../header.php'); ?>

<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="http://www.feuerwehr-bs.de/">Projektstartseite</a> &nbsp;&#8250;&nbsp; <a href="#">Entwicklerhandbuch</a> &nbsp;&#8250;&nbsp; Date Helper
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="example.com/user_guide/" />Entwicklerhandbuch durchsuchen&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<!-- START CONTENT -->
<div id="content">


<h1>Date Helper</h1>

<p>The Date Helper file contains functions that help you work with dates.</p>


<h2>Loading this Helper</h2>

<p>This helper is loaded using the following code:</p>
<code>$this->load->helper('date');</code>


<p>The following functions are available:</p>

<h2>now()</h2>

<p>Returns the current time as a Unix timestamp, referenced either to your server's local time or GMT, based on the "time reference"
setting in your config file.  If you do not intend to set your master time reference to GMT (which you'll typically do if you
run a site that lets each user set their own timezone settings) there is no benefit to using this function over PHP's time() function.
</p>




<h2>mdate()</h2>

<p>This function is identical to PHPs <a href="http://www.php.net/date">date()</a> function, except that it lets you
use MySQL style date codes, where each code letter is preceded with a percent sign:  %Y %m %d etc.</p>

<p>The benefit of doing dates this way is that you don't have to worry about escaping any characters that
are not date codes, as you would normally have to do with the date() function.  Example:</p>

<code>$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";<br />
$time = time();<br />
<br />
echo mdate($datestring, $time);</code>

<p>If a timestamp is not included in the second parameter the current time will be used.</p>


<h2>standard_date()</h2>

<p>Lets you generate a date string in one of several standardized formats. Example:</p>

<code>
$format = 'DATE_RFC822';<br />
$time = time();<br />
<br />
echo standard_date($format, $time);
</code>

<p>The first parameter must contain the format, the second parameter must contain the date as a Unix timestamp.</p>

<p>Supported formats:</p>

<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
	<tr>
		<th>Constant</th>
		<th>Description</th>
		<th>Example</th>
	</tr>
	<tr>
		<td>DATE_ATOM</td>
		<td>Atom</td>
		<td>2005-08-15T16:13:03+0000</td>
	</tr>
	<tr>
		<td>DATE_COOKIE</td>
		<td>HTTP Cookies</td>
		<td>Sun, 14 Aug 2005 16:13:03 UTC</td>
	</tr>
	<tr>
		<td>DATE_ISO8601</td>
		<td>ISO-8601</td>
		<td>2005-08-14T16:13:03+00:00</td>
	</tr>
	<tr>
		<td>DATE_RFC822</td>
		<td>RFC 822</td>
		<td>Sun, 14 Aug 05 16:13:03 UTC</td>
	</tr>
	<tr>
		<td>DATE_RFC850</td>
		<td>RFC 850</td>
		<td>Sunday, 14-Aug-05 16:13:03 UTC</td>
	</tr>
	<tr>
		<td>DATE_RFC1036</td>
		<td>RFC 1036</td>
		<td>Sunday, 14-Aug-05 16:13:03 UTC</td>
	</tr>
	<tr>
		<td>DATE_RFC1123</td>
		<td>RFC 1123</td>
		<td>Sun, 14 Aug 2005 16:13:03 UTC</td>	
	</tr>
	<tr>
		<td>DATE_RFC2822</td>
		<td>RFC 2822</td>
		<td>Sun, 14 Aug 2005 16:13:03 +0000</td>
	</tr>
	<tr>
		<td>DATE_RSS</td>
		<td>RSS</td>
		<td>Sun, 14 Aug 2005 16:13:03 UTC</td>
	</tr>
	<tr>
		<td>DATE_W3C</td>
		<td>World Wide Web Consortium</td>
		<td>2005-08-14T16:13:03+0000</td>
	</tr>
</table>

<h2>local_to_gmt()</h2>

<p>Takes a Unix timestamp as input and returns it as GMT.  Example:</p>

<code>$now = time();<br />
<br />
$gmt = local_to_gmt($now);</code>


<h2>gmt_to_local()</h2>

<p>Takes a Unix timestamp (referenced to GMT) as input, and converts it to a localized timestamp based on the
timezone and Daylight Saving time submitted.  Example:</p>

<code>
$timestamp = '1140153693';<br />
$timezone  = 'UM8';<br />
$daylight_saving = TRUE;<br />
<br />
echo gmt_to_local($timestamp, $timezone, $daylight_saving);</code>

<p><strong>Note:</strong> For a list of timezones see the reference at the bottom of this page.</p>

<h2>mysql_to_unix()</h2>

<p>Takes a MySQL Timestamp as input and returns it as Unix. Example:</p>

<code>$mysql = '20061124092345';<br />
<br />
$unix = mysql_to_unix($mysql);</code>


<h2>unix_to_human()</h2>

<p>Takes a Unix timestamp as input and returns it in a human readable format with this prototype:</p>

<code>YYYY-MM-DD HH:MM:SS AM/PM</code>

<p>This can be useful if you need to display a date in a form field for submission.</p>

<p>The time can be formatted with or without seconds, and it can be set to European or US format.  If only
the timestamp is submitted it will return the time without seconds formatted for the U.S. Examples:</p>

<code>$now = time();<br />
<br />
echo unix_to_human($now); // U.S. time, no seconds<br />
<br />
echo unix_to_human($now, TRUE, 'us'); // U.S. time with seconds<br />
<br />
echo unix_to_human($now, TRUE, 'eu'); // Euro time with seconds</code>


<h2>human_to_unix()</h2>

<p>The opposite of the above function.  Takes a "human" time as input and returns it as Unix.  This function is
useful if you accept "human" formatted dates submitted via a form.  Returns FALSE (boolean) if
the date string passed to it is not formatted as indicated above.  Example:</p>

<code>$now = time();<br />
<br />
$human = unix_to_human($now);<br />
<br />
$unix = human_to_unix($human);</code>





<h2>timespan()</h2>

<p>Formats a unix timestamp so that is appears similar to this:</p>

<code>1 Year, 10 Months, 2 Weeks, 5 Days, 10 Hours, 16 Minutes</code>

<p>The first parameter must contain a Unix timestamp.  The second parameter must contain a
timestamp that is greater that the first timestamp.  If the second parameter empty, the current time will be used.  The most common purpose
for this function is to show how much time has elapsed from some point in time in the past to now.  Example:</p>

<code>$post_date = '1079621429';<br />
$now = time();<br />
<br />
echo timespan($post_date, $now);</code>

<p class="important"><strong>Note:</strong> The text generated by this function is found in the following language file: language/&lt;your_lang&gt;/date_lang.php</p>


<h2>days_in_month()</h2>

<p>Returns the number of days in a given month/year. Takes leap years into account.  Example:</p>
<code>echo days_in_month(06, 2005);</code>

<p>If the second parameter is empty, the current year will be used.</p>
<h2>timezones()</h2>
<p> Takes a timezone reference (for a list of valid timezones, see the &quot;Timezone Reference&quot; below) and returns the number of hours offset from UTC.</p>
<p><code>echo timezones('UM5');</code></p>
<p>This function is useful when used with timezone_menu(). </p>
<h2>timezone_menu()</h2>
<p>Generates a pull-down menu of timezones, like this one:</p>

<form action="#">
<select name="timezones">
<option value='UM12'>(UTC - 12:00) Enitwetok, Kwajalien</option>
<option value='UM11'>(UTC - 11:00) Nome, Midway Island, Samoa</option>
<option value='UM10'>(UTC - 10:00) Hawaii</option>
<option value='UM9'>(UTC - 9:00) Alaska</option>
<option value='UM8'>(UTC - 8:00) Pacific Time</option>
<option value='UM7'>(UTC - 7:00) Mountain Time</option>
<option value='UM6'>(UTC - 6:00) Central Time, Mexico City</option>
<option value='UM5'>(UTC - 5:00) Eastern Time, Bogota, Lima, Quito</option>
<option value='UM4'>(UTC - 4:00) Atlantic Time, Caracas, La Paz</option>
<option value='UM25'>(UTC - 3:30) Newfoundland</option>
<option value='UM3'>(UTC - 3:00) Brazil, Buenos Aires, Georgetown, Falkland Is.</option>
<option value='UM2'>(UTC - 2:00) Mid-Atlantic, Ascention Is., St Helena</option>
<option value='UM1'>(UTC - 1:00) Azores, Cape Verde Islands</option>
<option value='UTC' selected='selected'>(UTC) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
<option value='UP1'>(UTC + 1:00) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome</option>
<option value='UP2'>(UTC + 2:00) Kaliningrad, South Africa, Warsaw</option>
<option value='UP3'>(UTC + 3:00) Baghdad, Riyadh, Moscow, Nairobi</option>
<option value='UP25'>(UTC + 3:30) Tehran</option>
<option value='UP4'>(UTC + 4:00) Adu Dhabi, Baku, Muscat, Tbilisi</option>
<option value='UP35'>(UTC + 4:30) Kabul</option>
<option value='UP5'>(UTC + 5:00) Islamabad, Karachi, Tashkent</option>
<option value='UP45'>(UTC + 5:30) Bombay, Calcutta, Madras, New Delhi</option>
<option value='UP6'>(UTC + 6:00) Almaty, Colomba, Dhaka</option>
<option value='UP7'>(UTC + 7:00) Bangkok, Hanoi, Jakarta</option>
<option value='UP8'>(UTC + 8:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
<option value='UP9'>(UTC + 9:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
<option value='UP85'>(UTC + 9:30) Adelaide, Darwin</option>
<option value='UP10'>(UTC + 10:00) Melbourne, Papua New Guinea, Sydney, Vladivostok</option>
<option value='UP11'>(UTC + 11:00) Magadan, New Caledonia, Solomon Islands</option>
<option value='UP12'>(UTC + 12:00) Auckland, Wellington, Fiji, Marshall Island</option>
</select>
</form>

<p>This menu is useful if you run a membership site in which your users are allowed to set their local timezone value.</p>

<p>The first parameter lets you set the "selected" state of the menu.  For example, to set Pacific time as the default you will do this:</p>

<code>echo timezone_menu('UM8');</code>

<p>Please see the timezone reference below to see the values of this menu.</p>

<p>The second parameter lets you set a CSS class name for the menu.</p>

<p class="important"><strong>Note:</strong> The text contained in the menu is found in the following language file: language/&lt;your_lang&gt;/date_lang.php</p>



<h2>Timezone Reference</h2>

<p>The following table indicates each timezone and its location.</p>

<table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
<tr>
<th>Time Zone</th>
<th>Location</th>
</tr><tr>

<td class="td">UM12</td><td class="td">(UTC - 12:00) Enitwetok, Kwajalien</td>
</tr><tr>
<td class="td">UM11</td><td class="td">(UTC - 11:00) Nome, Midway Island, Samoa</td>
</tr><tr>
<td class="td">UM10</td><td class="td">(UTC - 10:00) Hawaii</td>
</tr><tr>
<td class="td">UM9</td><td class="td">(UTC - 9:00) Alaska</td>
</tr><tr>
<td class="td">UM8</td><td class="td">(UTC - 8:00) Pacific Time</td>
</tr><tr>
<td class="td">UM7</td><td class="td">(UTC - 7:00) Mountain Time</td>
</tr><tr>
<td class="td">UM6</td><td class="td">(UTC - 6:00) Central Time, Mexico City</td>
</tr><tr>
<td class="td">UM5</td><td class="td">(UTC - 5:00) Eastern Time, Bogota, Lima, Quito</td>
</tr><tr>
<td class="td">UM4</td><td class="td">(UTC - 4:00) Atlantic Time, Caracas, La Paz</td>
</tr><tr>
<td class="td">UM25</td><td class="td">(UTC - 3:30) Newfoundland</td>
</tr><tr>
<td class="td">UM3</td><td class="td">(UTC - 3:00) Brazil, Buenos Aires, Georgetown, Falkland Is.</td>
</tr><tr>
<td class="td">UM2</td><td class="td">(UTC - 2:00) Mid-Atlantic, Ascention Is., St Helena</td>
</tr><tr>
<td class="td">UM1</td><td class="td">(UTC - 1:00) Azores, Cape Verde Islands</td>
</tr><tr>
<td class="td">UTC</td><td class="td">(UTC) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</td>
</tr><tr>
<td class="td">UP1</td><td class="td">(UTC + 1:00) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome</td>
</tr><tr>
<td class="td">UP2</td><td class="td">(UTC + 2:00) Kaliningrad, South Africa, Warsaw</td>
</tr><tr>
<td class="td">UP3</td><td class="td">(UTC + 3:00) Baghdad, Riyadh, Moscow, Nairobi</td>
</tr><tr>
<td class="td">UP25</td><td class="td">(UTC + 3:30) Tehran</td>
</tr><tr>
<td class="td">UP4</td><td class="td">(UTC + 4:00) Adu Dhabi, Baku, Muscat, Tbilisi</td>
</tr><tr>
<td class="td">UP35</td><td class="td">(UTC + 4:30) Kabul</td>
</tr><tr>
<td class="td">UP5</td><td class="td">(UTC + 5:00) Islamabad, Karachi, Tashkent</td>
</tr><tr>
<td class="td">UP45</td><td class="td">(UTC + 5:30) Bombay, Calcutta, Madras, New Delhi</td>
</tr><tr>
<td class="td">UP6</td><td class="td">(UTC + 6:00) Almaty, Colomba, Dhaka</td>
</tr><tr>
<td class="td">UP7</td><td class="td">(UTC + 7:00) Bangkok, Hanoi, Jakarta</td>
</tr><tr>
<td class="td">UP8</td><td class="td">(UTC + 8:00) Beijing, Hong Kong, Perth, Singapore, Taipei</td>
</tr><tr>
<td class="td">UP9</td><td class="td">(UTC + 9:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</td>
</tr><tr>
<td class="td">UP85</td><td class="td">(UTC + 9:30) Adelaide, Darwin</td>
</tr><tr>
<td class="td">UP10</td><td class="td">(UTC + 10:00) Melbourne, Papua New Guinea, Sydney, Vladivostok</td>
</tr><tr>
<td class="td">UP11</td><td class="td">(UTC + 11:00) Magadan, New Caledonia, Solomon Islands</td>
</tr><tr>
<td class="td">UP12</td><td class="td">(UTC + 12:00) Auckland, Wellington, Fiji, Marshall Island</td>
</tr>
</table>


</div>
<!-- END CONTENT -->

<? include_once('../footer.php'); ?>