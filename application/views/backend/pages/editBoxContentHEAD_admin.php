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
        'class' => 'input_text',
        'value' => set_value('content_txt', $box_content['content'])
    );
 ?> 
 <!--
<script type="text/javascript">
  function ajaxSave(){
    var data = tinyMCE.get('content_txt').getContent();
    var ajax = new XMLHttpRequest();
    //alert(data);
    ajax.open('POST','<?=base_url('admin/content/page/box/content/save/'.$box_content['boxContentID'])?>', true);
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('data='+data);
  }
</script> 
 -->
<div id='content'>
<div id='page_box_content'>

<?=form_open(base_url('admin/content/page/box/content/save/'.$box_content['boxContentID']), $form_txt);?>

<table>
    <tr>
        <td><button type='submit' name='box_content_edit_submit' id='box_content_edit_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
        <td><a href='<?=$this->session->userdata('pageedit_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a></td>
    </tr>
</table>
<br/>

<h1>Headline pflegen</h1>
<p>       
                                
<?=form_input($content);?>              

</p>
</div>
</div>