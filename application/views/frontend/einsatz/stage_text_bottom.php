<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) : ?>        
    <div class="pictures" id="pictures_0" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div id="stagewrapper">    
            <div class="<?=$item['class']?>">
                <figure><img src="images/icon_einsaetze/<?=$item['class_einsatz']?>.png" /></figure>
                <h1><?=$item['text'][0]?></h1>
                <h2><?=$item['text'][1]?></h2>
            </div>
        </div>
    </div>
<? endforeach; ?>      
</section>