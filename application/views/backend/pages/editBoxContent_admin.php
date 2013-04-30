<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
    
    $boxTags = explode(PAGES_BOX_TAGS_SEPARATOR, $box_meta['boxTags']);  
    $boxTagsNames = explode(PAGES_BOX_TAGS_SEPARATOR, $box_meta['boxTagsNames']);            
    $tag_count = count($boxTags);      
	
    $i=0;
 ?> 
 
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script> 
 
<div id='content'>
<div id='page_box_content'>

<h1>Inhalte pflegen</h1>
<p>
<div id="tabs">
<ul>

<? 
    foreach($boxTags as $box) 
    {
        echo '<li><a href="#tabs-'.($i+1).'">'.$boxTagsNames[$i].'</a></li>';
        $i++;
    }
?>

</ul>  

<?
    $i = 0; 
    foreach($boxTags as $box) 
    {           
        $form = array('id'	 => 'page_box_content_'.$box_content[$i]['boxContentID']);
        echo '<div id="tabs-'.($i+1).'"><p>';
        
        switch($box)
        {
            case 'IMG':
?>
                                <div id="upload-img">
                                	<h2>Upload a file</h2>
                                	<!-- Upload function on action form -->
                                	<?php echo form_open_multipart('/upload/upload_img', array('id' => 'fileupload')); ?>
                                	<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                	<div class="row fileupload-buttonbar">
                                		<div class="span7">
                                			<!-- The fileinput-button span is used to style the file input field as button -->
                                			<span class="btn btn-success fileinput-button">
                                				<span><i class="icon-plus icon-white"></i> Add files...</span>
                                				<!-- Replace name of this input by userfile-->
                                				<input type="file" name="userfile" multiple>
                                			</span>
                                
                                			<button type="submit" class="btn btn-primary start">
                                				<i class="icon-upload icon-white"></i> Start upload
                                			</button>
                                
                                			<button type="reset" class="btn btn-warning cancel">
                                				<i class="icon-ban-circle icon-white"></i> Cancel upload
                                			</button>
                                
                                			<button type="button" class="btn btn-danger delete">
                                				<i class="icon-trash icon-white"></i> Delete
                                			</button>
                                
                                			<input type="checkbox" class="toggle">
                                		</div>
                                
                                		<div class="span5">
                                
                                		<!-- The global progress bar -->
                                			<div class="progress progress-success progress-striped active fade">
                                				<div class="bar" style="width:0%;"></div>
                                			</div>
                                		</div>
                                	</div>
                                
                                	<!-- The loading indicator is shown during image processing -->
                                	<div class="fileupload-loading"></div>
                                	<br>
                                	<!-- The table listing the files available for upload/download -->
                                	<table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
                                	<?php echo form_close(); ?>
                                
                                </div>
<?
                                break;
            case 'TXT':
                                break;
            case 'HEADLINE':
                                break;
        }
        echo 'Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.';
        
        echo'</p></div>';    
        $i++;    
    } 
?>
</div>
</p>
</div>
</div>