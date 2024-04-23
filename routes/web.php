<?php

use App\Models\module;
use App\Http\Controllers\pages;
use App\Http\Controllers\gerer_user;
use App\Http\Controllers\importData;
use App\Http\Controllers\gerer_salle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gerer_emploi;
use App\Http\Controllers\gerer_groupe;
use App\Http\Controllers\gerer_module;
use App\Http\Controllers\gerer_seance;
use App\Http\Controllers\gerer_filiere;
use App\Http\Controllers\authController;
use App\Http\Controllers\valideExporter;
use App\Http\Controllers\gerer_formateur;
use App\Http\Controllers\masterController;
use App\Http\Controllers\api_get\filtrer_seance;
use App\Http\Controllers\gerer_formateur_module;
use App\Http\Controllers\api_get\api_get_gerer_emploi;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|formateursa jouter_groupe modifier_seance
*/

Route::get("/", [pages::class, 'home']);
Route::get("/groupes", [pages::class, 'groupes'])->name('groupes');
Route::get("/formateurs", [pages::class, 'afficher_formateurs']);
Route::post("/ajouter_emploi", [gerer_emploi::class, 'ajouter_emploi'])->name('ajouter_emploi');
Route::post("/ajouter_seance", [gerer_seance::class, 'ajouter_seance'])->name('ajouter_seance');
Route::post("/modifier_seance", [gerer_seance::class, 'modifier_seance'])->name('modifier_seance');
Route::post("/modifier_seance_groupe", [gerer_seance::class, 'modifier_seance_groupe'])->name('modifier_seance_groupe');
Route::post("/supprimer_seance", [gerer_seance::class, 'supprimer_seance'])->name('supprimer_seance');
Route::get('/afficher-afficher_emploi_par_id/{id_emploi}', [pages::class, 'afficher_emploi_par_id'])->name('afficher_emploi_par_id');
Route::post("/ajouter_groupe", [gerer_groupe::class, 'ajouter_groupe'])->name('ajouter_groupe');
Route::post("/afficher_emploi", [pages::class, 'afficher_emploi'])->name('afficher_emploi');

// -------------------------------------------
// -------------------------------------------

