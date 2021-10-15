<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = Point::all();

        return view('points.index', ['points' => $points]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('points.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'point' => 'required',
        ]);

        $point = new Point();
        $point->name = $request->input('name');
        $point->description = $request->input('description');
        $point->point = $request->input('point');
        $point->save();

        $request->session()->flash('message', 'El Punto fue creado correctamente.');

        return redirect(route('points.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        return view('points.edit', ['point' => $point]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        $point->name = $request->input('name');
        $point->description = $request->input('description');
        $point->point = $request->input('point');
        $point->save();

        return redirect(route('points.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        $point->delete();

        return redirect(route('points.index'));
    }

    public function addPointsToUser(REquest $request)
    {
        $pointsIds = $request->input('puntos');
        $userId = $request->input('user');

        $currentPeriod = Period::getCurrentPeriod();

        $user = User::find($userId);
        foreach ($pointsIds as $k => $pointsId) {
            $pointsIds[$k] = [
                'point_id'=>$pointsId,
                'period_id'=> $currentPeriod[0]->id,
                'created_at' => Carbon::now()
            ];
        }
        $user->points()->attach($pointsIds);
    }
}
