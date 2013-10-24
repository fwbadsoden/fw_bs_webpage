<!DOCTYPE html>
        <html>
          <head>
            <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
            <style type="text/css">
              html { height: 100% }
              body { height: 100%; margin: 0; padding: 0 }
              #map-canvas { height: 100% }
            </style>
            <script type="text/javascript"
              src="https://maps.googleapis.com/maps/api/js?key=<?=$api_key?>&sensor=<?=$sensor?>">
            </script>
            <script type="text/javascript">
              function initialize() {
                google.maps.visualRefresh = <?=$visual_refresh?>;
                var useragent = navigator.userAgent;
                var mapdiv = document.getElementById("map-canvas");
                var mapOptions = {
                  center: new google.maps.LatLng(<?=$lat_lng_1?>, <?=$lat_lng_2?>),
                  zoom: 8,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"),
                    mapOptions);
              }
              google.maps.event.addDomListener(window, 'load', initialize);
              if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
                mapdiv.style.width = '100%';
                mapdiv.style.height = '100%';
              }
            </script>
          </head>
          <body>
            <div id="map-canvas"></div>
          </body>
        </html>