Route::middleware('auth')->group(function () {



    // IMPORT  ///////////////////////////////////////////////////////////////////////////////////
    Route::controller(importData::class)->group(function(){
        Route::get('/import','index')->name('importView');
        Route::post('/import','upload')->name('UploedFileExcel');
    });
    // VALIDEEXPORTER  ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(valideExporter::class)->group(function(){
        Route::get('/valideExporter','valideExporter')->name('valideExporter');
        Route::post('/valideExporterPost','valideExporterPost')->name('valideExporterPost');
    });
    // SEANCE  ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_seance::class)->group(function () {

        Route::post("/ajouter_seance", 'ajouter_seance')->name('ajouter_seance');
        Route::post("/modifier_seance", 'modifier_seance')->name('modifier_seance');
        Route::post("/modifier_seance_groupe", 'modifier_seance_groupe')->name('modifier_seance_groupe');
        Route::post("/supprimer_seance", 'supprimer_seance')->name('supprimer_seance');
        Route::post("/ajouter_seanceFomFormateur", 'ajouter_seanceFomFormateur')->name('ajouter_seanceFomFormateur');
        Route::post("/supprimer_seanceFiliere", 'supprimer_seanceFiliere')->name('supprimer_seanceFiliere');


    });

    // MODULES ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_module::class)->group(function () {

        Route::prefix('/gererModule')->group(function(){
            Route::get('/','gererModule')->name('gererModule');
            Route::post('/addModule','addModule')->name('addModule');
            Route::delete('/{module}','deleteModule')->name('deleteModule');
            Route::post('/{module}/activate','activate')->name('module.activate');
            Route::post('/{module}/deactivate','deactivate')->name('module.deactivate');
            Route::put('/updateModule/{module}', 'updateModule')->name('updateModule');


        });
    });
    // FORMATEUR ///////////////////////////////////////////////////////////////////////////////////
    Route::controller(gerer_formateur::class)->group(function () {

        Route::prefix('/gererFormateur')->group(function () {

            Route::get('/', 'showGererFormateur')->name('showGereFormateur');
            Route::post('/addFormateur', 'addFormateur')->name('addFormateur');
            Route::delete('/{formateur}', 'deleteFormateur')->name('deleteFormateur');
            Route::put('/updateFormateur/{formateur}', 'updateFormateur')->name('updateFormateur');
            Route::post('formateur/{id}/status', 'changeStatusFormateur')->name('formateur.changeStatus');
            Route::post('formateur-cds/{id}/CDS', 'changeCDS')->name('formateur.changeCDS');
        });
    });
    // gerer_formateur_module ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_formateur_module::class)->group(function(){
        Route::prefix('gerer_formateur_module')->group(function(){
            Route::post('/assign-modules', 'assignModules')->name('assignModules');
            Route::post('/assign-groupes', 'assignGroupes')->name('assignGroupes');
            Route::post('/assign-filieres-formateurs', 'assignFilieresFormateur')->name('assignFilieresFormateur');
            Route::get('/statusModules','statusModules')->name('statusModules');
            Route::get('/statusGroupes','statusGroupes')->name('statusGroupes');
            Route::get('/statusFilieres','statusFilieres')->name('statusFilieres');
            Route::post('formateur-module/{id}/status', 'changeStatus')->name('formateurModule.changeStatus');
            Route::delete('/formateur-module/{formateurModule}', 'destroyFormateurModule')->name('formateurModule.delete');
            Route::delete('/formateur-groupe/{formateurGroupe}', 'destroyFormateurGroupe')->name('formateurGroupe.delete');
            Route::delete('/formateur-filiere/{formateurFiliere}', 'destroyFormateurFiliere')->name('formateurFiliere.delete');

        });
        Route::get('/groupes-modules', 'GroupeModule')->name('GroupeModule');
        Route::post('/groupes-modules/assign-groupes-modules', 'assignGroupesModules')->name('assignGroupesModules');
        Route::get('/formateur-groupes', 'FormateurGroupe')->name('FormateurGroupe');
        Route::get('/formateur-modules', 'FormateurModule')->name('FormateurModule');
        Route::get('/formateur-filieres', 'FormateurFiliere')->name('FormateurFiliere');
        Route::get('/get-modules/{groupeId}', 'getModules');
        Route::get('/get-all-modules','getAllModules');

    });
    // SALLE ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_salle::class)->group(function () {
        Route::prefix('/gererSalle')->group(function () {
            Route::get('/', 'gererSalle')->name('gererSalle');
            Route::post('/addSalle', 'addSalle')->name('addSalle');
            Route::delete('/{salle}', 'deleteSalle')->name('deleteSalle');
            Route::put('/updateSalle/{salle}', 'updateSalle')->name('updateSalle');
        });
        Route::get('/salles','ViewSalles')->name('salles');
    });
    // FILIERE ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_filiere::class)->group(function () {

        Route::prefix('/gererFiliere')->group(function () {

            Route::get('/', 'gereFiliere')->name('gererFiliere');
            Route::post('/addFiliere', 'addFiliere')->name('addFiliere');
            Route::put('/updateFiliere/{filiere}', 'updateFiliere')->name('updateFiliere');
            Route::delete('/{filiere}', 'deleteFiliere')->name('deleteFiliere');
        });
    });
    // USER ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_user::class)->group(function () {

        Route::prefix('/gererUser')->group(function () {

            Route::get('/', 'gererUser')->name('gererUser');
            Route::put('/{user}', 'updateUser')->name('updateUser');
        });
    });
    // GROUPE ///////////////////////////////////////////////////////////////////////////////////

    Route::controller(gerer_groupe::class)->group(function () {

        Route::prefix('/gererGroupe')->group(function () {

            Route::get('/', 'gererGroupe')->name('gererGroupe');
            Route::post('/addGroupe', 'addGroupe')->name('addGroupe');
            Route::post('/', 'deleteGroupe')->name('deleteGroupe');
            Route::put('/updateGroupe/{groupe}', 'updateGroupe')->name('updateGroupe');
            Route::post('groupe/{id}/stage', 'changeStage')->name('groupe.changeStage');



        });
    });
    // EMPLOI //////////////////////////////////////////////////////////////////////////////////////
    Route::controller(gerer_emploi::class)->group(function () {

        Route::get('/gereSemaine', 'gererSemaine')->name('gererSemaine');
        Route::post('/gereSemaine', 'deleteSemaine')->name('deleteSemaine');
        Route::post('/ajouter_emploi', 'ajouter_emploi')->name('ajouter_emploi');
        Route::get('/nouveau emploi', 'afficher_ajouter_emploi')->name('afficher_ajouter_emploi');
        Route::get('/emplois_formateurs', 'afficher_emploi_par_formateurs')->name('emplois_formateurs');
        Route::get('/emplois_groupes', 'afficher_emploi_par_groupes')->name('emplois_groupes');
        Route::get('/emplois_formateur', 'afficher_emploi_par_formateur')->name('emploi_formateur');
        Route::get('/emploi_groupe', 'afficher_emploi_par_groupe')->name('emploi_groupe');
        Route::get('/emploi_filiere', 'afficher_emploi_par_filiere')->name('emploi_filiere');
        Route::get('/fetch-groups','fetchGroups')->name('fetch-groups');
    });
});
Route::controller(masterController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::prefix('/')->group(function () {
            Route::get('/', 'home')->name('home');
            Route::get('/backup', 'showBackUp')->name('showBackUp');
            Route::match(['get', 'post'], '/bp', 'backup')->name('backup');
            Route::get('/filter-groups', 'filterGroups')->name('filter.groups');
            Route::get('/getGroupesByFiliere/{filiereId}', 'getGroupesByFiliere');


            Route::prefix('/settings')->group(function () {
            });
        });
    });
});

Route::controller(authController::class)->group(function () {

    Route::middleware('guest')->group(function () {

        Route::get('/login', 'showLogin')->name('showLogin');
        Route::get('/register', 'showRegister')->name('showRegister');
        Route::post('/register', 'createUser')->name('createUser');
        Route::post('/login', 'login')->name('login');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/logout', 'logout')->name('logout');
    });
});
// -------------------------------------------
// -------------------------------------------
// api_get
Route::controller(api_get_gerer_emploi::class)->group(function(){
    Route::prefix('api_get')->group(function () {
        Route::get('/emplois_formateur', 'afficher_emploi_par_formateur')->name('afficher_seance_par_formateur');
        Route::get('/afficher_message', 'afficher_message')->name('afficher_message');
    });
});
Route::controller(filtrer_seance::class)->group(function(){
    Route::prefix('api_get')->group(function () {
        Route::get('/filtrer_seance', 'afficher_seance_par_formateur')->name('afficher_seance_par_formateur');
        Route::get('/afficher_message', 'afficher_message')->name('afficher_message');
    });
});
