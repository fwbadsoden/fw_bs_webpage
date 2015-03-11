<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $this->load->helper('form');
    
    $search_form = array(
        'id'    => 'search',
        'name'  => 'search'
    );   
    $search_input = array(
        'id'    => 'search_query',
        'name'  => 'search_query',
        'class' => 'searchtext'
    );
    $meta = array(
        array('name' => 'keywords', 'content' => META_KEYWORDS),
        array('name' => 'description', 'content' => META_DESCRIPTION),
        array('name' => 'page-topic', 'content' => META_PAGE_TOPIC),
        array('name' => 'revisit-after', 'content' => META_REVISIT_AFTER),
        array('name' => 'language', 'content' => META_LANGUAGE),
        array('name' => 'copyright', 'content' => META_COPYRIGHT),
        array('name' => 'author', 'content' => META_AUTHOR),
        array('name' => 'publisher', 'content' => META_PUBLISHER),
        array('name' => 'audience', 'content' => META_AUDIENCE),
        array('name' => 'expires', 'content' => META_EXPIRES),
        array('name' => 'page-type', 'content' => META_PAGE_TYPE),
        array('name' => 'robots', 'content' => META_ROBOTS),
        array('name' => 'rating', 'content' => META_RATING),
        array('name' => 'Content-type', 'content' => META_EQUIV_CONTENT_TYPE, 'type' => 'equiv'),
        array('name' => 'viewport', 'content' => META_VIEWPORT),
        array('name' => 'X-UA-Compatible', 'content' => META_X_UA_COMPATIBLE),
        array('name' => 'imagetoolbar', 'content' => META_EQUIV_IMAGE_TOOLBAR, 'type' => 'equiv')
    );
    
    // Open Graph Tags
    if($facebook_infos != null) {
        foreach($facebook_infos as $info) {
            array_push($meta, array('name' => $info["property"], 'content' => $info["content"], 'type' => 'property'));
        }
    }
    echo doctype('html5');
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-de" lang="de-de">
<head>
<title><?=FRONTEND_TITLE?></title>
<?
    echo meta($meta);
?>	
<link rel="shortcut icon" href="<?=base_url('images/favicon.ico')?>" type="image/x-icon" />

<link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?=base_url('css/frontend/styles.css')?>" type="text/css" />
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<!-- socialshareprivacy -->
<script type="text/javascript" src="<?=base_url('js/socialshareprivacy/jquery.socialshareprivacy.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('js/socialshareprivacy/jquery.socialshareprivacy.min.de.js')?>"></script>

