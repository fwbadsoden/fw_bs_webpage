<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
    
    $form_txt = array(
        'id'	=> 'page_box_content',
        'name'	=> 'page_box_content'
    );
    $content = array(
        'name' 	=> 'content_txt',
        'id'	=> 'content_txt',
        'class' => 'tinymce',
        'value' => $box_content['content']
    );
    $hidden_id = array(
        'name'  => 'box_content_id',
        'id'  => 'box_content_id',
        'value' => $box_content['boxContentID']
    );
 ?> 
 
<script type="text/javascript">
  function ajaxSave(){
    var data = tinyMCE.get('content_txt').getContent();
    var id = tinyMCE.get('name');
    var ajax = new XMLHttpRequest();
    ajax.open('POST','hello.php',false);
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('data='+data);
  }
</script> 
 
<div id='content'>
<div id='page_box_content'>

<table>
    <tr><td><a href='<?=$this->session->userdata('pageedit_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a></td></tr>
</table>
<br>

<h1>Inhalte pflegen</h1>
<p>       
                                
<?=form_open($this->session->userdata('einsatzedit_submit').'/save', $form_txt);?>
<?=form_hidden($hidden_id);?>
<?=form_textarea($content);?>               
        


</p>
</div>
</div>