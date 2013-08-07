<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) : ?>        
    <div class="pictures" id="pictures_0" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div id="stagewrapper">    
            <div class="<?=$item['class']?>">
                <figure><img src="images/icon_einsaetze/<?=$stage_text['class']?>.png" /></figure>
                <h1><?=$stage_text['einsatz']?></h1>
                <h2><?=$stage_text['type']?></h2>
            </div>
        </div>
    </div>
<? endforeach; ?>      
</section>

 