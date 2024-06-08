<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            [
                "id" => 1,
                "name" => "Alabama/N.W. Florida",
                "website" => "http://www.aaarea1.org"
            ],
            [
                "id" => 2,
                "name" => "Alaska",
                "website" => "http://www.area02alaska.org"
            ],
            [
                "id" => 3,
                "name" => "Arizona",
                "website" => "http://www.area03.org"
            ],
            [
                "id" => 4,
                "name" => "Arkansas",
                "website" => "http://www.arkansasaa.org"
            ],
            [
                "id" => 5,
                "name" => "Southern California",
                "website" => "http://www.area05aa.org"
            ],
            [
                "id" => 6,
                "name" => "Northern Coastal California",
                "website" => "http://www.cnca06.org"
            ],
            [
                "id" => 7,
                "name" => "Northern Interior California",
                "website" => "http://www.cnia.org"
            ],
            [
                "id" => 8,
                "name" => "San Diego/Imperial California",
                "website" => "http://www.area8aa.org"
            ],
            [
                "id" => 9,
                "name" => "Mid-Southern California",
                "website" => "http://www.msca09aa.org"
            ],
            [
                "id" => 10,
                "name" => "Colorado",
                "website" => "http://www.coloradoaa.org"
            ],
            [
                "id" => 11,
                "name" => "Connecticut",
                "website" => "http://www.ct-aa.org"
            ],
            [
                "id" => 12,
                "name" => "Delaware",
                "website" => "http://www.delawareaa.org"
            ],
            [
                "id" => 13,
                "name" => "District Of Columbia",
                "website" => "http://www.area13aa.org"
            ],
            [
                "id" => 14,
                "name" => "North Florida",
                "website" => "http://www.aanorthflorida.org"
            ],
            [
                "id" => 15,
                "name" => "So. Florida/Bahamas/US V.I./Antigua",
                "website" => "http://www.area15aa.org"
            ],
            [
                "id" => 16,
                "name" => "Georgia",
                "website" => "http://www.aageorgia.org"
            ],
            [
                "id" => 17,
                "name" => "Hawaii",
                "website" => "http://www.area17aa.org"
            ],
            [
                "id" => 18,
                "name" => "Idaho",
                "website" => "http://www.idahoarea18aa.org"
            ],
            [
                "id" => 19,
                "name" => "Chicago Illinois",
                "website" => "http://www.chicagoaa.org"
            ],
            [
                "id" => 20,
                "name" => "Northern Illinois",
                "website" => "http://www.aa-nia.org"
            ],
            [
                "id" => 21,
                "name" => "Southern Illinois",
                "website" => "http://area21aa.org"
            ],
            [
                "id" => 22,
                "name" => "Northern Indiana",
                "website" => "http://www.area22indiana.org"
            ],
            [
                "id" => 23,
                "name" => "Southern Indiana",
                "website" => "http://www.area23aa.org"
            ],
            [
                "id" => 24,
                "name" => "Iowa",
                "website" => "http://www.aa-iowa.org"
            ],
            [
                "id" => 25,
                "name" => "Kansas",
                "website" => "https://ks-aa.org/"
            ],
            [
                "id" => 26,
                "name" => "Kentucky",
                "website" => "http://www.area26.net"
            ],
            [
                "id" => 27,
                "name" => "Louisiana",
                "website" => "http://www.aa-louisiana.org"
            ],
            [
                "id" => 28,
                "name" => "Maine",
                "website" => "http://www.maineaa.org"
            ],
            [
                "id" => 29,
                "name" => "Maryland",
                "website" => "http://www.marylandaa.org"
            ],
            [
                "id" => 30,
                "name" => "Eastern Massachusetts",
                "website" => "http://www.aaemass.org"
            ],
            [
                "id" => 31,
                "name" => "Western Massachusetts",
                "website" => "http://www.area31AA.org"
            ],
            [
                "id" => 32,
                "name" => "Central Michigan",
                "website" => "http://www.cmia32.org"
            ],
            [
                "id" => 33,
                "name" => "Southeastern Michigan",
                "website" => "http://www.aa-semi.org"
            ],
            [
                "id" => 34,
                "name" => "Western Michigan",
                "website" => "http://area34aa.org"
            ],
            [
                "id" => 35,
                "name" => "Northern Minnesota",
                "website" => "http://www.area35.org"
            ],
            [
                "id" => 36,
                "name" => "Southern Minnesota",
                "website" => "http://www.area36.org"
            ],
            [
                "id" => 37,
                "name" => "Mississippi",
                "website" => "http://www.aa-mississippi.org"
            ],
            [
                "id" => 38,
                "name" => "Eastern Missouri",
                "website" => "http://www.eamo.org"
            ],
            [
                "id" => 39,
                "name" => "Western Missouri",
                "website" => "http://www.wamo-aa.org"
            ],
            [
                "id" => 40,
                "name" => "Montana",
                "website" => "http://www.aa-montana.org"
            ],
            [
                "id" => 41,
                "name" => "Nebraska",
                "website" => "http://www.area41.org"
            ],
            [
                "id" => 42,
                "name" => "Nevada",
                "website" => "http://www.nevadaarea42.org"
            ],
            [
                "id" => 43,
                "name" => "New Hampshire",
                "website" => "http://www.nhaa.net"
            ],
            [
                "id" => 44,
                "name" => "Northern New Jersey",
                "website" => "http://www.nnjaa.org"
            ],
            [
                "id" => 45,
                "name" => "Southern New Jersey",
                "website" => "http://www.snjaa.org"
            ],
            [
                "id" => 46,
                "name" => "New Mexico",
                "website" => "http://www.nm-aa.org"
            ],
            [
                "id" => 47,
                "name" => "Central New York",
                "website" => "http://www.aacny.org"
            ],
            [
                "id" => 48,
                "name" => "NENY Area Association",
                "website" => "http://www.aahmbny.org"
            ],
            [
                "id" => 49,
                "name" => "Southeast New York",
                "website" => "http://www.aaseny.org"
            ],
            [
                "id" => 50,
                "name" => "Western New York",
                "website" => "http://www.area50wny.org"
            ],
            [
                "id" => 51,
                "name" => "New York",
                "website" => "http://www.aaseny.org"
            ],
            [
                "id" => 52,
                "name" => "Western New York",
                "website" => "http://www.area50wny.org"
            ],
            [
                "id" => 53,
                "name" => "North Carolina",
                "website" => "http://www.aanorthcarolina.org"
            ],
            [
                "id" => 54,
                "name" => "Northeast Ohio",
                "website" => "http://www.area54.org"
            ],
            [
                "id" => 55,
                "name" => "Central & Southeast Ohio",
                "website" => "http://www.area55aa.org"
            ],
            [
                "id" => 56,
                "name" => "Southern Ohio",
                "website" => "http://www.aaarea56.org"
            ],
            [
                "id" => 57,
                "name" => "Western Pennsylvania",
                "website" => "http://www.wpaarea60.org"
            ],
            [
                "id" => 58,
                "name" => "Eastern Pennsylvania",
                "website" => "http://www.area59aa.org"
            ],
            [
                "id" => 59,
                "name" => "Rhode Island",
                "website" => "http://www.rhodeisland-aa.org"
            ],
            [
                "id" => 60,
                "name" => "South Carolina",
                "website" => "http://www.area62.org"
            ],
            [
                "id" => 61,
                "name" => "South Dakota",
                "website" => "http://www.area63aa.org"
            ],
            [
                "id" => 62,
                "name" => "East Tennessee",
                "website" => "http://www.etiaa.org"
            ],
            [
                "id" => 63,
                "name" => "Middle Tennessee",
                "website" => "http://www.area64.org"
            ],
            [
                "id" => 64,
                "name" => "West Tennessee",
                "website" => "http://www.area64.org"
            ],
            [
                "id" => 65,
                "name" => "Southeast Texas",
                "website" => "http://www.seta-aa.org"
            ],
            [
                "id" => 66,
                "name" => "Southwest Texas",
                "website" => "http://www.swta.org"
            ],
            [
                "id" => 67,
                "name" => "Texas Gulf Coast",
                "website" => "http://www.area67.org"
            ],
            [
                "id" => 68,
                "name" => "Central Texas",
                "website" => "http://www.aaarea68.org"
            ],
            [
                "id" => 69,
                "name" => "Utah",
                "website" => "http://www.utahaa.org"
            ],
            [
                "id" => 70,
                "name" => "Vermont",
                "website" => "http://www.aavt.org"
            ],
            [
                "id" => 71,
                "name" => "Virginia",
                "website" => "http://www.area71.org"
            ],
            [
                "id" => 72,
                "name" => "Western Washington",
                "website" => "http://www.area72aa.org"
            ],
            [
                "id" => 73,
                "name" => "Eastern Washington",
                "website" => "http://www.area92aa.org"
            ],
            [
                "id" => 74,
                "name" => "West Virginia",
                "website" => "http://www.aawv.org"
            ],
            [
                "id" => 75,
                "name" => "Southern Wisconsin",
                "website" => "http://www.area75.org"
            ],
            [
                "id" => 76,
                "name" => "Northern Wisconsin/Upper Peninsula of Michigan",
                "website" => "http://www.area74.org"
            ],
            [
                "id" => 77,
                "name" => "Wyoming",
                "website" => "http://www.area76aa.org"
            ],
            [
                "id" => 78,
                "name" => "Quebec",
                "website" => "http://www.aa-quebec.org"
            ],
            [
                "id" => 79,
                "name" => "Southeastern Ontario",
                "website" => "http://www.seoaa.org"
            ],
            [
                "id" => 80,
                "name" => "Northeastern Ontario",
                "website" => "http://www.area84aa.org"
            ],
            [
                "id" => 81,
                "name" => "Western Ontario",
                "website" => "http://www.area86aa.org"
            ],
            [
                "id" => 82,
                "name" => "Northwest Territories",
                "website" => "http://www.area82aa.org"
            ],
            [
                "id" => 83,
                "name" => "Newfoundland/Labrador",
                "website" => "http://www.area83aa.org"
            ],
            [
                "id" => 84,
                "name" => "Nova Scotia",
                "website" => "http://www.area84aa.org"
            ],
            [
                "id" => 85,
                "name" => "New Brunswick",
                "website" => "http://www.area85aa.org"
            ],
            [
                "id" => 86,
                "name" => "Prince Edward Island",
                "website" => "http://www.area86aa.org"
            ],
            [
                "id" => 87,
                "name" => "Yukon",
                "website" => "http://www.area87aa.org"
            ],
            [
                "id" => 88,
                "name" => "Saskatchewan",
                "website" => "http://www.area88aa.org"
            ],
            [
                "id" => 89,
                "name" => "Manitoba",
                "website" => "http://www.area89aa.org"
            ],
            [
                "id" => 90,
                "name" => "British Columbia/Yukon",
                "website" => "http://www.area90aa.org"
            ],
            [
                "id" => 91,
                "name" => "Alberta/NWT",
                "website" => "http://www.area91aa.org"
            ],
            [
                "id" => 92,
                "name" => "Nunavut",
                "website" => "http://www.area92aa.org"
            ],
            [
                "id" => 93,
                "name" => "Southwest California",
                "website" => "http://www.area93aa.org"
            ],
            [
                "id" => 94,
                "name" => "Northwest California",
                "website" => "http://www.area94aa.org"
            ],
            [
                "id" => 95,
                "name" => "Southeast California",
                "website" => "http://www.area95aa.org"
            ],
            [
                "id" => 96,
                "name" => "Central California",
                "website" => "http://www.area96aa.org"
            ],
            [
                "id" => 97,
                "name" => "Northeast California",
                "website" => "http://www.area97aa.org"
            ],
            [
                "id" => 98,
                "name" => "Southwest Nevada",
                "website" => "http://www.area98aa.org"
            ],
            [
                "id" => 99,
                "name" => "Northwest Nevada",
                "website" => "http://www.area99aa.org"
            ],
            [
                "id" => 100,
                "name" => "Southeast Nevada",
                "website" => "http://www.area100aa.org"
            ]
        ]);

        DB::table('districts')->insert([
            'area_id' => 6,
            'number' => 6,
            'name' => 'San Francisco',
            'website' => 'https://sfgeneralservice.org',
            'timezone' => 'America/Los_Angeles',
            'language' => 'en'
        ]);

        DB::table('users')->insert([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);

        DB::table('district_user')->insert([
            'district_id' => 1,
            'user_id' => 1,
        ]);
    }
}
