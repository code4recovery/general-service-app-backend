import { polygonDefaultStyle, polygonSelectedStyle } from "./styles.ts";

import { District } from "./types.ts";

export function selectDistricts({
    districts,
    map,
    selected,
}: {
    districts: District[];
    map: google.maps.Map;
    selected: District[];
}) {
    // reset all districts
    districts
        .filter((district) => !selected.includes(district))
        .forEach((district) => {
            district.polygon?.setOptions(polygonDefaultStyle);
            district.button.removeAttribute("aria-pressed");
        });

    // reset map if no districts selected
    if (!selected.length) {
        map.setCenter({ lat: 48, lng: -100 });
        map.setZoom(4);

        // remove district and area from query string
        const url = new URL(window.location.href);
        url.searchParams.delete("area");
        url.searchParams.delete("district");
        history.replaceState({}, "", url);

        return;
    }

    // set selected districts
    const bounds = new google.maps.LatLngBounds();
    selected.forEach((district) => {
        district.polygon?.setOptions(polygonSelectedStyle);
        bounds.union(district.bounds);
        if (selected.length === 1) {
            district.button.setAttribute("aria-pressed", "true");

            if (district.areaButton.getAttribute("aria-pressed") !== "true") {
                district.areaItem.setAttribute("aria-expanded", "true");
                district.areaButton.setAttribute("aria-pressed", "true");
            }

            document
                .getElementById("map")
                ?.querySelector("aside")
                ?.scrollTo({
                    top: district.button.offsetTop - 100,
                    behavior: "smooth",
                });
        }
    });

    map.fitBounds(bounds);

    // add district and area to query string
    const url = new URL(window.location.href);
    const selectedAreas = selected
        .map(({ area }) => area)
        .filter((value, index, array) => array.indexOf(value) === index);
    if (selectedAreas.length === 1) {
        url.searchParams.set("area", selectedAreas[0].toString());
    }
    if (selected.length === 1) {
        url.searchParams.set("district", selected[0].district);
    }
    history.replaceState({}, "", url);
}
