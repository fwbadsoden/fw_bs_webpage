<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
            
            <h1 class="module" id="anker_mitteilungen">Pressemitteilungen</h1>
            <div class="listContent">
<? foreach($articles as $article) :  
    $date = cp_get_date_as_array($article['datum']);
?>
				<div class="row">
<? if($article['link'] == '') : ?>
                	<a href="<?=base_url($article['fullpath'])?>" download="<?=$article['name']?>">
<? else : ?>
                    <a href="<?=$article['link']?>" target="_blank">
<? endif; ?>
                	<div class="date_small trenner"><span class="inline_date"><?=$date[2]?>. <?=cp_get_month_name($date[1])?> <?=$date[0]?></span></div>
<? if($article['link'] == '') : ?>                    
                 	<div class="size trenner"><p><?=strtoupper($article['extension'])?></p><p class="bytes"><?=$article['size']?> KB</p></div>
<? else : ?>
                    <div class="size trenner"><p>URL&nbsp;&nbsp;</p><p class="bytes"></p></div>
<? endif; ?>                    
	               	<div class="headline smallBoxHead"><span class="medium"><?=$article['source']?></span><br/><?=$article['name']?></div>
                    <div class="moreButton_arrow"></div>
               		</a>
                </div>
<? endforeach; ?>
                <hr class="clear" />
            </div>