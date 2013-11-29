<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$api_key = 'AIzaSyCIdNCnXP0RCrhpGxjGuS_qZEnz7QCLns4';
$lat_lng_1 = '50.145006';
$lat_lng_2 = '8.49844';
$zoom = '13';
$visual_refresh = 'true';
$sensor = 'false';
?>

<div class="slidewrapper smallstage"><script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCIdNCnXP0RCrhpGxjGuS_qZEnz7QCLns4&sensor=false"></script>

    <div class="oneColumnBox">  
        <div class="article" id="anker_allgemein">
            <p>
                Wie alle Feuerwehren haben auch wir bei der Feuerwehr Bad Soden ein bestimmtes Einsatzgebiet, für das wir zuständig sind. Das Gebiet umfasst das Stadtgebiet der Stadt Bad Soden am Taunus mit den Stadtteilen 
                Neuenhain und Altenhain. Darüber hinaus werden wir für überörtliche Einsätze im gesamten Main-Taunus-Kreis eingesetzt.
            </p>

            <div id="map_canvas" style="width: 100%; height: 500px; "></div>

        </div>
        <h1 class="module" id="anker_schwerpunkte">Schwerpunkte</h1>
        <div class="article"> 
            <p>
                Die Stadt Bad Soden hat einige Gefahrenschwerpunkte. Damit sind spezielle Gebäude oder Einrichtungen gemeint, für die besondere Alarmpläne und Einsatzrichtlinien existieren, 
                die im Alarmfall berücksichtigt werden müssen.
            </p>
            <h1>Kliniken, Senioreneinrichtungen und Schulen</h1>
            <p>
                In diesen Einrichtungen müssen wir im Gefahrfall nicht nur mit Gefahrstoffen (z.B. Labormaterial) rechnen, sondern auch mit einer Vielzahl von Menschen, die unter Umständen evakuiert werden müssen. 
                Besonders die Gesundheitseinrichtungen, bei denen im Alarmfall viele kranke, alte und behinderte Menschen betroffen sind, erfordern besondere Maßnahmen. 
                Deshalb werden diesen Objekten besondere Alarmpläne zugeordnet.</p>  
            <ul>
                <li>Kliniken des Main-Taunus-Kreises Bad Soden am Taunus</li>
                <li>Enddarmkliniken</li>
                <li>Medico-Palais</li>
                <li>Badehaus</li>
                <li>Freibad</li>
                <li>Wohnstift Collegium Augustinum</li>
                <li>Senioren Residenz</li>
                <li>Taunus Residenzen</li>
                <li>Elisabethenheim</li>
                <li>3 Grundschulen im Stadtgebiet</li>
                <li>Mehrere Kindergärten im Stadtgebiet</li>
            </ul>
            <h1>Industrie und Gewerbe</h1>
            <ul>
                <li>City-Arkaden</li>
                <li>Aventis-Pharma Deutschland</li>
                <li>Krupp-Uhde</li>
                <li>Messer</li>
                <li>Radiologen und chemische Labore</li>
                <li>Aussiedlerhöfe</li>
            </ul>
            <h1>Überschwemmungsgebiet Innenstadt / Heilquellen / Kureinrichtungen</h1>
            <p>
                Durch die besondere Lage der Kernstadt ist Bad Soden am Taunus für Überschwemmungen anfällig, was bereits des Öfteren schon zu größeren Problemen führte. Drei Bäche (Sulzbach, Niedersdorfbach und Waldbach) fließen durch unsere Stadt. Bei Hochwasser hat dies schon zu katastrophalen Wasserständen in der Innenstadt geführt. Deshalb werden bei starken Regenfällen präventiv im gesamten Stadtgebiet die Bachläufe und die Rechen kontrolliert und von Dreck sowie Unrat befreit.
            </p>
        </div>

        <script type="text/javascript">

            // Marker
            var locations = [
                ['Kliniken des Main-Taunus-Kreises<br/>Bad Soden am Taunus', 50.151331, 8.514133],
                ['Feuerwehr Bad Soden', 50.139131, 8.511029],
                ['Feuerwehr Neuenhain', 50.158639, 8.495477],
                ['Feuerwehr Altenhain', 50.156875, 8.468608],
                ['Taunusresidenzen', 50.143738, 8.511266]
            ];

            var overlayCoord = [
                new google.maps.LatLng(50.130538, 8.492425),
                new google.maps.LatLng(50.131391, 8.493412),
                new google.maps.LatLng(50.133509, 8.490837),
                new google.maps.LatLng(50.133206, 8.48882),
                new google.maps.LatLng(50.136067, 8.486588),
                new google.maps.LatLng(50.139313, 8.483499),
                new google.maps.LatLng(50.141568, 8.480838),
                new google.maps.LatLng(50.152871, 8.463285),
                new google.maps.LatLng(50.151606, 8.461354),
                new google.maps.LatLng(50.151524, 8.459938),
                new google.maps.LatLng(50.150424, 8.459466),
                new google.maps.LatLng(50.150204, 8.457706),
                new google.maps.LatLng(50.151111, 8.452514),
                new google.maps.LatLng(50.154521, 8.453029),
                new google.maps.LatLng(50.155648, 8.452299),
                new google.maps.LatLng(50.166123, 8.453415),
                new google.maps.LatLng(50.170082, 8.454874),
                new google.maps.LatLng(50.169889, 8.45732),
                new google.maps.LatLng(50.167883, 8.458264),
                new google.maps.LatLng(50.165381, 8.46144),
                new google.maps.LatLng(50.168597, 8.463414),
                new google.maps.LatLng(50.17327, 8.473585),
                new google.maps.LatLng(50.16901, 8.483112),
                new google.maps.LatLng(50.159635, 8.501995),
                new google.maps.LatLng(50.159993, 8.504527),
                new google.maps.LatLng(50.159003, 8.508046),
                new google.maps.LatLng(50.158645, 8.510449),
                new google.maps.LatLng(50.154961, 8.50899),
                new google.maps.LatLng(50.151716, 8.517144),
                new google.maps.LatLng(50.145721, 8.509548),
                new google.maps.LatLng(50.142393, 8.515342),
                new google.maps.LatLng(50.139478, 8.512681),
                new google.maps.LatLng(50.137333, 8.516801),
                new google.maps.LatLng(50.133454, 8.513711),
                new google.maps.LatLng(50.131363, 8.507488),
                new google.maps.LatLng(50.130345, 8.492768)
            ];

            var mapOptions = {
                center: new google.maps.LatLng(50.145006, 8.49844),
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map_canvas"),
                    mapOptions);

            // Infofenster ("Blase") soll angezeigt werden
            var infowindow = new google.maps.InfoWindow();
            // Auslesen der Markerinformationen
            var marker, i;

            // Länge und Breite und Festlegung für welche div-ID dies gilt
            for (i = 0; i < locations.length; i++)
            {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                });

                // Infofenster: Wie wird es angesprochen und was befindet sich in ihm
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
            // Construct the polygon
            // Note that we don't specify an array or arrays, but instead just
            // a simple array of LatLngs in the paths property
            overlay = new google.maps.Polygon({
                paths: overlayCoord,
                strokeColor: "#828282",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#828282",
                fillOpacity: 0.35
            });

            overlay.setMap(map);

        </script>   
