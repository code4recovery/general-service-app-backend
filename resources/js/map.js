import { initClick } from "./helpers/init-click.js";
import { initControls } from "./helpers/init-controls.js";
import { initDistricts } from "./helpers/init-districts.js";
import { selectMap } from "./helpers/select-map.js";

async function initMap() {
    const [{ Map }, { AdvancedMarkerElement, PinElement }] = await Promise.all([
        google.maps.importLibrary("maps"),
        google.maps.importLibrary("marker"),
        google.maps.importLibrary("geometry"),
    ]);

    const map = new Map(document.getElementById("map"), {
        disableDefaultUI: true,
        zoomControl: window.innerWidth > 500,
        mapId: "d1b0f3f",
    });

    // get map data
    const mapData = await fetch(`/storage/map.json?${new Date().getTime()}`);
    const areas = await mapData.json();

    const marker = new AdvancedMarkerElement({
        content: new PinElement().element,
        map,
    });

    const districts = initDistricts(map, areas);
    initClick(map, districts);

    selectMap(map, districts);

    initControls(map, areas, districts, marker);
}

initMap();
