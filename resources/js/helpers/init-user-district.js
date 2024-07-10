export function initUserDistrict(districts, userPosition) {
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
