<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Entity;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $areas = [
            [
                "area" => 1,
                "name" => "Alabama/N.W. Florida",
                "website" => "http://www.aaarea1.org"
            ],
            [
                "area" => 2,
                "name" => "Alaska",
                "website" => "http://www.area02alaska.org"
            ],
            [
                "area" => 3,
                "name" => "Arizona",
                "website" => "http://www.area03.org"
            ],
            [
                "area" => 4,
                "name" => "Arkansas",
                "website" => "http://www.arkansasaa.org"
            ],
            [
                "area" => 5,
                "name" => "Southern California",
                "website" => "http://www.area05aa.org"
            ],
            [
                "area" => 6,
                "name" => "Northern Coastal California",
                "website" => "http://www.cnca06.org"
            ],
            [
                "area" => 7,
                "name" => "Northern Interior California",
                "website" => "http://www.cnia.org"
            ],
            [
                "area" => 8,
                "name" => "San Diego/Imperial California",
                "website" => "http://www.area8aa.org"
            ],
            [
                "area" => 9,
                "name" => "Mid-Southern California",
                "website" => "http://www.msca09aa.org"
            ],
            [
                "area" => 10,
                "name" => "Colorado",
                "website" => "http://www.coloradoaa.org"
            ],
            [
                "area" => 11,
                "name" => "Connecticut",
                "website" => "http://www.ct-aa.org"
            ],
            [
                "area" => 12,
                "name" => "Delaware",
                "website" => "http://www.delawareaa.org"
            ],
            [
                "area" => 13,
                "name" => "District Of Columbia",
                "website" => "http://www.area13aa.org"
            ],
            [
                "area" => 14,
                "name" => "North Florida",
                "website" => "http://www.aanorthflorida.org"
            ],
            [
                "area" => 15,
                "name" => "So. Florida/Bahamas/US V.I./Antigua",
                "website" => "http://www.area15aa.org"
            ],
            [
                "area" => 16,
                "name" => "Georgia",
                "website" => "http://www.aageorgia.org"
            ],
            [
                "area" => 17,
                "name" => "Hawaii",
                "website" => "http://www.area17aa.org"
            ],
            [
                "area" => 18,
                "name" => "Idaho",
                "website" => "http://www.idahoarea18aa.org"
            ],
            [
                "area" => 19,
                "name" => "Chicago Illinois",
                "website" => "http://www.chicagoaa.org"
            ],
            [
                "area" => 20,
                "name" => "Northern Illinois",
                "website" => "http://www.aa-nia.org"
            ],
            [
                "area" => 21,
                "name" => "Southern Illinois",
                "website" => "http://area21aa.org"
            ],
            [
                "area" => 22,
                "name" => "Northern Indiana",
                "website" => "http://www.area22indiana.org"
            ],
            [
                "area" => 23,
                "name" => "Southern Indiana",
                "website" => "http://www.area23aa.org"
            ],
            [
                "area" => 24,
                "name" => "Iowa",
                "website" => "http://www.aa-iowa.org"
            ],
            [
                "area" => 25,
                "name" => "Kansas",
                "website" => "https://ks-aa.org/"
            ],
            [
                "area" => 26,
                "name" => "Kentucky",
                "website" => "http://www.area26.net"
            ],
            [
                "area" => 27,
                "name" => "Louisiana",
                "website" => "http://www.aa-louisiana.org"
            ],
            [
                "area" => 28,
                "name" => "Maine",
                "website" => "http://www.maineaa.org"
            ],
            [
                "area" => 29,
                "name" => "Maryland",
                "website" => "http://www.marylandaa.org"
            ],
            [
                "area" => 30,
                "name" => "Eastern Massachusetts",
                "website" => "http://www.aaemass.org"
            ],
            [
                "area" => 31,
                "name" => "Western Massachusetts",
                "website" => "http://www.area31AA.org"
            ],
            [
                "area" => 32,
                "name" => "Central Michigan",
                "website" => "http://www.cmia32.org"
            ],
            [
                "area" => 33,
                "name" => "Southeastern Michigan",
                "website" => "http://www.aa-semi.org"
            ],
            [
                "area" => 34,
                "name" => "Western Michigan",
                "website" => "http://area34aa.org"
            ],
            [
                "area" => 35,
                "name" => "Northern Minnesota",
                "website" => "http://www.area35.org"
            ],
            [
                "area" => 36,
                "name" => "Southern Minnesota",
                "website" => "http://www.area36.org"
            ],
            [
                "area" => 37,
                "name" => "Mississippi",
                "website" => "http://www.aa-mississippi.org"
            ],
            [
                "area" => 38,
                "name" => "Eastern Missouri",
                "website" => "http://www.eamo.org"
            ],
            [
                "area" => 39,
                "name" => "Western Missouri",
                "website" => "http://www.wamo-aa.org"
            ],
            [
                "area" => 40,
                "name" => "Montana",
                "website" => "http://www.aa-montana.org"
            ],
            [
                "area" => 41,
                "name" => "Nebraska",
                "website" => "http://www.area41.org"
            ],
            [
                "area" => 42,
                "name" => "Nevada",
                "website" => "http://www.nevadaarea42.org"
            ],
            [
                "area" => 43,
                "name" => "New Hampshire",
                "website" => "http://www.nhaa.net"
            ],
            [
                "area" => 44,
                "name" => "Northern New Jersey",
                "website" => "http://www.nnjaa.org"
            ],
            [
                "area" => 45,
                "name" => "Southern New Jersey",
                "website" => "http://www.snjaa.org"
            ],
            [
                "area" => 46,
                "name" => "New Mexico",
                "website" => "http://www.nm-aa.org"
            ],
            [
                "area" => 47,
                "name" => "Central New York",
                "website" => "http://www.aacny.org"
            ],
            [
                "area" => 48,
                "name" => "NENY Area Association",
                "website" => "http://www.aahmbny.org"
            ],
            [
                "area" => 49,
                "name" => "Southeast New York",
                "website" => "http://www.aaseny.org"
            ],
            [
                "area" => 50,
                "name" => "Western New York",
                "website" => "http://www.area50wny.org"
            ],
            [
                "area" => 51,
                "name" => "New York",
                "website" => "http://www.aaseny.org"
            ],
            [
                "area" => 52,
                "name" => "Western New York",
                "website" => "http://www.area50wny.org"
            ],
            [
                "area" => 53,
                "name" => "North Carolina",
                "website" => "http://www.aanorthcarolina.org"
            ],
            [
                "area" => 54,
                "name" => "Northeast Ohio",
                "website" => "http://www.area54.org"
            ],
            [
                "area" => 55,
                "name" => "Central & Southeast Ohio",
                "website" => "http://www.area55aa.org"
            ],
            [
                "area" => 56,
                "name" => "Southern Ohio",
                "website" => "http://www.aaarea56.org"
            ],
            [
                "area" => 57,
                "name" => "Western Pennsylvania",
                "website" => "http://www.wpaarea60.org"
            ],
            [
                "area" => 58,
                "name" => "Eastern Pennsylvania",
                "website" => "http://www.area59aa.org"
            ],
            [
                "area" => 59,
                "name" => "Rhode Island",
                "website" => "http://www.rhodeisland-aa.org"
            ],
            [
                "area" => 60,
                "name" => "South Carolina",
                "website" => "http://www.area62.org"
            ],
            [
                "area" => 61,
                "name" => "South Dakota",
                "website" => "http://www.area63aa.org"
            ],
            [
                "area" => 62,
                "name" => "East Tennessee",
                "website" => "http://www.etiaa.org"
            ],
            [
                "area" => 63,
                "name" => "Middle Tennessee",
                "website" => "http://www.area64.org"
            ],
            [
                "area" => 64,
                "name" => "West Tennessee",
                "website" => "http://www.area64.org"
            ],
            [
                "area" => 65,
                "name" => "Southeast Texas",
                "website" => "http://www.seta-aa.org"
            ],
            [
                "area" => 66,
                "name" => "Southwest Texas",
                "website" => "http://www.swta.org"
            ],
            [
                "area" => 67,
                "name" => "Texas Gulf Coast",
                "website" => "http://www.area67.org"
            ],
            [
                "area" => 68,
                "name" => "Central Texas",
                "website" => "http://www.aaarea68.org"
            ],
            [
                "area" => 69,
                "name" => "Utah",
                "website" => "http://www.utahaa.org"
            ],
            [
                "area" => 70,
                "name" => "Vermont",
                "website" => "http://www.aavt.org"
            ],
            [
                "area" => 71,
                "name" => "Virginia",
                "website" => "http://www.area71.org"
            ],
            [
                "area" => 72,
                "name" => "Western Washington",
                "website" => "http://www.area72aa.org"
            ],
            [
                "area" => 73,
                "name" => "Eastern Washington",
                "website" => "http://www.area92aa.org"
            ],
            [
                "area" => 74,
                "name" => "West Virginia",
                "website" => "http://www.aawv.org"
            ],
            [
                "area" => 75,
                "name" => "Southern Wisconsin",
                "website" => "http://www.area75.org"
            ],
            [
                "area" => 76,
                "name" => "Northern Wisconsin/Upper Peninsula of Michigan",
                "website" => "http://www.area74.org"
            ],
            [
                "area" => 77,
                "name" => "Wyoming",
                "website" => "http://www.area76aa.org"
            ],
            [
                "area" => 78,
                "name" => "Quebec",
                "website" => "http://www.aa-quebec.org"
            ],
            [
                "area" => 79,
                "name" => "Southeastern Ontario",
                "website" => "http://www.seoaa.org"
            ],
            [
                "area" => 80,
                "name" => "Northeastern Ontario",
                "website" => "http://www.area84aa.org"
            ],
            [
                "area" => 81,
                "name" => "Western Ontario",
                "website" => "http://www.area86aa.org"
            ],
            [
                "area" => 82,
                "name" => "Northwest Territories",
                "website" => "http://www.area82aa.org"
            ],
            [
                "area" => 83,
                "name" => "Newfoundland/Labrador",
                "website" => "http://www.area83aa.org"
            ],
            [
                "area" => 84,
                "name" => "Nova Scotia",
                "website" => "http://www.area84aa.org"
            ],
            [
                "area" => 85,
                "name" => "New Brunswick",
                "website" => "http://www.area85aa.org"
            ],
            [
                "area" => 86,
                "name" => "Prince Edward Island",
                "website" => "http://www.area86aa.org"
            ],
            [
                "area" => 87,
                "name" => "Yukon",
                "website" => "http://www.area87aa.org"
            ],
            [
                "area" => 88,
                "name" => "Saskatchewan",
                "website" => "http://www.area88aa.org"
            ],
            [
                "area" => 89,
                "name" => "Manitoba",
                "website" => "http://www.area89aa.org"
            ],
            [
                "area" => 90,
                "name" => "British Columbia/Yukon",
                "website" => "http://www.area90aa.org"
            ],
            [
                "area" => 91,
                "name" => "Alberta/NWT",
                "website" => "http://www.area91aa.org"
            ],
            [
                "area" => 92,
                "name" => "Nunavut",
                "website" => "http://www.area92aa.org"
            ],
            [
                "area" => 93,
                "name" => "Southwest California",
                "website" => "http://www.area93aa.org"
            ],
            [
                "area" => 94,
                "name" => "Northwest California",
                "website" => "http://www.area94aa.org"
            ],
            [
                "area" => 95,
                "name" => "Southeast California",
                "website" => "http://www.area95aa.org"
            ],
            [
                "area" => 96,
                "name" => "Central California",
                "website" => "http://www.area96aa.org"
            ],
            [
                "area" => 97,
                "name" => "Northeast California",
                "website" => "http://www.area97aa.org"
            ],
            [
                "area" => 98,
                "name" => "Southwest Nevada",
                "website" => "http://www.area98aa.org"
            ],
            [
                "area" => 99,
                "name" => "Northwest Nevada",
                "website" => "http://www.area99aa.org"
            ],
            [
                "area" => 100,
                "name" => "Southeast Nevada",
                "website" => "http://www.area100aa.org"
            ]
        ];

        Entity::create([
            'name' => 'General Service Office',
            'website' => 'https://www.aa.org',
            'language' => 'en'
        ]);

        foreach ($areas as $area) {
            Entity::create($area);
        }

        $district = Entity::create([
            'area' => 6,
            'district' => 6,
            'name' => 'San Francisco',
            'banner' => 'https://sfgeneralservice.org/wp-content/uploads/2019/06/cropped-cropped-bigstock-Golden-Gate-Bridge-Aerial-View-213412633.jpg',
            'website' => 'https://sfgeneralservice.org',
            'language' => 'en'
        ]);

        $district->users()->create([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
