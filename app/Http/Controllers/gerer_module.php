<?php

namespace App\Http\Controllers;

use App\Models\module;
use App\Models\formateur;
use Illuminate\Http\Request;

class gerer_module extends Controller
{
    public function gererModule(){
        $modules = module::with('formateur')->paginate(999);
        // $groupes = Groupe::with('filiere')->paginate(99999);
        $formateurs = formateur::all();
        return view('gererModules',compact('formateurs','modules'));
    }

    public function addModule(Request $request){
            // Validate the incoming request data
       $validatedData = $request->validate([
           'nom_module' => 'required|string|max:255',
           'intitule' => 'required|string|max:255', // Adjust validation rules as needed
        //    'formateur_id' => 'required'
           // Add more validation rules for other form fields if necessary
       ]);

       // Create a new formateur using the validated data
       module::create($validatedData);

       // Redirect to the appropriate route after creating the formateur
       return redirect()->route('gererModule');
    }

    public function updateModule(Request $request,module $module){
        $validatedData = $request->validate([
            'nom_module' => 'required|string|max:255',
            'intitule' => 'required|string|max:255', // Adjust validation rules as needed
            // Add more validation rules for other form fields if necessary
        ]);
        $module->fill($validatedData)->save();
        return redirect()->route('gererModule');
    }

    public function deleteModule(module $module){
        $module->delete();
        return redirect()->route('gererModule');
    }
    public function activate(module $module)
    {
        $module->update(['active' => 'oui']);
        return redirect()->back()->with('success', 'Module activated successfully.');
    }

    public function deactivate(module $module)
    {
        $module->update(['active' => 'non']);
        return redirect()->back()->with('success', 'Module deactivated successfully.');
    }
}
