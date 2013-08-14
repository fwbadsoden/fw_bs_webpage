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
          <?  foreach($menue_meta as $key => $item) {     
            if($key == 0) echo '<li class="first">'; else echo '<li>';    
            echo'<a href="'.$item['link'].'" target="'.$item['target'].'">'.$item['name'].'</a></li>';
        } ?>
                </ul>
            </div>
            <ul id="menu">  
                <li><a href="#">News</a>  
                   <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="#">Eins&auml;tze</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / &Uuml;ber&ouml;rtlicher Einsatz</span><br />Ausl&ouml;sung der Brandmeldeanlage</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Brandeinsatz</span><br />Brand einer Lagerhalle</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Hilfeleistungseinsatz</span><br />Autounfall A66</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Fehlalarm</span><br />Ausl&ouml;sung der Brandmeldeanlage</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Hilfeleistungseinsatz</span><br />T&uuml;r&ouml;ffnung für den Rettungsdienst</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Termine</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / 20:00 Uhr</span><br />Feuerwehr Stammtisch</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / ab 11:00 Uhr</span><br />Tag der offnen T&uuml;r</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Presse</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / H&ouml;chsterkreisblatt</span><br />Lorem ipsum dolor</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Taunuszeitung</span><br />Lorem ipsum dolor</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / Bad Sodener Echo</span><br />Lorem ipsum dolor</a></li>
                        	<li><a href="#"><span class="subline">22.07.2013 / H&ouml;chsterkreisblatt</span><br />Lorem ipsum dolor</a></li>
                    	</ul>  
                    	<ul class="special navTeaser">
                        	<li class="headline"><a href="#"><img src="images/navTeaser_tagderoffnentuer.png" /></a></li>
                    	</ul>  
                   </div>  
                </li>  
                <li><a href="#">Menschen</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="#">Mannschaft</a></li>
                        	<li><a href="#">Leitung</a></li>
                            <li><a href="#">Gruppenführer</a></li>
                            <li><a href="#">Mannschaft</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Die Wache</a></li>
                            <li><a href="#">Ger&auml;tehaus</a></li>
                            <li><a href="#">Aufentahltsraum</a></li>
                            <li><a href="#">Fahrzeugraum</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Galerie</a></li>
                            <li><a href="#">Einsätze</a></li>
                            <li><a href="#">Feiern</a></li>
                            <li><a href="#">Fotoshooting</a></li>
                            <li><a href="#">Unsere Wache</a></li>
                    	</ul>  
                    	<ul class="special">
                            <li class="headline"><a href="#">Leistungsgruppe</a></li>
                            <li class="headline"><a href="#">Alters- und Ehrenabteilung</a></li>
                            <li class="headline"><a href="#">Verein</a></li>
                            <li class="headline"><a href="#">Geschichte</a></li>
                    	</ul>  
                    </div>  
				</li>  
                <li><a href="#">Technik</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="#">Fahrzeuge</a></li>
                        	<li><a href="#">KodW - Kommandowagen</a></li>
                            <li><a href="#">ELF - Einsatzleitwagen</a></li>
                            <li><a href="#">MTF - Mannschafttransportfahrzeug</a></li>
                            <li><a href="#">TLF 24/50 - Tankl&ouml;schfahrzeug</a></li>
                            <li><a href="#">DLK 23/12- Drehleiterfahrzeug</a></li>
                            <li><a href="#">LF 16/1 - L&ouml;schfahrzeug</a></li>
                            <li><a href="#">LF 16/2 - L&ouml;schfahrzeug</a></li>
                            <li><a href="#">LF 16/3 - L&ouml;schfahrzeug</a></li>
                            <li><a href="#">RW- R&uuml;stfahrzeug</a></li>
                            <li><a href="#">GW-L - Ger&auml;tewagen Logistik</a></li>
                            <li><a href="#">WLF - Wechselladerfahrzeug</a></li>
                            <li><a href="#">Rettungshundeanh&auml;nger</a></li>
                            <li><a href="#">Notdienst-PKW</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Ausr&uuml;stung</a></li>
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
                        	<li class="headline"><a href="#">Kleidung</a></li>
                        	<li><a href="#">Pers&ouml;nliche Ausr&uuml;stung</a></li>
                            <li><a href="#">Funktionswesten</a></li>
                            <li><a href="#">Ausgehuniform</a></li>
                            <li><a href="#">Spezialausr&uuml;stung</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Ausbildung</a></li>
                        	<li><a href="#">Erstausbildung</a></li>
                            <li><a href="#">Truppmannausbildung</a></li>
                            <li><a href="#">Atemschutz</a></li>
                            <li><a href="#">Atemschutz f&uuml;r Tunnel</a></li>
                            <li><a href="#">Maschinist</a></li>
                            <li><a href="#">H&ouml;henrettung</a></li>
                            <li><a href="#">Gefahrengut</a></li>
                    	</ul>  
                    </div>  
                </li>  
                <li><a href="#">Infos</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="#">Brandschutztipps</a></li>
                        	<li><a href="#">Erste Hilfe</a></li>
                            <li><a href="#">Notruf Absetzen</a></li>
                            <li><a href="#">Rauchmelder</a></li>
                            <li><a href="#">Verhalten bei Unf&auml;llen</a></li>
                            <li><a href="#">Verhalten bei Brandf&auml;llen</a></li>
                            <li><a href="#">Feuerl&ouml;scher</a></li>
                            <li><a href="#">K&uuml;chenbrand</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">B&uuml;rgerinfos</a></li>
                        	<li><a href="#">Blaulicht und Martinshorn</a></li>
                            <li><a href="#">Sonderrechte</a></li>
                            <li><a href="#">Insekten</a></li>
                            <li><a href="#">Vogelgrippe</a></li>
                            <li><a href="#">Hinweise zu Unwettern</a></li>
                            <li><a href="#">Nach dem Brand</a></li>
                            <li><a href="#">Sichtbare Hausnummern</a></li>
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="#">Artikel</a></li>
                        	<li><a href="#">Feuerwehraustausch</a></li>
                            <li><a href="#">Tag der offnen T&uuml;r 2013</a></li>
                            <li><a href="#">Atemschutztraining</a></li>
                            <li><a href="#">Turnierbericht</a></li>
                    	</ul>  
                    	<ul class="special">
                        	<li class="headline"><a href="#">Einsatzgebiet</a></li>
                        	<li class="headline"><a href="#">Gesetze & Richtlinien</a></li>
                            <li class="headline"><a href="#">Downloads</a></li>
                            <li class="headline"><a href="#">H&auml;ufige Fragen</a></li>
                    	</ul>  
                    </div>  
                </li>  
                <li><a href="#">Jugend</a>  
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


