<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\salle;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\seance;
use App\Models\filiere;
use App\Models\formateur;
use Illuminate\Http\Request;
use App\Http\Requests\forRequests;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class masterController extends Controller
{
    public function home(){
        return view('home');
    }


    public function showBackUp()
    {
        $latestEmploi = Emploi::latest('date_debu')->first();
        $selectedDate = $latestEmploi ? $latestEmploi->date_debu : null;
        $filieres = filiere::all();
        // $formateurs = Formateur::all();
        $formateurs = formateur::where('status', 'oui')->get();
        $emplois = Emploi::orderBy('date_debu','desc')->get();
        $groupes = Groupe::all();
        $salles = Salle::all();
        $id_emploi = $latestEmploi ? $latestEmploi->id : null;
        $seances = $latestEmploi ? Seance::where('id_emploi', $latestEmploi->id)->get() : collect();
        $selectedType = 'emploi_formateur'; // Set the default selected type
        $filieres = filiere::all();
        $selectedCDJ = 'CDJ';
        // Store the selected date in the session
        session(['selected_date' => $selectedDate]);

        return view('backup', compact("formateurs", 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType', 'filieres','selectedCDJ'));
    }



    public function backup(Request $request)
    {

        // Get the selected date from the request
        $selectedDate = $request->input('selected_date');
        $filieres = filiere::all();
        $selectedCDJ = $request->input('selected_cdj_cds');


        // Store the selected date in the session
        Session::put('selected_date', $selectedDate);

        // Get the selected type from the request
        $selectedType = $request->input('selected_type');

        // Fetch emploi for the selected date
     // Fetch emploi for the selected date
        $emploi = Emploi::where('date_debu', $selectedDate)->first();

        // If no emploi found for the selected date, fetch the latest emploi
        if (!$emploi) {
            $latestEmploi = Emploi::latest('date_debu')->first();

            // Set the default selected date to the latest emploi date
            $selectedDate = $latestEmploi ? $latestEmploi->date_debu : null;
        }

        // Fetch the selected CDJ/CDS from the request
        // Fetch formateurs, groupes, salles
        $formateurs = formateur::where('status', 'oui')->get();
        $groupes = Groupe::all();
        $salles = Salle::all();
        // Fetch seances for the selected emploi
        if ($emploi) {
            $seances = Seance::where('id_emploi', $emploi->id)->get();
            $id_emploi = $emploi->id;
        } else {
            // If no emploi found for the selected date, return an empty collection
            $seances = collect();
            $id_emploi = null;
        }

        // Fetch all emplois (for dropdown)
        $emplois = Emploi::orderBy('date_debu', 'desc')->get();

        // Pass selected date, type, and CDJ/CDS to the view
        return view('backup', compact('formateurs', 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType', 'selectedCDJ', 'filieres'));

    }


    public function filterGroups(Request $request)
    {
        // Validate the request
        $request->validate([
            'school_year' => 'required|string', // Adjust the validation rule based on your expected format
        ]);

        // Retrieve the school year from the request
        $schoolYear = $request->input('school_year');

        // Query the database to retrieve groups based on the provided school year
        $query = Groupe::query()->where('Niveau', $schoolYear);

        // Retrieve the filtered groups
        $filteredGroups = $query->get();

        // Check if any groups are found
        if ($filteredGroups->isEmpty()) {
            // If no groups are found, return an empty array or an appropriate response
            return response()->json([]);
        }

        // Return the filtered groups as JSON response
        return response()->json($filteredGroups);
    }

public function getGroupesByFiliere($filiereId)
{
    $groupes = Groupe::where('filiere_id', $filiereId)->get();
    return response()->json($groupes);
}

}
