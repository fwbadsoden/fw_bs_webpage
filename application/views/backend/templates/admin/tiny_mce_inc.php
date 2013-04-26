<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

?>
<script type="text/javascript">
        $(function() {
                $('textarea.tinymce').tinymce({
                        script_url : '/js/tinymce/tinymce.min.js',
                        theme : "modern",
                        skin : 'crazypixls',
                        width: 500,
                        height: 400,
                        plugins : [ 
                            "advlist autolink autoresize autosave",
                            "bbcode",
                            "charmap code contextmenu",
                            "directionality",
                            "emoticons",
                            "fullpage fullscreen",
                            "hr",
                            "image insertdatetime",
                            "layer legacyoutput",
                            "link lists",
                            "media",
                            "nonbreaking noneditable",
                            "pagebreak paste preview print",
                            "save searchreplace spellchecker",
                            "tabfocus table template textcolor",
                            "visualblocks visualchars wordcount" 
                        ],
                        

                        // Example content CSS (should be your site CSS) -- geht mit aktuellem CSS nicht... prüfen!!!
                        //content_css : "/css/admin/admin.css",
                });
        });
</script>