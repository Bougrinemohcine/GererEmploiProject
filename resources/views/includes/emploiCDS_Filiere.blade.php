<h3>Emploi : CDS</h3>
                    <table id="emploiTable1" class="table border border-dark border-4">
                        <tr>
                            <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                            @php
                                if ($seanceorder == 's5') {
                                    $order_seance = '19H00 à 21H00';
                                }
                            @endphp
                            <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$order_seance}}</th>
                        </tr>
                        <tr>
                            <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                            <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
                        </tr>
                        <!-- Loop through the days -->
                        @foreach($jours as $jour)
                        <!-- Loop through the groups -->
                            @php
                            $groupeCount = count($groupes->where('Mode_de_formation','CDS'));
                            $firstGroupe = $groupes->where('Mode_de_formation','CDS')->first();
                            @endphp
                            @foreach($groupes->where('Mode_de_formation','CDS') as  $groupe)
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
                                                                $modalId_update = $jour.'_'. $seanceorder . '_' .$groupe->id.'_'."update";
                                                                $modalId_ajouter = $jour.'_'. $seanceorder . '_' .$groupe->id.'_'."ajouter";
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
                                                            <td class=" v cellule text-black border border-dark {{ $loop->last && $groupe->id === $groupeCount - 1 ? 'd' : '' }}" id="#{{$modalId_ajouter}}" style="background-color: white; text-align:center;" data-toggle="modal" data-target="#{{$modalId_ajouter}}">
                                                            </td>
                                                            @endif
                                                            <!-- form_qui_ajouter_un_seance -->
                                                            <div class="modal fade" id="{{$modalId_ajouter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seanceorder}} {{$jour}} {{$groupe->nom_groupe}}</h1>
                                                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{route('ajouter_seance')}}" method="post">
                                                                                @csrf
                                                                                <input name="day" type="text" hidden value="{{$jour}}">
                                                                                <input name="id_emploi" type="text" hidden value="{{$id_emploi}}">
                                                                                <input name="order_seance" type="text" hidden value="{{$seanceorder}}">
                                                                                <input name="id_groupe" type="text" hidden value="{{$groupe->id}}">
                                                                                <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                                    <option value="">Choose a formateur</option>
                                                                                        @foreach ($formateurs->where('CDS','oui') as $formateur)
                                                                                            @php
                                                                                                // Check if the formateur is related to the selected groupe
                                                                                                $formateur_related_to_groupe = $formateur->groupes->contains($groupe->id);
                                                                                                // Check if the formateur is available for the selected jour and seanceorder
                                                                                                $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                                                        ->where('day', $jour)
                                                                                                                                        ->where('order_seance', $seanceorder)
                                                                                                                                        ->isNotEmpty();
                                                                                            @endphp
                                                                                            @if ($formateur_related_to_groupe && !$formateur_deja_occupe)
                                                                                                <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                </select>
                                                                                <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                                    <option selected value="">choisissez la salle</option>
                                                                                    @foreach($salles as $salle)
                                                                                            @php
                                                                                                $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seanceorder);
                                                                                                $salle_has_no_seance=$salle->seance->isEmpty();
                                                                                            @endphp
                                                                                            @if($salle_occupe->count()===0 || $salle_has_no_seance)
                                                                                            <option value="{{$salle->id}}">{{$salle->nom_salle}}</option>
                                                                                            @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                <select name="type_seance" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
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
                                                                    <!-- form qui update un seance-->
                                                            @if($seance)
                                                                <div class="modal fade" id="{{$modalId_update}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seanceorder}}</h1>
                                                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{route('modifier_seance_groupe')}}" method="post">
                                                                                    @csrf
                                                                                    <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                                                    <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                                        <option selected value="{{$seance->formateur->id }}">{{$seance->formateur->name}} </option>
                                                                                        @foreach ($formateurs->where('CDS','oui') as $formateur)
                                                                                            @php
                                                                                                // Check if the formateur is related to the selected groupe
                                                                                                $formateur_related_to_groupe = $formateur->groupes->contains($groupe->id);
                                                                                                // Check if the formateur is available for the selected jour and seanceorder
                                                                                                $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                                                        ->where('day', $jour)
                                                                                                                                        ->where('order_seance', $seanceorder)
                                                                                                                                        ->isNotEmpty();
                                                                                            @endphp
                                                                                            @if ($formateur_related_to_groupe && !$formateur_deja_occupe)
                                                                                                <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                                        @if ($seance->salle)
                                                                                            <option selected value="{{ $seance->salle->id_salle }}">
                                                                                                {{ $seance->salle->nom_salle }}</option>
                                                                                        @else
                                                                                            <option selected value="">choisissez la salle</option>
                                                                                        @endif
                                                                                        @foreach($salles as $salle)
                                                                                            @php
                                                                                                $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seanceorder);
                                                                                                $salle_has_no_seance=$salle->seance->isEmpty();
                                                                                            @endphp
                                                                                            @if($salle_occupe->count()===0 || $salle_has_no_seance)
                                                                                            <option value="{{$salle->id}}">{{$salle->nom_salle}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <select name="type_seance" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                                        <option value="presentielle">presentielle</option>
                                                                                        <option value="team">team</option>
                                                                                        <option value="efm">efm</option>
                                                                                    </select>
                                                                                    <button type="submit" class="btn btn-success">update</button>
                                                                                </form>
                                                                                <form action="{{route('supprimer_seanceFiliere')}}" method="post">
                                                                                    @csrf

                                                                                    <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                                                    <input name="groupe" type="text"  value="{{ $groupe->id }}" hidden>
                                                                                    <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                                                    <input name="order_seance" type="text"
                                                                                        value="{{ $seanceorder }}" hidden>
                                                                                    <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                                                    <button type="submit" class="btn btn-danger">supprimer</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                    @endif
                                    <!-- Add cells for s2, s3, and s4 -->
                                </tr>
                            @endforeach
                        @endforeach
                    </table>

