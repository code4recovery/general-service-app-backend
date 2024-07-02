let map;

async function initMap() {
    const {
        Map
    } = await google.maps.importLibrary("maps");

    map = new Map(document.getElementById("map"), {
        center: {
            lat: 50,
            lng: -95
        },
        disableDefaultUI: true,
        mapId: "b0e99130d7895350",
        zoom: 4,
        zoomControl: true,
    });
}

initMap();

