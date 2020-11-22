
//var mapboxUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var defaultLat;
var mapboxUrl = 'http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png';

var map = L.map('map', {
    center: [-25.754264,0],
    zoom: 8
    //zoomControl: true
});

L.tileLayer(mapboxUrl).addTo(map);

var control = L.Routing.control({
    "type": "LineString",
    waypoints: [
        L.latLng(-25.754264,0)
    ],
    /*
    "coordinates": [
       [52.5002237, -2.94],
       [52.5002237, -0.949],
       [52.5002237, -1.949]
    ],
    /*
    createMarker: (i, wp) => {
         return L.marker(wp.latLng, {
           icon: L.icon.glyph({ glyph: String.fromCharCode(65 + i) })
         });
       },*/
    lineOptions : {
        styles: [
            // {color: 'black', opacity: 0.15, weight: 9},
            // {color: 'white', opacity: 0.8, weight: 6},
            // {color: 'red', opacity: 1, weight: 2},
            {className: 'animate'}
        ],
        missingRouteStyles: [
            {color: 'black', opacity: 0.5, weight: 7},
            {color: 'white', opacity: 0.6, fweight: 4},
            {color: 'gray', opacity: 0.8, weight: 2, dashArray: '7,12'}
        ]
    },

    show: true,
    addWaypoints: false,
    autoRoute: true,
    routeWhileDragging: false,
    draggableWaypoints: false,
    useZoomParameter: false,
    showAlternatives: true,
    //  geocoder: L.Control.Geocoder.nominatim(),
    /*
    routingstart: function(){
       console.log('routingstart')
    }*/
}).addTo(map)
    .on('routingerror', function(e) {
        try {
            map.getCenter();
        } catch (e) {
            map.fitBounds(L.latLngBounds(waypoints));
        }
        handleError(e);
    });

L.Routing.errorControl(control).addTo(map);


L.Routing.itinerary({
    pointMarkerStyle:{radius: 5,color: '#03f',fillColor: 'white',opacity: 1,fillOpacity: 0.7},
    //show: true
}).addTo(map);


function setValues(lat1,lat2,lat3){
    let newWaypoints = [
        L.latLng(lat1[0],lat1[1]),
        L.latLng(lat2[0],lat2[1]),
        L.latLng(lat3[0],lat3[1])
    ];

    control.setWaypoints(newWaypoints);
}


function createSVGRoutingMarker() {
    let primaryColor = '#FFDDCC';
    let strokeCoreColor = '#34FDCF';
    let strokeColor = '#333333';
    let selected = false;
    let baseSize = 18;
    const centerStrokeWidth = 3 ;
    const colors = this.palette.colorForVan();
    const displayCross = null;

    const selectedAddon = selected ? ' stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="null" stroke-width="40" ' : '';

    const icon = `<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="1000" height="500">
              <path style="fill:#FFDDCC; fill-rule:evenodd" ${selectedAddon} d="M 295.78419,86.816926 L 295.78419,335.08252 L 687.71625,335.40310 C 664.71649,354.19396 650.35734,380.09418 650.54503,414.08813 L 261.47933,413.85667 C 257.75238,281.97351 70.642616,282.42223 66.576854,413.09434 C 38.473995,412.88466 34.575813,406.50199 34.304870,380.61469 L 34.304868,281.61469 C 33.952015,237.37253 28.426810,266.57731 61.177014,182.67997 C 94.875059,93.246445 85.585107,101.51291 116.06480,99.204795 L 295.78419,86.816926 z M 217.93865,233.19966 L 219.48981,127.72046 L 119.43969,133.92512 C 101.20003,135.14704 101.04823,135.26154 94.621050,156.41701 L 69.026832,224.66825 C 60.428592,245.60250 61.797130,251.77115 85.314062,248.71131 L 217.93865,233.19966 z M 966.63494,335.59074 L 966.82552,391.36792 L 902.21802,414.23783 L 845.49140,414.20156 C 845.72230,381.85903 832.28136,354.65711 808.44981,335.54893 L 966.63494,335.59074 z " />
              <rect x="335.82718" y="12.158683" height="301.70154" width="631.32404" style="fill:${strokeColor};" ${selectedAddon} />
              <circle r="77" cx="164" cy="412" style="fill:${strokeCoreColor};" ${selectedAddon} />
              <circle r="77" cx="748" cy="412" style="fill:${strokeCoreColor};" ${selectedAddon} />
            </svg>`;

    let url = "data:image/svg+xml;base64," + btoa(icon);
    return L.icon({
        iconUrl: url,
        iconSize: [baseSize * 2 , baseSize ],
        // shadowSize: [12, 10],
        // iconAnchor: [baseSize / 2, baseSize / 2],
        popupAnchor: [0, 0],
        className: "van-marker"
    });
}


// http://www.liedman.net/leaflet-routing-machine/tutorials/
// DOC : http://www.liedman.net/leaflet-routing-machine/api/#l-routing-control
// var control = L.Routing.control(L.extend(window.lrmConfig, {
// 	waypoints: [
// 		L.latLng(-25.754264,28.195877),
// 		L.latLng(-25.76774,28.27503)
// 	],
// 	geocoder: L.Control.Geocoder.nominatim(),
// 	routeWhileDragging: true,
// 	reverseWaypoints: true,
// 	showAlternatives: true,
// 	altLineOptions: {
// 		styles: [
// 			{color: 'black', opacity: 0.15, weight: 9},
// 			{color: 'white', opacity: 0.8, weight: 6},
// 			{color: 'blue', opacity: 0.5, weight: 2}
// 		]
// 	}
// })).addTo(map);
//
// L.Routing.errorControl(control).addTo(map);

