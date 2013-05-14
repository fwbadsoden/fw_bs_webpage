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
    foreach($menue as $item) {
        if($item['special_function'] == '') {
?>        
            <ul>
                <li class="headline"><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<?          if(isset($item['submenue'])) {
                foreach($item['submenue'] as $subitem) {
?>
                <li><a href="<?=$subitem['link']?>" target="<?=$subitem['target']?>"><?=$subitem['name']?></a></li>
<?
                }
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

<script type="text/javascript" charset="utf-8" src="<?=base_url('js/basic-min.js')?>"></script>

</body>