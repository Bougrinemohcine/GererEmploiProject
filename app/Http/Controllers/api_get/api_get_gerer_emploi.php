<?php

namespace App\Http\Controllers\api_get;

use App\Http\Controllers\Controller;
use App\Models\seance;
use Illuminate\Http\Request;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\salle;
use App\Models\formateur;
class api_get_gerer_emploi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function afficher_emploi_par_formateur(Request $request)
    {
        $formateurId = $request->formateurId;
        $derniereEmploi = emploi::latest()->first();
        $id_emploi="";
        if($derniereEmploi){
            $id_emploi = $derniereEmploi->id;
        }
        $groupes = groupe::all();
        $salles = salle::all();
        // Get the selected formateur
        $selectedFormateur = formateur::findOrFail($formateurId);
        // Get seances data based on selected formateur
        $seances=[];
        if($selectedFormateur){
            $seances = seance::where('id_emploi', $id_emploi)
            ->where('id_formateur', $formateurId)
            ->get();
        }
        if ($seances->isNotEmpty()) {
            foreach ($seances as $seance) {
                // Assign the associated group using the relationship method
                $seance->groupe = $seance->groupe()->first();
                $seance->salle = $seance->salle()->first();
            }
        }
        $datas=[
            'groupes'=>$groupes,
            'id_emploi'=>$id_emploi,
          'seances'=>$seances,
         'salles'=>$salles,
         'selectedFormateur'=>$selectedFormateur
        ];
        return response()->json($datas);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function afficher_message()
    {
        return response()->json(["message"=>"succes"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(seance $seance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(seance $seance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, seance $seance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(seance $seance)
    {
        //
    }
}
