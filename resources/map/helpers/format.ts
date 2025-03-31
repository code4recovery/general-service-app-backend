import { Area, District } from "./types";

export function formatAreaName({ area, name }: Area) {
  return `${area.toString().padStart(2, "0")}: ${name}`;
}

export function formatDistrictName({ district, name }: District) {
  if (name) {
    return `${district}: ${name}`;
  }
  return `District ${district}`;
}
