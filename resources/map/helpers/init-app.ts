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
    const defaultArea = embedElement.hasAttribute("data-area")
        ? parseInt(embedElement.getAttribute("data-area") as string)
        : undefined;

    return { mapElement, panelElement, defaultArea };
}
