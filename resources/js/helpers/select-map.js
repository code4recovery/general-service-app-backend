import { defaultPolygonStyle, selectedPolygonStyle } from "./styles.js";

export function selectMap(map, districts, district) {
    const menu = document.getElementById("menu");

    if (!district) {
        map.setCenter({ lat: 48, lng: -100 });
        map.setZoom(4);
        if (menu) {
            menu.value = "";
        }

        return;
    }
    districts.forEach((district) => {
        district.polygon.setOptions(defaultPolygonStyle);
    });
    district.polygon.setOptions(selectedPolygonStyle);

    if (menu) {
        menu.value = district.index;
    }

    map.fitBounds(district.bounds);
}
