import { selectDistricts } from "./select-districts.ts";

import { District } from "./types";

export function initClick({
  districts,
  map,
}: {
  districts: District[];
  map: google.maps.Map;
}) {
  districts.forEach(({ polygon }) =>
    polygon.addListener(
      "click",
      ({ latLng }: { latLng: google.maps.LatLng }) => {
        // find the smallest district containing the click
        const selected = districts
          .filter(({ polygon }) =>
            google.maps.geometry.poly.containsLocation(latLng, polygon)
          )
          .sort((a, b) => a.surfaceArea - b.surfaceArea);
        selectDistricts({ map, districts, selected: [selected[0]] });
      }
    )
  );
}
