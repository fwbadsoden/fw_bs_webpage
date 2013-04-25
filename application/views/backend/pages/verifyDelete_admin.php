<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    switch($type) {
        case 'page':    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die <strong>Seite</strong> <strong>"'.$page_title.'"</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden <strong>s&auml;mtliche</strong> f&uuml;r diese Seite angelegten Zeilen mit ihren Inhalten <strong>gel&ouml;scht</strong>!<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um die Seite handelt, welche Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/content/page/delete/'.$id;
                        $redirect   = 'pageliste_redirect';
                        break;
        case 'row':     $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die <strong>Zeile</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden <strong>s&auml;mtliche</strong> f&uuml;r diese Zeile angelegten Inhaltselemente mit ihren Inhalten <strong>gel&ouml;scht</strong>!<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um die Zeile handelt, welche Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/content/page/row/delete/'.$id.'/'.$superID;
                        $redirect   = 'pageedit_redirect';
                        break;
        case 'box':     $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass das <strong>Inhaltselement</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden <strong>s&auml;mtliche</strong> f&uuml;r dieses Element angelegten Inhalte <strong>gel&ouml;scht</strong>!<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um das Inhaltselement handelt, welches Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/content/page/box/delete/'.$id;
                        $redirect   = 'pageedit_redirect';
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