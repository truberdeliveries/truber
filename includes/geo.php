<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Leaflet OSRM Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="../maps/dist/leaflet.css" />
    <link rel="stylesheet" href="../maps/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="../maps/dist/index.css" />

</head>
<body>
<div id="demo"></div>
<script src="../assets/js/jquery.min.js"></script>
    <div id="map" class="map"></div>
    <script src="../maps/js/leaflet.js"></script>
    <script src="../maps/js/leaflet-routing-machine.js"></script>
    <script src="../maps/js/index.js"></script>
<script src='../maps/js/turf.min.js'></script>
<script>

    var from = turf.point([-25.754264,28.195877]);
    var to = turf.point([-25.74868, 28.19539]);
    var options = {units: 'kilometers'};

    var distance = turf.distance(from, to, options);
    console.log(distance);
    setValues([-25.754264,28.195877],[-25.74868, 28.195804]);
</script>
</body>
</html>