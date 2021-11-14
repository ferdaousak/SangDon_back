<?php

namespace App\Http\Controllers;

use App\Models\demande;
use App\Models\Don;
use App\Models\TypeSang;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DonController extends Controller
{
    /**
     * consulter les dons d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response()->json([
               'dons' => Don::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);
        //creer un nouveau don
        $don = new Don(['adresse' => $validated['adresse']]);
        /*$don->created_at = Carbon::now();
        $don->updated_at = Carbon::now();*/

        $user = User::find($validated['id_user']);
        $type_sang = $user->type_sang;
        
        $don->user()->associate($user);
        $don->type_sang()->associate($type_sang);
        $don->save();

        return response()->json([
            'msg' => 'Don sauveguarder avec succes',
        ]);
    }
    /**
     * Display Dons d'un utilisateur
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function showUserDons($id_user)
    {
        $user = User::find($id_user);
        $dons = $user->dons;

        return response()->json([
            'dons' => $dons,
        ]);
    }

    /**
     * Display une Don
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $don = Don::findOrFail($id);

        return response()->json([
            'don' => $don,
        ]);
    }
    /**
     * Display User statics
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function showDonbyYear($id_user)
    {
        $dons = Don::selectRaw('year(created_at) year, count(*) data')
                                ->where('user_id',$id_user)
                                ->groupBy('year')
                                ->orderBy('year', 'desc')
                                ->get();

        return response()->json([
            'stats' => $dons
            ]);
    }
    
    public function showStats($id_user)
    {
        $dons = DB::table('dons')->where('user_id',$id_user)->count();
        $demandes = DB::table('demandes')->where('id_user',$id_user)->count();

        return response()->json([
            'dons' => $dons,
            'demandes' => $demandes 
            ]);      
    }

    public function timeUntilNextDon($id_user)
    {
        $lastDate = DB::table('dons')
                            ->orderBy('updated_at','desc')
                            ->where('user_id', $id_user)
                            ->value('updated_at');
        if($lastDate == null)
        {
            $lastDate = DB::table('dons')
                            ->orderBy('created_at','desc')
                            ->where('user_id', $id_user)
                            ->value('created_at');
        }
        $currentDate = Carbon::now();
        
        $currentDate =Carbon::createFromFormat('Y-m-d H:s:i', $currentDate);
        $lastDate = Carbon::createFromFormat('Y-m-d H:s:i', $lastDate);

        $different_days = $currentDate->diffInDays($lastDate);

        $canDonate = false;
        if($different_days > 56)
            $canDonate = true;
        return response()->json([
            'current date' => $currentDate->format('Y-m-d'),
            'last date' => $lastDate->format('Y-m-d'),
            'time' => $different_days,
            'canDonate' =>$canDonate

        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'adresse' => 'required|max:255',
        ]);
        try{
            $don = Don::findOrFail($id);
        }catch(Exception $e)
        {
            return response()->json(['err' => "Id not found"]);
        }

        $don->adresse = $validated['adresse'];
        
        $don->save();

        return response()->json([
            'don' => $don,
            'msg' => 'don modifier avec succes'

        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $don = Don::findOrFail($id);

        $don->delete();

        return response()->json([
            'msg' => 'don supprimer avec succes'
        ]);
    }


    private function validated(Request $request)
    {
        $validated = $request->validate([
            'adresse' => 'required|max:255',
            'id_user' => 'required'
        ]);

        return $validated;
    }
}
