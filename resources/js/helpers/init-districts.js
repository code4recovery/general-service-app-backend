import { defaultPolygonStyle } from "./styles.js";

export function initDistricts(map, areas) {
    return areas
        .map((area) => {
            return area.districts.map((district) => {
                district.index = `${area.area}-${district.district}`;

                district.paths = district.boundary.map(([lng, lat]) => ({
                    lat,
                    lng,
                }));

                district.polygon = new google.maps.Polygon({
                    ...defaultPolygonStyle,
                    paths: district.paths,
                    fillColor: district.color,
                    strokeColor: district.color,
                });

                district.area = google.maps.geometry.spherical.computeArea(
                    district.paths
                );

                district.bounds = district.paths.reduce(
                    (bounds, { lat, lng }) => {
                        bounds.extend(new google.maps.LatLng(lat, lng));
                        return bounds;
                    },
                    new google.maps.LatLngBounds()
                );

                district.polygon.setMap(map);

                return district;
            });
        })
        .flat();
}
