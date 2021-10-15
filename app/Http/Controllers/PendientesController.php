<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Role;

class PendientesController extends Controller
{
    public function index()
    {
        $players = User::all();

        $team  = Team::find(env('PENDING_TEAM_ID'));
        $users = $team->allUsers();

        $users = $users->filter(function($user) {
            return !$user->belongsToTeam(Team::find(env('ADMIN_TEAM_ID')));
        });

        return view('pendientes', ['users' => $users]);
    }

    public function changeTeam(Request $request)
    {
        $user = $request->input('userId');
        $team = $request->input('teamId');

        $user = User::find($user);
        $team = Team::find($team);

        $adminTeam = Team::find(env('ADMIN_TEAM_ID'));
        if (!$user->belongsToTeam($adminTeam) and $team->id != $adminTeam->id) {
            DB::delete('delete from team_user where user_id = ?', [$user->id]);
            DB::insert("insert into team_user (`team_id`,`user_id`,`role`) values(?,?,?)",
                [
                    $team->id,
                    $user->id,
                    'editor'
                ]
            );
            DB::update('update users set current_team_id = ? where id = ?',
                [
                    $team->id,
                    $user->id
                ]
            );
        }

    }
}
