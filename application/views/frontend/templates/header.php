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

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>
<body>



<header>
	<div class="site">
    	<h1>
        	<a href="<?=base_url('')?>" title="Home">Freiwillige Feuerwehr Bad Soden am Taunus</a>
        </h1>
        <nav>    
            <div id="metanavigation"> 
                <ul>
                    <li class="first"><a href="<?=base_url('admin')?>" target='_blank'>Login</a></li>
                    <li><a href="<?=base_url('kontakt')?>" target="_top">Kontakt</a></li>
                    <li><a href="<?=base_url('mitmachen')?>" target="_top">Mitmachen</a></li>
                    <li><a class="fancybox-metaLayer" href="#notruflayer_js" >Notfall</a></li>
                </ul>
            </div>
            <ul id="menu">  
                <li><a href="news">News</a>  
                   <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('einsaetze')?>">Einsätze</a></li>
<? foreach($einsaetze['einsaetze'] as $e) : ?>                            
                        	<li><a href="<?=base_url('einsatz/'.$e->id)?>"><span class="subline"><?=cp_get_ger_date($e->datum_beginn)?> / <?=$e->type_name?></span><br /><?=$e->name?></a></li>
<? endforeach; ?>                            
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('termine')?>">Termine</a></li>
<? foreach($termine as $t) : ?>                               
                        	<li><a href=""<?=base_url('termin/'.$t['terminID'])?>"><span class="subline"><?=cp_get_ger_date($t['datum'])?> / <?=$t['beginn']?> Uhr</span><br /><?=$t['name']?></a></li>
<? endforeach; ?>  
                    	</ul>  
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('presse')?>">Presse</a></li>
<? foreach($articles as $a) : ?>                            
<? if($a['link'] == '') : ?>
                	       <li><a href="<?=base_url($a['fullpath'])?>" download="<?=$a['name']?>"><span class="subline"><?=cp_get_ger_date($a['datum'])?> / <?=$a['source']?></span><br /><?=$a['name']?></a></li>
<? else : ?>
                           <li><a href="<?=$a['link']?>" target="_blank"><span class="subline"><?=cp_get_ger_date($a['datum'])?> / <?=$a['source']?></span><br /><?=$a['name']?></a></li>
<? endif; ?>
<? endforeach; ?>
                       	</ul>  
              <!--      	<ul class="special navTeaser">
                        	<li class="headline"><a href="<?=base_url('')?>"><img src="images/navTeaser_tagderoffnentuer.png" /></a></li>
                    	</ul>  -->
                   </div>  
                </li>  
                <li><a href="<?=base_url('mannschaft')?>">Menschen</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('mannschaft')?>">Mannschaft</a></li>
                        	<li><a href="<?=base_url('mannschaft#anker_fuehrung')?>">Führung</a></li>
                            <li><a href="<?=base_url('mannschaft#anker_mannschaft')?>">Mannschaft</a></li>
                    	</ul>  
                    	<!--<ul>
                        	<li class="headline"><a href="<?=base_url('wache')?>">Die Wache</a></li>
                            <li><a href="<?=base_url('wache/geraetehaus')?>">Ger&auml;tehaus</a></li>
                            <li><a href="<?=base_url('wache/florianstube')?>">Florianstube</a></li>
                            <li><a href="<?=base_url('wache/fahrzeughalle')?>">Fahrzeughalle</a></li>
                    	</ul>  -->
                    	<!--<ul>
                        	<li class="headline"><a href="<?=base_url('galerie')?>">Galerie</a></li>
                            <li><a href="<?=base_url('galerie/einsaetze')?>">Einsätze</a></li>
                            <li><a href="<?=base_url('galerie/feiern')?>">Feiern</a></li>
                            <li><a href="<?=base_url('galerie/fotoshooting')?>">Fotoshooting</a></li>
                            <li><a href="<?=base_url('galerie/wache')?>">Unsere Wache</a></li>
                    	</ul> -->
                    	<ul class="special">
                            <li class="headline"><a href="<?=base_url('leistungsgruppe')?>">Leistungsgruppe</a></li>
							<li class="headline"><a href="<?=base_url('rettungshunde')?>">Rettungshundeeinheit</a></li>
                            <!--<li class="headline"><a href="<?=base_url('altersundehrenabteilung')?>">Alters- und Ehrenabteilung</a></li>-->
                            <li class="headline"><a href="<?=base_url('verein')?>">Verein</a></li>
                            <li class="headline"><a href="<?=base_url('geschichte')?>">Geschichte</a></li>
                    	</ul>  
                    </div>  
				</li>  
                <li><a href="<?=base_url('technik')?>">Technik</a>  
                    <div class="dropdown">  
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('fahrzeuge')?>">Fahrzeuge</a></li>
<?  $i = 0; $count = count($fahrzeuge);
    foreach($fahrzeuge as $f) : ?>                        
                        	<li><a href="<?=base_url('fahrzeug/'.$f['fahrzeugID'])?>">
                            <? if($f['fahrzeugNameLang'] != '') : echo $f['fahrzeugName'].' - '.$f['fahrzeugNameLang']; else : echo $f['fahrzeugName']; endif; ?>
                            </a></li>
    <? if ($i == 3) { $i = 0; echo "</ul><ul><li class='headline'><a href='".base_url('fahrzeuge')."'>&nbsp;</a></li>"; } else $i++; ?>    
