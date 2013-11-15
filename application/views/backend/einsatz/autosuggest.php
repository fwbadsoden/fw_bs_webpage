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

//	  function split( val ) {
//    return val.split( /,\s*/ );
//  }
//
//  function extractLast( term ) {
//     return split( term ).pop();
//   }
//
//   $( "#weitereeinsatzkraefte" )
//        .autocomplete({
//             minLength: 0,
//             source: function( request, response ) {
//                 response( $.ui.autocomplete.filter(
//                     items, extractLast( request.term ) ) );
//             },
//             focus: function() {
//                 return false;
//             },
//            select: function( event, ui ) {
//                var terms = split( this.value );
//                terms.pop();
//                terms.push( ui.item.value );
//                terms.push( "" );
//                this.value = terms.join( ", " );
//                return false;
//            }
//        });
});
        
</script>