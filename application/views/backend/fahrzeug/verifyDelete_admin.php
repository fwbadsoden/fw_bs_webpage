<?php if (!defined('BASEPATH')) exit('No direct script access allowed');    
    $headline   = 'ACHTUNG: Wollen Sie den Datensatz wirklich l&ouml;schen?';
	$text       = 'Sind Sie sicher, dass das <strong>Fahrzeug</strong> <strong>'.$fahrzeugRufnamePrefix.' '.$fahrzeugRufname.' - '.$fahrzeugName.'</strong> gel&ouml;scht werden soll?<br><strong>Bitte pr&uuml;fen Sie sorgf&auml;ltig</strong>, ob es sich genau um das Fahrzeug handelt, welches Sie l&ouml;schen m&ouml;chten.';
	$del_link   = 'admin/content/fahrzeug/delete/'.$fahrzeugID;
    $redirect   = 'fahrzeugliste_redirect';
?>

<div id='content'>
<div id='fahrzeug_delete_verify'>

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
