<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = ['RedWood 1','ADMINS','RedWood 2','Pendiente'];

        foreach ($teams as $team) {
            $id = DB::table('teams')->insert([
                'name' => $team,
                'personal_team' => 0,
                'user_id' => 1,
            ]);
        }
    }
}
