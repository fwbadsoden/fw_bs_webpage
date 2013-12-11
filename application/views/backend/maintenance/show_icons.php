<?php
// Pfad zum Verzeichnis (Hier ist es ein Unterverzeichnis)
$verzeichnis = 'images/admin/buttons/notused/';

$handle = opendir($verzeichnis); 
$dir = array(); 
while($file = readdir($handle)){ 
if($file != "." && $file != ".."){ 
$dir[] = $file; 
} 
} 
closedir($handle); 
sort($dir); 


echo "<div id='content'><ul>";
foreach($dir as $d) {
   $info = getImageSize($verzeichnis.$d);
   // Bild anzeigen
	
   echo "<li><img src=".base_url($verzeichnis.$d);
   echo " width=".$info[0]." height=".$info[1]." alt = ".base_url($verzeichnis.$d)."> ".base_url($verzeichnis.$d)."</li>";
  
}
echo "</ul></div>";

/* End of file show_icons.php */
/* Location: ./application/views/backend/maintenance/show_icons.php */