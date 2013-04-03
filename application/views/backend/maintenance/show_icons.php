<?php
// Pfad zum Verzeichnis (Hier ist es ein Unterverzeichnis)
$verzeichnis = 'images/admin/buttons/notused/';
$handle = openDir($verzeichnis); // Verzeichnis öffnen
echo "<ul>";
while ($datei = readDir($handle)) { // Verzeichnis auslesen
 // Verzeichnisse filtern
 if ($datei != "." && $datei != ".." && !is_dir($datei)) {
  // Nur Bilder durch lassen (Filter)
  if (strstr($datei, ".abc") ||
     strstr($datei, ".png") ||
     strstr($datei, ".ccc")) {
   // Pfad zur aktuellen Datei
   $verzeichnis_datei = $verzeichnis . $datei;
   // Bildinfos ermitteln (Breite, Höhe)
   $info = getImageSize($verzeichnis_datei);
   // Bild anzeigen
	
   echo "<li><img src=".base_url($verzeichnis.$datei);
   echo " width=".$info[0]." height=".$info[1]." alt = ".base_url($verzeichnis.$datei)."> ".base_url($verzeichnis.$datei)."</li>";
  }
 }
}
echo "</ul>";
closeDir($handle); // Verzeichnis schließen 
?>1