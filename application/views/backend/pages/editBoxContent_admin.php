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
        echo form_fieldset('&nbsp;&nbsp;&nbsp;Inhalt pflegen:&nbsp;&nbsp;&nbsp;');
        echo 'Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.';
        echo form_fieldset_close();
        echo'</p></div>';    
        $i++;    
    } 
?>
</div>
</p>
</div>
</div>