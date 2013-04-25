<script type="text/javascript">
        $(function() {
                $('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url : '/js/tiny_mce/tiny_mce.js',

                        // General options
                        theme : "advanced",
                        plugins : "style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras",

                        // Theme options
                        theme_advanced_buttons1 : ",undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,",
                        theme_advanced_buttons2 : ",hr,removeformat,visualaid,|,sub,sup,|,advhr,|,ltr,rtl,|,visualchars,nonbreaking,",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,

                        // Example content CSS (should be your site CSS)
                        content_css : "../../css/layout.css",

                });
        });
</script>