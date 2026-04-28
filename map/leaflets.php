<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dagupan Outage Map</title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css"
    />

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css"
    />

    <style>

        body{
            margin:0;
            padding:0;
        }

        #map{
            height:100vh;
            width:100%;
        }

        .custom-popup{
            font-family: Arial;
        }

    </style>
</head>
<body>

<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

<script>

    // Create map centered on Dagupan
    const map = L.map('map').setView([16.0433, 120.3333], 13);

    // Map tiles
    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '© OpenStreetMap Contributors'
        }
    ).addTo(map);

    // Marker clusters
    const clusterGroup = L.markerClusterGroup();

    /*
        CUSTOM ICONS
    */

    const powerIcon = L.icon({

        iconUrl:
        'https://cdn-icons-png.flaticon.com/512/1048/1048953.png',

        iconSize: [45,45],
        iconAnchor: [22,45],
        popupAnchor: [0,-40]

    });

    const fireIcon = L.icon({

        iconUrl:
        'https://cdn-icons-png.flaticon.com/512/482/482502.png',

        iconSize: [45,45],
        iconAnchor: [22,45],
        popupAnchor: [0,-40]

    });

    const warningIcon = L.icon({

        iconUrl:
        'https://cdn-icons-png.flaticon.com/512/564/564619.png',

        iconSize: [45,45],
        iconAnchor: [22,45],
        popupAnchor: [0,-40]

    });

    /*
        REPORTS AROUND DAGUPAN
    */

    const reports = [

        {
            lat:16.0433,
            lng:120.3333,
            type:"power",
            title:"Major Power Outage",
            location:"Downtown Dagupan",
            severity:"Critical"
        },

        {
            lat:16.0475,
            lng:120.3405,
            type:"fire",
            title:"Electrical Fire",
            location:"Bonuan Gueset",
            severity:"High"
        },

        {
            lat:16.0380,
            lng:120.3265,
            type:"warning",
            title:"Low Voltage",
            location:"Lucao",
            severity:"Moderate"
        },

        {
            lat:16.0522,
            lng:120.3369,
            type:"power",
            title:"Transformer Explosion",
            location:"Tapuac",
            severity:"Critical"
        },

        {
            lat:16.0415,
            lng:120.3470,
            type:"warning",
            title:"Power Fluctuation",
            location:"Mangin",
            severity:"Low"
        }

    ];

    /*
        ADD MARKERS
    */

    reports.forEach(report => {

        let selectedIcon;

        if(report.type === "power"){

            selectedIcon = powerIcon;

        } else if(report.type === "fire"){

            selectedIcon = fireIcon;

        } else {

            selectedIcon = warningIcon;

        }

        const marker = L.marker(
            [report.lat, report.lng],
            {
                icon:selectedIcon
            }
        );

        marker.bindPopup(`
            <div class="custom-popup">

                <h3>${report.title}</h3>

                <p>
                    <b>Location:</b>
                    ${report.location}
                </p>

                <p>
                    <b>Severity:</b>
                    ${report.severity}
                </p>

            </div>
        `);

        clusterGroup.addLayer(marker);

    });

    // Add clusters to map
    map.addLayer(clusterGroup);

</script>

</body>
</html>