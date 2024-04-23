<?php

namespace App\Http\Controllers;

use App\Models\module;
use App\Models\formateur;
use Illuminate\Http\Request;
use App\Models\FormateurGroupe;
use App\Models\FormateurModule;
use App\Models\FiliereFormateur;

class gerer_formateur extends Controller
{
    public function showGererFormateur(){
        $formateurs = formateur::paginate(121111111);
        $modules = module::paginate(111111112);
        $FormateurModules = FormateurModule::with('formateur', 'module')->paginate(999);
        $FormateurGroupes = FormateurGroupe::with('formateur','groupe')->paginate(999);
        $FormateurFilieres = FiliereFormateur::with('formateur', 'filiere')->paginate(999);

        return view('gererFormateur',compact('formateurs','modules','FormateurModules','FormateurGroupes','FormateurFilieres'));
    }
    public function addFormateur(Request $request){
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255', // Adjust validation rules as needed
        'prenom' => 'required|string|max:255',
        // Add more validation rules for other form fields if necessary
    ]);
    // Create a new formateur using the validated data
    formateur::create($validatedData);

    // Redirect to the appropriate route after creating the formateur
    return redirect()->route('showGereFormateur');
    }
    public function deleteFormateur(formateur $formateur){
        $formateur->delete();
        return redirect()->route('showGereFormateur');

    }
    public function showUpdateFormateur(formateur $formateur){
        $idFormateur = $formateur->id;
        $formateurs = formateur::paginate(121111111);
        return view('showUpdateFormateur',compact('formateurs','idFormateur', 'formateur'));
    }
    public function updateFormateur(Request $request,formateur $formateur){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',// Adjust validation rules as needed
            'prenom' => 'required|string|max:255',
            // Add more validation rules for other form fields if necessary
        ]);
        $formateur->fill($validatedData)->save();
        return redirect()->route('showGereFormateur');
    }

    public function changeStatusFormateur(Request $request, $id)
    {
        $formateur = formateur::findOrFail($id);

        // Toggle the status
        $formateur->status = $formateur->status === 'oui' ? 'non' : 'oui';
        $formateur->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    public function changeCDS(Request $request, $id)
    {
        $formateur = formateur::findOrFail($id);

        // Toggle the status
        $formateur->CDS = $formateur->CDS === 'oui' ? 'non' : 'oui';
        $formateur->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }


}
