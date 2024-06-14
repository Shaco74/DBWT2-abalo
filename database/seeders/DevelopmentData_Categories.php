<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SplFileObject;

//P4 T5: Seeder for article_has_articlecategory
class DevelopmentData_Categories extends Seeder
{
    public function run()
    {
        $file = new SplFileObject(storage_path('seeding/development/article_has_articlecategory.csv'));
        $file->setCsvControl(';');
        $file->setFlags(SplFileObject::READ_CSV);


        foreach ($file as $row) {
            DB::table('ab_article_has_articlecategory')->insert([
                'ab_articlecategory_id' => intval($row[0]),
                'ab_article_id' => intval($row[1]),
            ]);
        }
    }
}
