<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->insertGetId([
            'name' => 'Zangles',
            'email' => 'azuresky07@gmail.com',
            'password' => Hash::make('septiembre08'),
            'current_team_id' => env('ADMIN_TEAM_ID')
        ]);

        DB::insert("insert into team_user (`team_id`,`user_id`,`role`) values(?,?,?)",
            [
                env('ADMIN_TEAM_ID'),
                $id,
                'admin'
            ]
        );

        $this->call([
            TeamSeeder::class,
            PlayerSeeder::class,
            PointSeeder::class,
            PeriodSeeder::class,
        ]);
    }
}
