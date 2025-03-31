import { District } from "./types";

export function getDistrictAtPoint({
  districts,
  point,
}: {
  districts: District[];
  point: google.maps.LatLng;
}) {
  const containingDistricts = districts.filter(({ polygon }) =>
    google.maps.geometry.poly.containsLocation(point, polygon)
  );
  if (!containingDistricts.length) {
    return null;
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
