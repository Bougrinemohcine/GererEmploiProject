<?php

namespace App\Http\Controllers;

use App\Models\user;
// Models
use App\Models\group;
use App\Models\branch;
use App\Models\groupe;
use App\Models\module;
use App\Models\filiere;
use App\Models\formateur;
use App\Models\class_room;
use App\Models\main_emploi;
use App\Models\GroupeModule;
use Illuminate\Http\Request;
use App\Models\establishment;
use App\Models\class_has_type;
use App\Models\class_room_type;
use App\Models\FormateurModule;
use App\Models\FiliereFormateur;
use App\Models\group_has_module;
use Illuminate\Support\Facades\DB;
use App\Models\formateur_has_group;
use App\Models\module_has_formateur;
use App\Models\formateur_has_branche;

class importData extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            // Store the uploaded file
            $filePath = $request->file('file')->storeAs('excel', $request->file('file')->getClientOriginalName());

            // Load the Excel file
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(storage_path('app/' . $filePath));
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            $existingGroupes = Groupe::pluck('nom_groupe')->toArray(); // Get all existing groups from the database

            $newGroupes = [];

            for ($row = 1; $row <= $highestRow; $row++) {
                $groupeName = $worksheet->getCell('G' . $row)->getValue();

                if (!empty($groupeName) && !in_array($groupeName, $existingGroupes)) {
                    // If group doesn't already exist, add it to the newGroupes array
                    $newGroupes[] = [
                        'nom_groupe' => $groupeName,
                        'Mode_de_formation' => 'CDS',
                        'Niveau' => 2,
                        'filiere_id' => 4,
                    ];
                }
            }

            // Insert new groups into the database
            if (!empty($newGroupes)) {
                Groupe::insert($newGroupes);
            }

            // Delete the uploaded file after processing
            unlink(storage_path('app/' . $filePath));

            return redirect()->route('importView')->with(['success' => 'Vous avez configuré les paramètres de votre compte avec succès.']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle any database errors
            if (isset($filePath)) {
                unlink(storage_path('app/' . $filePath));
            }
            return redirect()->route('importView')->withErrors(['errors' => $e->errorInfo[2]]);
        } catch (\Exception $e) {
            // Handle other errors
            return redirect()->route('importView')->withErrors(['errors' => $e->getMessage()]);
        }
    }

}
