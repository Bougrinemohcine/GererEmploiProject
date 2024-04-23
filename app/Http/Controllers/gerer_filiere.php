<?php

namespace App\Http\Controllers;

use App\Models\filiere;
use Illuminate\Http\Request;

class gerer_filiere extends Controller
{
    public function gereFiliere(){
        $filieres = filiere::paginate(11111111);
        return view('gererFiliere',compact('filieres'));
    }
    public function showAddFiliere(){
        $filieres = filiere::paginate(11111111);
        return view('addFiliere',compact('filieres'));
    }
    public function addFiliere(Request $request){
         // Validate the incoming request data
    $validatedData = $request->validate([
        'nom_filier' => 'required|string|max:255',
        'niveau_formation' => 'required|string|max:255', // Adjust validation rules as needed
        'mode_formation' => 'required|string|max:255'
        // Add more validation rules for other form fields if necessary
    ]);

    // Create a new formateur using the validated data
    filiere::create($validatedData);

    // Redirect to the appropriate route after creating the formateur
    return redirect()->route('gererFiliere');
    }
    public function showUpdateFiliere(filiere $filiere){
        $idFiliere = $filiere->id;
        $filieres = filiere::paginate(11111111);
        return view('showUpdateFiliere',compact('filieres','filiere','idFiliere'));
    }
    public function updateFiliere(Request $request,filiere $filiere){
        $validatedData = $request->validate([
            'nom_filier' => 'required',
            'niveau_formation' => 'required|string|max:255', // Adjust validation rules as needed
            'mode_formation' => 'required|string|max:255' // Adjust validation rules as needed
            // Add more validation rules for other form fields if necessary
        ]);
        $filiere->fill($validatedData)->save();
        return redirect()->route('gererFiliere');
    }
    public function deleteFiliere(filiere $filiere){
        $filiere->delete();
        return redirect()->route('gererFiliere');
    }
}
