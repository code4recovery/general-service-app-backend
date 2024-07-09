let districts;
let map;

import { defaultPolygonStyle, selectedPolygonStyle } from "./helpers.js";

async function initMap() {
    const [{ Map }] = await Promise.all([
        google.maps.importLibrary("maps"),
        google.maps.importLibrary("geometry"),
    ]);

    map = new Map(document.getElementById("map"), {
        disableDefaultUI: true,
        zoomControl: true,
    });

    const { data, userPosition } = await initData();

    districts = initDistricts(data);

    const userDistrict = initUserDistrict(userPosition);
    if (userDistrict) {
        selectDistrict(userDistrict);
    } else {
        selectAll();
    }

    initMenu(userDistrict);
}

initMap();

async function initData() {
    const apiKey = import.meta.env.VITE_GOOGLE_API_KEY;
    const sheetId = "1h_NttpifenTqUEbb0OxdCA0F5tmbQOXoKy8MJeVg4VU";

    const [sheetData, position] = await Promise.all([
        fetch(
            `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/A1:ZZ?key=${apiKey}`
        ),
        fetch("https://ipapi.co/json"),
    ]);

    const { values: data } = await sheetData.json();

    const { latitude, longitude } = await position.json();

    const userPosition = new google.maps.LatLng(latitude, longitude);

    return { data, userPosition };
}

function initDistricts([headers, ...rows]) {
    // load districts
    return rows.map((row, index) => {
        const district = {};
        row.forEach((value, index) => {
            const header = headers[index];
            district[header] = value;
        });

        district.index = index;

        // create the polygon
        district.paths = district.polygon
            .substring(10, district.polygon.length - 2)
            .split(", ")
            .map((point) => {
                const [lng, lat] = point.split(" ");
                return { lat: parseFloat(lat), lng: parseFloat(lng) };
            });

        district.polygon = new google.maps.Polygon({
            ...defaultPolygonStyle,
            paths: district.paths,
            fillColor: district.color,
            strokeColor: district.color,
        });

        district.area = google.maps.geometry.spherical.computeArea(
            district.paths
        );

        district.bounds = district.paths.reduce((bounds, { lat, lng }) => {
            bounds.extend(new google.maps.LatLng(lat, lng));
            return bounds;
        }, new google.maps.LatLngBounds());

        district.polygon.setMap(map);

        google.maps.event.addListener(
            district.polygon,
            "click",
            function ({ latLng }) {
                // get the smallest containing district
                const containingDistricts = districts
                    .filter(({ polygon }) =>
                        google.maps.geometry.poly.containsLocation(
                            latLng,
                            polygon
                        )
                    )
                    .sort((a, b) => a.area - b.area);
                selectDistrict(containingDistricts[0], districts);
            }
        );

        return district;
    });
}

function initMenu(userDistrict) {
    const select = document.createElement("select");
    select.id = "menu";
    const option = document.createElement("option");
    option.value = "";
    option.innerText = "Select a district";
    select.appendChild(option);
    districts.forEach(({ district, index, name }) => {
        const option = document.createElement("option");
        option.value = index;
        option.innerText = `${district.padStart(2, "0")} ${name}`;
        if (userDistrict && userDistrict.index === index) {
            option.selected = true;
        }
        select.appendChild(option);
    });
    select.onchange = ({ target }) => {
        if (target.value) {
            const selectedDistrict = districts.find(
                ({ index }) => index === parseInt(target.value)
            );
            selectDistrict(selectedDistrict);
        } else {
            selectAll();
        }
    };
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(select);
}

function initUserDistrict(userPosition) {
    const containingDistricts = districts.filter(({ polygon }) =>
        google.maps.geometry.poly.containsLocation(userPosition, polygon)
    );
    if (!containingDistricts.length) {
        return false;
    }
    if (containingDistricts.length > 1) {
        const userLanguage = navigator.language.split("-")[0];
        const languageDistrict = containingDistricts.find(
            ({ language }) => language === userLanguage
        );
        if (languageDistrict) {
            return languageDistrict;
        }
    }
    return containingDistricts[0];
}

function selectAll() {
    districts.forEach(({ polygon }) => {
        polygon.setOptions(defaultPolygonStyle);
    });
    const totalBounds = new google.maps.LatLngBounds();
    districts.forEach(({ bounds }) => {
        totalBounds.union(bounds);
    });
    map.fitBounds(totalBounds);
}

function selectDistrict(district) {
    districts.forEach((district) => {
        district.polygon.setOptions(defaultPolygonStyle);
    });
    district.polygon.setOptions(selectedPolygonStyle);

    const menu = document.getElementById("menu");
    if (menu) {
        menu.value = district.index;
    }

    map.fitBounds(district.bounds);
}
