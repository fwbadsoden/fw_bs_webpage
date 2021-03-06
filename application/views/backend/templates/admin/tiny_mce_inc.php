<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
if(!isset($config))  $config = 'default';

$tinymce['default'] = '
    selector: "textarea.tinymce",
    script_url : "/js/tinymce/tinymce.min.js",
    theme : "modern",
    skin : "crazypixls",
    language : "de",
    width: "500",
    height: "400",
    doctype: "",
    plugins : [ "advlist autolink autoresize charmap code contextmenu fullscreen hr link lists nonbreaking pagebreak paste preview spellchecker table visualblocks visualchars wordcount" ],
    menu: "newdocument undo redo visualaid cut copy paste selectall bold italic underline strikethrough subscript superscript removeformat formats link charmap print preview hr pagebreak spellchecker searchreplace visualblocks visualchars code fullscreen insertdatetime nonbreaking inserttable tableprops deletetable cell row column",
    pagebreak_separator: "<br>",
    save_onsavecallback : "ajaxSave",
    toolbar: "undo redo cut copy paste | link nonbreaking charmap | preview fullscreen | code | spellchecker | styleselect | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist",   
';

$tinymce['pages'] = '
    selector: "textarea.tinymce",
    script_url : "/js/tinymce/tinymce.min.js",
    theme : "modern",
    skin : "crazypixls",
    language : "de",
    width: "500",
    height: "400",
    doctype: "",
    plugins : [ "advlist autolink autoresize charmap code contextmenu fullscreen hr link lists nonbreaking pagebreak paste preview spellchecker table visualblocks visualchars wordcount" ],
    menu: "newdocument undo redo visualaid cut copy paste selectall bold italic underline strikethrough subscript superscript removeformat formats link charmap print preview hr pagebreak spellchecker searchreplace visualblocks visualchars code fullscreen insertdatetime nonbreaking inserttable tableprops deletetable cell row column",
    pagebreak_separator: "<br>",
    save_onsavecallback : "ajaxSave",
    toolbar: "undo redo cut copy paste | link nonbreaking hr charmap | preview fullscreen | visualblocks visualchars code | spellchecker | styleselect | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist",    
';

?>
<script type="text/javascript">
$(function() {
    $('textarea.tinymce').tinymce({
        <?=$tinymce[$config]?>                           
    });
});
</script>