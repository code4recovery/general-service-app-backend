export function initApp() {
    const embedElement = document.getElementById("map");

    if (!embedElement) {
        throw Error("No map element found");
    }

    const mapElement = document.createElement("main");

    const panelElement = document.createElement("aside");
    Object.assign(panelElement.style);
    embedElement.appendChild(panelElement);
    embedElement.appendChild(mapElement);

    // if the map element has a data-area attribute, use that as the selected area
    let selectedArea = embedElement.hasAttribute("data-area")
        ? parseInt(embedElement.getAttribute("data-area") as string)
        : null;

    // but override with URL param
    const urlParams = new URLSearchParams(window.location.search);
    const area = urlParams.get("area");
    if (area) {
        selectedArea = parseInt(area);
    }

    return { mapElement, panelElement, selectedArea };
}
