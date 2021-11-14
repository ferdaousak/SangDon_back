<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Centre::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'heure_ouv'=> 'required|date_format:H:i',
            'heure_ferm'=> 'required|date_format:H:i|after:heure_ouv',
            'phone_number'=> 'required|numeric|digits:10',
            'ville_id' => 'required|exists:villes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $centre = new Centre;
        $centre->name = $request['name'];
        $centre->address = $request['address'];
        $centre->heure_ouv = $request['heure_ouv'];
        $centre->heure_ferm = $request['heure_ferm'];
        $centre->phone_number = $request['phone_number'];
        $centre->ville_id = $request["ville_id"];

        $centre->save();

        return response($centre);
    }

    public function show(Centre $centre)
    {
        return response($centre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Centre  $centre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Centre $centre)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'heure_ouv'=> 'required|date_format:H:i',
            'heure_ferm'=> 'required|date_format:H:i|after:heure_ouv',
            'phone_number'=> 'required|numeric|digits:10',
            'ville_id' => 'required|exists:villes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $centre->name = $request['name'];
        $centre->address = $request['address'];
        $centre->heure_ouv = $request['heure_ouv'];
        $centre->heure_ferm = $request['heure_ferm'];
        $centre->phone_number = $request['phone_number'];
        $centre->ville_id = $request["ville_id"];

        $centre->save();

        return response($centre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Centre  $centre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Centre $centre)
    {
        $centre->delete();
        return response(["success" => true]);
    }

    public function getCentreByVilleId($ville_id)
    {
        $centre = DB::table('centres')->where('ville_id', $ville_id)->get();
        return response($centre);
    }
    public function centreOuvert()
    {

        $current_time = Carbon::now()->format('H:i');
        $centre = DB::table('centres')->where('heure_ouv','<', $current_time)
                                      ->where('heure_ferm','>', $current_time) ->get();
        return response($centre);
    }
}