<script type="text/javascript">
$(document).ready(function () {    
    if($('#share').length > 0) {
        $('#share').socialSharePrivacy({
            
            "path_prefix"       : "<?=base_url('js/socialshareprivacy');?>/",
            "info_link_target"  : "_blank",
            "uri"               : "https://www.facebook.com/feuerwehr.badsoden",
            "services" : {
                "facebook"      : {
                    "dummy_line_img"    : "images/de/dummy_facebook.png",
                    "dummy_box_img"     : "images/de/dummy_box_facebook.png"
                },
                "buffer"        : {"status":false },
                "delicious"     : {"status":false },
                "disqus"        : {"status":false },
                "fbshare"       : {"status":false },
                "flattr"        : {"status":false },
                "gplus"         : {"status":false },
                "hackernews"    : {"status":false},
                "linkedin"      :{"status":false},
                "mail"          :{"status":false},
                "pinterest"     :{"status":false},
                "reddit"        :{"status":false},
                "stumbleupon"   :{"status":false},
                "tumblr"        :{"status":false},
                "twitter"       :{"status":false},
                "xing"          :{"status":false}
            },
            "css_path"  : "socialshareprivacy.css",
            "language"  : "de"
            
        });
    }
});    
</script>
<!-- socialshareprivacy END -->

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
                    <li><a href="https://portal-fwbs.de/" target="_blank">Infoportal</a></li>
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
<? if(current_url() == base_url('aktuelles/news')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('aktuelles/news')?>"<?=$class?>>News</a></li>
<? foreach($news as $n) : ?>  
<? if(strlen($n->title) > 32) $n->title = substr($n->title,0,32).'...'; ?>              
<? if(current_url() == base_url('aktuelles/news/'.$n->id)) : $class = ' class="active"'; else : $class = ''; endif; ?>                
                        	<li><a href="<?=base_url('aktuelles/news/'.$n->id)?>"<?=$class?>><span class="subline"><?=cp_get_ger_date($n->valid_from)?></span><br /><?=$n->title?></a></li>
<? endforeach; ?>                            
                    	</ul>                    
                    	<ul>
<? if(current_url() == base_url('aktuelles/einsaetze')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('aktuelles/einsaetze')?>"<?=$class?>>Einsätze</a></li>
<? foreach($einsaetze['einsaetze'] as $e) : ?> 
<? if(strlen($e->name) > 32) $e->name = substr($e->name,0,32).'...'; ?>             
<? if(current_url() == base_url('aktuelles/einsatz/'.$e->id)) : $class = ' class="active"'; else : $class = ''; endif; ?>                
                        	<li><a href="<?=base_url('aktuelles/einsatz/'.$e->id)?>"<?=$class?>><span class="subline"><?=cp_get_ger_date($e->datum_beginn)?> / <?=$e->type_name?></span><br /><?=$e->name?></a></li>
<? endforeach; ?>                            
                    	</ul>  
                    	<ul>
<? if(current_url() == base_url('aktuelles/termine')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('aktuelles/termine')?>"<?=$class?>>Termine</a></li>
<? foreach($termine as $t) : ?>                           
<? if(strlen($t['name']) > 32) $t['name'] = substr($t['name'],0,32).'...'; ?>         
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
                        	<li class="headline"><a href="<?=base_url('menschen/jugend')?>"<?=$class?>>Nachwuchs</a></li>
<? if(strpos(current_url(), 'menschen/jugend' !== false)) : $class = ' class="active"'; else : $class = ''; endif; ?>                             
                        	<li><a href="<?=base_url('menschen/jugend')?>"<?=$class?>>Jugendfeuerwehr</a></li>
<? if(strpos(current_url(), 'menschen/minifeuerwehr' !== false)) : $class = ' class="active"'; else : $class = ''; endif; ?>                             
                            <li><a href="<?=base_url('menschen/minifeuerwehr')?>"<?=$class?>>Minifeuerwehr</a></li>
                    	</ul>   
                    	<ul>
<? if(strpos(current_url(), base_url('menschen/leistungsgruppe')) !== false) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
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
<?  $counter = 0;
    foreach($fahrzeuge as $f) : 
        if($f['retired'] == 0) : 
            if($counter == 9) :
                $counter = 0; ?>
                        </ul><ul>                                  
                        	<li class="headline"><a href="<?=base_url('technik/fahrzeuge')?>"<?=$class?>>&nbsp;</a></li>
<?          endif; ?>            
<? if(current_url() == base_url('technik/fahrzeug/'.$f['fahrzeugID'])) : $class = ' class="active"'; else : $class = ''; endif; ?>     
                        	<li><a href="<?=base_url('technik/fahrzeug/'.$f['fahrzeugID'])?>"<?=$class?>>
                            <? if($f['fahrzeugNameLang'] != '') : echo $f['fahrzeugName'].' - '.$f['fahrzeugNameLang']; else : echo $f['fahrzeugName']; endif; ?>
                            </a></li>  
<?          $counter++;
        endif;
    endforeach; ?>
                    	</ul>  
   	                    <ul>
<? if(current_url() == base_url('technik/fahrzeuge/ausserdienst')) : $class = ' class="active"'; else : $class = ''; endif; ?>                         
                        	<li class="headline"><a href="<?=base_url('technik/fahrzeuge/ausserdienst')?>"<?=$class?>>Fahrzeuge a.D.</a></li>
<?  if($hasRetiredFahrzeuge) :
        foreach($fahrzeugeAusserDienst as $f) : ?>                        
<? if(current_url() == base_url('technik/fahrzeug/'.$f['fahrzeugID'])) : $class = ' class="active"'; else : $class = ''; endif; ?>     
                        	<li><a href="<?=base_url('technik/fahrzeug/'.$f['fahrzeugID'])?>"<?=$class?>>
                            <? if($f['fahrzeugNameLang'] != '') : echo $f['fahrzeugName'].' - '.$f['fahrzeugNameLang']; else : echo $f['fahrzeugName']; endif; ?>
                            </a></li>  
<?      endforeach; 
    endif; ?>
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
                                <li><a class="fancybox-metaLayer" href="#notruflayer_js" >Notruf richtig absetzen</a></li>
    <? if(current_url() == base_url('informationen/buergerinformationen/rauchmelder')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                                <li><a href="<?=base_url('informationen/buergerinformationen/rauchmelder')?>"<?=$class?>>Rauchwarnmelder</a></li>
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
<? if(current_url() == base_url('verein')) : $class = ' class="active"'; else : $class = ''; endif; ?>  
                <li><a href="<?=base_url('verein')?>"<?=$class?>>Verein</a>  
                </li> 
<!--                <li><a href="#" class="desktopsearch">&nbsp;</a>
                    <div class="dropdown">
                        <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                        <div class="search">	
                            <?=form_input($search_input);?>
                        </div>
                        <input type="submit" value="Suchen &raquo;" class="searchbutton" />
                        </form>
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
              <li><a href="<?=base_url('aktuelles/news')?>">News</a></li>
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
              <li><a href="<?=base_url('menschen/minifeuerwehr')?>">Minifeuerwehr</a></li>
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
      <li><a href="<?=base_url('verein')?>">Verein</a></li>
      <li class="subnavi">    
          <ul>  
            <li><a href="<?=base_url('verein')?>" class="first">Verein</a></li>
          </ul>
      </li>
      <li class="metanav">
      	<ul>
          <li><a href="<?=base_url('admin')?>" target="_blank">Login</a></li>
          <li><a href="https://portal-fwbs.de/" target="_blank">Infoportal</a></li>
          <li><a href="<?=base_url('kontakt')?>">Kontakt</a></li>               
   	      <li><a href="<?=base_url('links')?>">Links</a></li>
          <li><a class="fancybox-metaLayer" href="#notruflayerjs">Notfall</a></li>
        </ul>
      </li>
   </ul>
</div>