<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            [
                "number" => 1,
                "name" => "Alabama/N.W. Florida",
                "website" => "http://www.aaarea1.org"
            ],
            [
                "number" => 2,
                "name" => "Alaska",
                "website" => "http://www.area02alaska.org"
            ],
            [
                "number" => 3,
                "name" => "Arizona",
                "website" => "http://www.area03.org"
            ],
            [
                "number" => 4,
                "name" => "Arkansas",
                "website" => "http://www.arkansasaa.org"
            ],
            [
                "number" => 5,
                "name" => "Southern California",
                "website" => "http://www.area05aa.org"
            ],
            [
                "number" => 6,
                "name" => "Northern Coastal California",
                "website" => "http://www.cnca06.org"
            ],
            [
                "number" => 7,
                "name" => "Northern Interior California",
                "website" => "http://www.cnia.org"
            ],
            [
                "number" => 8,
                "name" => "San Diego/Imperial California",
                "website" => "http://www.area8aa.org"
            ],
            [
                "number" => 9,
                "name" => "Mid-Southern California",
                "website" => "http://www.msca09aa.org"
            ],
            [
                "number" => 10,
                "name" => "Colorado",
                "website" => "http://www.coloradoaa.org"
            ],
            [
                "number" => 11,
                "name" => "Connecticut",
                "website" => "http://www.ct-aa.org"
            ],
            [
                "number" => 12,
                "name" => "Delaware",
                "website" => "http://www.delawareaa.org"
            ],
            [
                "number" => 13,
                "name" => "District Of Columbia",
                "website" => "http://www.area13aa.org"
            ],
            [
                "number" => 14,
                "name" => "North Florida",
                "website" => "http://www.aanorthflorida.org"
            ],
            [
                "number" => 15,
                "name" => "So. Florida/Bahamas/US V.I./Antigua",
                "website" => "http://www.area15aa.org"
            ],
            [
                "number" => 16,
                "name" => "Georgia",
                "website" => "http://www.aageorgia.org"
            ],
            [
                "number" => 17,
                "name" => "Hawaii",
                "website" => "http://www.area17aa.org"
            ],
            [
                "number" => 18,
                "name" => "Idaho",
                "website" => "http://www.idahoarea18aa.org"
            ],
            [
                "number" => 19,
                "name" => "Chicago Illinois",
                "website" => "http://www.chicagoaa.org"
            ],
            [
                "number" => 20,
                "name" => "Northern Illinois",
                "website" => "http://www.aa-nia.org"
            ],
            [
                "number" => 21,
                "name" => "Southern Illinois",
                "website" => "http://area21aa.org"
            ],
            [
                "number" => 22,
                "name" => "Northern Indiana",
                "website" => "http://www.area22indiana.org"
            ],
            [
                "number" => 23,
                "name" => "Southern Indiana",
                "website" => "http://www.area23aa.org"
            ],
            [
                "number" => 24,
                "name" => "Iowa",
                "website" => "http://www.aa-iowa.org"
            ],
            [
                "number" => 25,
                "name" => "Kansas",
                "website" => "https://ks-aa.org/"
            ],
            [
                "number" => 26,
                "name" => "Kentucky",
                "website" => "http://www.area26.net"
            ],
            [
                "number" => 27,
                "name" => "Louisiana",
                "website" => "http://www.aa-louisiana.org"
            ],
            [
                "number" => 28,
                "name" => "Maine",
                "website" => "http://www.maineaa.org"
            ],
            [
                "number" => 29,
                "name" => "Maryland",
                "website" => "http://www.marylandaa.org"
            ],
            [
                "number" => 30,
                "name" => "Eastern Massachusetts",
                "website" => "http://www.aaemass.org"
            ],
            [
                "number" => 31,
                "name" => "Western Massachusetts",
                "website" => "http://www.area31AA.org"
            ],
            [
                "number" => 32,
                "name" => "Central Michigan",
                "website" => "http://www.cmia32.org"
            ],
            [
                "number" => 33,
                "name" => "Southeastern Michigan",
                "website" => "http://www.aa-semi.org"
            ],
            [
                "number" => 34,
                "name" => "Western Michigan",
                "website" => "http://area34aa.org"
            ],
            [
                "number" => 35,
                "name" => "Northern Minnesota",
                "website" => "http://www.area35.org"
            ],
            [
                "number" => 36,
                "name" => "Southern Minnesota",
                "website" => "http://www.area36.org"
            ],
            [
                "number" => 37,
                "name" => "Mississippi",
                "website" => "http://www.aa-mississippi.org"
            ],
            [
                "number" => 38,
                "name" => "Eastern Missouri",
                "website" => "http://www.eamo.org"
            ],
            [
                "number" => 39,
                "name" => "Western Missouri",
                "website" => "http://www.wamo-aa.org"
            ],
            [
                "number" => 40,
                "name" => "Montana",
                "website" => "http://www.aa-montana.org"
            ],
            [
                "number" => 41,
                "name" => "Nebraska",
                "website" => "http://www.area41.org"
            ],
            [
                "number" => 42,
                "name" => "Nevada",
                "website" => "http://www.nevadaarea42.org"
            ],
            [
                "number" => 43,
                "name" => "New Hampshire",
                "website" => "http://www.nhaa.net"
            ],
            [
                "number" => 44,
                "name" => "Northern New Jersey",
                "website" => "http://www.nnjaa.org"
            ],
            [
                "number" => 45,
                "name" => "Southern New Jersey",
                "website" => "http://www.snjaa.org"
            ],
            [
                "number" => 46,
                "name" => "New Mexico",
                "website" => "http://www.nm-aa.org"
            ],
            [
                "number" => 47,
                "name" => "Central New York",
                "website" => "http://www.aacny.org"
            ],
            [
                "number" => 48,
                "name" => "NENY Area Association",
                "website" => "http://www.aahmbny.org"
            ],
            [
                "number" => 49,
                "name" => "Southeast New York",
                "website" => "http://www.aaseny.org"
            ],
            [
                "number" => 50,
                "name" => "Western New York",
                "website" => "http://www.area50wny.org"
            ],
            [
                "number" => 51,
                "name" => "New York",
                "website" => "http://www.aaseny.org"
            ],
            [
                "number" => 52,
                "name" => "Western New York",
                "website" => "http://www.area50wny.org"
            ],
            [
                "number" => 53,
                "name" => "North Carolina",
                "website" => "http://www.aanorthcarolina.org"
            ],
            [
                "number" => 54,
                "name" => "Northeast Ohio",
                "website" => "http://www.area54.org"
            ],
            [
                "number" => 55,
                "name" => "Central & Southeast Ohio",
                "website" => "http://www.area55aa.org"
            ],
            [
                "number" => 56,
                "name" => "Southern Ohio",
                "website" => "http://www.aaarea56.org"
            ],
            [
                "number" => 57,
                "name" => "Western Pennsylvania",
                "website" => "http://www.wpaarea60.org"
            ],
            [
                "number" => 58,
                "name" => "Eastern Pennsylvania",
                "website" => "http://www.area59aa.org"
            ],
            [
                "number" => 59,
                "name" => "Rhode Island",
                "website" => "http://www.rhodeisland-aa.org"
            ],
            [
                "number" => 60,
                "name" => "South Carolina",
                "website" => "http://www.area62.org"
            ],
            [
                "number" => 61,
                "name" => "South Dakota",
                "website" => "http://www.area63aa.org"
            ],
            [
                "number" => 62,
                "name" => "East Tennessee",
                "website" => "http://www.etiaa.org"
            ],
            [
                "number" => 63,
                "name" => "Middle Tennessee",
                "website" => "http://www.area64.org"
            ],
            [
                "number" => 64,
                "name" => "West Tennessee",
                "website" => "http://www.area64.org"
            ],
            [
                "number" => 65,
                "name" => "Southeast Texas",
                "website" => "http://www.seta-aa.org"
            ],
            [
                "number" => 66,
                "name" => "Southwest Texas",
                "website" => "http://www.swta.org"
            ],
            [
                "number" => 67,
                "name" => "Texas Gulf Coast",
                "website" => "http://www.area67.org"
            ],
            [
                "number" => 68,
                "name" => "Central Texas",
                "website" => "http://www.aaarea68.org"
            ],
            [
                "number" => 69,
                "name" => "Utah",
                "website" => "http://www.utahaa.org"
            ],
            [
                "number" => 70,
                "name" => "Vermont",
                "website" => "http://www.aavt.org"
            ],
            [
                "number" => 71,
                "name" => "Virginia",
                "website" => "http://www.area71.org"
            ],
            [
                "number" => 72,
                "name" => "Western Washington",
                "website" => "http://www.area72aa.org"
            ],
            [
                "number" => 73,
                "name" => "Eastern Washington",
                "website" => "http://www.area92aa.org"
            ],
            [
                "number" => 74,
                "name" => "West Virginia",
                "website" => "http://www.aawv.org"
            ],
            [
                "number" => 75,
                "name" => "Southern Wisconsin",
                "website" => "http://www.area75.org"
            ],
            [
                "number" => 76,
                "name" => "Northern Wisconsin/Upper Peninsula of Michigan",
                "website" => "http://www.area74.org"
            ],
            [
                "number" => 77,
                "name" => "Wyoming",
                "website" => "http://www.area76aa.org"
            ],
            [
                "number" => 78,
                "name" => "Quebec",
                "website" => "http://www.aa-quebec.org"
            ],
            [
                "number" => 79,
                "name" => "Southeastern Ontario",
                "website" => "http://www.seoaa.org"
            ],
            [
                "number" => 80,
                "name" => "Northeastern Ontario",
                "website" => "http://www.area84aa.org"
            ],
            [
                "number" => 81,
                "name" => "Western Ontario",
                "website" => "http://www.area86aa.org"
            ],
            [
                "number" => 82,
                "name" => "Northwest Territories",
                "website" => "http://www.area82aa.org"
            ],
            [
                "number" => 83,
                "name" => "Newfoundland/Labrador",
                "website" => "http://www.area83aa.org"
            ],
            [
                "number" => 84,
                "name" => "Nova Scotia",
                "website" => "http://www.area84aa.org"
            ],
            [
                "number" => 85,
                "name" => "New Brunswick",
                "website" => "http://www.area85aa.org"
            ],
            [
                "number" => 86,
                "name" => "Prince Edward Island",
                "website" => "http://www.area86aa.org"
            ],
            [
                "number" => 87,
                "name" => "Yukon",
                "website" => "http://www.area87aa.org"
            ],
            [
                "number" => 88,
                "name" => "Saskatchewan",
                "website" => "http://www.area88aa.org"
            ],
            [
                "number" => 89,
                "name" => "Manitoba",
                "website" => "http://www.area89aa.org"
            ],
            [
                "number" => 90,
                "name" => "British Columbia/Yukon",
                "website" => "http://www.area90aa.org"
            ],
            [
                "number" => 91,
                "name" => "Alberta/NWT",
                "website" => "http://www.area91aa.org"
            ],
            [
                "number" => 92,
                "name" => "Nunavut",
                "website" => "http://www.area92aa.org"
            ],
            [
                "number" => 93,
                "name" => "Southwest California",
                "website" => "http://www.area93aa.org"
            ],
            [
                "number" => 94,
                "name" => "Northwest California",
                "website" => "http://www.area94aa.org"
            ],
            [
                "number" => 95,
                "name" => "Southeast California",
                "website" => "http://www.area95aa.org"
            ],
            [
                "number" => 96,
                "name" => "Central California",
                "website" => "http://www.area96aa.org"
            ],
            [
                "number" => 97,
                "name" => "Northeast California",
                "website" => "http://www.area97aa.org"
            ],
            [
                "number" => 98,
                "name" => "Southwest Nevada",
                "website" => "http://www.area98aa.org"
            ],
            [
                "number" => 99,
                "name" => "Northwest Nevada",
                "website" => "http://www.area99aa.org"
            ],
            [
                "number" => 100,
                "name" => "Southeast Nevada",
                "website" => "http://www.area100aa.org"
            ]
    ]);
    }
}
