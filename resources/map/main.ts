import { Loader } from "@googlemaps/js-api-loader";

import "./map.css";

import { initApp } from "./helpers/init-app";
import { initClick } from "./helpers/init-click";
import { initData } from "./helpers/init-data";
import { initPanel } from "./helpers/init-panel";
import { initSelected } from "./helpers/init-selected";
import { initZoomButtons } from "./helpers/init-zoom-buttons";
import { selectDistricts } from "./helpers/select-districts";

(async () => {
    const { mapElement, panelElement, defaultArea } = initApp();

    const { Map } = await new Loader({
        // @ts-ignore
        apiKey: import.meta.env.VITE_GOOGLE,
        libraries: ["geometry"],
    }).importLibrary("maps");

    const map = new Map(mapElement, {
        disableDefaultUI: true,
        renderingType: google.maps.RenderingType.VECTOR,
    });

    const marker = new google.maps.Marker({
        map,
    });

    const json = await fetch(`/storage/map.json?${new Date().getTime()}`);

    const data = await json.json();

    const { areas, districts } = initData({ data, map });

    initClick({ districts, map });

    const { selectedArea, selectedDistrict } = initSelected({
        defaultArea,
        areas,
    });

    if (!selectedArea && !selectedDistrict) {
        map.setOptions({ center: { lat: 45, lng: -100 }, zoom: 4 });
    }

    initPanel({
        areas,
        districts,
        map,
        marker,
        panelElement,
        selectedArea,
        selectedDistrict,
    });

    initZoomButtons(map);
})();
