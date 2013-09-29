<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 
            <div class="listContent">

				<div class="row">
                	<div class="number trenner<?=$special_class?>"><a href="<?=base_url('aktuelles/einsatz/'.$id)?>"><?=$lfd_nr?></a></div>
                	<div class="date trenner<?=$special_class?>"><a href="<?=base_url('aktuelles/einsatz/'.$id)?>"><span class="inline_date"><?=cp_get_ger_date($datum_beginn)?></span> <span class="inline_slash">/</span> <span class="inline_time"><?=$uhrzeit_beginn?> Uhr</span></a></div>
                	<div class="icon trenner<?=$special_class?>"><a href="<?=base_url('aktuelles/einsatz/'.$id)?>" class="<?=$type_class?>"><?=$type_class?></a></div>
                	<div class="headline<?=$special_class?>"><a href="<?=base_url('aktuelles/einsatz/'.$id)?>"><?=$name?></a></div>
                    <div class="moreButton<?=$special_class?>"><a href="<?=base_url('aktuelles/einsatz/'.$id)?>" class="button_black">Mehr lesen</a></div>
                    <div class="moreButton_mobile<?=$special_class?>"><a href="<?=base_url('aktuelles/einsatz/'.$id)?>" class="button_blackarrow_mobile">&nbsp;</a></div>
                </div>
                
            </div>
			<hr class="clear" />