import { initClick } from "./helpers/init-click.js";
import { initData } from "./helpers/init-data.js";
import { initDistricts } from "./helpers/init-districts.js";
import { initMenu } from "./helpers/init-menu.js";
import { initUserDistrict } from "./helpers/init-user-district.js";
import { selectMap } from "./helpers/select-map.js";

async function initMap() {
    const [{ Map }] = await Promise.all([
        google.maps.importLibrary("maps"),
        google.maps.importLibrary("geometry"),
    ]);

    const map = new Map(document.getElementById("map"), {
        disableDefaultUI: true,
        zoomControl: window.innerWidth > 500,
    });

    const { areas, userPosition } = await initData();

    const districts = initDistricts(map, areas);
    initClick(map, districts);

    const userDistrict = initUserDistrict(districts, userPosition);
    selectMap(map, districts, userDistrict);

    initMenu(map, areas, districts, userDistrict);
}

initMap();
