                    <table id="emploiTable1" class="table border border-dark  border-4">
                        <tr class="export-hidden">
                            <td  colspan="1"></td>
                            <td colspan="2">EMPLOI DU TEMPS DU FORMATEUR FACE A FACE : Stagiaire</td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="1"></td>
                            <td colspan="2">Au titre de l'année 2024 - 2025</td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="3"></td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="1">DRGC</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="2">Complexe/EFP : ITA MY RACHID</td>
                            <td colspan="1"></td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="1">Fomateur : {{$selectedFormateur->name}}</td>
                            <td colspan="1">Statutaire : </td>
                            <td colspan="1">Mle:15615</td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="1">Filière :
                                @foreach ($formateurFiliere as $index => $ff)
                                    <span>{{$ff->filiere->nom_filier}}</span>@if ($index != count($formateurFiliere) - 1)/@endif
                                @endforeach
                            </td>
                            <td colspan="1">Coopérant : </td>
                            <td colspan="1"></td>
                        </tr>
                        <tr class="export-hidden">
                            <td colspan="1">Niveau : @foreach ($formateurFiliere as $index => $ff)
                                <span>{{$ff->filiere->niveau_formation}}</span>@if ($index != count($formateurFiliere) - 1)/@endif
                            @endforeach</td>
                            <td colspan="1">Vacataire : </td>
                            <td colspan="1"></td>
                        </tr>
                        <tr class="export-hidden">
                            @php
                            $countMH = 0;
                                foreach ($seancesGroupedCDS  as $group) {
                                    $countMH += 1;
                                }
                            $MH = $countMH * 2.5
                            @endphp
                            <td colspan="1">Masse Horaire : {{$MH}} H</td>
                            <td colspan="1">Contrat de service </td>
                            <td colspan="1">Période d'application : ({{$derniereEmploi->date_debu}})</td>
                        </tr>
                        <tr>
                            <th class="text-black border-4" style="text-align:center" colspan="2" >Heure</th>
                            @php
                                if ($seanceorder == 's5') {
                                    $order_seance = '19H00 à 21H00';
                                }
                            @endphp
                            <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{ $order_seance }}</th>
                        </tr>
                        <tr class="border-4">
                            <th style="text-align:center"  class="border border-dark bg-grey text-black border-4">Jour</th>
                        </tr>
                        @foreach ($jours as $jour)
                            <tr >
                                <th rowspan="3" class="border border-dark bg-grey text-black border-4">{{ $jour }}</th>
                                <th class="s border-end boredr-start border-bottom-0 border-dark bg-grey text-black border-4">Groupe</th>
                                    @php
                                        $seance = $seances->first(function($item) use ($jour, $seanceorder, $selectedFormateur) {
                                            return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_formateur == $selectedFormateur->id;
                                        });
                                        $modalId_update = $jour.''. $seanceorder . '' .$selectedFormateur->id.'_'."update";
                                        $modalId_ajouter = $jour.''. $seanceorder . '' .$selectedFormateur->id.'_'."ajouter";
                                    @endphp
                                    @if($seance)
                                        <td class="cellule border-end border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                            @foreach($groupes as $formateurGroupe)
                                            @if ($formateurGroupe->groupe->Mode_de_formation == 'CDS')

                                                @php
                                                    $groupe_deja_occupee = $formateurGroupe->groupe->seances
                                                        ->where('id_emploi', $id_emploi)
                                                        ->where('day', $jour)
                                                        ->where('order_seance', $seanceorder)
                                                        ->where('id_formateur', $selectedFormateur->id);
                                                @endphp
                                                @if ($groupe_deja_occupee->isNotEmpty())
                                                    <span>{{ $formateurGroupe->groupe->nom_groupe }}</span>
                                                @endif
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
                                        $seance = $seances->first(function($item) use ($jour, $seanceorder, $selectedFormateur) {
                                            return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_formateur == $selectedFormateur->id;
                                        });
                                        $modalId_update = $jour.''. $seanceorder . '' .$selectedFormateur->id.'_'."update";
                                        $modalId_ajouter = $jour.''. $seanceorder . '' .$selectedFormateur->id.'_'."ajouter";
                                    @endphp
                                    @if($seance)
                                        <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                            @if ($seance->module_id)
                                                <span class=" bg-grey text-black">{{$seance->module->intitule}}</span>
                                            @else
                                                <span>M</span>
                                            @endif
                                            {{-- <span>{{$seance->type_seance}}</span> --}}
                                        </td>
                                    @else
                                        <td class="cellule border-end border-start border-top-0 border-bottom-0  border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                        </td>
                                    @endif
                            </tr>
                            <tr>
                                <th class="border-end border-start border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Salle</th>
                                    @php
                                        $seance = $seances->first(function($item) use ($jour, $seanceorder, $selectedFormateur) {
                                            return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_formateur == $selectedFormateur->id;
                                        });
                                        $modalId_update = $jour.''. $seanceorder . '' .$selectedFormateur->id.'_'."update";
                                        $modalId_ajouter = $jour.''. $seanceorder . '' .$selectedFormateur->id.'_'."ajouter";
                                    @endphp
                                    @if($seance)
                                        <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_update}}">
                                            @if ($seance->salle)
                                                <span>{{ $seance->salle->nom_salle }}</span>
                                            @else
                                                <span>SALLE</span>
                                            @endif
                                        </td>
                                    @else
                                        <td class="cellule border-end boredr-start border-top-0 border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                        </td>
                                    @endif

                                    <!-- form_qui_ajouter_un_seance -->
                                    <div class="modal fade" id="{{ $modalId_ajouter }}" tabindex="-1"aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $seanceorder }} {{$jour}}</h1>
                                                    <button type="button" class="btn-close" data-dismiss="modal"aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ajouter_seanceFomFormateur') }}" method="post">
                                                        @csrf
                                                        <input name="day" type="text" hidden value="{{ $jour }}">
                                                        <input name="id_emploi" type="text" hidden value="{{ $id_emploi }}">
                                                        <input name="order_seance" type="text" hidden
                                                            value="{{ $seanceorder }}">
                                                        <input name="id_formateur" type="text" hidden
                                                            value="{{ $selectedFormateur->id }}">
                                                            {{-- <select class="form-select filiereSelect" style="margin-bottom:10px;" aria-label="Default select example">
                                                                <option selected value="">Choose a filiere</option>
                                                                @foreach ($filieres as $filiere)
                                                                    <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                                                @endforeach
                                                            </select>
                                                            <select class="form-select schoolYearSelect" style="margin-bottom:10px;" aria-label="Default select example">
                                                                <option selected value="">choisissez une année</option>
                                                                <option value="1">Premier cycle</option>
                                                                <option value="2">Deuxième cycle</option>
                                                                <option value="3">Troisième cycle</option>
                                                            </select> --}}

                                                            <!-- HTML code: Add filiere select -->

                                                            <!-- Existing select for groupes -->
                                                            <p>Groupes</p>
                                                            <div style="border: 1px solid grey; border-radius: 5px; margin: 10px; max-height: 200px; overflow-y: auto; padding: 5px;">
                                                                @foreach ($groupes as $formateurGroupe)
                                                                @if ($formateurGroupe->groupe->Mode_de_formation == 'CDS')

                                                                    @php
                                                                        $groupe_deja_occupe = $formateurGroupe->groupe->seances
                                                                            ->where('id_emploi', $id_emploi)
                                                                            ->where('day', $jour)
                                                                            ->where('order_seance', $seanceorder);
                                                                        $groupe_has_no_seance = $formateurGroupe->groupe->seances->isEmpty();
                                                                    @endphp
                                                                    @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                                                        <div class="form-check" style="margin-bottom: 5px;">
                                                                            <input class="form-check-input" type="checkbox" name="id_groupe[]" id="groupe{{ $formateurGroupe->groupe->id }}" value="{{ $formateurGroupe->groupe->id }}" style="margin-right: 5px;">
                                                                            <label class="form-check-label" for="groupe{{ $formateurGroupe->groupe->id }}">{{ $formateurGroupe->groupe->nom_groupe }}</label>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        <select name="id_salle" class="form-select" style="margin-bottom:10px;"
                                                            aria-label="Default select example">
                                                            <option selected value="">choisissez la salle</option>
                                                            @foreach ($salles as $salle)
                                                                @php
                                                                    $salle_occupe = $salle->seance
                                                                        ->where('id_emploi', '==', $id_emploi)
                                                                        ->where('day', '==', $jour)
                                                                        ->where('order_seance', '==', $seanceorder);
                                                                    $salle_has_no_seance = $salle->seance->isEmpty();
                                                                @endphp
                                                                @if ($salle_occupe->count() === 0 || $salle_has_no_seance)
                                                                    <option value="{{ $salle->id }}">{{ $salle->nom_salle }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <select class="form-control" id="module_id" name="module_id">
                                                            <option selected value="">choisissez le module</option>
                                                            <!-- Populate options dynamically based on available modules -->
                                                            @foreach ($modules as $module)
                                                                <option value="{{ $module->module_id }}">{{ $module->module->nom_module }}</option>
                                                            @endforeach
                                                        </select>
                                                        <select name="type_seance" class="form-select" style="margin-bottom:10px;"
                                                            aria-label="Default select example">
                                                            <option selected value="">choisissez le type de la seance</option>
                                                            <option value="presentielle">presentielle</option>
                                                            <option value="team">team</option>
                                                            <option value="efm">efm</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary">ajouter seance</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--form_qui_update-->
                                    @if($seance)
                                        <div class="modal fade" id="{{ $modalId_update }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $seanceorder }}
                                                        </h1>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('modifier_seance') }}" method="post">
                                                            @csrf
                                                            <input type="text" name="seance_id" value="{{ $seance->id }}"
                                                            hidden>
                                                                <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                                <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                                <input name="order_seance" type="text"
                                                                    value="{{ $seanceorder }}" hidden>
                                                                <input name="id_formateur" type="text"
                                                                    value="{{ $selectedFormateur->id }}" hidden>
                                                            <p>Groupes</p>
                                                            <div style="border: 1px solid grey; border-radius: 5px; margin: 10px; max-height: 200px; overflow-y: auto; padding: 5px;">
                                                                @foreach ($groupes as $formateurGroupe)
                                                                @if ($formateurGroupe->groupe->Mode_de_formation == 'CDS')

                                                                    @php
                                                                        $groupe_deja_occupe = $formateurGroupe->groupe->seances
                                                                            ->where('id_emploi', $id_emploi)
                                                                            ->where('day', $jour)
                                                                            ->where('order_seance', $seanceorder);
                                                                        $groupe_has_no_seance = $formateurGroupe->groupe->seances->isEmpty();
                                                                    @endphp
                                                                    @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                                                        <div class="form-check" style="margin-bottom: 5px;">
                                                                            <input class="form-check-input" type="checkbox" name="id_groupe[]" id="groupe{{ $formateurGroupe->groupe->id }}" value="{{ $formateurGroupe->groupe->id }}" style="margin-right: 5px;">
                                                                            <label class="form-check-label" for="groupe{{ $formateurGroupe->groupe->id }}">{{ $formateurGroupe->groupe->nom_groupe }}</label>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                            <select name="id_salle" class="form-select"
                                                                style="margin-bottom:10px;" aria-label="Default select example">
                                                                @if ($seance->salle)
                                                                    <option selected value="{{ $seance->salle->id_salle }}">
                                                                        {{ $seance->salle->nom_salle }}</option>
                                                                @else
                                                                    <option selected value="">choisissez la salle</option>
                                                                @endif
                                                                @foreach ($salles as $salle)
                                                                    @php
                                                                        $salle_occupe = $salle->seance
                                                                            ->where('id_emploi', '==', $id_emploi)
                                                                            ->where('day', '==', $jour)
                                                                            ->where('order_seance', '==', $seanceorder);
                                                                        $salle_has_no_seance = $salle->seance->isEmpty();
                                                                    @endphp
                                                                    @if ($salle_occupe->count() === 0 || $salle_has_no_seance)
                                                                        <option value="{{ $salle->id }}">
                                                                            {{ $salle->nom_salle }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="btn btn-success" hidden>update</button>
                                                        </form>
                                                        <form action="{{ route('supprimer_seance') }}" method="post">
                                                            @csrf
                                                            <input type="text" name="seance_id" value="{{ $seance->id }}"
                                                                hidden>

                                                                <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                                <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                                <input name="order_seance" type="text"
                                                                    value="{{ $seanceorder }}" hidden>
                                                                <input name="id_formateur" type="text"
                                                                    value="{{ $selectedFormateur->id }}" hidden>
                                                            <button type="submit" class="btn btn-danger">supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            </tr>
                        @endforeach
                    </table>
