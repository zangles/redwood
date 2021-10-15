<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Point;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $players = User::orderBy('name')->get();
        $points = Point::all();

        return view('dashboard', ['players' => $players, 'points' => $points]);
    }

    public function userDashboard($userId = null)
    {
        if (auth()->user()->belongsToTeam(Team::find(env('ADMIN_TEAM_ID')))){
            if (!is_null($userId)) {
                $user = User::find($userId);
            } else {
                $user = auth()->user();
            }
        } else {
            $user = auth()->user();
        }

        $chart = $user->getChartPoints();

        return view('udashboard', ['chart' => $chart, 'user' => $user]);
    }
}

