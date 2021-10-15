<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Period extends Model
{
    use HasFactory;

    public static function getCurrentPeriod()
    {
        $period = DB::table('periods')->whereNull('end_date')->get();
        return $period;
    }
}
