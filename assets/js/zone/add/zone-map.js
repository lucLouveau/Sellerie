var map;
var polygon;
var markers = [];
var points = [];

function createMap(lat,lng, data) {
    // Initialisation de la carte
    map = L.map('map').setView([49.118480, -1.066835], 20);

    // Ajout des tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);
    // Création du polygone vide
    polygon = L.polygon(points).addTo(map);
    constructExistZone(data);
    // Ajout d'un écouteur d'événement au clic pour créer un marqueur et un point dans le polygone
    map.on('click', createMarker);

    for( var i=0;i<lat.length;i++){
        var e={
            "latlng":{
                "lat":parseFloat(lat[i]),
                "lng":parseFloat(lng[i]),
            }
        }
        createMarker(e);
    }
}

function createMarker(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    console.log(e.latlng);
    // Ajout du point à la liste des points
    points.push([lng, lat]); // Attention à l'ordre lng, lat pour Turf.js

    // Création du marqueur
    var marker = L.marker(e.latlng).addTo(map);
    markers.push(marker);

    // Ajout d'un événement au clic sur le marqueur pour le supprimer
    marker.on('click', function() {
        deleteMarker(marker);
    });

    // Recalculer le polygone avec l'enveloppe convexe
    updatePolygon();
}

function updatePolygon() {
    // Créer un FeatureCollection à partir des points
    var pointsGeoJSON = turf.featureCollection(points.map(function(point) {
        return turf.point(point);
    }));
    
    console.log(pointsGeoJSON);
    // Calculer l'enveloppe convexe
    var convexHull = turf.convex(pointsGeoJSON);
    console.log(convexHull);
    if (convexHull) {
        // Obtenir les coordonnées de l'enveloppe convexe et réordonner les points du polygone
        var latlngs = convexHull.geometry.coordinates[0].map(function(coord) {
            return [coord[1], coord[0]]; // Remettre dans l'ordre lat, lng pour Leaflet
        });
        // Mettre à jour le polygone avec les nouveaux points
        polygon.setLatLngs(latlngs);
        var lat=[];
        var lng=[];

        for(var i=0;i<latlngs.length;i++){
            lat.push(latlngs[i][0]);
            lng.push(latlngs[i][1]);
        }
        document.querySelector('#zone_add').disabled=false;
        document.querySelector('#zone_latitude').value=lat;
        document.querySelector('#zone_longitude').value=lng;
    }
}

function deleteMarker(marker) {
    // Suppression du marqueur de la carte
    map.removeLayer(marker);

    // Retirer le point correspondant dans la liste des points
    var lat = marker.getLatLng().lat;
    var lng = marker.getLatLng().lng;
    points = points.filter(function(point) {
        return !(point[1] === lat && point[0] === lng);
    });

    // Recalculer le polygone
    updatePolygon();
}

function constructExistZone(zones){
    console.log(zones);
    for(key  in  zones){
        var cover=[];
        for(var j=0;j<zones[key].latitude.length;j++){
            cover.push([zones[key].latitude[j],zones[key].longitude[j]]);
        }
        var oldPolygon=L.polygon(cover,{
            color: 'black',
            className: 'zone'
        }).addTo(map);
        var center = oldPolygon.getBounds().getCenter();
        oldPolygon.bindTooltip(zones[key].nom, { 
            permanent: true,   // Permet d'afficher le tooltip en permanence
            direction: 'center', // Centrer le tooltip par rapport à la position
            className: 'custom-tooltip'  // Vous pouvez personnaliser le style du tooltip
        }).openTooltip(center);
    }
}