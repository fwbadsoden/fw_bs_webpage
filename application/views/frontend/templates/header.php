<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $this->load->helper('form');
    
    $search_form = array(
        'id'    => 'search',
        'name'  => 'search'
    );   
    $search_input = array(
        'id'    => 'searchitem',
        'name'  => 'searchitem',
        'class' => 'searchtext'
    );
    $meta = array(
        array('name' => 'keywords', 'content' => 'feuerwehr-bs.de, Feuerwehr, Freiwillige Feuerwehr, Bad Soden'),
        array('name' => 'description', 'content' => 'Alle Infos rund um die freiwillige Feuerwehr der Stadt Bad Soden am Taunus'),
        array('name' => 'page-topic', 'content' => 'feuerwehr-bs.de - Freiwillige Feuerwehr der Stadt Bad Soden am Taunus'),
        array('name' => 'revisit-after', 'content' => '1 days'),
        array('name' => 'language', 'content' => 'de'),
        array('name' => 'copyright', 'content' => 'feuerwehr-bs.de'),
        array('name' => 'author', 'content' => 'info[at]feuerwehr-bs.de'),
        array('name' => 'publisher', 'content' => 'Freiwillige Feuerwehr Bad Soden am Taunus'),
        array('name' => 'audience', 'content' => 'Alle'),
        array('name' => 'expires', 'content' => 'never'),
        array('name' => 'page-type', 'content' => 'Portal'),
        array('name' => 'robots', 'content' => 'INDEX,FOLLOW'),
        array('name' => 'rating', 'content' => 'General'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
        array('name' => 'viewport', 'content' => 'width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;'),
        array('name' => 'X-UA-Compatible', 'content' => 'edge'),
        array('name' => 'imagetoolbar', 'content' => 'no', 'type' => 'equiv')
    );
    echo doctype('html5');
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-de" lang="de-de">
<head>
<title><?=$title?></title>
<?=meta($meta)?>	
<link rel="shortcut icon" href="<?=base_url('images/favicon.ico')?>" type="image/x-icon" />
<link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?=base_url('css/frontend/styles.css')?>" type="text/css" />

<!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="<?=base_url('js/respond.js')?>"></script>
<![endif]-->
     <!--[if IE 7]>
    	<link rel="stylesheet" type="text/css" href="<?=base_url('css/frontend/styles_ie7.css')?>"/>
     <![endif]-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>



<header>
	<div class="site">
    	<h1>
        	<a href="/" title="Home">Freiwillige Feuerwehr Bad Soden am Taunus</a>
        </h1>
        <nav>    
            <div id="metanavigation"> 
                <ul>
                    <li class="first"><a href="mitmachen" target="_top">Mitmachen</a></li>
                    <li><a href="kontakt" target="_top">Kontakt</a></li>
                    <li><a href="notruf" target="_top">Notruf</a></li> 
                </ul>
            </div>
            <ul id="menu">  
                <li><a href="news">News</a>  
                   <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="#">Eins&auml;tze</a></li>
<? foreach($einsaetze['einsaetze'] as $e) : ?>                            
                        	<li><a href="einsatz/<?=$e->id?>"><span class="subline"><?=cp_get_ger_date($e->datum_beginn)?> / <?=$e->type_name?></span><br /><?=$e->name?></a></li>
<? endforeach; ?>                            
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="termine">Termine</a></li>
<? foreach($termine as $t) : ?>                               
                        	<li><a href="termin/<?=$t['terminID']?>"><span class="subline"><?=cp_get_ger_date($t['datum'])?> / <?=$t['beginn']?> Uhr</span><br /><?=$t['name']?></a></li>
<? endforeach; ?>  
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="presse">Presse</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / H&ouml;chsterkreisblatt</span><br />Lorem ipsum dolor</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Taunuszeitung</span><br />Lorem ipsum dolor</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Bad Sodener Echo</span><br />Lorem ipsum dolor</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / H&ouml;chsterkreisblatt</span><br />Lorem ipsum dolor</a></li>
                    	</ul>  
              <!--      	<ul class="special navTeaser">
                        	<li class="headline"><a href="#"><img src="images/navTeaser_tagderoffnentuer.png" /></a></li>
                    	</ul>  -->
                   </div>  
                </li>  
                <li><a href="menschen">Menschen</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="menschen">Mannschaft</a></li>
                        	<li><a href="menschen/fuehrung">Führung</a></li>
                            <li><a href="menschen/mannschaft">Mannschaft</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="wache">Die Wache</a></li>
                            <li><a href="wache/geraetehaus">Ger&auml;tehaus</a></li>
                            <li><a href="wache/florianstube">Florianstube</a></li>
                            <li><a href="wache/fahrzeughalle">Fahrzeughalle</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="galerie">Galerie</a></li>
                            <li><a href="galerie/einsaetze">Einsätze</a></li>
                            <li><a href="galerie/feiern">Feiern</a></li>
                            <li><a href="galerie/fotoshooting">Fotoshooting</a></li>
                            <li><a href="galerie/wache">Unsere Wache</a></li>
                    	</ul>  
                    	<ul class="special">
                            <li class="headline"><a href="leistungsgruppe">Leistungsgruppe</a></li>
                            <li class="headline"><a href="altersundehrenabteilung">Alters- und Ehrenabteilung</a></li>
                            <li class="headline"><a href="verein">Verein</a></li>
                            <li class="headline"><a href="geschichte">Geschichte</a></li>
                    	</ul>  
                    </div>  
				</li>  
                <li><a href="technik">Technik</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="fahrzeuge">Fahrzeuge</a></li>
<? foreach($fahrzeuge as $f) : ?>                            
                        	<li><a href="fahrzeug/<?=$f['fahrzeugID']?>">
                            <? if($f['fahrzeugNameLang'] != '') : echo $f['fahrzeugName'].' - '.$f['fahrzeugNameLang']; else : echo $f['fahrzeugName']; endif; ?>
                            </a></li>
<? endforeach; ?>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="ausruestung">Ausr&uuml;stung</a></li>
                        	<li><a href="#">Rettungssatz</a></li>
                            <li><a href="#">Halligan-Tool</a></li>
                            <li><a href="#">Wasserwerfer</a></li>
                            <li><a href="#">Bel&uuml;ftungsger&auml;te</a></li>
                            <li><a href="#">Tauchpumpe</a></li>
                            <li><a href="#">Atemschutz</a></li>
                            <li><a href="#">Stromerzeuger</a></li>
                            <li><a href="#">Mobiler Rauchverschluss</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="kleidung">Kleidung</a></li>
                        	<li><a href="#">Pers&ouml;nliche Ausr&uuml;stung</a></li>
                            <li><a href="#">Funktionswesten</a></li>
                            <li><a href="#">Ausgehuniform</a></li>
                            <li><a href="#">Spezialausr&uuml;stung</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="ausbildung">Ausbildung</a></li>
                        	<li><a href="#">Erstausbildung</a></li>
                            <li><a href="#">Truppmannausbildung</a></li>
                            <li><a href="#">Atemschutz</a></li>
                            <li><a href="#">Technische Hilfeleistung</a></li>
                            <li><a href="#">Maschinist</a></li>
                            <li><a href="#">Gefahrgut</a></li>
                    	</ul>  
                    </div>  
                </li>  
                <li><a href="infos">Infos</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="infos/brandschutz">Brandschutztipps</a></li>
                        	<li><a href="infos/erstehilfe">Erste Hilfe</a></li>
                            <li><a href="infos/notruf">Notruf Absetzen</a></li>
                            <li><a href="infos/rauchmelder">Rauchmelder</a></li>
                            <li><a href="infos/unfaelle">Verhalten bei Unf&auml;llen</a></li>
                            <li><a href="infos/feuer">Verhalten bei Brandf&auml;llen</a></li>
                            <li><a href="infos/feuerloescher">Feuerl&ouml;scher</a></li>
                            <li><a href="infos/kuechenbrand">K&uuml;chenbrand</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="buergerinfos">B&uuml;rgerinfos</a></li>
                        	<li><a href="buergerinfos/blaulicht">Blaulicht und Martinshorn</a></li>
                            <li><a href="buergerinfos/sonderrechte">Sonderrechte</a></li>
                            <li><a href="buergerinfos/insekten">Insekten</a></li>
                            <li><a href="buergerinfos/unwetter">Hinweise zu Unwettern</a></li>
                            <li><a href="buergerinfos/brand">Nach dem Brand</a></li>
                            <li><a href="buergerinfos/hausnummern">Sichtbare Hausnummern</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="artikel">Artikel</a></li>
                        	<li><a href="#">Feuerwehraustausch</a></li>
                            <li><a href="#">Tag der offnen T&uuml;r 2013</a></li>
                            <li><a href="#">Atemschutztraining</a></li>
                            <li><a href="#">Turnierbericht</a></li>
                    	</ul>  
                    	<ul class="special">
                        	<li class="headline"><a href="einsatzgebiet">Einsatzgebiet</a></li>
                        	<li class="headline"><a href="gesetze">Gesetze & Richtlinien</a></li>
                            <li class="headline"><a href="downloads">Downloads</a></li>
                            <li class="headline"><a href="faq">H&auml;ufige Fragen</a></li>
                    	</ul>  
                    </div>  
                </li>  
                <li><a href="jugend">Jugend</a>  
                </li> 
                <li><a href="#" class="desktopsearch">&nbsp;</a>
                    <div class="dropdown">
                        <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                        <div class="search">	
                            <?=form_input($search_input);?>
                        </div>
                        <input type="button" value="Suchen &raquo;" class="searchbutton" />
                    </div>
                </li>
            </ul>
       	</nav>
        
        <div id="mobileHeader">
           	<a href="#"><img src="<?=base_url('images/layout/nav_mobileButton.png')?>" width="18" height="18" id="mobileNavButton" /></a>
        </div>

    </div>
    
</header>

<div id="mobileNavigation">    
   <ul class="mobileMainNavContainer">
      <li><a href="news">News</a></li>
      <li><a href="menschen">Menschen</a></li>
      <li><a href="technik">Technik</a></li>
      <li class="subnavi">    
          <ul>  
            <li><a href="fahrzeuge" class="first">Fahrzeuge</a></li>
            <li><a href="geraete">Geräte</a></li>
            <li><a href="kleidung">Kleidung</a></li>
            <li><a href="ausbildung">Ausbildung</a></li>
          </ul>
      </li>
      <li><a href="infos">Infos</a></li>
      <li><a href="jugend">Jugend</a></li>
      <li class="metanav">
      	<ul>
          <li><a href="admin">Login</a></li>
          <li><a href="mitmachen">Mitmachen</a></li>
          <li><a href="kontakt">Kontakt</a></li>
          <li><a href="notfall">Notfall</a></li>
        </ul>
      </li>
      <li class="search">
      	<form>
        	<input type="text" name="searchitem" class="text" />
           <input type="button" value="Go" class="button_black" />
        </form>
      </li>
   </ul>
</div>