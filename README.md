fw_bs_webpage
=============

Homepage der Feuerwehr Bad Soden am Taunus

Installationsanleitung:
Um lokal entwickeln zu können sind folgende Schritte notwendig:
1. Apache + PHP + MySQL Installation (am besten einfach XAMPP nehmen)
2. In der Datei C:\Windows\System32\Drivers\etc\hosts folgenden Eintrag hinzufügen:
    127.0.0.1  	fw_bs_webpage 
3. In der Apache Konfiguration einen virtuellen Host anlegen
    <VirtualHost fw_bs_webpage:80>
    DocumentRoot "\xampp-portable\htdocs\fw_bs_webpage"          // \xampp-portable\htdocs durch dein eigenen doc root ersetzen
    ServerName fw_bs_webpage
    </VirtualHost> 
4. Im Verzeichnis application/config/ der Webseite einen Unterordnern mit dem eigenen Namen anlegen
5. In dieses Verzeichnis mindestens die config.php und database.php kopieren 
5.1 config.php die base_url anpassen auf den lokalen Pfad $config['base_url']  = 'http://fw_bs_webpage/';
5.2 database.php die Parameter der lokalen Datenbank Verbindung eintragen
6. index.php die Environment Konstante korrekt setzen auf den in Punkt 4 gesetzten Verzeichnisnamen (Bsp. define('ENVIRONMENT', 'habib'); )
   und dann in der darunter stehenden switch Auswahl noch das definierte Environment hinzufügen
7. Datenbank installieren (aktuellen Export bekommt ihr über mich [Habib]
8. wenn alles nix hilft: Habib fragen!!!
