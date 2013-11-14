<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
$(function() {    
    
    var availableTags = new Array();
<? foreach($weitere_kraefte as $key => $wert): 
      echo "availableTags['$key'] = '$wert';\n";
   endforeach; ?>
    $( "#weitereeinsatzkraefte" ).autocomplete({
      source: availableTags,
      position: { my : "left top", at: "right top" },
      autofocus: true,
    });
});
        
</script>