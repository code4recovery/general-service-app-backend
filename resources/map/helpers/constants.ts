// supported
const supportedLanguages = ["en", "es", "fr"];
const browserLanguage = navigator.language.split("-")[0];
export const language = supportedLanguages.includes(browserLanguage)
  ? browserLanguage
  : "en";

const dictionary = {
  en: {
    findMe: "Find Me",
    errorGeocoding: "Address not found",
    errorGeolocation: "Geolocation is not available",
    search: "Search for an address",
  },
  es: {
    findMe: "Encuéntrame",
    errorGeocoding: "Dirección no encontrada",
    errorGeolocation: "La geolocalización no está disponible",
    search: "Buscar una dirección",
  },
  fr: {
    findMe: "Trouve Moi",
    errorGeocoding: "Adresse introuvable",
    errorGeolocation: "La géolocalisation n'est pas disponible",
    search: "Rechercher une adresse",
  },
};

export const strings = dictionary[language as keyof typeof dictionary];
