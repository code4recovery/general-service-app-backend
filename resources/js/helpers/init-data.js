export async function initData() {
    const [mapData, position] = await Promise.all([
        fetch("/storage/map.json"),
        fetch("https://ipapi.co/json"),
    ]);

    const areas = await mapData.json();

    const { latitude, longitude } = await position.json();

    const userPosition = new google.maps.LatLng(latitude, longitude);

    return { areas, userPosition };
}
