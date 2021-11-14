<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tsangs = ['0-','0+','A+','A-','B-','B+','AB-','AB+'];

        foreach($tsangs as $ts)
        {
            DB::table('type_sangs')->insert([
                'tsang' => $ts
            ]);
        }
    }
}
