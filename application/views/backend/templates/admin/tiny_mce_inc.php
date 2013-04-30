<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

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
//                        style_formats: [
//                                {title: 'Image Left', selector: 'img', styles: {
//                                        'float' : 'left', 
//                                        'margin': '0 10px 0 10px'
//                                }},
//                                {title: 'Image Right', selector: 'img', styles: {
//                                        'float' : 'right', 
//                                        'margin': '0 10px 0 10px'
//                                }},
//                        ],
                        toolbar: "undo redo cut copy paste | styleselect | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview fullscreen | forecolor backcolor",    
                        
                });
        });
</script>