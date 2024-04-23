<?php

namespace App\Http\Controllers;

use App\Models\salle;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\seance;
use App\Models\filiere;
use App\Models\formateur;
use Illuminate\Http\Request;
use App\Models\FormateurGroupe;
use App\Models\FormateurModule;
use App\Models\FiliereFormateur;

class valideExporter extends Controller
{
    public function valideExporter(){
            $emplois = emploi::all();
            $filieres = filiere::all();
            $derniereEmploi = emploi::latest()->first();
            $id_emploi="";
            if($derniereEmploi){
                $id_emploi =$derniereEmploi->id;
                $date_debu = $derniereEmploi->date_debu;
            }
            // $groupes = groupe::all();
            // $formateurs = formateur::all();
            $formateurs = formateur::where('status', 'oui')->get();
            $salles = salle::all();

            // Get the selected formateur

            // Get seances data based on selected formateur
            $seances = seance::where('id_emploi', $id_emploi)
                                ->with('module')
                                ->get();

            $groupes = FormateurGroupe::whereHas('groupe', function ($query) {
                        $query->where('stage', 'non');
                    })
                    ->with('groupe')
                    ->get();


                    $modules = FormateurModule::where('status', 'oui')
                            ->with('module')
                            ->get();
            $groupesorigine = groupe::all();
            $niveaux = Groupe::select('Niveau')->distinct()->pluck('Niveau');


            $formateurFiliere = FiliereFormateur::with('filiere')->get();

            return view('valideExporte', compact("formateurs", 'id_emploi', 'seances', 'groupes', 'salles','filieres','modules','groupesorigine','niveaux','emplois','formateurFiliere','derniereEmploi','date_debu'));

    }

    public function valideExporterPost(Request $request){
        $emplois = emploi::all();
        $filieres = filiere::all();
        // dd($request->emploi);
        if ($request->emploi) {
            $derniereEmploi = emploi::where('id', $request->emploi)->first();
        }

        $id_emploi = "";
        if($derniereEmploi){
            $id_emploi = $derniereEmploi->id;
            $date_debu = $derniereEmploi->date_debu;
        }

        // $groupes = groupe::all();
        // $formateurs = formateur::all();
        $formateurs = formateur::where('status', 'oui')->get();
        $salles = salle::all();

        // Get the selected formateur

        // Get seances data based on selected formateur
        $seances = seance::where('id_emploi', $id_emploi)
                            ->with('module')
                            ->get();

        $groupes = FormateurGroupe::whereHas('groupe', function ($query) {
                    $query->where('stage', 'non');
                })
                ->with('groupe')
                ->get();


                $modules = FormateurModule::where('status', 'oui')
                        ->with('module')
                        ->get();
        $groupesorigine = groupe::all();
        $niveaux = Groupe::select('Niveau')->distinct()->pluck('Niveau');

        $formateurFiliere = FiliereFormateur::with('filiere')->get();


        return view('valideExporte', compact("formateurs", 'id_emploi', 'seances', 'groupes', 'salles','filieres','modules','groupesorigine','niveaux','emplois','formateurFiliere','derniereEmploi','date_debu'));

}
}
