<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use App\Models\demande;
use App\Models\Don;
use App\Models\Rdv;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Rdv::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_centre' => 'required',
            'date_rdv' => 'required|date'
        ]);

        $rdv = new Rdv();

        $centre = Centre::findOrFail($validated['id_centre']);

        $rdv->centre()->associate($centre);
        $rdv->date_rdv = $validated["date_rdv"];

        $rdv->save();

        return response()->json([
            'msg' => 'Rdv enregistré',
            'rdv' => $rdv
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rdv = Rdv::findOrFail($id);

        return ($rdv);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required'
        ]);

        $rdv = Rdv::findOrFail($id);

        $rdv->date = $validated['date'];

        $rdv->save();

        return response()->json([
            'msg' => 'rdv modifié avec succes'
        ]);
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rdv = Rdv::findOrFail($id);

        $rdv->delete();

        return response()->json([
            'msg' => 'rdv supprimer avec succes'
        ]);
    }
}
