<?php

namespace App\Http\Controllers\api_get;

use App\Http\Controllers\Controller;
use App\Models\seance;
use Illuminate\Http\Request;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\salle;
use App\Models\formateur;
class filtrer_seance extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function afficher_seance_par_formateur(Request $request)
    {
       $derniereEmploi = emploi::latest()->first();
       $niveau=$request->niveau;
       $filiere_id=$request->filiere_id;
       ///
       $jour=$request->jour;
       $order_seance=$request->order_seance;
       ///
       $groupes=[];
       if($niveau && $filiere_id==""){
        $groupes_niveau = groupe::with('seance')->where('niveau', $niveau)->get();
         foreach($groupes_niveau as $groupe){
                if($groupe->seance->isEmpty() ){
                    $groupes[]=$groupe;
                }else{
                    $groupe_deja_occupe = $groupe->seance
                    ->where('id_emploi', $derniereEmploi->id)
                    ->where('day', $jour)
                    ->where('order_seance', $order_seance);
                    if($groupe_deja_occupe->count() == 0 ){
                            $groupes[]=$groupe;
                    }
                }
            }
       }
       if($filiere_id && $niveau==""){
        $groupes_filiere = groupe::with('seance')->where('filiere_id', $filiere_id)->get();
        foreach($groupes_filiere as $groupe){
               if($groupe->seance->isEmpty() ){
                   $groupes[]=$groupe;
               }else{
                   $groupe_deja_occupe = $groupe->seance
                   ->where('id_emploi', $derniereEmploi->id)
                   ->where('day', $jour)
                   ->where('order_seance', $order_seance);
                   if($groupe_deja_occupe->count() == 0 ){
                           $groupes[]=$groupe;
                   }
               }
           }
       }
       if($filiere_id && $niveau){
        $groupes_filiere_niveau = groupe::with('seance')->where('filiere_id', $filiere_id)->where('niveau', $niveau)->get();
        foreach($groupes_filiere_niveau as $groupe){
            if($groupe->seance->isEmpty() ){
                $groupes[]=$groupe;
            }else{
                $groupe_deja_occupe = $groupe->seance
                ->where('id_emploi', $derniereEmploi->id)
                ->where('day', $jour)
                ->where('order_seance', $order_seance);
                if($groupe_deja_occupe->count() == 0 ){
                        $groupes[]=$groupe;
                }
            }
        }
       }
       return response()->json(["groupes"=>$groupes]);
    //    $seances=seance::where('id_formateur',$request->id_formateur)->where('id_groupe',$request->id_groupe)->where('id_salle',$request->id_salle)->where('type_seance',$request->type_seance)->where('niveau',$niveau)->where('filiere',$filiere)->orderBy('date_debu','desc')->get();
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