<header id="top">
	<div class="site">
    	<h1>
        	<a href="/" title="Home"><?=$title?></a>
        </h1>
        <div class="navBox">  
            <div class="metanavigation"> 
                <ul>
     <?  foreach($menue_meta as $key => $item) {     
            if($key == 0) echo '<li class="first">'; else echo '<li>';    
            echo'<a href="'.$item['link'].'" target="'.$item['target'].'">'.$item['name'].'</a></li>';
        } ?>
                </ul>
            </div>
            <nav> 
                <ul>
<?  foreach($menue as $item) { ?>            
                    <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<? } ?> 
                    <li><a href="#" class="desktopsearch">Suche</a></li>
                </ul>
                <div id="searchBox">
                    <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                        <?=form_input($search_input);?>
                        <input type="submit" value="Go" class="button_black" />
                        <a href="#" class="closeSearch">x</a>
                    </form>
            		
                </div>
            </nav>
            <div class="mobileHeader">
            	<a href="#"><img src="<?=base_url('images/layout/nav_mobileButton.png')?>" width="18" height="18" id="mobileNavButton" /></a>
            </div>
        </div>
    </div>
</header>

<div id="mobileNavigation">    
   <ul class="mobileMainNavContainer">
<?  foreach($menue as $item) { ?>            
        <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<?  } ?> 
        <li class="metanav">
          	<ul>
     <?  foreach($menue_meta as $key => $item) { ?>  
                <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
     <?  } ?>            
            </ul>
        </li>
        <li class="search">
            <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                <?=form_input($search_input);?>
                <input type="button" value="Go" class="button_black" />
            </form>
        </li>
   </ul>
</div>