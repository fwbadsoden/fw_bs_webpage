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

<? if(ENVIRONMENT == 'production') : ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44450948-1', 'feuerwehr-bs.de');
  ga('send', 'pageview');

</script>
<? endif; ?>

<header>
	<div class="site" id="top">
    	<h1>
        	<a href="<?=base_url('')?>" title="Home">Freiwillige Feuerwehr Bad Soden am Taunus</a>
        </h1>
        <nav>    
            <div id="metanavigation"> 
                <ul>
                    <li class="first"><a href="<?=base_url('admin')?>" target='_blank'>Login</a></li>
<? if(current_url() == base_url('kontakt')) : $class = ' class="active"'; else : $class = ''; endif; ?>   
                    <li><a href="<?=base_url('kontakt')?>"<?=$class?> target="_top">Kontakt</a></li>
<? if(current_url() == base_url('links')) : $class = ' class="active"'; else : $class = ''; endif; ?>                     
        	        <li><a href="<?=base_url('links')?>">Links</a></li>
                    <li><a class="fancybox-metaLayer" href="#notruflayer_js" >Notfall</a></li>
                </ul>
            </div>
            <ul id="menu">  
<? if(strpos(current_url(), base_url('aktuelles')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>             
                <li><a href="<?=base_url('aktuelles')?>"<?=$class?>>News</a>  
                   <div class="dropdown">  
                    	<ul>
<? if(current_url() == base_url('aktuelles/einsaetze')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('aktuelles/einsaetze')?>"<?=$class?>>Einsätze</a></li>
<? foreach($einsaetze['einsaetze'] as $e) : ?>             
<? if(current_url() == base_url('aktuelles/einsatz/'.$e->id)) : $class = ' class="active"'; else : $class = ''; endif; ?>                
                        	<li><a href="<?=base_url('aktuelles/einsatz/'.$e->id)?>"<?=$class?>><span class="subline"><?=cp_get_ger_date($e->datum_beginn)?> / <?=$e->type_name?></span><br /><?=$e->name?></a></li>
<? endforeach; ?>                            
                    	</ul>  
                    	<ul>
<? if(current_url() == base_url('aktuelles/termine')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('aktuelles/termine')?>"<?=$class?>>Termine</a></li>
<? foreach($termine as $t) : ?>                               
                        	<li><a><span class="subline"><?=cp_get_ger_date($t['datum'])?> / <?=$t['beginn']?> Uhr</span><br /><?=$t['name']?></a></li>
<? endforeach; ?>  
                    	</ul>  
                    	<ul>
<? if(current_url() == base_url('aktuelles/presse')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('aktuelles/presse')?>"<?=$class?>>Presse</a></li>
<? foreach($articles as $a) : ?>    
<? if(strlen($a['name']) > 32) $a['name'] = substr($a['name'],0,32).'...'; ?>                        
<? if($a['link'] == '') : ?>
                	       <li><a href="<?=base_url($a['fullpath'])?>" class="fancybox-gallery" rel="gallery_presse_menue"><span class="subline"><?=cp_get_ger_date($a['datum'])?> / <?=$a['source']?></span><br /><?=$a['name']?></a></li>
<? else : ?>
                           <li><a href="<?=$a['link']?>" target="_blank"><span class="subline"><?=cp_get_ger_date($a['datum'])?> / <?=$a['source']?></span><br /><?=$a['name']?></a></li>
<? endif; ?>
<? endforeach; ?>
                       	</ul>  
                   </div>  
                </li>  
<? if(strpos(current_url(), base_url('menschen/mannschaft')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>                 
                <li><a href="<?=base_url('menschen/mannschaft')?>"<?=$class?>>Menschen</a>  
                    <div class="dropdown">  
                    	<ul>                      
                        	<li class="headline"><a href="<?=base_url('menschen/mannschaft')?>"<?=$class?>>Mannschaft</a></li>
                        	<li><a href="<?=base_url('menschen/mannschaft#anker_fuehrung')?>">Führung</a></li>
                            <li><a href="<?=base_url('menschen/mannschaft#anker_mannschaft')?>">Mannschaft</a></li>
                    	</ul>  
                    	<ul>
<? if(strpos(current_url(), base_url('menschen/rettungshunde')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('menschen/rettungshunde')?>"<?=$class?>>Rettungshunde</a></li>
                        	<li><a href="<?=base_url('menschen/rettungshunde#anker_einleitung')?>">Einleitung</a></li>
                            <li><a href="<?=base_url('menschen/rettungshunde#anker_ausbildung')?>">Ablauf der Ausbildung</a></li>
                    	</ul> 
                    	<ul>
<? if(current_url() == base_url('menschen/jugend')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('menschen/jugend')?>"<?=$class?>>Jugendfeuerwehr</a></li>
<? if(current_url() == base_url('menschen/jugend/aktivitaeten')) : $class = ' class="active"'; else : $class = ''; endif; ?>                             
                        	<li><a href="<?=base_url('menschen/jugend/aktivitaeten')?>"<?=$class?>>Aktivitäten</a></li>
<? if(current_url() == base_url('menschen/jugend/ausbildung')) : $class = ' class="active"'; else : $class = ''; endif; ?>                             
                            <li><a href="<?=base_url('menschen/jugend/ausbildung')?>"<?=$class?>>Ausbildung</a></li>
                    	</ul>   
                    	<ul>
<? if(strpos(current_url(), base_url('menschen/jugend')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('menschen/leistungsgruppe')?>"<?=$class?>>Leistungsgruppe</a></li>
                        	<li><a href="<?=base_url('menschen/leistungsgruppe#anker_theorie')?>">Theorie</a></li>
                            <li><a href="<?=base_url('menschen/leistungsgruppe#anker_praxis')?>">Praxis</a></li>
                    	</ul>  
                    </div>  
				</li>  
<? if(strpos(current_url(), base_url('technik')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>                 
                <li><a href="<?=base_url('technik')?>"<?=$class?>>Technik</a>  
                    <div class="dropdown">  
                    	<ul>
<? if(current_url() == base_url('technik/fahrzeuge')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('technik/fahrzeuge')?>"<?=$class?>>Fahrzeuge</a></li>
<?  $i = 0; $count = count($fahrzeuge);
    foreach($fahrzeuge as $f) : ?>                        
<? if(current_url() == base_url('technik/fahrzeug/'.$f['fahrzeugID'])) : $class = ' class="active"'; else : $class = ''; endif; ?>     
                        	<li><a href="<?=base_url('technik/fahrzeug/'.$f['fahrzeugID'])?>"<?=$class?>>
                            <? if($f['fahrzeugNameLang'] != '') : echo $f['fahrzeugName'].' - '.$f['fahrzeugNameLang']; else : echo $f['fahrzeugName']; endif; ?>
                            </a></li>
    <? if ($i == 3) { $i = 0; echo "</ul><ul><li class='headline'><a href='".base_url('technik/fahrzeuge')."'>&nbsp;</a></li>"; } else $i++; ?>    
<? endforeach; ?>
                    	</ul>  
                    </div>  
                </li>  
<? if(strpos(current_url(), base_url('informationen')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>                 
                <li><a href="<?=base_url('informationen')?>"<?=$class?>>Infos</a>  
                    <div class="dropdown">  
                    	<ul>
<? if(current_url() == base_url('informationen/buergerinformationen')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('informationen/buergerinformationen')?>"<?=$class?>>B&uuml;rgerinfos</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/blaulicht')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                            	<li><a href="<?=base_url('informationen/buergerinformationen/blaulicht')?>"<?=$class?>>Blaulicht und Martinshorn</a></li>
    <? if(current_url() == base_url('informationen/buergerinformationen/nachdembrand')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                                <li><a href="<?=base_url('informationen/buergerinformationen/nachdembrand')?>"<?=$class?>>Nach dem Brand</a></li>
    <? if(current_url() == base_url('informationen/buergerinformationen/hausnummern')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                                <li><a href="<?=base_url('informationen/buergerinformationen/hausnummern')?>"<?=$class?>>Sichtbare Hausnummern</a></li>
                    	</ul>   
                        <ul>
<? if(current_url() == base_url('informationen/einsatzgebiet')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li class="headline"><a href="<?=base_url('informationen/einsatzgebiet')?>"<?=$class?>>Einsatzgebiet</a></li>
                            <li><a href="<?=base_url('informationen/einsatzgebiet#anker_allgemein')?>">Allgemein</a></li>
                            <li><a href="<?=base_url('informationen/einsatzgebiet#anker_schwerpunkte')?>">Schwerpunkte</a></li>
                        </ul>
                        <ul>
<? if(current_url() == base_url('informationen/aufgaben')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li class="headline"><a href="<?=base_url('informationen/aufgaben')?>"<?=$class?>>Aufgaben & Gesetze</a></li>
                            <li><a href="<?=base_url('informationen/aufgaben#anker_aufgaben')?>">Aufgaben</a></li>
                            <li><a href="<?=base_url('informationen/aufgaben#anker_gesetze')?>">Gesetze</a></li>                            
                        </ul>
                        <ul>
<? if(current_url() == base_url('informationen/aao')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li class="headline"><a href="<?=base_url('informationen/aao')?>"<?=$class?>>Alarm- und Ausrückeordnung</a></li>
                            <li><a href="<?=base_url('informationen/aao#anker_oertlich')?>">Örtlich</a></li>
                            <li><a href="<?=base_url('informationen/aao#anker_uoertlich')?>">Überörtlich</a></li>                        
                        </ul>
                    </div>  
                </li>
<!--
<? if(current_url() == base_url('informationen')) : $class = ' class="active"'; else : $class = ''; endif; ?>                 
                <li><a href="<?=base_url('informationen')?>"<?=$class?>>Infos</a>  
                    <div class="dropdown">  
                    	<ul>
<? if(current_url() == base_url('informationen/buergerinformationen')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('informationen/buergerinformationen')?>"<?=$class?>>B&uuml;rgerinfos</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/blaulicht')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li><a href="<?=base_url('informationen/buergerinformationen/blaulicht')?>"<?=$class?>>Blaulicht und Martinshorn</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/sonderrechte')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                            <li><a href="<?=base_url('informationen/buergerinformationen/sonderrechte')?>"<?=$class?>>Sonderrechte</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/notfaelle')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                            <li><a href="<?=base_url('informationen/buergerinformationen/notfaelle')?>"<?=$class?>>Tipps bei Notfällen</a></li>
                    	</ul> 
                    	<ul>
                        	<li class="headline"><a href="<?=base_url('informationen/buergerinformationen')?>">&nbsp;</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/unwetter')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                            <li><a href="<?=base_url('informationen/buergerinformationen/unwetter')?>"<?=$class?>>Hinweise zu Unwettern</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/nachdembrand')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                            <li><a href="<?=base_url('informationen/buergerinformationen/nachdembrand')?>"<?=$class?>>Nach dem Brand</a></li>
<? if(current_url() == base_url('informationen/buergerinformationen/hausnummern')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                            <li><a href="<?=base_url('informationen/buergerinformationen/hausnummern')?>"<?=$class?>>Sichtbare Hausnummern</a></li>
                    	</ul>   
                    	<ul class="special">
<? if(current_url() == base_url('informationen/einsatzgebiet')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li class="headline"><a href="<?=base_url('informationen/einsatzgebiet')?>"<?=$class?>>Einsatzgebiet</a></li>
<? if(current_url() == base_url('informationen/aufgaben')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li class="headline"><a href="<?=base_url('informationen/aufgaben')?>"<?=$class?>>Aufgaben, Gesetze & Richtlinien</a></li>
<? if(current_url() == base_url('informationen/aao')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                        	<li class="headline"><a href="<?=base_url('informationen/aao')?>"<?=$class?>>Alarm- und Ausrückeordnung</a></li>
                    	</ul>  
                    </div>  
                </li>  -->
<? if(current_url() == base_url('verein')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                <li><a href="<?=base_url('verein')?>"<?=$class?>>Verein</a>  
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
      <li><a href="<?=base_url('aktuelles')?>">News</a></li>
      <li class="subnavi">    
          <ul> 
              <li><a href="<?=base_url('aktuelles/einsaetze')?>">Einsätze</a></li>
              <li><a href="<?=base_url('aktuelles/termine')?>">Termine</a></li>
              <li><a href="<?=base_url('aktuelles/presse')?>">Presse</a></li>
            </ul>
      </li>
      <li><a href="<?=base_url('menschen')?>">Menschen</a></li>
      <li class="subnavi">    
          <ul> 
              <li><a href="<?=base_url('menschen/mannschaft')?>">Mannschaft</a></li>
              <li><a href="<?=base_url('menschen/rettungshunde')?>">Rettungshunde</a></li>
              <li><a href="<?=base_url('menschen/jugend')?>">Jugendfeuerwehr</a></li>
              <li><a href="<?=base_url('menschen/leistungsgruppe')?>">Leistungsgruppe</a></li>
          </ul>
      </li>
      <li><a href="<?=base_url('technik')?>">Technik</a></li>
      <li class="subnavi">    
          <ul>  
            <li><a href="<?=base_url('technik/fahrzeuge')?>" class="first">Fahrzeuge</a></li>
          </ul>
      </li>
      <li><a href="<?=base_url('informationen')?>">Infos</a></li>
      <li class="subnavi">    
          <ul>  
                <li><a href="<?=base_url('informationen/buergerinformationen')?>">Bürgerinfos</a></li>
                <li><a href="<?=base_url('informationen/einsatzgebiet')?>"<?=$class?>>Einsatzgebiet</a></li>
               	<li><a href="<?=base_url('informationen/aufgaben')?>"<?=$class?>>Aufgaben & Gesetze</a></li>
               	<li><a href="<?=base_url('informationen/aao')?>"<?=$class?>>Alarm- und Ausrückeordnung</a></li>
          </ul>
      </li>
      <li class="metanav">
      	<ul>
          <li><a href="<?=base_url('admin')?>" target="_blank">Login</a></li>
          <li><a href="<?=base_url('kontakt')?>">Kontakt</a></li>
          <li><a class="fancybox-metaLayer" href="#notruflayerjs">Notfall</a></li>
        </ul>
      </li>
   </ul>
</div>