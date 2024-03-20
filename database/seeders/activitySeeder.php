<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Activity;

class activitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['alias' => 'activity1', 'lavorata' => false,'padre' => null],
            ['alias' => 'activity1', 'lavorata' => false, 'padre' => 1],
            ['alias' => 'activity2', 'lavorata' => false, 'padre' => 2],
            ['alias' => 'activity3', 'lavorata' => false, 'padre' => 3],
            ['alias' => 'activity4', 'lavorata' => false, 'padre' => 3],
            ['alias' => 'activity5', 'lavorata' => false, 'padre' => 4],
        ];

        foreach ($data as $row) {
            DB::table('activities')->insert([
                'alias' => $row['alias'],
                'lavorata' => $row['lavorata'],
                'padre' => $row['padre'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        }

    }

