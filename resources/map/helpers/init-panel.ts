import { getDistrictAtPoint } from "./get-district-at-point.ts";
import { selectDistricts } from "./select-districts.ts";

import { strings } from "./constants.ts";
import { formatAreaName } from "./format.ts";
import { polygonDefaultStyle, polygonHoveredStyle } from "./styles.ts";
import { Area, District } from "./types.ts";

export function initPanel({
    areas,
    districts,
    map,
    marker,
    panelElement,
    selectedArea,
    selectedDistrict,
}: {
    areas: Area[];
    districts: District[];
    map: google.maps.Map;
    marker: google.maps.Marker;
    panelElement: HTMLElement;
    selectedArea?: number;
    selectedDistrict?: District;
}) {
    const form = document.createElement("form");

    const input = document.createElement("input");
    input.type = "search";
    input.placeholder = strings.search;
    form.appendChild(input);

    form.onsubmit = (event) => {
        event.preventDefault();
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: input.value }, (results, status) => {
            if (status !== "OK" || !results) {
                alert(strings.errorGeocoding);
                return;
            }
            const result = results[0];
            input.value = result.formatted_address;
            map.panTo(result.geometry.location);
            marker.setPosition(result.geometry.location);
            const myDistrict = getDistrictAtPoint({
                districts,
                point: result.geometry.location,
            });
            selectDistricts({
                map,
                districts,
                selected: myDistrict ? [myDistrict] : [],
            });
            input.blur();
        });
    };

    panelElement.appendChild(form);

    const findMeButton = document.createElement("button");
    findMeButton.innerText = strings.findMe;
    findMeButton.onclick = () => {
        navigator.geolocation.getCurrentPosition(
            ({ coords: { latitude, longitude } }) => {
                const point = new google.maps.LatLng(latitude, longitude);
                marker.setPosition(point);
                map.panTo(point);
                const myDistrict = getDistrictAtPoint({
                    districts,
                    point,
                });
                selectDistricts({
                    map,
                    districts,
                    selected: myDistrict ? [myDistrict] : [],
                });
                (
                    document.getElementById(
                        "address_search"
                    ) as HTMLInputElement
                ).value = "";
            },
            () => alert(strings.errorGeolocation)
        );
    };
    panelElement.appendChild(findMeButton);

    let selectedAreaButton: HTMLButtonElement | null = null;
    let selectedDistrictButton: HTMLButtonElement | null = null;

    const areaList = document.createElement("ul");
    areaList.role = "tree";
    areaList.ariaLabel = "Areas";

    // create accordion of areas
    areas
        .sort((a, b) => a.area - b.area)
        .forEach((area) => {
            area.item.role = "treeitem";
            area.item.ariaExpanded = "false";

            if (selectedArea === area.area) {
                selectedAreaButton = area.button;
            }

            const districtList = document.createElement("ul");
            districtList.role = "group";

            area.districts.forEach((district) => {
                district.button.onclick = () =>
                    selectDistricts({
                        map,
                        districts,
                        selected: [district],
                    });
                const districtItem = document.createElement("li");
                districtItem.role = "treeitem";
                districtItem.appendChild(district.button);
                districtList.appendChild(districtItem);
                district.button.onmouseenter = () => {
                    district.polygon.setOptions(polygonHoveredStyle);
                };
                district.button.onmouseleave = () => {
                    district.polygon.setOptions(polygonDefaultStyle);
                };

                if (selectedDistrict === district) {
                    selectedDistrictButton = district.button;
                }
            });

            area.button.innerText = formatAreaName(area);
            area.item.appendChild(area.button);
            area.item.appendChild(districtList);

            area.button.onclick = () => {
                // remove marker
                marker.setPosition();

                // collapse other accordions
                areas.forEach((otherArea) => {
                    if (otherArea === area) return;
                    otherArea.button.setAttribute("aria-pressed", "false");
                    otherArea.item.setAttribute("aria-expanded", "false");
                });

                // expand accordion
                if (area.item.getAttribute("aria-expanded") === "false") {
                    area.item.setAttribute("aria-expanded", "true");
                    area.button.setAttribute("aria-pressed", "true");
                    panelElement.scrollTo({
                        top: area.button.offsetTop,
                        behavior: "smooth",
                    });
                    selectDistricts({
                        map,
                        districts,
                        selected: area.districts,
                    });
                    return;
                }

                // collapse accordion
                area.button.setAttribute("aria-pressed", "false");
                area.item.setAttribute("aria-expanded", "false");
                selectDistricts({ map, districts, selected: [] });
            };

            areaList.appendChild(area.item);
        });

    panelElement.appendChild(areaList);

    // expand selected area
    if (selectedDistrictButton) {
        // @ts-ignore
        selectedDistrictButton.click();
    } else if (selectedAreaButton) {
        // @ts-ignore
        selectedAreaButton?.click();
    }
}
