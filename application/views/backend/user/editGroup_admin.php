<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
    include_once('application/models/utility_models/form_element.php');
    $groupdata = $groupdata[0];
	
	$form = array(
		'id'	 => 'group',
	);
	if(!$value = set_value('name')) $value = $groupdata->ugrp_name;
	$groupName = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'class' => 'input_text',
		'value' => $value
	);
	if(!$value = set_value('description')) $value = $groupdata->ugrp_desc;
	$groupDescription = array(
		'name' 	=> 'description',
		'id'	=> 'description',
		'class'	=> 'input_text',
		'value'	=> $value
	);
    $groupAdmin = array(
        'name'  => 'admin',
        'id'    => 'admin',
        'class' => '',
        'value' => 'yes'
    );	
	$groupAdminLabel = 'Administrator';
	if($this->input->post('admin') == 'yes' or isset($groupdata->ugrp_admin)) 
	{
		$groupAdmin['checked'] = 'checked'; 
	}
 
    $priv_list = new FormElement();
    for($i = 0; $i < count($privs); $i++)
	{
        $pp        = new FormElement();
		$pp->name  = 'p_'.$privs[$i]->upriv_id;
		$pp->id    = 'p_'.$privs[$i]->upriv_id;
		$pp->class = '';
		$pp->value = $privs[$i]->upriv_id;	
        $pp->label = $privs[$i]->upriv_name;	
		
		if(!$this->input->post('p_'.$privs[$i]->upriv_id) == $privs[$i]->upriv_id) {
            foreach($group_privs as $gp) {
                if($gp->upriv_id == $privs[$i]->upriv_id) 
                    $pp->checked = 'checked';
            } 
		}
        else
            $pp->checked = 'checked';
        $priv_list->list[$i] = $pp;
	}
?>

<div id='content'>
<div id='group_edit'>
<?=form_open($this->session->userdata('groupedit_submit').'/save', $form);?>

    <table>
		<tr>
            <td><button type='submit' name='group_submit' id='group_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
            <td><a href='<?=$this->session->userdata('groupliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
        </tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Gruppendaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
    	<tr>
            <td class='form_label'><?=form_label('Gruppenname:', $groupName['id']); ?></td>
            <td><?=form_input($groupName); ?></td>
        </tr>
    	<tr>
            <td class='form_label'><?=form_label('Beschreibung:', $groupDescription['id']); ?></td>
            <td><?=form_input($groupDescription); ?></td>            
        </tr>
        <tr>
            <td class='form_label'><?=form_label($groupAdminLabel, $groupAdmin['id']);?></td>
            <td><?=form_checkbox($groupAdmin); ?></td>
        </tr>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <p></p>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Berechtigungen:&nbsp;&nbsp;&nbsp;');?>
   	<p>
                 <table>
<? foreach($privs as $i => $value) { ?>
                    <tr>
                        <td colspan='2'><?=form_checkbox((array) $priv_list->list[$i]); ?> <?=form_label($priv_list->list[$i]->label, $priv_list->list[$i]->id); ?></td>
                    </tr>    
<? } ?>               
                </table>
    </p>
    <?=form_fieldset_close();?>
    <script type="text/javascript" language="JavaScript">
        document.forms['<?=$form['id']?>'].elements['<?=$groupName['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>