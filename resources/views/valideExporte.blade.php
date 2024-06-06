<x-master title="emplois_formateurs">
    @php
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    $seances_order = ['s1', 's2', 's3', 's4'];
    $seanceorder = 's5';
    @endphp
    <div style=" max-height: 85vh;border-radius:10px">

        <style>
            /* Your custom CSS styles */
            .s {
                border-bottom: 1px solid black !important;
            }
            .centered-card {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>

<div class="container">
    <div class="header text-center mt-3">
        <h3 class="text-info">Sélectionnez l'emploi souhaité</h3>
        <form action="{{ route('valideExporterPost') }}" method="POST">
            @csrf
            <select name="emploi" id="emploiSelect" class="form-select mt-3">
                @foreach ($emplois as $emploi)
                    <option {{$emploi->id == $id_emploi ? 'selected' : ''}} value="{{$emploi->id}}">{{$emploi->date_debu}} - {{$emploi->date_fin}}</option>
                @endforeach
            </select>
        </form>
    </div>

        {{-- emplois par filiere --}}
        <div style="display: none" >
                @foreach ($filieres as $filiere)
                    <h3>{{$filiere->nom_filier}}</h3>
                    @foreach ($niveaux as $niveau)
                        <h3>{{$filiere->nom_filier}} - {{$niveau}}</h3>
                        @if ($filiere->groupes->where('Niveau', $niveau)->isNotEmpty())
                            <h3>Emploi : CDJ</h3>
                            <table  id="tableCDJ_{{$filiere->id}}_{{$niveau}}" class="table border border-dark border-4">
                                <tr>
                                    <td  colspan="2"></td>
                                    <td colspan="4">EMPLOI DU TEMPS DE LA SECTION</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="4">Au titre de l'année 2024 - 2025</td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <td colspan="1">DRGC</td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <td colspan="4">Complexe/EFP : ITA MY RACHID</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">Filière :
                                        <span>{{ $filiere->nom_filier }}</span>
                                    </td>
                                    <td colspan="1"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">Niveau :
                                            <span>{{ $filiere->niveau_formation }}</span>
                                    </td>
                                    <td colspan="1"></td>
                                </tr>
                                <tr>
                                    @php
                                    $countMH = 0;
                                    $filiere_id = $filiere->id;
                                    $niveau = $niveau;
                                    $seancesGroupedCDJ = \App\Models\Seance::where('id_emploi', $id_emploi)
                                        ->whereHas('groupe', function ($query) use ($filiere_id,$niveau){
                                            $query->where('Mode_de_formation', 'CDJ')->where('filiere_id',$filiere_id)->where('Niveau',$niveau);
                                        })
                                        ->get();
                                        foreach ($seancesGroupedCDJ as $group) {
                                            $countMH += 1;
                                        }
                                    $MH = $countMH * 2.5
                                    @endphp
                                    <td colspan="4">Masse Horaire : {{$MH}} H</td>
                                    <td colspan="2">Période d'application : ({{$derniereEmploi->date_debu}})</td>
                                </tr>
                                <tr>
                                    <td colspan="4"> Mode de formaion :
                                            <span>{{ $filiere->mode_formation }}</span>
                                    </td>
                                    <td colspan="2">Parrain:</td>
                                </tr>
                                <tr>
                                    <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                                    @foreach ($seances_order as $seance_order)
                                        <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seance_order}}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                                    <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
                                </tr>
                                <!-- Loop through the days -->
                                @foreach($jours as $jour)
                                <!-- Loop through the groups -->
                                    @php
                                    $groupeCount = count($groupesorigine->where('filiere_id',$filiere->id)->where('Niveau',$niveau)->where('Mode_de_formation','CDJ'));
                                    $firstGroupes = $groupesorigine->where('filiere_id',$filiere->id)->where('Niveau',$niveau)->where('Mode_de_formation','CDJ')->first();
                                    // $firstGroupe = $groupesorigine->where('Mode_de_formation','CDJ')->first();
                                    @endphp
                                    @foreach($groupesorigine->where('filiere_id',$filiere->id)->where('Niveau',$niveau)->where('Mode_de_formation','CDJ') as $groupe)

                                        <tr>
                                            <!-- For the first group of each day, add the rowspan for the day cell -->
                                            @if($groupe->id === $firstGroupes->id)
                                            <td rowspan="{{ $groupeCount }}" class="border border-dark bg-grey text-black border-4">{{ $jour }}</td>
                                            @endif
                                            <td rowspan="1" class="border border-dark bg-grey text-black border-4">{{ $groupe['nom_groupe'] }}</td>
                                            <!-- Add cells for s1, s2, s3, and s4 -->
                                            @if ($groupe->stage == 'stage')
                                                <td colspan="4" style="text-align: center"><strong>STAGE</strong></td>
                                            @else
                                                @foreach ($seances_order as $seance_order)
                                                                    @php
                                                                        $seance = $seances->first(function($item) use ($jour, $seance_order, $groupe) {
                                                                            return $item->day === $jour  && $item->order_seance === $seance_order && $item->id_groupe == $groupe->id;
                                                                        });
                                                                    @endphp
                                                                    @php
                                                                        $modalId_update = $jour.''. $seance_order . '' .$groupe->id.'_'."update";
                                                                        $modalId_ajouter = $jour.''. $seance_order . '' .$groupe->id.'_'."ajouter";
                                                                    @endphp
                                                                    @if($seance)
                                                                        <td class=" v cellule text-black border border-dark" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                                                            <span>{{ $seance->formateur->name }} </span>
                                                                                {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                                                                @if ($seance->salle)
                                                                                    / <span>{{ $seance->salle->nom_salle }}</span>
                                                                                @endif
                                                                                @if ($seance->type_seance == 'team')
                                                                                / <span>FAD</span>
                                                                                @endif
                                                                        </td>
                                                                    @else
                                                                        <td class=" v cellule text-black border border-dark {{  $loop->parent->last? 'd' : '' }}" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">

                                                                        </td>
                                                                    @endif
                                                @endforeach
                                            @endif
                                            <!-- Add cells for s2, s3, and s4 -->
                                            <!-- form_qui_ajouter_un_seance -->

                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                            @if ($filiere->groupes->where('Niveau', $niveau)->where('Mode_de_formation','CDS')->isNotEmpty())
                                <h3>Emploi : CDS</h3>
                                <table id="tableCDS_{{$filiere->id}}_{{$niveau}}" class="table border border-dark border-4">
                                    <tr>
                                        <td  colspan="1"></td>
                                        <td colspan="2">EMPLOI DU TEMPS DE LA SECTION</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1"></td>
                                        <td colspan="2">Au titre de l'année 2024 - 2025</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">DRGC</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Complexe/EFP : ITA MY RACHID</td>
                                        <td colspan="1"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Filière :
                                                <span>{{ $filiere->nom_filier }}</span>
                                        </td>
                                        <td colspan="1"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Niveau :
                                                <span>{{ $filiere->niveau_formation }}</span>
                                        </td>
                                        <td colspan="1"></td>
                                    </tr>
                                    <tr>
                                        @php
                                        $countMH = 0;
                                        $filiere_id = $filiere->id;
                                        $niveau = $niveau;
                                        $seancesGroupedCDS = \App\Models\Seance::where('id_emploi', $id_emploi)
                                        ->whereHas('groupe', function ($query) use ($filiere_id,$niveau){
                                            $query->where('Mode_de_formation', 'CDS')->where('filiere_id',$filiere_id)->where('Niveau',$niveau);
                                        })
                                        ->get();
                                            foreach ($seancesGroupedCDS as $group) {
                                                $countMH += 1;
                                            }
                                        $MH = $countMH * 2.5
                                        @endphp
                                        <td colspan="2">Masse Horaire : {{$MH}} H</td>
                                        <td colspan="1">Période d'application : ({{$derniereEmploi->date_debu}})</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> Mode de formaion :
                                                <span>{{ $filiere->mode_formation }}</span>
                                        </td>
                                        <td colspan="1">Parrain:</td>
                                    </tr>
                                    <tr>
                                        <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                                        <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seanceorder}}</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                                        <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
                                    </tr>
                                    <!-- Loop through the days -->
                                    @foreach($jours as $jour)
                                    <!-- Loop through the groups -->
                                        @php
                                        $groupeCount = count($groupesorigine->where('filiere_id',$filiere->id)->where('Niveau',$niveau)->where('Mode_de_formation','CDS'));
                                        $firstGroupe = $groupesorigine->where('filiere_id',$filiere->id)->where('Niveau',$niveau)->where('Mode_de_formation','CDS')->first();
                                        @endphp
                                        @foreach($groupesorigine->where('filiere_id',$filiere->id)->where('Niveau',$niveau)->where('Mode_de_formation','CDS') as  $groupe)
                                            <tr>
                                                <!-- For the first group of each day, add the rowspan for the day cell -->
                                                @if($groupe->id === $firstGroupe->id)
                                                <td rowspan="{{ $groupeCount }}" class="border border-dark bg-grey text-black border-4">{{ $jour }}</td>
                                                @endif
                                                <td rowspan="1" class="border border-dark bg-grey text-black border-4">{{ $groupe['nom_groupe'] }}</td>
                                                <!-- Add cells for s1, s2, s3, and s4 -->
                                                @if ($groupe->stage == 'stage')
                                                    <td colspan="4" style="text-align: center"><strong>STAGE</strong></td>
                                                @else
                                                                        @php
                                                                            $seance = $seances->first(function($item) use ($jour, $seanceorder, $groupe) {
                                                                                return $item->day === $jour  && $item->order_seance === $seanceorder && $item->id_groupe == $groupe->id;
                                                                            });
                                                                        @endphp
                                                                        @php
                                                                            $modalId_update = $jour.''. $seanceorder . '' .$groupe->id.'_'."update";
                                                                            $modalId_ajouter = $jour.''. $seanceorder . '' .$groupe->id.'_'."ajouter";
                                                                        @endphp
                                                                        @if($seance)
                                                                        <td class=" v cellule text-black border border-dark" id="#{{$modalId_update}}" style="background-color: white; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                                                            <span>{{ $seance->formateur->name }} </span> /
                                                                                {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                                                                @if ($seance->salle)
                                                                                / <span>{{ $seance->salle->nom_salle }}</span>
                                                                                @endif
                                                                                @if ($seance->type_seance == 'team')
                                                                                / <span>FAD</span>
                                                                                @endif
                                                                            </td>
                                                                        @else
                                                                            <td class=" v cellule text-black border border-dark {{  $loop->parent->last? 'd' : '' }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" >

                                                                            </td>
                                                                        @endif
                                                @endif
                                                <!-- Add cells for s2, s3, and s4 -->
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </table>
                            @endif
                        @endif
                    @endforeach
                @endforeach
        <!-- emplois formateur -->
                @foreach ($formateurs as $formateur)
                    <h3>Emploi : CDJ</h3>
                    <h6>{{$formateur->name}}</h6>
                    <table id="tableCDJ_{{$formateur->id}}" class="table border border-dark border-4">
                        <tr>
                            <td  colspan="2"></td>
                            <td colspan="4">EMPLOI DU TEMPS DU FORMATEUR FACE A FACE : Stagiaire</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="4">Au titre de l'année 2024 - 2025</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="1">DRGC</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Complexe/EFP : ITA MY RACHID</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="2">Fomateur : {{$formateur->name}}</td>
                            <td colspan="2">Statutaire : </td>
                            <td colspan="2">Mle:15615</td>
                        </tr>
                        <tr>
                            <td colspan="2">Filière :
                                @foreach ($formateurFiliere->where('formateur_id', $formateur->id) as $index => $ff)
                                    <span>{{ $ff->filiere->nom_filier }}</span>/
                                @endforeach
                            </td>

                            <td colspan="2">Coopérant : </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2">Niveau :
                                @foreach ($formateurFiliere->where('formateur_id', $formateur->id) as $index => $ff)
                                    <span>{{ $ff->filiere->niveau_formation }}</span>
                                    /
                                @endforeach
                            </td>
                            <td colspan="2">Vacataire : </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            @php
                                $seancesGrouped = \App\Models\Seance::where('id_emploi', $id_emploi)
                                    ->where('id_formateur', $formateur->id)
                                    ->whereHas('groupe', function ($query) {
                                        $query->where('Mode_de_formation', 'CDJ');
                                    })
                                    ->groupBy(['order_seance', 'day'])
                                    ->selectRaw('order_seance, day, count(*) as seances_count')
                                    ->get();

                                    $countMH = 0;
                                foreach ($seancesGrouped as $group) {
                                    $countMH += 1;
                                }
                                $MH = $countMH * 2.5;
                            @endphp
                            <td colspan="2">Masse Horaire: {{$MH}} H</td>

                            <td colspan="2">Contrat de service </td>
                            <td colspan="2">Période d'application : ({{ $derniereEmploi->date_debu }})</td>
                        </tr>
                        <!-- Table header -->
                        <tr>
                            <th class="text-black border-4" style="text-align:center" colspan="2">Heure</th>
                            @foreach ($seances_order as $seance_order)
                                <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seance_order}}</th>
                            @endforeach
                        </tr>
                        <tr class="border-4">
                            <th style="text-align:center" class="border border-dark bg-grey text-black border-4">Jour</th>
                        </tr>
                        <!-- Table body -->
                        @foreach ($jours as $jour)
                            <tr>
                                <th rowspan="3" class="border border-dark bg-grey text-black border-4">{{$jour}}</th>
                                <th class="s border-end border-start border-bottom-0 border-dark bg-grey text-black border-4">Groupe</th>
                                @foreach ($seances_order as $seance_order)
                                    @php
                                        $seance = $seances->first(function($item) use ($jour, $seance_order, $formateur) {
                                            return $item->day === $jour && $item->order_seance === $seance_order && $item->id_formateur == $formateur->id;
                                        });
                                        $modalId_update = $jour . $seance_order . $formateur->id . "_update";
                                        $modalId_ajouter = $jour . $seance_order . $formateur->id . "_ajouter";
                                    @endphp
                                    @if ($seance)
                                        <td class="cellule border-end border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                            @php $displayedGroups = []; @endphp <!-- Initialize an array to keep track of displayed groups -->
                                            @foreach($groupes as $formateurGroupe)
                                                @php
                                                    $groupe_deja_occupee = $formateurGroupe->groupe->seances
                                                        ->where('id_emploi', $id_emploi)
                                                        ->where('day', $jour)
                                                        ->where('order_seance', $seance_order)
                                                        ->where('id_formateur', $formateur->id);
                                                @endphp
                                                @if ($groupe_deja_occupee->isNotEmpty() && !in_array($formateurGroupe->groupe->nom_groupe, $displayedGroups))
                                                    <span>{{ $formateurGroupe->groupe->nom_groupe }}</span>
                                                    @php $displayedGroups[] = $formateurGroupe->groupe->nom_groupe; @endphp <!-- Add displayed group to array -->
                                                @endif
                                            @endforeach
                                            @if ($seance->type_seance == 'team')
                                                <span>FAD</span>
                                            @endif
                                        </td>
                                    @else
                                        <td class="cellule border-end border-start border-bottom-0 border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <th class="s border border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Module</th>
                                @foreach ($seances_order as $seance_order)
                                    @php
                                        $seance = $seances->first(function($item) use ($jour, $seance_order, $formateur) {
                                            return $item->day === $jour && $item->order_seance === $seance_order && $item->id_formateur == $formateur->id;
                                        });
                                        $modalId_update = $jour . $seance_order . $formateur->id . "_update";
                                        $modalId_ajouter = $jour . $seance_order . $formateur->id . "_ajouter";
                                    @endphp
                                    @if (isset($seance))
                                        <td class="cellule border border-dark bg-grey text-black" id="#{{ $modalId_update }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{ $modalId_update }}">
                                            @if ($seance->module_id)
                                                <span class="border border-dark bg-grey text-black">{{ $seance->module->intitule }}</span>
                                            @else
                                                <span>M</span>
                                            @endif
                                            {{-- <span>{{ $seance->type_seance }}</span> --}}
                                        </td>
                                    @else
                                        <td class="cellule border-end border-start border-top-0 border-bottom-0 border-dark bg-grey text-black border-4" id="#{{ $modalId_ajouter }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{ $modalId_ajouter }}">
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <th class="border-end border-start border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Salle</th>
                                @foreach ($seances_order as $seance_order)
                                    @php
                                        $seance = $seances->first(function($item) use ($jour, $seance_order, $formateur) {
                                            return $item->day === $jour && $item->order_seance === $seance_order && $item->id_formateur == $formateur->id;
                                        });
                                        $modalId_update = $jour . $seance_order . $formateur->id . "_update";
                                        $modalId_ajouter = $jour . $seance_order . $formateur->id . "_ajouter";
                                    @endphp
                                    @if($seance)
                                        <td class="cellule border border-dark bg-grey text-black" id="#{{ $modalId_update }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{ $modalId_update }}">
                                            <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;border-right:4px solid #344767 !important;border-bottom:4px solid #344767 !important" data-toggle="modal" data-target="#{{$modalId_update}}">
                                                @if ($seance->salle)
                                                    <span>{{ $seance->salle->nom_salle }}</span>
                                                @else
                                                    <span>SALLE</span>
                                                @endif
                                            </td>                                    </td>
                                    @else
                                        <td class="cellule border-end border-start border-top-0 border-dark bg-grey text-black border-4" id="#{{ $modalId_ajouter }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{ $modalId_ajouter }}">
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            <!-- Remaining table rows -->
                        @endforeach
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Formateur</td>
                                <td colspan="2">Directeur / Directeur Pédagogique</td>
                                <td colspan="2">Directeur du Complexe</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2"></td>
                                <td colspan="2"></td>
                            </tr>
                    </table>
                    @if($formateur->CDS == 'oui')
                        <h3>Emploi : CDS</h3>
                        <table id="tableCDS_{{$formateur->id}}" class="table border border-dark  border-4">
                            <tr>
                                <td  colspan="1"></td>
                                <td colspan="2">EMPLOI DU TEMPS DU FORMATEUR FACE A FACE : Stagiaire</td>
                            </tr>
                            <tr>
                                <td colspan="1"></td>
                                <td colspan="2">Au titre de l'année 2024 - 2025</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="1">DRGC</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Complexe/EFP : ITA MY RACHID</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Fomateur : {{$formateur->name}}</td>
                                <td colspan="1">Statutaire : </td>
                                <td colspan="1">Mle:15615</td>
                            </tr>
                            <tr>
                                <td colspan="1">Filière :
                                    @foreach ($formateurFiliere->where('formateur_id', $formateur->id) as $index => $ff)
                                        <span>{{$ff->filiere->nom_filier}}</span>/
                                    @endforeach
                                </td>
                                <td colspan="1">Coopérant : </td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Niveau :
                                    @foreach ($formateurFiliere->where('formateur_id', $formateur->id) as $index => $ff)
                                        <span>{{ $ff->filiere->niveau_formation }}</span>/
                                    @endforeach
                                </td>
                                <td colspan="1">Vacataire : </td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                @php
                                    $seancesGrouped = \App\Models\Seance::where('id_emploi', $id_emploi)
                                        ->where('id_formateur', $formateur->id)
                                        ->whereHas('groupe', function ($query) {
                                            $query->where('Mode_de_formation', 'CDS');
                                        })
                                        ->groupBy(['order_seance', 'day'])
                                        ->selectRaw('order_seance, day, count(*) as seances_count')
                                        ->get();

                                        $countMH = 0;
                                    foreach ($seancesGrouped as $group) {
                                        $countMH += 1;
                                    }
                                    $MH = $countMH * 2.5;
                                @endphp
                                <td colspan="1">Masse Horaire : {{$MH}} H</td>
                                <td colspan="1">Contrat de service </td>
                                <td colspan="1">Période d'application : ({{$derniereEmploi->date_debu}})</td>
                            </tr>
                            <tr>
                                <th class="text-black border-4" style="text-align:center" colspan="2" >Heure</th>
                                <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{ $seanceorder }}</th>
                            </tr>
                            <tr class="border-4">
                                <th style="text-align:center"  class="border border-dark bg-grey text-black border-4">Jour</th>
                            </tr>
                            @foreach ($jours as $jour)
                                <tr >
                                    <th rowspan="3" class="border border-dark bg-grey text-black border-4">{{ $jour }}</th>
                                    <th class="s border-end boredr-start border-bottom-0 border-dark bg-grey text-black border-4">Groupe</th>
                                        @php
                                            $seance = $seances->first(function($item) use ($jour, $seanceorder, $formateur) {
                                                return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_formateur == $formateur->id;
                                            });
                                            $modalId_update = $jour.''. $seanceorder . '' .$formateur->id.'_'."update";
                                            $modalId_ajouter = $jour.''. $seanceorder . '' .$formateur->id.'_'."ajouter";
                                        @endphp
                                        @if($seance)
                                            <td class="cellule border-end border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                                @php $displayedGroups = []; @endphp <!-- Initialize an array to keep track of displayed groups -->
                                                @foreach($groupes as $formateurGroupe)
                                                    @php
                                                        $groupe_deja_occupee = $formateurGroupe->groupe->seances
                                                            ->where('id_emploi', $id_emploi)
                                                            ->where('day', $jour)
                                                            ->where('order_seance', $seanceorder)
                                                            ->where('id_formateur', $formateur->id);
                                                    @endphp
                                                    @if ($groupe_deja_occupee->isNotEmpty() && !in_array($formateurGroupe->groupe->nom_groupe, $displayedGroups))
                                                        <span>{{ $formateurGroupe->groupe->nom_groupe }}</span>
                                                        @php $displayedGroups[] = $formateurGroupe->groupe->nom_groupe; @endphp <!-- Add displayed group to array -->
                                                    @endif
                                                @endforeach
                                                @if ($seance->type_seance == 'team')
                                                <span>FAD</span>
                                                @endif
                                            </td>
                                        @else
                                            <td class="cellule border-end border-start border-bottom-0 border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                            </td>
                                        @endif
                                </tr>
                                <tr>
                                    <th class="s border border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Module</th>
                                        @php
                                            $seance = $seances->first(function($item) use ($jour, $seanceorder, $formateur) {
                                                return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_formateur == $formateur->id;
                                            });
                                            $modalId_update = $jour.''. $seanceorder . '' .$formateur->id.'_'."update";
                                            $modalId_ajouter = $jour.''. $seanceorder . '' .$formateur->id.'_'."ajouter";
                                        @endphp
                                        @if($seance)
                                            <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                                @if ($seance->module_id)
                                                    <span class="border border-dark bg-grey text-black">{{$seance->module->intitule}}</span>
                                                @else
                                                    <span>M</span>
                                                @endif
                                            </td>
                                        @else
                                            <td class="cellule border-end border-start border-top-0 border-bottom-0  border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                            </td>
                                        @endif
                                </tr>
                                <tr>
                                    <th class="border-end border-start border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Salle</th>
                                        @php
                                            $seance = $seances->first(function($item) use ($jour, $seanceorder, $formateur) {
                                                return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_formateur == $formateur->id;
                                            });
                                            $modalId_update = $jour.''. $seanceorder . '' .$formateur->id.'_'."update";
                                            $modalId_ajouter = $jour.''. $seanceorder . '' .$formateur->id.'_'."ajouter";
                                        @endphp
                                        @if($seance)
                                            <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                                @if ($seance->salle)
                                                <span>{{ $seance->salle->nom_salle }}</span>
                                                @else
                                                    <span>SALLE</span>
                                                @endif                                        </td>
                                        @else
                                            <td class="cellule border-end boredr-start border-top-0 border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                            </td>
                                        @endif
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Formateur</td>
                                <td colspan="1">Directeur / Directeur Pédagogique</td>
                                <td colspan="1">Directeur du Complexe</td>
                            </tr>
                            <tr>
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                            </tr>
                        </table>
                    @endif
                @endforeach

                    <table id="salleCDJ" class="table border border-dark border-4">
                        <!-- CDJ Table content -->
                        <tr>
                            <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                            @foreach ($seances_order as $seance_order)
                                <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seance_order}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                            <th class="border border-dark bg-grey text-black border-4">SALLES</th>
                        </tr>
                        <!-- Loop through the days -->
                        @foreach($jours as $jour)
                            <!-- Loop through the rooms -->
                            @php
                                $sallesCount = count($salles);
                                $firstsalles = $salles->first();
                            @endphp
                            @foreach($salles as $salle)
                                <tr>
                                    <!-- For the first room of each day, add the rowspan for the room cell -->
                                    @if($salle->id === $firstsalles->id && $loop->first)
                                        <td rowspan="{{ $sallesCount }}" class="border border-dark bg-grey text-black border-4">{{ $jour }}</td>
                                    @endif
                                    <td rowspan="1" class="border border-dark bg-grey text-black border-4">{{ $salle['nom_salle'] }}</td>

                                    @foreach ($seances_order as $seance_order)
                                        @php
                                            $seances_filtered = $seances->filter(function($item) use ($jour, $seance_order, $salle) {
                                                return $item->day === $jour && $item->order_seance === $seance_order && $item->id_salle == $salle->id;
                                            });
                                        @endphp

                                        <!-- Check if there are sessions for the current criteria -->
                                        @if ($seances_filtered->isNotEmpty())
                                            <!-- Get the first session to display formateur and groups -->
                                            @php
                                                $seance = $seances_filtered->first();
                                            @endphp
                                            <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;">
                                                <span>{{ $seance->formateur->name }}</span> <br>
                                                @foreach ($seances_filtered as $seance_group)
                                                    <span>{{ $seance_group->groupe->nom_groupe }} </span>
                                                @endforeach
                                            </td>
                                        @else
                                            <!-- If no sessions for the current criteria, display empty cell -->
                                            <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;"></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </table>

                    <table id="salleCDS" class="table border border-dark border-4">
                        <!-- CDS Table content -->
                        <tr>
                            <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                            <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seanceorder}}</th>
                        </tr>
                        <tr>
                            <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                            <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
                        </tr>
                        <!-- Loop through the days -->
                        @foreach($jours as $jour)
                        <!-- Loop through the groups -->
                            @php
                            $sallesCount = count($salles);
                            $firstSalle = $salles->first();
                            @endphp
                            @foreach($salles as  $salle)
                                <tr>
                                    <!-- For the first group of each day, add the rowspan for the day cell -->
                                    @if($salle->id === $firstSalle->id)
                                    <td rowspan="{{ $sallesCount }}" class="border border-dark bg-grey text-black border-4">{{ $jour }}</td>
                                    @endif
                                    <td rowspan="1" class="border border-dark bg-grey text-black border-4">{{ $salle['nom_salle'] }}</td>

                                    @php
                                        $seances_filtered = $seances->filter(function($item) use ($jour, $seanceorder, $salle) {
                                            return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_salle == $salle->id;
                                        });
                                    @endphp

                                    <!-- Check if there are sessions for the current criteria -->
                                    @if ($seances_filtered->isNotEmpty())
                                        <!-- Get the first session to display formateur and groups -->
                                        @php
                                            $seance = $seances_filtered->first();
                                        @endphp
                                        <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;">
                                            <span>{{ $seance->formateur->name }}</span> <br>
                                            @foreach ($seances_filtered as $seance_group)
                                                <span>{{ $seance_group->groupe->nom_groupe }} </span>
                                            @endforeach
                                        </td>
                                    @else
                                        <!-- If no sessions for the current criteria, display empty cell -->
                                        <td class="v cellule text-black border border-dark" style="background-color: white; text-align:center;"></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <label for="formateurSelect" class="form-label">Select Formateur:</label>
                        <select class="form-select mb-3" id="formateurSelect" name="formateurId">
                            <option value="">Select Formateur</option>
                            <!-- Replace this with your actual loop -->
                            @foreach ($formateurs as $formateur)
                                <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success" onclick="exportSingleFormateurToExcel()">Exporter Excel pour le formateur sélectionné</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <button class="btn btn-success mb-3" onclick="ExportToExcelAllFormateur('xlsx')">Exporter tous les emplois des formateurs vers Excel</button>
                <button class="btn btn-success" onclick="emploiTableALLGROUPES('xlsx')">Exporter tous les emplois de tous les groupes de toutes les filières vers Excel</button>
                <button class="btn btn-success" onclick="ExportToExcelSalle('xlsx')">Export SALLES to excel</button>
            </div>
        </div>
    </div>

    </div>
