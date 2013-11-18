<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
$(function() {    
    
    var availableTags = new Array();
<? foreach($weitere_kraefte as $key => $wert): 
      echo "availableTags['$key'] = '$wert';\n";
   endforeach; ?>
   
        function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#weitereeinsatzkraefte" )
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,                
                position: { my : "left top", at: "right top" },
				source: function( request, response ) {
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {	return false; },
				select: function( event, ui ) {
					var terms = split( this.value );
					terms.pop();
					terms.push( ui.item.value );
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});     
});
        
</script>