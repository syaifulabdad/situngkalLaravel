<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $file_path = resource_path('sql/referensi.sql');
        $file_path = database_path('seeders/sql/referensi.sql');
        DB::unprepared(
            file_get_contents($file_path)
        );

        $file_path = database_path('seeders/sql/wilayah.sql');
        DB::unprepared(
            file_get_contents($file_path)
        );
    }
}
