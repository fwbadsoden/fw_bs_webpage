<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    if(strlen($lage) > 65)
        $lage = substr($lage,0,65).' [...]';
?> 
            <div class="listContent">

				<div class="row">
                	<div class="number trenner<?=$special_class?>"><a href="<?=base_url('einsatz/'.$id)?>"><?=$lfd_nr?></a></div>
                	<div class="date trenner<?=$special_class?>"><a href="<?=base_url('einsatz/'.$id)?>"><span class="inline_date"><?=cp_get_ger_date($datum)?></span> <span class="inline_slash">/</span> <span class="inline_time"><?=$beginn?> Uhr</span></a></div>
                	<div class="icon trenner<?=$special_class?>"><a href="<?=base_url('einsatz/'.$id)?>" class="<?=$type_class?>"><?=$type_class?></a></div>
                	<div class="headline<?=$special_class?>"><a href="<?=base_url('einsatz/'.$id)?>"><?=$lage?></a></div>
                    <div class="moreButton<?=$special_class?>"><a href="<?=base_url('einsatz/'.$id)?>" class="button_black">Mehr lesen</a></div>
                    <div class="moreButton_mobile<?=$special_class?>"><a href="<?=base_url('einsatz/'.$id)?>" class="button_blackarrow_mobile">&nbsp;</a></div>
                </div>
                
            </div>
			<hr class="clear" />