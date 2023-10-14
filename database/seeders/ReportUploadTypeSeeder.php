<?php

namespace Database\Seeders;

use App\Models\ReportUploadType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportUploadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportUploadType::create([
            'name' => 'Replace'
        ]);
        ReportUploadType::create([
            'name' => 'Append'
        ]);
    }
}
