<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
if(!isset($config))  $config = 'default';

$tinymce['default'] = '
    script_url : "/js/tinymce/tinymce.min.js",
    theme : "modern",
    skin : "crazypixls",
    language : "de",
    width: "700",
    height: "400",
    doctype: "",
    plugins : [ "advlist autolink autoresize charmap code contextmenu fullscreen hr link lists nonbreaking pagebreak paste preview spellchecker table visualblocks visualchars wordcount" ],
    menu: "newdocument undo redo visualaid cut copy paste selectall bold italic underline strikethrough subscript superscript removeformat formats link charmap print preview hr pagebreak spellchecker searchreplace visualblocks visualchars code fullscreen insertdatetime nonbreaking inserttable tableprops deletetable cell row column",
    pagebreak_separator: "<br>",
    save_onsavecallback : "ajaxSave",
    toolbar: "undo redo cut copy paste | link nonbreaking hr charmap | preview fullscreen | visualblocks visualchars code | spellchecker | styleselect | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",     
';

$tinymce['pages'] = '
    script_url : "/js/tinymce/tinymce.min.js",
    theme : "modern",
    skin : "crazypixls",
    language : "de",
    width: "700",
    height: "400",
    doctype: "",
    plugins : [ "advlist autolink autoresize charmap code contextmenu fullscreen hr link lists nonbreaking pagebreak paste preview save spellchecker table visualblocks visualchars wordcount" ],
    menu: "newdocument undo redo visualaid cut copy paste selectall bold italic underline strikethrough subscript superscript removeformat formats link charmap print preview hr pagebreak spellchecker searchreplace visualblocks visualchars code fullscreen insertdatetime nonbreaking inserttable tableprops deletetable cell row column",
    pagebreak_separator: "<br>",
    save_onsavecallback : "ajaxSave",
    toolbar: "save | undo redo cut copy paste | link nonbreaking hr charmap | preview fullscreen | visualblocks visualchars code | spellchecker | styleselect | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",     
';

?>
<script type="text/javascript">
$(function() {
    $('textarea.tinymce').tinymce({
        <?=$tinymce[$config]?>                           
    });
});
</script>