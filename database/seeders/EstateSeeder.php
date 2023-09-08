<?php

namespace Database\Seeders;

use App\Models\Estate;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        if (!Estate::count()) {
            $csv = Reader::createFromPath(storage_path('app/estates.csv'));

            $skip = true;

            foreach ($csv->getRecords(['name', 'price', 'bedrooms', 'bathrooms', 'storeys', 'garages']) as $row) {
                if ($skip) {
                    $skip = false;
                } else {
                    Estate::create($row);
                }
            }
        }
    }
}
