<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    switch($type) {
        case 'page':    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die Seite <strong>"'.$title.'"</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden sämtliche für diese Seite angelegten Zeilen mit ihren Inhalten gelöscht!<br>Bitte prüfen Sie sorgfältig, ob es sich genau um die Seite handelt, welche Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/content/page/delete/'.$id;
                        $redirect   = 'pageliste_redirect';
                        break;
        case 'row':     $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die Zeile gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden sämtliche für diese Zeile angelegten Inhaltselemente mit ihren Inhalten gelöscht!<br>Bitte prüfen Sie sorgfältig, ob es sich genau um die Zeile handelt, welche Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/content/page/delrow/'.$id.'/'.$superID;
                        $redirect   = 'pageedit_redirect';
                        break;
        case 'box':     $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass das Inhaltselement gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden sämtliche für dieses Element angelegten Inhalte gelöscht!<br>Bitte prüfen Sie sorgfältig, ob es sich genau um das Inhaltselement handelt, welches Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/content/page/delbox/'.$id;
                        $redirect   = 'pageedit_redirect';
                        break;
    }
?>

<div id='content'>
<div id='page_delete_verify'>

<h1><?=$headline?></h1>
<p><?=$text?></p>
<p>
    <a href='<?=base_url($del_link)?>' target='_top' class="button_gross"><span class="button_delete">L&ouml;schen</span></a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href='<?=$this->session->userdata($redirect)?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a>
</p>

</div>
</div>