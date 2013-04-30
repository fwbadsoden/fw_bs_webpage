<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
 ?> 
 
<script type="text/javascript">
  function ajaxSave(){
    var data = tinyMCE.get('content').getContent();
    var tmp_id = tinyMCE.get('name');
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

<?
        switch($box)
        {
            
/* --------------- Bild-Element ----------------- */
            case 'IMG':
                                $form_upload = array(
                            		'id'	=> 'page_box_content_'.$box_content[$i]['boxContentID'],
                            		'name'	=> 'image_upload'
                            	);
                            	$image_upload = array(
                            		'name'	=> 'upload_image',
                            		'maxLength' => '4000'
                            	);
                            	$alt_upload = array(
                            		'name' 	=> 'alt',
                            		'class' => 'bild_details'
                            	);
?>
                                <script type="text/javascript">
                                    $(document).ready(function($){
			                            $("input:submit","#page_box_content_".$box_content[$i]['boxContentID']).button();
			                            $("#page_box_content_".$box_content[$i]['boxContentID']).submit(function(){
                                            $.post(
                                                "/form", 
                                                $("#page_box_content_".$box_content[$i]['boxContentID']).serialize(),function(data){
                                                    $("#errors").empty();$("#errors").append(data);
                                                }
                                            );
                                            return false;
                                        });
                                    });
                                </script>

                                <h1>Bildelement bearbeiten</h1>  
                                <?=form_open_multipart('HIER FEHLT NOCH EINE URL', $form_upload)?>        
                                <?=form_fieldset('&nbsp;&nbsp;&nbsp;Bild hochladen:&nbsp;&nbsp;&nbsp;');?>
                                <p>
                            		<table>
                            			<div id="errors"></div>
                            			<tr><td colspan='2'><?=form_upload($image_upload)?></td></tr>	
                            			<tr><td colspan="2">&nbsp;</td></tr>
                            			<tr><td>Beschreibung:</td><td><?=form_input($alt_upload)?></td></tr>
                            			<tr><td colspan="2"></td></tr>
                            			<tr>
                            				<td colspan="2"><button type='submit' name='image_submit' id='image_submit' class='button_gross'><span class='button_save'>Hochladen</span></button></td>
                            			</tr>
                            		</table>
                            	</p>
                            	<?=form_fieldset_close();?>                                                      
<?
                                if(!is_null($box_content[$i]['image']))
                                {
?>
                                    <p>&nbsp;</p>
                                    <span class="span_img_preview">
                                    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Bildervorschau:&nbsp;&nbsp;&nbsp;');?>
                                    <p>
                                		<table>
                                			<tr>
                                				<td style="vertical-align:top; width: 250px;">
                                					<table>
                                						<input type='hidden' name='img_id' value='' id='img_id' />
                                						<tr><td>Bildbeschreibung:</td><td><?=form_input($alt_preview)?></td></tr>
                                						<tr><td colspan="2">&nbsp;</td></tr>
                                						<tr><td>Breite:</td><td><?=form_input($breite_preview)?></td></tr>
                                						<tr><td>Höhe:</td><td><?=form_input($hoehe_preview)?></td></tr>
                                						<tr><td colspan="2">&nbsp;</td></tr>
                                						<tr>
                                							<td colspan="2"><button type='submit' name='image_submit' id='image_submit' class='button_gross' value='img_delete'><span class='button_cancel'>Löschen</span></button></td>
                                						</tr>
                                					</table>	
                                				</td>
                                				<td style="vertical-align:top;">
                                					<img src='<?=base_url($box_content[$i]['image'])?>' name='view_imagefiles' id='previewimage' class='previewimage' alt='' title=''>
                                				</td>
                                			</tr>
                                		</table>	
                                		<br><br>					
                                	</p>
                                	<?=form_fieldset_close();?>                                    
<?
                                }
                                break;
                                
/* --------------- Text-Element ----------------- */
            case 'TXT':         
                                $form_txt = array(
                            		'id'	=> 'page_box_content_'.$box_content[$i]['boxContentID'],
                            		'name'	=> 'content_txt'
                            	);
                                $content_textarea = array(
                            		'name' 	=> 'content_txt_'.$box_content[$i]['boxContentID'],
                            		'id'	=> 'content_txt_'.$box_content[$i]['boxContentID'],
                            		'class' => 'tinymce',
                            		'value' => $box_content[$i]['content']
                            	);
                                echo form_open($this->session->userdata('einsatzedit_submit').'/save', $form_txt);
                                echo form_textarea($content_textarea); 
                                break;
                                
/* --------------- Headline-Element ----------------- */            
            case 'HEADLINE':
                                $content_hdl = $box_content[$i]['content'];
                                $form_hdl = array('id'	 => 'page_box_content_'.$box_content[$i]['boxContentID']);
                                echo 'HEADLINE';
                                break;
        }
        
        echo'</p></div>';    
        $i++;    
    } 
?>
</div>
</p>
</div>
</div>