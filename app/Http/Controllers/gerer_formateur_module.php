<?php

namespace App\Http\Controllers;

use App\Models\groupe;
use App\Models\module;
use App\Models\filiere;
use App\Models\formateur;
use App\Models\GroupeModule;
use Illuminate\Http\Request;
use App\Models\FormateurGroupe;
use App\Models\FormateurModule;
use App\Models\FiliereFormateur;

class gerer_formateur_module extends Controller
{


    public function GroupeModule(){
        $FormateurModules = FormateurModule::all();
        $GroupeModules = GroupeModule::all();
        $formateurGroupes = FormateurGroupe::all();
        $filieres = filiere::all();
        $groupes = groupe::all();
        $formateurs = formateur::all();
        $modules = module::all();
        $niveaux = $groupes->pluck('Niveau')->unique();
        return view('AffectationGroupeModule',compact('modules','formateurs','groupes','filieres','niveaux','formateurGroupes','GroupeModules','FormateurModules'));
    }
    public function FormateurFiliere(){
        $filieres = filiere::all();
        $formateurs = formateur::all();
        $FiliereFormateurs = FiliereFormateur::all();
        return view('AffectationFiliereFormateur',compact('formateurs','filieres','FiliereFormateurs'));
    }
    public function FormateurGroupe(){
        $FormateurModules = FormateurModule::all();
        $GroupeModules = GroupeModule::all();
        $formateurGroupes = FormateurGroupe::all();
        $filieres = filiere::all();
        $groupes = groupe::all();
        $formateurs = formateur::all();
        $modules = module::all();
        $niveaux = $groupes->pluck('Niveau')->unique();
        return view('AffectationFormateurGroupe',compact('modules','formateurs','groupes','filieres','niveaux','formateurGroupes','GroupeModules','FormateurModules'));
    }
    public function FormateurModule(){
        $FormateurModules = FormateurModule::all();
        $GroupeModules = GroupeModule::all();
        $formateurGroupes = FormateurGroupe::all();
        $filieres = filiere::all();
        $groupes = groupe::all();
        $formateurs = formateur::all();
        $modules = module::all();
        $niveaux = $groupes->pluck('Niveau')->unique();
        return view('AffectationFormateurModule',compact('modules','formateurs','groupes','filieres','niveaux','formateurGroupes','GroupeModules','FormateurModules'));
    }
    public function assignModules(Request $request)
{
    $formateur = Formateur::findOrFail($request->input('formateur_id'));
    $modules = Module::whereIn('id', $request->input('modules'))->get();

    $formateur->modules()->syncWithoutDetaching($modules);

    return redirect()->back();
}

    public function assignGroupes(Request $request){
        $formateur = Formateur::findOrFail($request->input('formateur_id'));
        $groupes = groupe::whereIn('id', $request->input('groupes'))->get();
        // $formateur->groupes()->sync($groupes);
        $formateur->groupes()->syncWithoutDetaching($groupes);
        return redirect()->back();
    }

   public function assignGroupesModules(Request $request)
    {
        $groupes = groupe::findOrFail($request->input('groupeModule'));

        $modules = Module::whereIn('id', $request->input('moduleGroupe'))->get();

        $groupes->modules()->syncWithoutDetaching($modules);

        return redirect()->back();
    }

    public function assignFilieresFormateur(Request $request){

        $formateur = Formateur::findOrFail($request->input('formateur_id'));
        $filieres = filiere::whereIn('id',$request->input('filiereFiliere'))->get();

        $formateur->filieres()->syncWithoutDetaching($filieres);
        return redirect()->back();
    }
public function statusModules(){
    // $FormateurModules = FormateurModule::all();
    $FormateurModules = FormateurModule::with('formateur', 'module')->paginate(999);
    return view('gererStatusModules',compact('FormateurModules'));
}
public function statusGroupes(){
    $FormateurGroupes = FormateurGroupe::with('formateur', 'groupe')->paginate(999);
    return view('gererStatusGroupes',compact('FormateurGroupes'));
}
public function statusFilieres(){
    $FormateurFilieres = FiliereFormateur::with('formateur', 'filiere')->paginate(999);
    return view('gererStatusFilieres',compact('FormateurFilieres'));
}
public function changeStatus(Request $request, $id)
{
    $formateurModule = FormateurModule::findOrFail($id);

    // Toggle the status
    $formateurModule->status = $formateurModule->status === 'oui' ? 'non' : 'oui';
    $formateurModule->save();

    return redirect()->back()->with('success', 'Status updated successfully.');
}

public function getModules($groupeId)
{
    // Fetch modules for the specified groupe ID
    $modules = GroupeModule::where('groupe_id', $groupeId)->with('module')->get();

    return response()->json($modules);
}
public function getAllModules()
{
    $modules = Module::all();
    return response()->json($modules);
}

public function destroyFormateurModule(FormateurModule $formateurModule)
{
    $formateurModule->delete();

    return redirect()->back()->with('success', 'Module deleted successfully');
}

public function destroyFormateurGroupe(FormateurGroupe $formateurGroupe)
{
    $formateurGroupe->delete();

    return redirect()->back()->with('success', 'Module deleted successfully');
}
    public function destroyFormateurFiliere(Request $request){
        // dd($request->formateurFiliere);
        FiliereFormateur::where('id',$request->formateurFiliere)->delete();
        return redirect()->back()->with('success', 'Module deleted successfully');
    }


}
