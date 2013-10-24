<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 
            <div class="listContent">

				<div class="row">
                	<!--<div class="number trenner"><a href="<?=base_url('aktuelles/news/'.$id)?>"><?=$id?></a></div>-->
                	<div class="date trenner"><a href="<?=base_url('aktuelles/news/'.$id)?>"><span class="inline_date"><?=cp_get_ger_date($valid_from)?></span></a></div>
                <!--	<div class="icon trenner"><a href="<?=base_url('aktuelles/news/'.$id)?>" class="<?=$type_class?>"><?=$type_class?></a></div>-->
                	<div class="headline"><a href="<?=base_url('aktuelles/news/'.$id)?>"><?=$title?></a><br /><?=$teaser?></div>
                    <div class="moreButton"><a href="<?=base_url('aktuelles/news/'.$id)?>" class="button_black">Mehr lesen</a></div>
                    <div class="moreButton_mobile"><a href="<?=base_url('aktuelles/news/'.$id)?>" class="button_blackarrow_mobile">&nbsp;</a></div>
                </div>
            </div>
			<hr class="clear" />