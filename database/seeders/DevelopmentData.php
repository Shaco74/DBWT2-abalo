<?php

namespace Database\Seeders;
use DateTime;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

function parse_timestamp($timestamp, $format = "Y-m-d H:i")
{
    // Format des Eingabedatums explizit angeben
    $timestamp_as_DateTime = DateTime::createFromFormat('d.m.y H:i', $timestamp);
    // Formatieren in das gewünschte Ausgabeformat
    return $timestamp_as_DateTime->format($format);
}

class DevelopmentData extends Seeder
{
    // Info from https://laravel.com/docs/8.x/seeding
    // and Copilot
    public function run(): void
    {
        $userCSV = storage_path('app\public\user.csv');
        $csvData = File::get($userCSV);
        $rows = explode("\n", $csvData);

        array_shift($rows); // remove header (first row)
        foreach ($rows as $row) {
            $data = str_getcsv($row, ';'); // Annahme: Komma als Trennzeichen
            if (count($data) != 4) {
                continue;
            }
            DB::table('ab_user')->insert([
                'ab_name' => $data[1],
                'ab_password' => $data[2],
                'ab_email' => $data[3],
            ]);
        }

        $articleCSV = storage_path('app\public\articles.csv');
        $csvData = File::get($articleCSV);
        $rows = explode("\n", $csvData);

        array_shift($rows);
        foreach ($rows as $row) {
            $data = str_getcsv($row, ';'); // Annahme: Komma als Trennzeichen
            if (count($data) != 6) {
                continue;
            }
            $price_as_String = str_replace('.', '', $data[2]);
            $price = (int)$price_as_String;
            DB::table('ab_article')->insert([
                'ab_name' => $data[1],
                'ab_price' => $price,
                'ab_description' => $data[3],
                'ab_creator_id' => (int)$data[4],
                'ab_createdate' => parse_timestamp($data[5]),
            ]);
        }


        $arcticleCategoryCSV = storage_path('app\public\articlecategory.csv');
        $csvData = File::get($arcticleCategoryCSV);
        $rows = explode("\n", $csvData);

            array_shift($rows);
        foreach ($rows as $row) {
            $data = str_getcsv($row, ';'); // Annahme: Komma als Trennzeichen
            if (count($data) != 3) {
                continue;
            }
            $ab_parent = $data[2];
            if ($ab_parent == 'NULL') {
                $ab_parent = null;
            }
            DB::table('ab_articlecategory')->insert([
                'ab_name' => $data[1],
                'ab_parent' => $ab_parent,
            ]);
        }
    }
}
