<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>
<? if($teaser_image_fullpath != '') { ?>
<figure>
    <img src="<?=base_url($teaser_image_fullpath)?>" title="<?=$title?>" />
</figure>
<? } ?>
<h1><?=$title?></h1>
<p><?=$teaser?></p>
<? if($text != '') : ?>
<p class="more"><a href="<?=base_url('/aktuelles/news/'.$newsID)?>" class="button_black">Mehr lesen</a></p>
<? endif; ?>