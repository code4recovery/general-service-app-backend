import { selectMap } from "./select-map";

export function initMenu(map, areas, districts, userDistrict) {
    // create select
    const select = document.createElement("select");
    select.id = "menu";

    // create first option
    const option = document.createElement("option");
    option.value = "";
    option.innerText = "Select a district";
    select.appendChild(option);

    // create option groups for areas
    areas
        .sort((a, b) => a.area - b.area)
        .forEach(({ districts, name, area }) => {
            const optgroup = document.createElement("optgroup");
            const areaNumber = area.toString().padStart(2, "0");
            optgroup.label = `${areaNumber} ${name}`;
            districts
                .sort((a, b) => a.district - b.district)
                .forEach(({ district, name }) => {
                    const option = document.createElement("option");
                    const districtNumber = district.toString();
                    option.value = `${area}-${district}`;
                    option.innerText = name
                        ? `${districtNumber} ${name}`
                        : `District ${districtNumber}`;
                    if (userDistrict?.index === option.value) {
                        option.selected = true;
                    }
                    optgroup.appendChild(option);
                });
            select.appendChild(optgroup);
        });
    select.onchange = ({ target }) => {
        const selectedDistrict = districts.find(
            ({ index }) => index === target.value
        );
        selectMap(map, districts, selectedDistrict);
    };
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(select);
}
