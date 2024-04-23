<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Util\TimeUtil;

/**
 * Class DevelopmentData
 *
 * This class is used to seed development data into the database.
 * It reads data from CSV files and inserts it into the database.
 * See https://laravel.com/docs/8.x/seeding for more information.
 */
class DevelopmentData extends Seeder {
    /**
     * Seeds development data into the database.
     * This method reads data from CSV files and inserts it into the database.
     *
     * @return void
     */
    public function run(): void {
        $this->handleUserCSV();
        $this->handleArticleCSV();
        $this->handleArticleCategoryCSV();
    }

    /**
     * Handles the seeding of user data from a CSV file.
     *
     * @return void
     */
    private function handleUserCSV(): void {
        $userRows = $this->getDataRowsFromFile(storage_path('seeding/development/user.csv'));
        foreach ($userRows as $userEntry) {
            $data = str_getcsv($userEntry, ';');
            $this->processUserRowAndInsert($data);
        }
    }

    /**
     * Gets data rows from a file after removing the header row.
     *
     * @param string $filePath The path of the file from which data rows should be retrieved.
     * @return array The data rows from the file after removing the header row.
     */
    private function getDataRowsFromFile(string $filePath): array {
        $csvData = File::get($filePath);
        $rows = explode("\n", $csvData);
        return $this->removeHeaderRow($rows);
    }

    /**
     * Removes the header row from an array.
     *
     * @param array $rows The array from which the header row should be removed.
     * @return array The array after removing the header row.
     */
    private function removeHeaderRow(array $rows): array {
        array_shift($rows);
        return $rows;
    }

    /**
     * Processes a row of user data and inserts it into the database.
     *
     * @param array $data The row of user data to process.
     * @return void
     */
    private function processUserRowAndInsert(array $data): void {
        if (!$this->hasExpectedColumns($data, 4)) {
            return;
        }
        DB::table('ab_user')->insert([
            'ab_name' => $data[1],
            // TODO: verschlüsselung fehlt
            'ab_password' => $data[2],
            'ab_email' => $data[3],
        ]);
    }

    /**
     * Checks if an array has the expected number of columns.
     *
     * @param array $data The array to check.
     * @param int $expectedColumnCount The expected number of columns.
     * @return bool True if the array has the expected number of columns, false otherwise.
     */
    private function hasExpectedColumns(array $data, int $expectedColumnCount): bool {
        return count($data) === $expectedColumnCount;
    }

    /**
     * Handles the seeding of article data from a CSV file.
     *
     * @return void
     */
    private function handleArticleCSV(): void {
        // TODO: add descriptor
        $articleRows = $this->getDataRowsFromFile(storage_path('seeding/development/articles.csv'));
        foreach ($articleRows as $articleEntry) {
            $data = str_getcsv($articleEntry, ';');
            $this->processArticleRowAndInsert($data);
        }
    }

    /**
     * Processes a row of article data and inserts it into the database.
     *
     * @param array $data The row of article data to process.
     * @return void
     */
    private function processArticleRowAndInsert(array $data): void {
        if (!$this->hasExpectedColumns($data, 6)) {
            return;
        }
        $price_as_String = str_replace('.', '', $data[2]);
        $price = (int)$price_as_String;
        DB::table('ab_article')->insert([
            'ab_name' => $data[1],
            'ab_price' => $price,
            'ab_description' => $data[3],
            'ab_creator_id' => (int)$data[4],
            'ab_createdate' => TimeUtil::parseTimestamp($data[5]),
        ]);
    }

    /**
     * Handles the seeding of article category data from a CSV file.
     *
     * @return void
     */
    private function handleArticleCategoryCSV(): void {
        $articleCategoryRows = $this->getDataRowsFromFile(storage_path('seeding/development/articlecategory.csv'));
        foreach ($articleCategoryRows as $articleCategoryEntry) {
            $data = str_getcsv($articleCategoryEntry, ';');
            $this->processArticleCategoryRowAndInsert($data);
        }
    }

    /**
     * Processes a row of article category data and inserts it into the database.
     *
     * @param array $data The row of article category data to process.
     * @return void
     */
    private function processArticleCategoryRowAndInsert(array $data): void {
        if (!$this->hasExpectedColumns($data, 3)) {
            return;
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
