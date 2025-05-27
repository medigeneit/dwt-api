<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/colleges.csv');

        $data = array_map('str_getcsv', file($path));
        $header = array_map('strtolower', array_shift($data));

        foreach ($data as $row) {
            $collegeData = array_combine($header, $row);

            College::updateOrCreate(
                ['code' => $collegeData['code']],
                [
                    'name' => $collegeData['name'],
                    'university' => $collegeData['university'],
                    'location' => $collegeData['location'],
                    'ownership_type' => $collegeData['ownership_type'],
                    'institute_type' => $collegeData['institute_type'],
                    'status' => $collegeData['status'] ?? 'active',
                ]
            );
        }
    }
}
