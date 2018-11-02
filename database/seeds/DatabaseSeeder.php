<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 25; $i++) {
            \Illuminate\Support\Facades\DB::table('api_tuan')->insert([
                'name' => 't' . $i,
                'description'=>'Tuần ' .$i,
            ]);
        }

    }
}
