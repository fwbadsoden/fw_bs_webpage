<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $count = 0;
?>

        <div class="oneColumnBox">
            <div class="factSheet_einsatzListe">
               <div class="factBox">    
               
<? foreach($types as $type) : ?>
                   <div class="row">
                      <div class="icon <?=$type['class']?>"><a style="width: 36px;">Icon:<?=ucfirst($type['class'])?></a></div> 
                      <div class="label"><?=$type['typePlural']?>:</div>
                      <div class="red">
<? if(isset($statistik[$type['typeShortname']])) : 
                        echo $statistik[$type['typeShortname']];
                        $count = $count + $statistik[$type['typeShortname']];
   else : 
                        echo '0';
   endif;                     ?>
                       </div>
                   </div>
<? endforeach ;               ?>
                   <div class="row">
                      <div class="icon all">Icon:Alle</div> 
                      <div class="label">Insgesamt:</div>
                      <div class="red"><?=$count?></div>
                   </div>
                   <div class="row">
                      <div class="icon city"><a style="width: 36px;">Icon:City</a></div> 
                      <div class="label">Davon überörtliche Einsätze:</div>
                      <div class="red"><?=$statistik['ueberoertlich']?></div>
                   </div>
               </div>
            </div>
        </div>
        <hr class="clear" />