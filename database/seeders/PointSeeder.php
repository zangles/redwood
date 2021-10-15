<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $points = [
          [
              'name' => 'Registro',
              'description' => 'Registro en tablero y en discord',
              'point' => 1
          ],
          [
              'name' => 'Build',
              'description' => 'Build requerida para la guerra',
              'point' => 1
          ],
          [
              'name' => 'Asistencia+',
              'description' => 'Esta presente al momento de armar la guerra',
              'point' => 1
          ],
          [
              'name' => 'Asistencia-',
              'description' => 'Esta ausente al momento de armar la guerra',
              'point' => -3
          ],
        ];

        foreach ($points as $point) {
            DB::table('points')->insert([
                'name' => $point['name'],
                'description' => $point['description'],
                'point' => $point['point'],
            ]);
        }
    }
}
