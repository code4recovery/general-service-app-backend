import type { District } from "../helpers/types";

export function initSelected({
    defaultArea: selectedArea,
    areas,
}: {
    defaultArea?: number;
    areas: { area: number; districts: District[] }[];
}) {
    // override default area with URL param
    const urlParams = new URLSearchParams(window.location.search);

    const area = urlParams.get("area");
    if (area) {
        selectedArea = parseInt(area);
    }

    let selectedDistrict;

    const district = urlParams.get("district");
    if (district) {
        selectedDistrict = areas
            .find(({ area }) => area === selectedArea)
            ?.districts?.find(({ district: d }) => d === district);
    }

    return { selectedArea, selectedDistrict };
}
