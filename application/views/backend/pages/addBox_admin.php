<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
 ?>
 
 <div id='content'>
<div id='add_box'>
    <table>
        <tr>
            <td><a href='<?=$this->session->userdata('pageedit_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a></td>
        </tr>
    </table>
    <h1>Inhaltselement auswählen</h1>
    <table>
<? foreach($boxes as $box) { ?>
        <tr>
            <td><?=$box['boxName']?></td><td><a href='<?=$this->session->userdata('pageaddbox_submit')?>/<?=$box['boxID']?>/save'><img src='<?=base_url('/images/admin/pages/'.$box['boxImg'])?>'></a></td>     
        </tr>
<? } ?>       
    </table>
</div>

<div style="clear:both;"></div>
</div>