<? endforeach; ?>
                    	</ul>  
                    <!--	<ul>
                        	<li class="headline"><a href="<?=base_url('ausruestung')?>">Ausr&uuml;stung</a></li>
                        	<li><a href="<?=base_url('')?>">Rettungssatz</a></li>
                            <li><a href="<?=base_url('')?>">Halligan-Tool</a></li>
                            <li><a href="<?=base_url('')?>">Wasserwerfer</a></li>
                            <li><a href="<?=base_url('')?>">Bel&uuml;ftungsger&auml;te</a></li>
                            <li><a href="<?=base_url('')?>">Tauchpumpe</a></li>
                            <li><a href="<?=base_url('')?>">Atemschutz</a></li>
                            <li><a href="<?=base_url('')?>">Stromerzeuger</a></li>
                            <li><a href="<?=base_url('')?>">Mobiler Rauchverschluss</a></li>
                    	</ul>  -->
                    <!--	<ul>
                        	<li class="headline"><a href="<?=base_url('kleidung')?>">Kleidung</a></li>
                        	<li><a href="<?=base_url('')?>">Pers&ouml;nliche Ausr&uuml;stung</a></li>
                            <li><a href="<?=base_url('')?>">Funktionswesten</a></li>
                            <li><a href="<?=base_url('')?>">Ausgehuniform</a></li>
                            <li><a href="<?=base_url('')?>">Spezialausr&uuml;stung</a></li>
                    	</ul>  -->
                    <!--	<ul>
                        	<li class="headline"><a href="<?=base_url('ausbildung')?>">Ausbildung</a></li>
                        	<li><a href="<?=base_url('')?>">Erstausbildung</a></li>
                            <li><a href="<?=base_url('')?>">Truppmannausbildung</a></li>
                            <li><a href="<?=base_url('')?>">Atemschutz</a></li>
                            <li><a href="<?=base_url('')?>">Technische Hilfeleistung</a></li>
                            <li><a href="<?=base_url('')?>">Maschinist</a></li>
                            <li><a href="<?=base_url('')?>">Gefahrgut</a></li>
                    	</ul>  -->
                    </div>  
                </li>  
                <li><a href="<?=base_url('informationen')?>">Infos</a>  
                    <div class="dropdown">  
                    	<!--<ul>
                        	<li class="headline"><a href="<?=base_url('informationen/brandschutz')?>">Brandschutztipps</a></li>
                        	<li><a href="<?=base_url('informationen/erstehilfe')?>">Erste Hilfe</a></li>
                            <li><a href="<?=base_url('informationen/notruf')?>">Notruf Absetzen</a></li>
                            <li><a href="<?=base_url('informationen/rauchmelder')?>">Rauchmelder</a></li>
                            <li><a href="<?=base_url('informationen/unfaelle')?>">Verhalten bei Unf&auml;llen</a></li>
                            <li><a href="<?=base_url('informationen/feuer')?>">Verhalten bei Brandf&auml;llen</a></li>
                            <li><a href="<?=base_url('informationen/feuerloescher')?>">Feuerl&ouml;scher</a></li>
                            <li><a href="<?=base_url('informationen/kuechenbrand')?>">K&uuml;chenbrand</a></li>
                    	</ul>  -->
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('buergerinformationen')?>">B&uuml;rgerinfos</a></li>
                        	<li><a href="<?=base_url('buergerinformationen/blaulicht')?>">Blaulicht und Martinshorn</a></li>
                            <li><a href="<?=base_url('buergerinformationen/sonderrechte')?>">Sonderrechte</a></li>
                            <li><a href="<?=base_url('buergerinformationen/insekten')?>">Insekten</a></li>
                            <li><a href="<?=base_url('buergerinformationen/unwetter')?>">Hinweise zu Unwettern</a></li>
                            <li><a href="<?=base_url('buergerinformationen/brand')?>">Nach dem Brand</a></li>
                            <li><a href="<?=base_url('buergerinformationen/hausnummern')?>">Sichtbare Hausnummern</a></li>
                    	</ul>  
                    	<!--<ul>
                        	<li class="headline"><a href="<?=base_url('artikel')?>">Artikel</a></li>
                        	<li><a href="<?=base_url('#')?>">Feuerwehraustausch</a></li>
                            <li><a href="<?=base_url('#')?>">Tag der offnen T&uuml;r 2013</a></li>
                            <li><a href="<?=base_url('#')?>">Atemschutztraining</a></li>
                    	</ul>  -->
                    	<ul class="special">
                        	<li class="headline"><a href="<?=base_url('einsatzgebiet')?>">Einsatzgebiet</a></li>
                        	<li class="headline"><a href="<?=base_url('gesetze')?>">Gesetze & Richtlinien</a></li>
                            <!--<li class="headline"><a href="<?=base_url('downloads')?>">Downloads</a></li>-->
                            <!--<li class="headline"><a href="<?=base_url('faq')?>">H&auml;ufige Fragen</a></li>-->
                    	</ul>  
                    </div>  
                </li>  
                <li><a href="<?=base_url('jugend')?>">Jugend</a>  
                </li> 
           <!--     <li><a href="#" class="desktopsearch">&nbsp;</a>
                    <div class="dropdown">
                        <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                        <div class="search">	
                            <?=form_input($search_input);?>
                        </div>
                        <input type="button" value="Suchen &raquo;" class="searchbutton" />
                    </div>
                </li>-->
            </ul>
       	</nav>
        
        <div id="mobileHeader">
           	<a href="#"><img src="<?=base_url('images/layout/nav_mobileButton.png')?>" width="18" height="18" id="mobileNavButton" /></a>
        </div>

    </div>
    
