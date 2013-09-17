<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) : 
    if($item['class_text'] != '') {
        $class_text = explode('|!!|', $item['class_text']);
        $class_1 = ' class="'.$class_text[0].'"';
        $class_2 = ' class="'.$class_text[1].'"'; 
    } else {
        $class_1 = '';
        $class_2 = '';
    }
?>        
    <div class="<?=$item['class_outer']?>" id="pictures_0" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div id="stagewrapper smallstage">    
            <div class="<?=$item['class_inner']?>">
                <figure><img src="images/icon_einsaetze/<?=$item['class_einsatz']?>.png" /></figure>
                <h1<?=$class_1?>><?=$item['text'][0]?></h1>
                <h2<?=$class_2?>><?=$item['text'][1]?></h2>
            </div>
        </div>
    </div>
<? endforeach; ?>      
</section>