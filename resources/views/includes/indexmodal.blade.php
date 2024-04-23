<div class="modal fade" id="{{$modalId_ajouter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}}</h1>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('ajouter_seance')}}" method="post">
                                            @csrf
                                            <input name="day" type="text" hidden value="{{$jour}}">
                                            <input name="partie_jour" type="text" hidden value="{{$part}}">
                                            <input name="id_emploi" type="text" hidden value="{{$id_emploi}}">
                                            <input name="order_seance" type="text" hidden value="{{$seance_order}}">
                                            <input name="id_groupe" type="text" hidden value="{{$groupe->id}}">
                                            <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                <option value="">Choose a formateur</option>
                                                @foreach ($formateurs as $formateur)
                                                    @php
                                                        // $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)->where('day', $jour)->where('order_seance', $seance_order);
                                                        // Change 'formateur_id' to 'id_formateur' in your query
                                                        $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                ->where('day', $jour)
                                                                                                ->where('order_seance', $seance_order);
                                                        $formateur_has_no_seance = $formateur->seance->isEmpty();
                                                    @endphp
                                                    @if ($formateur_deja_occupe->count() == 0 || $formateur_has_no_seance)
                                                        <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                            <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                <option selected value="">choisissez la salle</option>
                                                @foreach($salles as $salle)
                                                        @php
                                                            $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seance_order);
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
                        <!--form_qui_update-->
                        @if($seance)
                            <div class="modal fade" id="{{$modalId_update}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}}</h1>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('modifier_seance_groupe')}}" method="post">
                                                @csrf
                                                <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="{{$seance->formateur->id }}">{{$seance->formateur->name}} {{$seance->formateur->prenom}}</option>
                                                    @foreach ($formateurs as $formateur)
                                                        @php
                                                            // $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)->where('day', $jour)->where('order_seance', $seance_order);
                                                            // Change 'formateur_id' to 'id_formateur' in your query
                                                            $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                    ->where('day', $jour)
                                                                                                    ->where('order_seance', $seance_order);
                                                            $formateur_has_no_seance = $formateur->seance->isEmpty();
                                                        @endphp
                                                        @if ($formateur_deja_occupe->count() == 0 || $formateur_has_no_seance)
                                                            <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="{{$seance->salle->id }}">{{ $seance->salle->nom_salle }}</option>
                                                    @foreach($salles as $salle)
                                                        @php
                                                            $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seance_order);
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
                                            <form action="{{route('supprimer_seance')}}" method="post">
                                                @csrf
                                                <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                <button type="submit" class="btn btn-danger">supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
