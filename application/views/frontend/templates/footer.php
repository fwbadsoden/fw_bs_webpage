<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <hr class="clear" />   
    </div>

</section>


<footer id="endOfPage">

	<div id="shortlinks">
    	<h1>Freiwillige Feuerwehr Bad Soden am Taunus</h1>
        <ul>
        	<li class="first"><a href="<?=base_url('kontakt')?>">Kontakt</a></li>
        	<!--<li><a href="<?=base_url('mitmachen')?>">Mitmachen</a></li>-->
        	<li><a href="<?=base_url('links')?>">Links</a></li>
        	<li><a href="<?=base_url('impressum')?>">Impressum</a></li>            
        </ul>
    </div>
    <div id="share"></div>
    <div id="sitemap">
        
        <div class="completeSitemap"> 
        <div class="sitemapBox">   
            <ul>
                <li class="headline"><a href="<?=base_url('aktuelles/news')?>">News</a></li>
                <li><a href="<?=base_url('aktuelles/einsaetze')?>">Einsätze</a></li>
                <li><a href="<?=base_url('aktuelles/termine')?>">Termine</a></li>
                <li><a href="<?=base_url('aktuelles/presse')?>">Presse</a></li>
            </ul>
            <ul>
                <li class="headline"><a href="<?=base_url('menschen')?>">Menschen</a></li>
                <li><a href="<?=base_url('menschen/mannschaft')?>">Mannschaft</a></li>
                <li><a href="<?=base_url('menschen/altersundehrenabteilung')?>">Alters- und Ehrenabteilung</a></li>
                <li><a href="<?=base_url('menschen/jugend')?>">Jugendfeuerwehr</a></li>
                <li><a href="<?=base_url('menschen/minifeuerwehr')?>">Minifeuerwehr</a></li>
                <li><a href="<?=base_url('menschen/leistungsgruppe')?>">Leistungsgruppe</a></li>
            </ul>
            <ul>
                <li class="headline"><a href="<?=base_url('technik')?>">Technik</a></li>
                <li><a href="<?=base_url('technik/fahrzeuge')?>">Fahrzeuge</a></li>
                <li><a href="<?=base_url('technik/fahrzeuge/ausserdienst')?>">Fahrzeuge a. D.</a></li>
                <li><a href="<?=base_url('technik/rettungshunde')?>">Rettungshundeeinheit</a></li>
            </ul>
            <ul>
                <li class="headline"><a href="<?=base_url('informationen')?>">Infos</a></li>
                <li><a href="<?=base_url('informationen/buergerinformationen')?>">Bürgerinfos</a></li>
                <li><a href="<?=base_url('informationen/einsatzgebiet')?>">Einsatzgebiet</a></li>
                <li><a href="<?=base_url('informationen/aufgaben')?>"<?=$class?>>Aufgaben &amp; Gesetze</a></li>
                <li><a href="<?=base_url('informationen/aao')?>">Alarm- und Ausrückeordnung</a></li>
            </ul>
            <ul>
                <li class="headline"><a href="<?=base_url('verein')?>">Verein</a></li>
            </ul>
        </div>
        </div>

        <div class="smallSitemap">    
            <a href="<?=base_url('aktuelles/news')?>">News</a>
            <a href="<?=base_url('aktuelles/einsaetze')?>">Einsätze</a>
            <a href="<?=base_url('menschen/mannschaft')?>">Mannschaft</a>
            <a href="<?=base_url('technik/fahrzeuge')?>">Fahrzeuge</a>
            <a href="<?=base_url('informationen/buergerinformationen')?>">Bürgerinfos</a>
        </div>
        
    </div>
    <div id="copyright">
    	<p>&copy;<?php echo date("Y"); ?> Freiwillige Feuerwehr Bad Soden am Taunus 1868 e.V. / Hunsrückstraße 5-7 / 65812 Bad Soden am Taunus</p>
    </div>

</footer>

<div id="notruflayer_js" class="notruf_layer">
	<div class="tele">
		<h3>Notrufnummern</h3>
		<div class="box boxtrenner">
			<p class="number">112</p>
			<p>Feuerwehr</p>
			<p>Rettungsdienst</p>
		</div>
		<div class="box">
			<p class="number">110</p>
			<p>Polizei</p>
		</div>
	</div>
	<div class="faq">
		<h3>Notruf richtig absetzen</h3>
		<ul>
			<li>/ <span class="hightlight">Wo</span> ist es passiert?</li>
			<li>/ <span class="hightlight">Was</span> ist passiert?</li>
			<li>/ <span class="hightlight">Wie</span> viele Personen sind betroffen?</li>
			<li>/ <span class="hightlight">Welche</span> Art der Erkrankung oder Verletzung liegt vor?</li>
			<li>/ <span class="hightlight">Warten</span> auf Rückfragen.</li>
		</ul>
	</div>
	<hr class="clear" />
		<div class="greybox">
			<p class="number">Zentrale Leitstelle <span>+49 6192-5095</span></p>
			<p class="button"><a href="<?=URL_NOTRUFFAX?>" class="button_black_gross" target="_blank">Notruffax &raquo;</a></p>
			<hr class="clear" />
		</div>
	</div>
</div>

    <script type="text/javascript" charset="utf-8" src="<?=base_url('js/basic-min.js')?>"></script>
    <script type="text/javascript" charset="utf-8" src="<?=base_url('js/doubletaptogo.js')?>"></script>

	<script type="text/javascript" src="<?=base_url('js/jquery.mousewheel-3.0.6.pack.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('js/fancyBox/jquery.fancybox.js?v=2.1.5')?>"></script>
    
    <link rel="stylesheet" type="text/css" href=<?=base_url('js/fancyBox/jquery.fancybox.css?v=2.1.5')?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=base_url('js/fancyBox/helpers/jquery.fancybox-buttons.css?v=1.0.5')?>" />
	
	<script type="text/javascript" src="<?=base_url('js/fancyBox/helpers/jquery.fancybox-buttons.js?v=1.0.5')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('js/fancyBox/helpers/jquery.fancybox-thumbs.css?v=1.0.7')?>" />
	
	<script type="text/javascript" src="<?=base_url('js/fancyBox/helpers/jquery.fancybox-thumbs.js?v=1.0.7')?>"></script>
	<script type="text/javascript" src="<?=base_url('js/fancyBox/helpers/jquery.fancybox-media.js?v=1.0.6')?>"></script>    
 
    <script type="text/javascript">
        $( function() { $( '#menu li:has(div)' ).doubleTapToGo(); });      
      </script>
</body>