</x-master>
<script>
    // Assuming $formateurs is an array of objects
    var filieresJson = {!! json_encode($filieres) !!};
    var numbers = [1, 2, 3];

    function emploiTableALLGROUPES(type, fn, dl) {
        var wb = XLSX.utils.book_new(); // Create a new workbook

        for (var i = 0; i < filieresJson.length; i++) {
            var filiere = filieresJson[i];
            for (var j = 0; j < numbers.length; j++) {
                var number = numbers[j];
                var tableCDJId = 'tableCDJ_' + filiere.id + '_' + number;
                var tableCDSId = 'tableCDS_' + filiere.id + '_' + number;
                console.log("Trying to access element with ID CDJ:", tableCDJId);
                console.log("Trying to access element with ID CDS:", tableCDSId);

                var eltCDJ = document.getElementById(tableCDJId);
                if (eltCDJ) {
                    console.log("Element found:", eltCDJ);
                    var wsCDJ = XLSX.utils.table_to_sheet(eltCDJ);
                    XLSX.utils.book_append_sheet(wb, wsCDJ, filiere.nom_filier + '_' + number +  ' CDJ');
                } else {
                    console.error("Element with ID " + tableCDJId + " not found!");
                }

                var eltCDS = document.getElementById(tableCDSId);
                if (eltCDS) {
                    console.log("Element found:", eltCDS);
                    var wsCDS = XLSX.utils.table_to_sheet(eltCDS);
                    XLSX.utils.book_append_sheet(wb, wsCDS, filiere.nom_filier + '_' + number + ' CDS');
                } else {
                    console.error("Element with ID " + tableCDSId + " not found!");
                }
            }
        }

        if (dl) {
            var wbout = XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' });
            saveAs(new Blob([s2ab(atob(wbout))],{type:"application/octet-stream"}), fn);
        } else {
            XLSX.writeFile(wb, fn || ('EmploisALLFILIERS(Filiere).' + (type || 'xlsx')));
        }
    }

    var formateursJson = {!! json_encode($formateurs) !!};


    function exportSingleFormateurToExcel() {
        var formateurId = document.getElementById('formateurSelect').value;

        // Find the selected formateur from the formateursJson array
        var selectedFormateur = formateursJson.find(function(formateur) {
            return formateur.id == formateurId;
        });

        if (selectedFormateur) {
            var wb = XLSX.utils.book_new(); // Create a new workbook
            var tableCDJId = 'tableCDJ_' + selectedFormateur.id; // Assuming 'id' is a property of formateur
            var tableCDSId = 'tableCDS_' + selectedFormateur.id; // Assuming 'id' is a property of formateur

            // Create CDJ worksheet
            var eltCDJ = document.getElementById(tableCDJId);
            var wsCDJ = XLSX.utils.table_to_sheet(eltCDJ);
            XLSX.utils.book_append_sheet(wb, wsCDJ, selectedFormateur.name + ' CDJ'); // Append CDJ worksheet to the workbook

            // Check if the selected formateur has CDS equal to "oui"
            if (selectedFormateur.CDS === "oui") {
                // Create CDS worksheet
                var eltCDS = document.getElementById(tableCDSId);
                var wsCDS = XLSX.utils.table_to_sheet(eltCDS);
                XLSX.utils.book_append_sheet(wb, wsCDS, selectedFormateur.name + ' CDS'); // Append CDS worksheet to the workbook
            }

            // Write the workbook to a file
            var fileName = selectedFormateur.name + '_Emplois.xlsx';
            XLSX.writeFile(wb, fileName);
        } else {
            alert('Please select a formateur.');
        }
    }


    function ExportToExcelAllFormateur(type) {
        var wb = XLSX.utils.book_new(); // Create a new workbook

        for (var i = 0; i < formateursJson.length; i++) {
            var formateur = formateursJson[i];
            var tableCDJId = 'tableCDJ_' + formateur.id; // Assuming 'id' is a property of formateur
            var tableCDSId = 'tableCDS_' + formateur.id; // Assuming 'id' is a property of formateur

            // Create CDJ worksheet
            var eltCDJ = document.getElementById(tableCDJId);
            var wsCDJ = XLSX.utils.table_to_sheet(eltCDJ);
            XLSX.utils.book_append_sheet(wb, wsCDJ, formateur.name + ' CDJ'); // Append CDJ worksheet to the workbook

            // Check if the formateur has CDS equal to "oui"
            if (formateur.CDS === "oui") {
                // Create CDS worksheet
                var eltCDS = document.getElementById(tableCDSId);
                var wsCDS = XLSX.utils.table_to_sheet(eltCDS);
                XLSX.utils.book_append_sheet(wb, wsCDS, formateur.name + ' CDS'); // Append CDS worksheet to the workbook
            }
        }

        // Write the workbook to a file
        var fileName = 'AllEmploisFormateurs.xlsx';
        XLSX.writeFile(wb, fileName);
    }

    const emploiSelect = document.getElementById('emploiSelect');
    const form = emploiSelect.closest('form'); // Get the closest form element

    emploiSelect.addEventListener('change', (event) => {
        form.submit(); // Submit the form when the selection changes
    });

    function ExportToExcelSalle(type, fn, dl) {
       var wb = XLSX.utils.book_new();

       // CDJ Table export
       var cdjTable = document.getElementById('salleCDJ');
       var cdjWS = XLSX.utils.table_to_sheet(cdjTable);
       XLSX.utils.book_append_sheet(wb, cdjWS, "CDJ");

       // CDS Table export
       var cdsTable = document.getElementById('salleCDS');
       var cdsWS = XLSX.utils.table_to_sheet(cdsTable);
       XLSX.utils.book_append_sheet(wb, cdsWS, "CDS");

       // Save or download
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Salles.' + (type || 'xlsx')));
    }

</script>
