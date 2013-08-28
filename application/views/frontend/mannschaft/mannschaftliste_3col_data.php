<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $listcount = 1;
    $class = "";
?> 
            <div class="oneColumnBox">
                <ul id="anker_fuehrung" class="TeaserListe">
<? foreach($fuehrung as $f) :
    if($listcount > 3) $listcount = 1;
    switch($listcount)
    {
        case '1': $class = ''; break;
        case '2': $class = ' class="second"'; break;
        case '3': $class = ' class="third"'; break;
    }
    $listcount++;
    if($f->geschlecht == 'm') $dienstgrad_name = $f->dienstgrad_name_m;
    elseif($f->geschlecht == 'w') $dienstgrad_name = $f->dienstgrad_name_w;
    else $dienstgrad_name = $f->dienstgrad_name;
?>
                    <li<?=$class?>>
                        <figure>
                            <img src="<?=base_url(CONTENT_IMG_MANNSCHAFT_UPLOAD_PATH.$f->img)?>" />
                            <img src="<?=base_url(CONTENT_IMG_DIENSTGRAD_UPLOAD_PATH.$f->dienstgrad_img)?>" class="abzeichen" original-title="Dienstgrad" rel="tipsy" />
                        </figure>
                        <h1><?=$f->vorname?> <?=$f->name?></h1>
                        <h2><?=$dienstgrad_name?></h2>
<? if($f->funktion_name != '') : ?>
                        <h2><?=$f->funktion_name?></h2>
<? else : ?>    
                        <h2>&nbsp;</h2>
<? endif; ?>                                                                    
<? if($f->geburtstag != '' and $f->geburtstag != '0000-00-00') : ?>                        
                        <p>/ <?=cp_get_alter($f->geburtstag)?> Jahre 
<? endif; ?>                        
<? if($f->beruf != '') : ?>
<?    if($f->geburtstag != '' and $f->geburtstag != '0000-00-00') : ?>
                        <?=', '.$f->beruf?></p>
<?    else : ?>
                        <p><?=$f->beruf?></p>
<?    endif; ?>
<? else : ?>
<?    if($f->geburtstag != '' and $f->geburtstag != '0000-00-00') : ?>
                        </p>
<?    else : ?>         
                        <p>&nbsp;</p>
<?    endif; ?>
<? endif; ?>                        
<? if($f->familienstand != '') : ?>
                        <p>/  <?=$f->familienstand?></p>
<? else : ?>            
                        <p>&nbsp;</p>                        
<? endif; ?>                        
                    </li>
<? endforeach; 
   $listcount = 1;
?>                    
                </ul>

            <hr class="clear" />
            
            <h1 class="module" id="anker_mannschaft">Mannschaft</h1>
            <div class="oneColumnBox">
                <ul class="TeaserListe">
<? foreach($team as $t) : 
    if($listcount > 3) $listcount = 1;
    switch($listcount)
    {
        case '1': $class = ''; break;
        case '2': $class = ' class="second"'; break;
        case '3': $class = ' class="third"'; break;
    }
    $listcount++;
    if($t->geschlecht == 'm') $dienstgrad_name = $t->dienstgrad_name_m;
    elseif($t->geschlecht == 'w') $dienstgrad_name = $t->dienstgrad_name_w;
    else $dienstgrad_name = $t->dienstgrad_name;
?>
                    <li<?=$class?>>
                        <figure>
                            <img src="<?=base_url(CONTENT_IMG_MANNSCHAFT_UPLOAD_PATH.$t->img)?>" />
                            <img src="<?=base_url(CONTENT_IMG_DIENSTGRAD_UPLOAD_PATH.$t->dienstgrad_img)?>" class="abzeichen" original-title="Dienstgrad" rel="tipsy" />
                        </figure>
                        <h1><?=$t->vorname?> <?=$t->name?></h1>
                        <h2><?=$dienstgrad_name?></h2>
<? if($t->geburtstag != '' and $t->geburtstag != '0000-00-00') : ?>                        
                        <p>/ <?=cp_get_alter($t->geburtstag)?> Jahre 
<? endif; ?>                        
<? if($t->beruf != '') : ?>
<?    if($t->geburtstag != '' and $t->geburtstag != '0000-00-00') : ?>
                        <?=', '.$t->beruf?></p>
<?    else : ?>
                        <p><?=$t->beruf?></p>
<?    endif; ?>
<? else : ?>
<?    if($t->geburtstag != '' and $t->geburtstag != '0000-00-00') : ?>
                        </p>
<?    else : ?>         
                        <p>&nbsp;</p>
<?    endif; ?>
<? endif; ?>              
<? if($t->familienstand != '') : ?>
                        <p>/ <?=$t->familienstand?></p>
<? else : ?>            
                        <p>&nbsp;</p>                        
<? endif; ?>                        
                    </li>
<? endforeach; ?>                    
                </ul>
                <hr class="clear" />
    
            </div>
            <hr class="clear" />
		</div>