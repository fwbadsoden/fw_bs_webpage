<?php if (!defined('BASEPATH')) exit('No direct script access allowed');    
    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
	$text       = 'Sind Sie sicher, dass das <strong>Einsatzstichwort</strong> <strong>'.$cue->name .'</strong> gel&ouml;scht werden soll?<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um das Einsatzstichwort handelt, welches Sie l&ouml;schen m&ouml;chten.';
	$del_link   = 'admin/content/einsatz/cue/delete/'.$cue->id;
    $redirect   = 'cueliste_redirect';
?>

<div id='content'>
<div id='cue_delete_verify'>

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
