export type Area = {
    area: number;
    name: string;
    website: string;
    districts: District[];

    // added in init-data.ts
    button: HTMLButtonElement;
    item: HTMLLIElement;
};

export type District = {
    id: number;
    district: string;
    name: string | null;
    description: string | null;
    website: string | null;
    language: "en" | "es" | "fr";
    color: string;
    boundary: [number, number][];
    area: number;

    // added in init-data.ts
    areaButton: HTMLButtonElement;
    areaItem: HTMLLIElement;
    bounds: google.maps.LatLngBounds;
    button: HTMLButtonElement;
    polygon: google.maps.Polygon;
    surfaceArea: number;
};
