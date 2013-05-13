<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
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
<?  foreach($menue as $super_item) { ?> 
            <ul>
                <li class="headline"><a href="<?=$super_item['link']?>" target="<?=$super_item['target']?>"><?=$super_item['name']?></a></li>
<?      foreach($super_item['submenue'] as $item) { ?>
                <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<?      } ?>
            </ul>
<? } ?>
            <hr class="clear" />
        </div>
        
        <div class="smallSitemap">  
<?  foreach($menue as $super_item) { ?> 
            <a href="<?=$super_item['link']?>" target="<?=$super_item['target']?>"><?=$super_item['name']?></a>
<? } ?>
        </div>
        
    </div>
    <div id="copyright">
    	<p><?=FRONTEND_FOOTER?></p>
    </div>

</footer>

<script type="text/javascript" charset="utf-8" src="<?=base_url('js/basic-min.js')?>"></script>

</body>		
</html>