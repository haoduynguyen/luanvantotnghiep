<?php

use Illuminate\Database\Seeder;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1;$i<=25;$i++)
        {
            \Illuminate\Support\Facades\DB::table('users')->insert([
                'role_id' => 1
            ]);
        }
    }
}
