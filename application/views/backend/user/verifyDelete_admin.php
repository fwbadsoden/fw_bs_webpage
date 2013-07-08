<?php if (!defined('BASEPATH')) exit('No direct script access allowed');    
    switch($type) {
        case 'user':    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass der <strong>Benutzer</strong> <strong>'.$user->uacc_username.' ('.$user->first_name.' '.$user->last_name.')</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden <strong>s&auml;mtliche</strong> Daten des Benutzers und seine Berechtigungszuordnungen <strong>gel&ouml;scht</strong>!<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um den Benutzer handelt, welchen Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/user/delete/'.$user->uacc_id;
                        $redirect   = 'userliste_redirect';
                        break;
        case 'group':   $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die <strong>Gruppe '.$group->ugrp_name.'</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden <strong>s&auml;mtliche</strong> Benutzerzuordnungen für diese Gruppe <strong>gel&ouml;scht</strong>!<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um die Gruppe handelt, welche Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/user/group/delete/'.$group->ugrp_id;
                        $redirect   = 'groupliste_redirect';
                        break;
        case 'priv':    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
                        $text       = 'Sind Sie sicher, dass die <strong>Berechtigung '.$priv->upriv_name.'</strong> gel&ouml;scht werden soll?<br>Im Falle der L&ouml;schung werden <strong>s&auml;mtliche</strong> Gruppenzuordnungen <strong>gel&ouml;scht</strong> und es kann eventuell auf Funktionalitäten des Systems nicht mehr zugegriffen werden!<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um die Berechtigung handelt, welche Sie l&ouml;schen m&ouml;chten.';
                        $del_link   = 'admin/user/priv/delete/'.$priv->upriv_id;
                        $redirect   = 'privliste_redirect';
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