var zones=[];
var equipementsGlobal;
var map;

function createMap(zones, equipements){
    // Initialisation de la carte
    map = L.map('map').setView([49.118480, -1.066835], 20);

    // Ajout des tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);
    console.log(equipements);
    equipementsGlobal=equipements;
    console.log(zones);
    for(var i=0;i<zones.length;i++){
        createZone(zones[i]);
    }
}

function createZone(zone){
    var color="black";
    var popUpText=`<h2>${zone.nom}</h2>`;
    if(zone.nom.includes("terrain")){
        var equipements=equipementsGlobal.filter(value=> value.position==zone.nom);
        popUpText+=`<h4>Équipements présents ici: </h4><ul>`;
        if(equipements.length==0) popUpText+="<li>Il n'y a rien dans ce terrain</li>";
        for (let i = 0; i < equipements.length; i++) {
            popUpText+=`
            <li>${equipements[i].nom}</li>
            `;
        }
        popUpText+=`</ul>`;
        color="red";
    }
    else if(zone.nom.includes("batiment")){
        for(const [key,value] of Object.entries(zone.rayons)){
            popUpText+=`<h4>Rayon ${value.nom}</h4>`;
            popUpText+=createEmplacementTable(value, zone.nom);
        }
        color="blue";
    }
    var polygon=L.polygon(zone.coord,{
        color: color,
    }).addTo(map);
    polygon.bindPopup(popUpText);
    zones[zone.nom]=polygon;

    var center = polygon.getBounds().getCenter();

    polygon.bindTooltip(zone.nom, { 
        permanent: true,   // Permet d'afficher le tooltip en permanence
        direction: 'center', // Centrer le tooltip par rapport à la position
        className: 'custom-tooltip'  // Vous pouvez personnaliser le style du tooltip
    }).openTooltip(center);
}

function createEmplacementTable(rayon, nom){
    console.log(rayon);
    var popUpText="<table>";
    for(var y=1;y<=rayon.dimension[0];y++){
        popUpText+="<tr>";
        for(var x=1;x<=rayon.dimension[1];x++){
            var emplacement=rayon.emplacements.find((value)=> value.colone==x && value.etage==y);
            if(emplacement!= undefined){
                var equipement=equipementsGlobal.find((value)=> value.id==emplacement.equipement);
                if(equipement.position==nom) popUpText+=`<td><div class="la">${equipement.nom}</div></td>`;
                else popUpText+=`<td><div class="pasLa">${equipement.nom} au ${equipement.position}</div></td>`;

            }
            else{
                popUpText+=`<td><div class="aucun">Aucun équipements rataché</div></td>`;
            }
        }
        popUpText+="</tr>";
    }
    popUpText+=`</table>`;
    return popUpText;
}

function createTableEquipmentIn(){

}