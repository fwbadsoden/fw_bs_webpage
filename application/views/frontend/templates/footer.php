<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <hr class="clear" />   
    </div>

</section>


<footer id="endOfPage">

	<div id="shortlinks">
    	<h1><?=$title?></h1>
        <ul>
<?  foreach($menue_shortlink as $key => $item) { 
        if($key == 0) echo '<li class="first">'; else echo '<li>';    
?>
        <a href="<?=base_url($item['link'])?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<? } ?>
        </ul>
        <hr class="clear" />
    </div>
    <div id="sitemap">
        
        <div class="completeSitemap">    
<? 
    foreach($menue as $item) { ?>        
            <ul>
                <li class="headline"><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<?          if(isset($item['submenue'])) {
                foreach($item['submenue'] as $subitem) {
?>
                <li><a href="<?=$subitem['link']?>" target="<?=$subitem['target']?>"><?=$subitem['name']?></a></li>
<?
                }
            }
?>
            </ul>
<? } ?>
            <hr class="clear" />
        </div>

        <div class="smallSitemap">  
<?  foreach($menue as $item) { ?> 
            <a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a>
<? } ?>
        </div>
        
    </div>
    <div id="copyright">
    	<p><?=FRONTEND_FOOTER?></p>
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
			<li>/ <span class="hightlight">Wie</span> viele personen sind betroffen?</li>
			<li>/ <span class="hightlight">Welche</span> Art der Erkrankung oder Verletzung liegt vor?</li>
			<li>/ <span class="hightlight">Warten</span> auf Rückfragen.</li>
		</ul>
	</div>
	<hr class="clear" />
		<div class="greybox">
			<p class="number">Giftnotruf <span>+49 6131-19240</span></p>
			<p class="button"><a href="#" class="button_red">Alle Rufnummern <span class="zusatz">auf einen Blick</span> &raquo;</a></p>
			<hr class="clear" />
		</div>
	</div>
</div>

    <script type="text/javascript" charset="utf-8" src="<?=base_url('js/basic-min.js')?>"></script>
    <script type="text/javascript" charset="utf-8" src="<?=base_url('js/doubletabtogo.js')?>"></script>

	<script type="text/javascript" src="<?=base_url('js/jquery.mousewheel-3.0.6.pack.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('js/fancyBox/jquery.fancybox.js?v=2.1.5')?>"></script>
    
    <link rel="stylesheet" type="text/css" href=<?=base_url('js/fancyBox/jquery.fancybox.css?v=2.1.5')?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=base_url('js/fancyBox/helpers/jquery.fancybox-buttons.css?v=1.0.5')?>" />
	
	<script type="text/javascript" src="<?=base_url('js/fancyBox/helpers/jquery.fancybox-buttons.js?v=1.0.5')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('js/fancyBox/helpers/jquery.fancybox-thumbs.css?v=1.0.7')?>" />
	
	<script type="text/javascript" src="<?=base_url('js/fancyBox/helpers/jquery.fancybox-thumbs.js?v=1.0.7')?>"></script>
	<script type="text/javascript" src="<?=base_url('js/fancyBox/helpers/jquery.fancybox-media.js?v=1.0.6')?>"></script>

    <script>$( function() { $( '#menu li:has(div)' ).doubleTapToGo(); });</script>
 

</body>