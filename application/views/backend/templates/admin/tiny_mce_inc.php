<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  
$tinymce = array(
    'script_url' => '/js/tinymce/tinymce.min.js',
    'theme' => 'modern',
    'skin' => 'crazypixls',
    'language' => 'de',
    'width' => 700,
    'height' => 400,
    'doctype' => '',
    'plugins' => array('advlist', 
                       'autolink', 
                       'autoresize', 
                       'autosave', 
                       'bbcode', 
                       'charmap', 
                       'code', 
                       'contextmenu',
                       'directionality',
                       'fullscreen',
                       'hr',
                       'image',
                       'insertdatetime',
                       'layer',
                       'legacyoutput',
                       'link',
                       'lists',
                       'nonbreaking',
                       'noneditable',
                       'pagebreak',
                       'paste',
                       'preview',
                       'save',
                       'searchreplace',
                       'spellchecker',
                       'tabfocus',
                       'table',
                       'template',
                       'textcolor',
                       'visualblocks',
                       'visualchars',
                       'wordcount'),
    'menu' => ' ',
    'save_onsavecallback' => 'ajaxSave',
    'toolbar' => array('undo',
                       'redo',
                       'cut',
                       'copy',
                       'paste',
                       '|',
                       'styleselect',
                       '|',
                       'bold',
                       'italic',
                       'underline',
                       'strikethrough',
                       'subscript',
                       'superscript',
                       '|',
                       'alignleft',
                       'aligncenter',
                       'alignright',
                       'alignjustify',
                       '|',
                       'bullist',
                       'numlist',
                       'outdent',
                       'indent',
                       '|',
                       'link',
                       'image',
                       '|',
                       'preview',
                       'fullscreen',
                       '|',
                       'forecolor','
                       backcolor'),
);

if(isset($tinymce_config['script_url'])) $tinymce['script_url'] = $tinymce_config['script_url'];
if(isset($tinymce_config['theme'])) $tinymce['theme'] = $tinymce_config['theme'];
if(isset($tinymce_config['skin'])) $tinymce['skin'] = $tinymce_config['skin'];
if(isset($tinymce_config['language'])) $tinymce['language'] = $tinymce_config['language'];
if(isset($tinymce_config['width'])) $tinymce['width'] = $tinymce_config['width'];
if(isset($tinymce_config['height'])) $tinymce['height'] = $tinymce_config['height'];
if(isset($tinymce_config['doctype'])) $tinymce['doctype'] = $tinymce_config['doctype'];
if(isset($tinymce_config['plugins'])) $tinymce['script_url'] = $tinymce_config['script_url'];
if(isset($tinymce_config['menu'])) $tinymce['script_url'] = $tinymce_config['script_url'];
if(isset($tinymce_config['save_onsavecallback'])) $tinymce['save_onsavecallback'] = $tinymce_config['save_onsavecallback,'];
if(isset($tinymce_config['toolbar'])) $tinymce['script_url'] = $tinymce_config['script_url'];
?>
<script type="text/javascript">
        $(function() {
                $('textarea.tinymce').tinymce({
                        script_url : '/js/tinymce/tinymce.min.js',
                        theme : "modern",
                        skin : 'crazypixls',
                        language : 'de',
                        width: 700,
                        height: 400,
                        doctype: '',
                        plugins : [ 
                            "advlist autolink autoresize autosave",
                            "bbcode",
                            "charmap code contextmenu",
                            "directionality",
                            "fullscreen",
                            "hr",
                            "image insertdatetime",
                            "layer legacyoutput",
                            "link lists",
                            "nonbreaking noneditable",
                            "pagebreak paste preview",
                            "save searchreplace spellchecker",
                            "tabfocus table template textcolor",
                            "visualblocks visualchars wordcount" 
                        ],
                        menu: " ",
                        save_onsavecallback : "ajaxSave",
                        toolbar: "undo redo cut copy paste | styleselect | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview fullscreen | forecolor backcolor",    
                        
                });
        });
</script>