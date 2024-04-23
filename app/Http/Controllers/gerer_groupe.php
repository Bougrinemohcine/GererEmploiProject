<?php

namespace App\Http\Controllers;

use App\Models\groupe;
use App\Models\filiere;
use Illuminate\Http\Request;

class gerer_groupe extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function gererGroupe(){
        $groupes = Groupe::with('filiere')->paginate(99999);
        $filieres = Filiere::all(); // Assuming you want to show all filières in the dropdown
        return view('gererGroupe', compact('groupes', 'filieres'));
    }
    public function addGroupe(Request $request){
        $validate=$request->validate([
            "nom_groupe"=>"required",
            "Mode_de_formation"=>"required",
            "Niveau"=>"required",
            "filiere_id"=>"required",
        ]);
        $groupes=groupe::create($validate);
        return to_route('gererGroupe');
    }
    public function deleteGroupe(Request $request){
        $id = $request->id;
        $groupe = groupe::findOrFail($id); // Retrieve the emploi instance based on the ID
        $groupe->delete(); // Delete the emploi
        return redirect()->route('gererGroupe'); // Redirect to the desired route
    }
    public function showUpdateGroupe(groupe $groupe){
        $idGroupe = $groupe->id;
        $groupes = Groupe::with('filiere')->paginate(99999);
        $filieres = Filiere::all(); // Assuming you want to show all filières in the dropdown
        return view('showUpdateGroupe',compact('groupes', 'filieres','idGroupe'));
    }

    public function updateGroupe(Request $request, groupe $groupe)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nom_groupe' => 'required',
            'Mode_de_formation' => 'required',
            'Niveau' => 'required',
            'filiere_id' => 'required',
        ]);

        // Update the groupe instance with the validated data
        $groupe->update($validatedData);

        // Redirect to the desired route after successful update
        return redirect()->route('gererGroupe')->with('success', 'Groupe updated successfully');
    }

    public function changeStage(Request $request, $id)
    {
        $groupe = groupe::findOrFail($id);

        // Toggle the status
        $groupe->stage = $groupe->stage === 'stage' ? 'non' : 'stage';
        $groupe->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