</header>

<div id="mobileNavigation">    
   <ul class="mobileMainNavContainer">
      <li><a href="<?=base_url('news')?>">News</a></li>
      <li><a href="<?=base_url('einsaetze')?>">Einsätze</a></li>
      <li><a href="<?=base_url('menschen')?>">Menschen</a></li>
      <li><a href="<?=base_url('technik')?>">Technik</a></li>
      <li class="subnavi">    
          <ul>  
            <li><a href="<?=base_url('fahrzeuge')?>" class="first">Fahrzeuge</a></li>
      <!--      <li><a href="<?=base_url('geraete')?>">Geräte</a></li> --> 
      <!--      <li><a href="<?=base_url('kleidung')?>">Kleidung</a></li> -->
      <!--      <li><a href="<?=base_url('ausbildung')?>">Ausbildung</a></li> -->
          </ul>
      </li>
      <li><a href="<?=base_url('infos')?>">Infos</a></li>
      <li><a href="<?=base_url('jugend')?>">Jugend</a></li>
      <li class="metanav">
      	<ul>
          <li><a href="<?=base_url('admin')?>" target="_blank">Login</a></li>
          <li><a href="<?=base_url('kontakt')?>">Kontakt</a></li>
          <li><a href="<?=base_url('mitmachen')?>" target="_top">Mitmachen</a></li>
          <li><a class="fancybox-metaLayer" href="#notruflayerjs">Notfall</a></li>
        </ul>
      </li>
 <!--     <li class="search">
      	<form>
        	<input type="text" name="searchitem" class="text" />
           <input type="button" value="Go" class="button_black" />
        </form>
      </li>-->
   </ul>
</div>