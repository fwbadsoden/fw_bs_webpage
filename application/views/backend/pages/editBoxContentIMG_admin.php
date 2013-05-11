<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
    
    $form_txt = array(
        'id'	=> 'page_box_content',
        'name'	=> 'page_box_content'
    );
    $content_options = array();
    $content_attr = "class = 'input_dropdown' id = 'input_dropdown'";
    foreach($images as $image)
    {
    	$content_options[$image['fileID']] = $image['name'];	
   	}
 ?> 
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

<h1>Bild w&auml;hlen</h1>
<p>       
                                
<?=form_dropdown('content_img', $content_options, set_value('content_img', $box_content['image']), $content_attr)?>            

</p>
</div>
</div>