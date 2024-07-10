import { selectMap } from "./select-map";

export function initClick(map, districts) {
    districts.forEach((district) => {
        district.polygon.addListener("click", ({ latLng }) => {
            const clickedDistricts = districts
                .filter(({ polygon }) =>
                    google.maps.geometry.poly.containsLocation(latLng, polygon)
                )
                .sort((a, b) => a.area - b.area);
            selectMap(map, districts, clickedDistricts[0]);
        });
    });
}
