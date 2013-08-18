<?php if (!defined('BASEPATH')) exit('No direct script access allowed');    
    switch($type) {
        case 'news':    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die <strong>News '.$news['title'].'</strong> gel&ouml;scht werden soll?';
                        $del_link   = 'admin/news/delete/'.$news['newsID'];
                        $redirect   = 'userliste_redirect';
                        break;
        case 'category':   $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die <strong>Kategorie '.$category['title'].'</strong> gel&ouml;scht werden soll?';
                        $del_link   = 'admin/news/category/delete/'.$category['categoryID'];
                        $redirect   = 'groupliste_redirect';
                        break;
    }
?>

<div id='content'>
<div id='page_delete_verify'>

<h1><?=$headline?></h1>
<p><?=$text?></p>
<p>
<table>
    <tr>
    <td><a href='<?=base_url($del_link)?>' target='_top' class="button_gross"><span class="button_delete">L&Ouml;SCHEN</span></a></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><a href='<?=$this->session->userdata($redirect)?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a></td>
    </tr>
</table>   
</p>

</div>
</div>