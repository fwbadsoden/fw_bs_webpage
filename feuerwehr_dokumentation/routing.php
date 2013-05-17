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

<h1>URI Routing</h1>

<p>Typically there is a one-to-one relationship between a URL string and its corresponding controller class/method.
The segments in a URI normally follow this pattern:</p>

<code>example.com/<dfn>class</dfn>/<samp>function</samp>/<var>id</var>/</code>

<p>In some instances, however, you may want to remap this relationship so that a different class/function can be called
instead of the one corresponding to the URL.</p>

<p>For example, lets say you want your URLs to have this prototype:</p>

<p>
example.com/product/1/<br />
example.com/product/2/<br />
example.com/product/3/<br />
example.com/product/4/
</p>

<p>Normally the second segment of the URL is reserved for the function name, but in the example above it instead has a product ID.
To overcome this, CodeIgniter allows you to remap the URI handler.</p>


<h2>Setting your own routing rules</h2>

<p>Routing rules are defined in your <var>application/config/routes.php</var> file.  In it you'll see an array called <dfn>$route</dfn> that
permits you to specify your own routing criteria. Routes can either be specified using <dfn>wildcards</dfn> or <dfn>Regular Expressions</dfn></p>


<h2>Wildcards</h2>

<p>A typical wildcard route might look something like this:</p>

<code>$route['product/:num'] = "catalog/product_lookup";</code>

<p>In a route, the array key contains the URI to be matched, while the array value  contains the destination it should be re-routed to.
In the above example, if the literal word "product" is found in the first segment of the URL, and a number is found in the second segment,
the "catalog" class and the "product_lookup" method are instead used.</p>

<p>You can match literal values or you can use two wildcard types:</p>

<p><strong>(:num)</strong> will match a segment containing only numbers.<br />
<strong>(:any)</strong> will match a segment containing any character.
</p>

<p class="important"><strong>Note:</strong> Routes will run in the order they are defined.
Higher routes will always take precedence over lower ones.</p>

<h2>Examples</h2>

<p>Here are a few routing examples:</p>

<code>$route['journals'] = "blogs";</code>
<p>A URL containing the word "journals" in the first segment will be remapped to the "blogs" class.</p>

<code>$route['blog/joe'] = "blogs/users/34";</code>
<p>A URL containing the segments blog/joe will be remapped to the "blogs" class and the "users" method.  The ID will be set to "34".</p>

<code>$route['product/(:any)'] = "catalog/product_lookup";</code>
<p>A URL with "product" as the first segment, and anything in the second will be remapped to the "catalog" class and the  "product_lookup" method.</p>

<code>$route['product/(:num)'] = "catalog/product_lookup_by_id/$1";</code>
<p>A URL with "product" as the first segment, and a number in the second will be remapped to the "catalog" class and the "product_lookup_by_id" method passing in the match as a variable to the function.</p>

<p class="important"><strong>Important:</strong> Do not use leading/trailing slashes.</p>

<h2>Regular Expressions</h2>

<p>If you prefer you can use regular expressions to define your routing rules.  Any valid regular expression is allowed, as are back-references.</p>

<p class="important"><strong>Note:</strong>&nbsp; If you use back-references you must use the dollar syntax rather than the double backslash syntax.</p>

<p>A typical RegEx route might look something like this:</p>

<code>$route['products/([a-z]+)/(\d+)'] = "$1/id_$2";</code>

<p>In the above example, a URI similar to <dfn>products/shirts/123</dfn> would instead call the <dfn>shirts</dfn> controller class and the <dfn>id_123</dfn> function.</p>

<p>You can also mix and match wildcards with regular expressions.</p>

<h2>Reserved Routes</h2>

<p>There are two reserved routes:</p>

<code>$route['default_controller'] = 'welcome';</code>

<p>This route indicates which controller class should be loaded if the URI contains no data, which will be the case
when people load your root URL. In the above example, the "welcome" class would be loaded.  You
are encouraged to always have a default route otherwise a 404 page will appear by default.</p>

<code>$route['404_override'] = '';</code>

<p>This route indicates which controller class should be loaded if the requested controller is not found. It will override the default 404
error page. It won't affect to the <samp>show_404()</samp> function, which will continue loading the default <dfn>error_404.php</dfn> file at <var>application/errors/error_404.php</var>.</p>

<p class="important"><strong>Important:</strong>&nbsp; The reserved routes must come before any wildcard or regular expression routes.</p>

</div>
<!-- END CONTENT -->

<? include_once('footer.php'); ?>