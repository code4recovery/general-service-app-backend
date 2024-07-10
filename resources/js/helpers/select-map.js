import { defaultPolygonStyle, selectedPolygonStyle } from "./styles.js";

export function selectMap(map, districts, district) {
    if (district) {
        districts.forEach((district) => {
            district.polygon.setOptions(defaultPolygonStyle);
        });
        district.polygon.setOptions(selectedPolygonStyle);

        const menu = document.getElementById("menu");
        if (menu) {
            menu.value = district.index;
        }

        map.fitBounds(district.bounds);
        return;
    }

    districts.forEach(({ polygon }) => {
        polygon.setOptions(defaultPolygonStyle);
    });
    const totalBounds = new google.maps.LatLngBounds();
    districts.forEach(({ bounds }) => {
        totalBounds.union(bounds);
    });
    map.fitBounds(totalBounds);
}
